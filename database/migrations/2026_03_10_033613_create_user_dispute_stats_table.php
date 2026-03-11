<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_dispute_stats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained('users')->cascadeOnDelete();
            $table->unsignedInteger('total_orders')->default(0);
            $table->unsignedInteger('total_disputes')->default(0);
            $table->unsignedInteger('won_disputes')->default(0);
            $table->unsignedInteger('lost_disputes')->default(0);
            $table->decimal('dispute_rate', 5, 2)->default(0);
            $table->decimal('positive_rate', 5, 2)->default(0);
            $table->decimal('negative_rate', 5, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_dispute_stats');
    }
};
