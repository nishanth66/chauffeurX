<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatedriverBasicDetailsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('driver_basic_details', function (Blueprint $table) {
            $table->increments('id');
            $table->text('driverid');
            $table->text('address');
            $table->text('city');
            $table->text('state');
            $table->text('country');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('driver_basic_details');
    }
}
