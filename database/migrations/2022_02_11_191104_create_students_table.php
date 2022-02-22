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
            $table->string('address')->nullable();
            $table->boolean('sex');
            $table->foreignId('level_id')->references('id')->on('levels');
            $table->string('father')->nullable();
            $table->string('mother')->nullable();
            $table->string('email')->nullable();
            $table->integer('phone1');//Personal phone
            $table->integer('phone2')->nullable();//parent phone
            $table->text('notes')->nullable();
            $table->foreignId('created_by')->references('id')->on('users');
            $table->foreignId('updated_by')->nullable()->references('id')->on('users');
            $table->foreignId('deleted_by')->nullable()->references('id')->on('users');
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
