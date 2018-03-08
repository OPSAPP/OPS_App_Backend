<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateElecteursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('electeurs', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('nom', 255)->nullable();
            $table->string('prenom', 255)->nullable();
            $table->string('prenom_pere', 255)->nullable();
            $table->string('prenom_grand_pere', 255)->nullable();
            $table->integer('age')->nullable();
            $table->string('gender', 10)->nullable();
            $table->string('centre_de_vote', 255)->nullable();
            $table->string('situation_familiale', 255)->nullable();
            $table->string('situation_pro', 255)->nullable();
            $table->boolean('isElecteur')->nullable();
            $table->string('orientation_de_vote', 255)->nullable();
            $table->string('intention_de_vote', 255)->nullable();
            $table->string('adresse', 255)->nullable();
            $table->string('niveau_academique', 255)->nullable();
            $table->string('remarque', 255)->nullable();
            $table->integer('num_tel')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('electeurs');
    }
}
