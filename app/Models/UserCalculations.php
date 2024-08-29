<?php

namespace App\Models;


use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Notifications\Notifiable;

class UserCalculations extends User
{
    public function total()
    {
        return $this->expenses->sum('price')
            + $this->paymentsAdd(PaymentType::TYPE_ideal)->sum('price')
            + $this->paymentsAdd(PaymentType::TYPE_bank_add)->sum('price')
            + $this->paymentsAdd(PaymentType::TYPE_direct_payment)->sum('price')
            - $this->tallies->sum('price');
    }

    public function totalNotInvoiced()
    {
        return $this->expensesNotInvoiced->sum('price')
            + $this->paymentsAddNotInvoiced(PaymentType::TYPE_ideal)->sum('price')
            + $this->paymentsAddNotInvoiced(PaymentType::TYPE_bank_add)->sum('price')
            + $this->paymentsAddNotInvoiced(PaymentType::TYPE_direct_payment)->sum('price')
            - $this->talliesNotInvoiced->sum('price');
    }

    public function checkNewTalliesForNewInvoice()
    {
        return $this->getNewTalliesForNewInvoice()
            ->whereDate('created_at', '<=', now()->subWeeks(4))
            ->exists();
    }
    public function getNewTalliesForNewInvoice()
    {
        return $this->tallies()
            ->where('status_id', Status::STATUS_ingevoerd);
    }

    public function checkNewPaymentsForNewInvoice($type)
    {
        return $this->getNewPaymentsForNewInvoice($type)
            ->whereDate('created_at', '<=', now()->subWeeks(4))
            ->exists();
    }

    public function getNewPaymentsForNewInvoice($type)
    {
        return $this->paymentsAdd($type)
            ->whereIn('status_id', [Status::STATUS_ingevoerd, Status::STATUS_herberekend]);

    }

    public function checkNewInvalidPaymentsForNewInvoice($type)
    {
        return $this->getNewInvalidPaymentsForNewInvoice($type)
            ->whereDate('created_at', '<=', now()->subWeeks(4))
            ->exists();
    }
    public function getNewInvalidPaymentsForNewInvoice($type)
    {
        return $this->paymentsAdd($type)
            ->whereIn('status_id', [Status::STATUS_ongeldig, Status::STATUS_tercontrole]);
    }

    public function checkNewExpensesForNewInvoice()
    {
        return $this->getNewExpensesForNewInvoice()
            ->whereDate('created_at', '<=', now()->subWeeks(4))
            ->exists();
    }
    public function getNewExpensesForNewInvoice()
    {
        return $this->expenses()
            ->where('status_id', Status::STATUS_ingevoerd);
    }


    public function checkForNewInvoice()
    {
        if ($this->checkNewTalliesForNewInvoice()) {
            return true;
        }

        if ($this->checkNewPaymentsForNewInvoice(PaymentType::TYPE_ideal)) {
            return true;
        }

        if ($this->checkNewPaymentsForNewInvoice(PaymentType::TYPE_bank_add)) {
            return true;
        }

        if ($this->checkNewPaymentsForNewInvoice(PaymentType::TYPE_direct_payment)) {
            return true;
        }

        if ($this->checkNewExpensesForNewInvoice()) {
            return true;
        }

        return false;
    }

    public function generateNewInvoice()
    {
        $invoice = new Invoices();
        $invoice->user_id = $this->id;
        $invoice->name = $this->name . '_' . $invoice->id;
        $invoice->file_name = $this->name . '_TEMP.pdf';
        $invoice->save();
        $invoice->file_name = $this->name . '_' . $invoice->id . '.pdf';

//        $data['tallies'] = $this->getNewTalliesForNewInvoice()->get();
//        $data['payments'] = $this->getNewPaymentsForNewInvoice()->get();
//        $data['invalid_payments'] = $this->getNewInvalidPaymentsForNewInvoice()->get();
//        $data['expenses'] = $this->getNewExpensesForNewInvoice()->get();

        $pdf = Pdf::loadView('pdf.invoice-template', ['user' => $this]);

        if(!$pdf->save($invoice->invoicePath  . $invoice->file_name)) {
            return false;
        }
        if(!$invoice->save()) {
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
