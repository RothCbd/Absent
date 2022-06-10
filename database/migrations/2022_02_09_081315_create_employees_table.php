<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('gender');
            $table->integer('postion_id')->unsigned();
            $table->foreign('postion_id')->references('id')->on('positions')->onDelete('cascade');

            $table->string('start_date');
            $table->json('phone_number')->nullable();
            $table->string('pic')->default('default.png');
            $table->string('profile_color');
            $table->boolean('is_inactive')->default(false);
            $table->string('leave_date')->nullable();;
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
        Schema::dropIfExists('employees');
    }
}
