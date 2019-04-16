<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatedriverVerificationsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('driver_verifications', function (Blueprint $table) {
            $table->increments('id');
            $table->text('licence');
            $table->text('licence_expire');
            $table->text('car_inspection');
            $table->text('car_reg');
            $table->text('car_insurance');
            $table->text('driving_licence');
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
        Schema::drop('driver_verifications');
    }
}
