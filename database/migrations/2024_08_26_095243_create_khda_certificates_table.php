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
        Schema::create('khda_certificates', function (Blueprint $table) {
            $table->id();
            $table->integer('student_id')->nullable();
            $table->string('name_in_arabic')->nullable();
            $table->string('name_in_english')->nullable();
            $table->string('religion')->nullable();
            $table->string('gender')->nullable();  // Corrected 'gendar' to 'gender'
            $table->date('dob')->nullable();
            $table->string('email')->nullable();  // Changed 'text' to 'string'
            $table->string('nationality')->nullable();  // Changed 'text' to 'string'
            $table->string('passport_number')->nullable();  // Changed 'text' to 'string'
            $table->integer('amount')->nullable();  // Corrected 'intege' to 'integer'
            $table->string('order_id')->nullable();  // Changed 'text' to 'string'
            $table->string('passport_image')->nullable();  // Changed 'text' to 'string'
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
        Schema::dropIfExists('khda_certificates');
    }
};
