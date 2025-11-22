<?php

use App\Traits\AuditColumnsTrait;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    use AuditColumnsTrait;
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_ranks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sort_order')->default(0)->index();
            $table->unsignedBigInteger('user_id')->unique();
            $table->unsignedBigInteger('rank_level');
            $table->boolean('is_active')->default(true);
            $table->timestamp('activated_at');



            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('rank_level')->references('id')->on('ranks')->onDelete('cascade');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_ranks');
    }
};
