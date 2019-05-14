<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAdvertisementUsersTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('advertisement_users', function (Blueprint $table) {
            $table->increments('id');
            $table->text('fname');
            $table->text('lname');
            $table->text('mname');
            $table->text('email');
            $table->text('phone');
            $table->text('address');
            $table->text('city');
            $table->text('state');
            $table->text('zip');
            $table->text('country');
            $table->text('suite_number');
            $table->text('ad_budget');
            $table->text('activated');
            $table->text('userid');
            $table->text('basic_details');
            $table->text('address_details');
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
        Schema::drop('advertisement_users');
    }
}
