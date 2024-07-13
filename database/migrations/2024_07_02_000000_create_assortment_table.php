<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateAssortmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('la_assortments', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
            $table->decimal('price')->default(0);
            $table->integer('category_id')->default(1);
            $table->integer('status_id')->default(1);
            $table->softDeletes();
            $table->timestamps();
        });


        $prices = DB::table('prijslijst')->get();
        foreach ($prices as $price) {
            $eenheid = DB::table('eenheid')->where('eenheid_id', $price->eenheid_id)->first();
            $assortiment = DB::table('assortiment')->where('assortiment_id', $eenheid->assortiment_id)->first();
            $data = [
                'id' => $price->prijslijst_id,
                'name' => $eenheid->name,
                'price' => $price->prijs,
                'category_id' => $assortiment->soort,
                'status_id' => $assortiment->status,
                'created_at' => $price->created_at,
                'updated_at' => $price->updated_at,
            ];

            \App\Models\Assortment::create($data);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('la_assortments');
    }
}
