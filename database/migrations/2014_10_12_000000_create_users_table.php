<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nom', 255);
            $table->string('prenom', 255);
            $table->string('login', 255);
            $table->string('password', 255);
            $table->integer('age')->nullable();
            $table->string('role', 15);
            $table->integer('num_tel')->nullable();
            $table->string('status', 255)->nullable();
            $table->string('mission_id', 255)->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
