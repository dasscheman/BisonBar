<?php

namespace App\Models;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $table = 'la_users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login_at' => 'datetime',
        'deleted_at' => 'datetime',
        'blocked_at' => 'datetime',
    ];

    public function expenses(): HasMany
    {
        return $this->hasMany(Expenses::class, 'user_id');
    }

    public function expensesNotInvoiced()
    {
        return $this->expenses()
            ->whereNull('invoice_id');
    }

    public function paymentsAddNotInvoiced($type)
    {
        return $this->paymentsAdd($type)
            ->whereNull('invoice_id');
    }

    public function paymentsAdd($type): HasMany
    {
        return $this->hasMany(Payment::class, 'user_id')
            ->where('type_id', $type)
            ->where('add_subtract', Payment::ADDSUBTRACT_ADD);
    }

    public function paymentsSubtractNotInvoiced($type)
    {
        return $this->paymentsSubtract($type)
            ->whereNull('invoice_id');
    }

    public function paymentsSubtract($type): HasMany
    {
        return $this->hasMany(Payment::class, 'user_id')
            ->where('type_id', $type)
            ->where('add_subtract', Payment::ADDSUBTRACT_SUBTRACT);
    }

    public function talliesNotInvoiced(): HasMany
    {
        return $this->tallies()
            ->whereNull('invoice_id');
    }

    public function tallies(): HasMany
    {
        return $this->hasMany(Tally::class, 'user_id');
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class, 'user_id');
    }


    public function pendingPaymentsExists()
    {
        return Payment::where('user_id', $this->id)
            ->where('mollie_status', PaymentType::MOLLIE_STATUS_pending)
            ->whereIsNull('deleted_at')
            ->exists();
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoices::class, 'user_id');
    }

    public function total()
    {
        $calculation = new Calculations($this);

//        $calculation->setDate($this->created_at);
        return $calculation->total();
    }

    public static function findByPayKey($payKey)
    {
        return User::where('pay_key', $payKey)->first();
    }

    public function generateNewInvoice()
    {
        $invoice = new Invoices;
        $invoice->user_id = $this->id;
        $invoice->name = $this->name.'_'.$invoice->id;
        $invoice->file_name = $this->name.'_TEMP.pdf';
        $invoice->save();
        $invoice->file_name = $this->name.'_'.$invoice->id.'.pdf';

        //        $data['tallies'] = $this->getNewTalliesForNewInvoice()->get();
        //        $data['payments'] = $this->getNewPaymentsForNewInvoice()->get();
        //        $data['invalid_payments'] = $this->getNewInvalidPaymentsForNewInvoice()->get();
        //        $data['expenses'] = $this->getNewExpensesForNewInvoice()->get();

        $pdf = Pdf::loadView('pdf.invoice-template', ['user' => $this]);

        if (! $pdf->save($invoice->invoicePath.$invoice->file_name)) {
            return false;
        }
        if (! $invoice->save()) {
            return false;
        }

        $invoice->save();

        return true;
    }
    //    public function createFactuur(User $user)
    //    {
    //        $this->setNewFactuurId();
    //        $this->setNewFactuurName($user->username . '_' . $this->factuur_id);
    //
    //        $this->new_bij_transacties = $user->getNewBijTransactiesUser()->all();
    //        $this->new_af_transacties = $user->getNewAfTransactiesUser()->all();
    //        $new_invalid_transacties = $user->getInvalidTransactionsNotInvoiced()->all();
    //        $this->new_turven = $user->getNewTurvenUsers()->all();
    //        $sum_new_bij_transacties = $user->getSumNewBijTransactiesUser();
    //        $sum_new_af_transacties = $user->getSumNewAfTransactiesUser();
    //        $sum_new_turven = $user->getSumNewTurvenUsers();
    //
    //        $vorig_openstaand =  $user->getSumOldBijTransactiesUser() - $user->getSumOldTurvenUsers() - $user->getSumOldAfTransactiesUser();
    //        $nieuw_openstaand = $vorig_openstaand - $sum_new_turven + $sum_new_bij_transacties - $sum_new_af_transacties;
    //        $content = Yii::$app->controller->renderPartial(
    //            '/factuur/factuur_template',
    //            [
    //                'user' => $user,
    //                'new_bij_transacties' => $this->new_bij_transacties,
    //                'new_af_transacties' => $this->new_af_transacties,
    //                'new_invalid_transacties' => $new_invalid_transacties,
    //                'new_turven' => $this->new_turven,
    //                'sum_new_bij_transacties' => $sum_new_bij_transacties,
    //                'sum_new_af_transacties' => $sum_new_af_transacties,
    //                'sum_new_turven' => $sum_new_turven,
    //                'vorig_openstaand' => $vorig_openstaand,
    //                'nieuw_openstaand' => $nieuw_openstaand
    //            ]
    //        );
    //
    //        // setup kartik\mpdf\Pdf component
    //        $pdf = new Pdf([
    //            // set to use core fonts only
    //            'mode' => Pdf::MODE_CORE,
    //            'format' => Pdf::FORMAT_A4,
    //            'marginLeft' => 20,
    //            'marginRight' => 15,
    //            'marginTop' => 48,
    //            'marginBottom' => 25,
    //            'marginHeader' => 10,
    //            'marginFooter' => 10,
    //            'defaultFont' => 'arial',
    //            'filename' =>  Yii::getAlias('@app') . '/web/uploads/facture/'. $this->naam . '.pdf',
    //            // portrait orientation
    //            'orientation' => 'P',
    //            // stream to browser inline
    ////                    'destination' => Pdf::DEST_BROWSER,
    //            'destination' => Pdf::DEST_FILE,
    //            // your html content input
    //            'content' => $content,
    //            // format content from your own css file if needed or use the
    //            // enhanced bootstrap css built by Krajee for mPDF formatting
    //            'cssFile' => Yii::getAlias('@app') . '/web/css/factuur.css',
    //            // set mPDF properties on the fly
    //            'options' => [
    //                'title' => $this->naam . '.pdf',
    //                'subject' => $this->naam . '.pdf',
    //                //    'keywords' => 'krajee, grid, export, yii2-grid, pdf'
    //            ],
    //        ]);
    //
    //        if ($pdf->render() === '') {
    //            return false;
    //        }
    //        return true;
    //    }


}
