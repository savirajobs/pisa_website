<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('feedbacks', function (Blueprint $table) {
            $table->id('feedback_id');
            $table->string('feedback_title');
            $table->string('slug')->unique();
            $table->string('sender_name');
            $table->string('email');
            $table->string('phone');
            $table->integer('feedback_category');
            $table->string('feedback_desc');
            $table->integer('verification_status')->nullable();
            $table->integer('spam_status')->nullable(); //1 = spam, 0 = bukan spam
            $table->integer('duplication_status')->nullable(); //1 = ada duplikasi, 0 = tidak ada duplikasi
            $table->integer('reply_status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feedbacks');
    }
};
