<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParticipantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('participants', function(Blueprint $table){
            
            $table->increments('id');
            $table->string('name');
            $table->integer('cpf')->unique();
            $table->string('email');
            $table->integer('phone');
            $table->string('address');
            $table->string('password');
            $table->enum('type', ['student', 'professor', 'community', 'organization']);
            $table->string('university'); //only valid to student and professor
            $table->string('course'); //only valid to student
            $table->string('department');
            $table->string('responsability');
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
        //
        Schema::drop('participants');
    }
}
