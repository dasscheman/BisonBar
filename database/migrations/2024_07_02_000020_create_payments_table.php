<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('la_payments', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('receipt_id')->nullable();
            $table->integer('invoice_id')->nullable();
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->decimal('price', 5, 2)->default(0);
            $table->boolean('add_subtract');
            $table->integer('type_id');
            $table->integer('status_id')->default(1);
            $table->integer('mollie_status')->nullable();
            $table->string('mollie_id')->nullable();
            $table->string('transaction_key')->nullable();
            $table->string('transaction_cost')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        $transacties = DB::table('transacties')->whereIn('type_id', [1, 2, 3, 8, 9, 17])->get();
        foreach ($transacties as $transactie) {
            $type = DB::table('betaling_type')->where('type_id', $transactie->type_id)->first();
            $data = [
                'id' => $transactie->transacties_id,
                'user_id' => $transactie->transacties_user_id,
                'receipt_id' => $transactie->bon_id,
                'invoice_id' => $transactie->factuur_id,
                'name' => $transactie->omschrijving,
                'description' => $type->omschrijving,
                'price' => $transactie->bedrag,
                'add_subtract' => $type->bijaf,
                'type_id' => $transactie->type_id,
                'status_id' => $transactie->status,
                'mollie_status' => $transactie->mollie_status,
                'mollie_id' => $transactie->mollie_id,
                'transaction_key' => $transactie->transactie_key,
                'transaction_cost' => $transactie->transactie_kosten,
                'created_at' => $transactie->created_at,
                'updated_at' => $transactie->updated_at,
            ];

            \App\Models\Payment::create($data);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('la_payments');
    }
}
