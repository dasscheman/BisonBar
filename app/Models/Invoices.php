<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoices extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'la_invoices';
    public $invoicePath = 'storage/app/invoices/';

    protected $fillable = [
        'id',
        'user_id',
        'name',
        'file_name',
        'send_at',
        'created_at',
        'updated_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }


//    public function genereerFacturen()
//    {
//        $users = User::find()
//            ->where('ISNULL(blocked_at)')
//            ->all();
//        $count = 0;
//        foreach ($users as $user) {
//            $generate = false;
//            if (!$user->getNewAfTransactiesUser()->exists() &&
//                !$user->getNewBijTransactiesUser()->exists() &&
//                !$user->getNewTurvenUsers()->exists() &&
//                !$user->getInvalidTransactionsNotInvoiced()->exists()) {
//                continue;
//            }
//
//            echo "\r\n";
//            echo '-->' . $user->getProfile()->one()->voornaam . " " . $user->getProfile()->one()->achternaam;
//            $turvenModel = $user->getNewTurvenUsers();
//            $turven = $turvenModel->orderBy(['datum'=>SORT_ASC])->one();
//
//            $fourWeeks = Yii::$app->setupdatetime->storeFormat(strtotime("-4 week"), 'datetime');
//
//            if (isset($turven->datum) && $turven->datum < $fourWeeks) {
//                // Als de oudste turf meer dan 4 weken geleden is, dan gaan we een factuur maken.
//                echo "\r\n";
//                echo '--> Nieuwe turven';
//                $generate = true;
//            }
//
//            if (!isset($turven->datum) && isset($turven->turflijst) && $turven->turflijst->end_datum < $fourWeeks) {
//                // Als de oudste turflijst meer dan 4 weken geleden is, dan gaan we een factuur maken.
//                echo "\r\n";
//                echo '--> Nieuwe turven op turflijst';
//                $generate = true;
//            }
//
//            $transactiesModel = $user->getTransactiesUserNietGefactureerd();
//            $transacties = $transactiesModel->one();
//            if (isset($transacties->datum) && $transacties->datum < $fourWeeks) {
//                // Als de oudste transactie meer dan 4 weken geleden is, dan gaan we een factuur maken.
//                $generate = true;
//                echo "\r\n";
//                echo '--> Nieuwe Transacties';
//            }
//
//            $facuur = new Factuur();
//
//            if ($generate && $facuur->createFactuur($user)){
//                echo "\r\n";
//                echo '--> Nieuwe Factuur aangemaakt';
//                $facuur->updateAfterCreateFactuur($user);
//                $count++;
//            }
//        }
//        return $count;
//    }
//
//
//    public function updateAfterCreateFactuur(User $user)
//    {
//        $this->ontvanger = $user->id;
//        $this->pdf = $this->naam . '.pdf';
//
//        $dbTransaction = Yii::$app->db->beginTransaction();
//        try {
//            if (!$this->save()) {
//                $dbTransaction->rollBack();
//                return false;
//            }
//            foreach ($this->new_bij_transacties as $new_bij_transactie) {
//                if (empty($new_bij_transactie)) {
//                    break;
//                }
//                $new_bij_transactie->status = Transacties::STATUS_factuur_gegenereerd;
//                $new_bij_transactie->factuur_id = $this->factuur_id;
//                if (!$new_bij_transactie->save()) {
//                    $dbTransaction->rollBack();
//                    return false;
//                }
//            }
//            foreach ($this->new_af_transacties as $new_af_transactie) {
//                if (empty($new_af_transactie)) {
//                    break;
//                }
//                $new_af_transactie->status = Transacties::STATUS_factuur_gegenereerd;
//                $new_af_transactie->factuur_id = $this->factuur_id;
//                if (!$new_af_transactie->save()) {
//                    $dbTransaction->rollBack();
//                    return false;
//                }
//            }
//            foreach ($this->new_turven as $turf) {
//                if (empty($turf)) {
//                    break;
//                }
//                $turf->status = Turven::STATUS_factuur_gegenereerd;
//                $turf->factuur_id = $this->factuur_id;
//                if (!$turf->save()) {
//                    $dbTransaction->rollBack();
//                    return false;
//                }
//            }
//
//            $dbTransaction->commit();
//            return true;
//        } catch (Exception $e) {
//            Yii::error($e->getMessage());
//        }
//
//        $dbTransaction->rollBack();
//        return false;
//    }
//
//    public function verzendFacturen()
//    {
//        $aantal = 0;
//        $verkoopData = array();
//        $aantalmaanden = 3;
//        foreach (Assortiment::find()->all() as $assortiment) {
//            $i = 0;
//            $count = 0;
//            while ($i <= $aantalmaanden) {
//                $date = date("Ymd", strtotime("-$i months"));
//                $count = $assortiment->getMaandTurven($date)->count() + $count;
//                $i++;
//            }
//            if ($count < 10) {
//                continue;
//            }
//            $verkoopData[$assortiment->name] = $assortiment->getVolumeSerie($aantalmaanden);
//        }
//
//        $facturen = Factuur::find()->where('ISNULL(verzend_datum) and ISNULL(deleted_at)')->all();
//        foreach ($facturen as $factuur) {
//            if ($aantal > 50) {
//                return $aantal;
//            }
//            $user = User::findOne($factuur->ontvanger);
//
//            $message = Yii::$app->mailer->compose('mail', [
//                'user' => $user,
//                'verkoopData' => $verkoopData
//            ])
//                ->setFrom($_ENV['ADMIN_EMAIL'])
//                ->setTo($user->email)
//                ->setSubject('Nota Bison bar')
//                ->attach(Yii::$app->basePath . '/web/uploads/facture/' . $factuur->pdf);
//            if (!empty($user->profile->public_email)) {
//                $message->setCc($user->profile->public_email);
//            }
//            if (!$message->send()) {
//                continue;
//            }
//            $aantal++;
//            $factuur->updateAfterSendFactuur();
//        }
//        return $aantal;
//    }
//
//    public function updateAfterSendFactuur()
//    {
//        $this->verzend_datum = date("Y-m-d H:i:s");
//
//        $transacties = $this->getTransacties()->all();
//        $turven = $this->getTurvens()->all();
//
//        $dbTransaction = Yii::$app->db->beginTransaction();
//        try {
//            foreach ($transacties as $transactie) {
//                if (empty($transactie)) {
//                    break;
//                }
//                $transactie->status = Transacties::STATUS_factuur_verzonden;
//                if (!$transactie->save()) {
//                    $dbTransaction->rollBack();
//                    return false;
//                }
//            }
//
//            foreach ($turven as $turf) {
//                if (empty($turf)) {
//                    break;
//                }
//                $turf->status = Turven::STATUS_factuur_verzonden;
//                if (!$turf->save()) {
//                    $dbTransaction->rollBack();
//                    return false;
//                }
//            }
//
//            if (!$this->save()) {
//                $dbTransaction->rollBack();
//                return false;
//            }
//            $dbTransaction->commit();
//            return true;
//        } catch (Exception $e) {
//            Yii::error($e->getMessage());
//        }
//    }
//
//    /*
//     * Delete factuur based on id.
//     * this is mostly used when a transaction is changed which is allready invoiced.
//     */
//    public function deleteFactuur($id)
//    {
//        $model = Factuur::findOne($id);
//        $dbTransaction = Yii::$app->db->beginTransaction();
//        try {
//            foreach ($model->getTransacties()->all() as $transactie) {
//                $transactie->status = Transacties::STATUS_herberekend;
//                $transactie->factuur_id = null;
//                if (!$transactie->save()) {
//                    $dbTransaction->rollBack();
//
//                    $model->sendErrorReport();
////                    foreach ($transactie->errors as $key => $error) {
////                        Yii::$app->session->setFlash('warning', Yii::t('app', 'Fout met opslaan: ' . $key . ':' . $error[0]));
////                    }
//                    return false;
//                }
//            }
//            foreach ($model->getTurvens()->all() as $turf) {
//                $turf->status = Turven::STATUS_herberekend;
//                $turf->factuur_id = null;
//                if (!$turf->save()) {
//                    $dbTransaction->rollBack();
//
//                    $model->sendErrorReport();
////                    foreach ($turf->errors as $key => $error) {
////                        Yii::$app->session->setFlash('warning', Yii::t('app', 'Fout met opslaan: ' . $key . ':' . $error[0]));
////                    }
//                    return false;
//                }
//            }
//            $model->deleted_at = Yii::$app->setupdatetime->storeFormat(time(), 'datetime');
//            if (!$model->save()) {
//                $dbTransaction->rollBack();
//
//                $model->sendErrorReport();
////                foreach ($factuur->errors as $key => $error) {
////                    Yii::$app->session->setFlash('warning', Yii::t('app', 'Fout met opslaan: ' . $key . ':' . $error[0]));
////                }
//                return false;
//            }
//            $dbTransaction->commit();
//        } catch (\Exception $e) {
//            $model->sendErrorReport($e);
////            Yii::$app->session->setFlash('warning', Yii::t('app', 'Je kunt deze transactie niet verwijderen: ' . $e));
//        }
//
//        return true;
//    }
//
//    public function verzendReminderLimiet()
//    {
//        $user = User::findOne($this->ontvanger);
//
//        $message = Yii::$app->mailer->compose('mail_reminder_limiet', [
//            'user' => $user
//        ])
//            ->setFrom($_ENV['ADMIN_EMAIL'])
//            ->setTo($user->email)
//            ->setSubject('Reminder Bison bar')
//            ->attach(Yii::$app->basePath . '/web/uploads/facture/' . $this->pdf);
//        if (!empty($user->profile->public_email)) {
//            $message->setCc($user->profile->public_email);
//        }
//        try {
//            $message->send();
//        } catch (\Exception $e) {
//            $this->sendErrorReport($e);
//        }
//    }

}
