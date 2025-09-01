<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Drop the old pdfs table if it exists
        Schema::dropIfExists('pdfs');
    }

    public function down(): void
    {
        // If you want to rollback, recreate pdfs table
        Schema::create('pdfs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('path');
            $table->timestamps();
        });
    }
};
