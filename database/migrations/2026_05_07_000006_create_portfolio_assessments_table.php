<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('portfolio_assessments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('portfolio_id')->constrained()->onDelete('cascade');
            $table->foreignId('admin_id')->constrained('users')->onDelete('cascade');
            $table->unsignedTinyInteger('score')->nullable(); // 0-100
            $table->text('feedback')->nullable();
            $table->timestamp('assessed_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('portfolio_assessments');
    }
};
