<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserRoleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_role', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->unsigned();
           // $table->foreign('user_id')->references('id')->on('users');
           // $table->foreign('role_id')->references('id')->on('roles');
            $table->timestamps();
        });
        Schema::table('user_role', function($table) {
       $table->foreign('user_id')->references('id')->on('users');
   });
        Schema::table('user_role', function($table) {
       $table->foreign('role_id')->references('id')->on('roles');
   });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_role');
    }
}
