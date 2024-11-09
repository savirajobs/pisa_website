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
        Schema::create('wslogs', function (Blueprint $table) {
            $table->id();
            $table->string('endpoint');
            $table->string('identifier');
            $table->text('identifier_data');
            $table->text('request_data');
            $table->text('response_data');
            $table->string('status');
            $table->string('ip_address');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wslogs');
    }
};
