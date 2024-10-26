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
        Schema::create('posts', function (Blueprint $table) {
            $table->string('post_id')->primary();
            $table->string('post_title');
            $table->string('slug')->unique();
            $table->text('post_desc')->nullable();
            $table->string('post_type');
            $table->integer('is_publish'); // 0 = not published, 1 = published
            $table->integer('category_id')->nullable();
            $table->datetime('event_at')->nullable();
            $table->string('notes')->nullable();
            //$table->datetime('upcoming_date')->nullable();
            $table->foreignId('created_by')->nullable()->references('id')->on('users');
            $table->foreignId('updated_by')->nullable()->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
