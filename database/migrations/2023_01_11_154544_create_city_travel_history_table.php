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
        Schema::create('city_travel_history', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('traveller_id')->unsigned()->nullable(false);
            $table->bigInteger('city_id')->unsigned()->nullable(false);
            $table->date('from_date')->nullable(false);
            $table->date('to_date')->nullable(false);

            $table->foreign('traveller_id')->references('id')->on('travelers');
            $table->foreign('city_id')->references('id')->on('cities');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('city_travel_history');
    }
};
