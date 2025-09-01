<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tenants_pdfs', function (Blueprint $table) {
            $table->id();
            $table->string('name');   // Original file name
            $table->string('path');   // Storage path
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tenants_pdfs');
    }
};
