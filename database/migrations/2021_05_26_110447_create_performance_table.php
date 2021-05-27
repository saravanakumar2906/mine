<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePerformanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('performance', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->unsigned();
           // $table->foreign('user_id')->references('id')->on('users');
            $table->string('year');
            $table->decimal('rate');
            $table->dateTime('deleted_at', $precision = 0);
            $table->timestamps();
        });
        Schema::table('performance', function($table) {
       $table->foreign('user_id')->references('id')->on('users');
   });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('performance');
    }
}
