<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserMissionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_mission', function(Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('user_id');
            // $table->integer('mission_id');
            $table->string('location_lat', 255)->nullable();
            $table->string('location_long', 255)->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('user_mission');
    }
}
