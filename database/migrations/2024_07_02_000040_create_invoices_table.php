<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('la_invoices', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('name');
            $table->string('file_name');
            $table->timestamp('send_at', 0)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        $facturen = DB::table('factuur')->get();
        foreach ($facturen as $factuur) {
            $data = [
                'id' => $factuur->factuur_id,
                'user_id' => $factuur->ontvanger,
                'name' => $factuur->naam,
                'file_name' => $factuur->pdf,
                'send_at' => $factuur->verzend_datum,
                'created_at' => $factuur->created_at,
                'updated_at' => $factuur->updated_at,
            ];
            \App\Models\Invoices::create($data);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('la_invoices');
    }
}
