<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDriverStripesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('driver_stripes', function (Blueprint $table) {
            $table->increments('id');
            $table->text('userid');
            $table->text('cardNo');
            $table->text('fingerprint');
            $table->text('status');
            $table->text('token');
            $table->text('brand');
            $table->text('customerId');
            $table->text('digits');
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
        Schema::drop('driver_stripes');
    }
}
