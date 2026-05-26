<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cv_portfolios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cv_document_id')->constrained()->onDelete('cascade');
            $table->foreignId('portfolio_id')->constrained()->onDelete('cascade');
            $table->unique(['cv_document_id', 'portfolio_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cv_portfolios');
    }
};
