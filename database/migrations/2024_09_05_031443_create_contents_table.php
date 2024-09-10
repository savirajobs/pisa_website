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
        Schema::create('contents', function (Blueprint $table) {
            $table->string('content_id')->primary();
            $table->string('content_title');
            $table->string('slug');
            $table->text('content_desc')->nullable();
            $table->string('content_type');
            $table->integer('is_publish'); // 0 = not published, 1 = published
            $table->integer('category_id');
            $table->datetime('published_at');
            $table->datetime('upcoming_date')->nullable();
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
        Schema::dropIfExists('contents');
    }
};
