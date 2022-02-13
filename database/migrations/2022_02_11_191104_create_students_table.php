<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('lname');
            $table->string('fname');
            $table->date('birthdate');
            $table->string('birthplace')->nullable();
            $table->boolean('sex');
            $table->foreignId('level_id')->references('id')->on('levels');
            $table->string('father');
            $table->string('mother');
            $table->string('email')->nullable();
            $table->integer('phone1');
            $table->integer('phone2')->nullable();
            $table->text('notes')->nullable();
            $table->foreignId('created_by')->references('id')->on('users');
            $table->foreignId('updated_by')->references('id')->on('users');
            $table->foreignId('deleted_by')->references('id')->on('users');
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
        Schema::dropIfExists('students');
    }
};
