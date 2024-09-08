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
            $table->text('content_desc')->nullable();
            $table->integer('content_type');
            $table->enum('is_publish', ['0', '1'])->default(1); // 0 = not published, 1 = published
            $table->foreignId('category_id');
            $table->datetime('published_at')->default(now());
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
