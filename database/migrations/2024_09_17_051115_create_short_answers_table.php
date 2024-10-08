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
        Schema::create('short_answers', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
           //$table->unsignedBigInteger('course_id');
            $table->unsignedBigInteger('assignment_id')->nullable();
            $table->integer('question_id')->nullable();
            $table->text('answer')->nullable();
            $table->tinyInteger('status')->default(0)->comment('0=> pending, 1 => pass, 2 => faile');
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
        Schema::dropIfExists('short_answers');
    }
};
