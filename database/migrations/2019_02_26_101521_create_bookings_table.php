<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatebookingsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->increments('id');
            $table->text('userid');
            $table->text('phone');
            $table->text('completed');
            $table->text('source');
            $table->text('destination');
            $table->text('price');
            $table->text('distance');
            $table->text('trip_date');
            $table->text('trip_time');
            $table->text('source_description');
            $table->text('destination_description');
            $table->text('alternate_phone');
            $table->text('statu');
            $table->text('image');
            $table->text('payment');
            $table->text('paid');
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
        Schema::drop('bookings');
    }
}
