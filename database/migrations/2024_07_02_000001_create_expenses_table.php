<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('la_expenses', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('receipt_id')->nullable();
            $table->integer('invoice_id')->nullable();
            $table->string('description')->nullable();
            $table->decimal('price')->default(0);
            $table->integer('status_id')->default(1);
            $table->softDeletes();
            $table->timestamps();
        });


        $transacties = DB::table('transacties')->where('type_id', 5)->get();
        foreach ($transacties as $transactie) {
            $relatedjoin = DB::table('related_transacties')->where('child_transacties_id', $transactie->transacties_id)->first();
            if($relatedjoin) {
                $related = DB::table('transacties')->where('transacties_id', $relatedjoin->parent_transacties_id)->first();
                if($related->bedrag == $transactie->bedrag) {
                    dump('skip transactie: ' . $transactie->transacties_id);
                }
            }
            $data = [
                'id' => $transactie->transacties_id,
                'user_id' => $transactie->transacties_user_id,
                'receipt_id' => $transactie->bon_id,
                'invoice_id' => $transactie->factuur_id,
                'description' => $transactie->omschrijving,
                'price' => $transactie->bedrag,
                'status_id' => $transactie->status,
                'created_at' => $transactie->created_at,
                'updated_at' => $transactie->updated_at,
            ];

            \App\Models\Expenses::create($data);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('la_expenses');
    }
}
