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
        Schema::create('scrubbed_data', function (Blueprint $table) {
        $table->id();
        $table->string('original_content');
        $table->string('cleaned_content');
        $table->string('type'); // e.g., email, phone, html
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scrubbed_data');
    }
};
