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
        Schema::create('assignments', function (Blueprint $table) {
            $table->id();
            $table->integer('sub_module_id')->nullable();
            $table->integer('created_by')->nullable();
            $table->string('title')->nullable();
            $table->string('image')->nullable();
            $table->text('description')->nullable();
            $table->string('due_date')->nullable();
            $table->string('due_time')->nullable();
            $table->string('scale_type')->nullable();
            $table->string('passing_score')->nullable();
            $table->string('max_score')->nullable();
            $table->tinyInteger('late_submission')->default('0')->comment('0 => No Submission, 1 => late_subnission')->nullable();
            $table->tinyInteger('lock_submission')->default('0')->comment('0 => No Submission, 1 => lock_subnission')->nullable();
            $table->tinyInteger('status')->default('0')->comment('0 => Inactive, 1 => Active, 2 => Deleted')->nullable();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('assignments');
    }
};
