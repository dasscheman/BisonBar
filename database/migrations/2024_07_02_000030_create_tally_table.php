<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateTallyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('la_tally_lists', function (Blueprint $table) {
            $table->id();
            $table->string('serial_number');
            $table->timestamp('start_date', 0)->nullable();
            $table->timestamp('end_date', 0)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        $lijsten = DB::table('turflijst')->get();
        foreach ($lijsten as $lijst) {
            $data = [
                'id' => $lijst->turflijst_id,
                'serial_number' => $lijst->volgnummer,
                'start_date' => $lijst->start_datum,
                'end_date' => $lijst->end_datum,
                'created_at' => $lijst->created_at,
                'updated_at' => $lijst->updated_at,
            ];
            \App\Models\TallyList::create($data);
        }

        Schema::create('la_tally', function (Blueprint $table) {
            $table->id();
            $table->integer('tally_list_id')->nullable();
            $table->integer('assortment_id', 0);
            $table->integer('user_id', 0);
            $table->integer('count', 0);
            $table->decimal('price', 5, 2)->default(0);
            $table->integer('type_id');
            $table->integer('status_id')->default(1);
            $table->integer('invoice_id', 0)->nullable();
            $table->integer('payment_id', 0)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        $turven = DB::table('turven')->get();
        foreach ($turven as $turf) {
            $data = [
                'id' => $turf->turven_id,
                'tally_list_id' => $turf->turflijst_id,
                'assortment_id' => $turf->prijslijst_id,
                'user_id' => $turf->consumer_user_id,
                'count' => $turf->aantal,
                'price' => $turf->totaal_prijs,
                'type_id' => $turf->type,
                'status_id' => $turf->status,
                'invoice_id' => $turf->factuur_id,
                'payment_id' => $turf->transacties_id,
                'created_at' => $turf->created_at,
                'updated_at' => $turf->updated_at,
            ];
            \App\Models\Tally::create($data);
        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('la_tally_lists');
        Schema::dropIfExists('la_tally');
    }
}
