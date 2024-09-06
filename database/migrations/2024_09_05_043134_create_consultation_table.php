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
        Schema::create('consultation', function (Blueprint $table) {
            $table->increments('consult_id');
            $table->string('consult_name');
            $table->string('job_name');
            $table->string('consult_email');
            $table->string('phone_number');
            $table->string('consult_title');
            $table->string('consult_category');
            $table->text('consult_desc');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consultation');
    }
};
