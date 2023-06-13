<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('r_a_b_details', function (Blueprint $table) {
            $table->id();
            $table->string('no_trx')->nullable();
            $table->integer('id_product')->nullable();
            $table->integer('price')->nullable();
            $table->integer('qty')->nullable();
            $table->integer('sub_total')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('r_a_b_details');
    }
};
