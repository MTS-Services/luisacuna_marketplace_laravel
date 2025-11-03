<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('email_templates', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('sort_order')->default(0);
            $table->string('key', 191)->unique(); // slug-like key
            $table->string('name', 255);
            $table->string('subject')->nullable();
            $table->longText('body')->nullable(); // "template" → more semantic name
            $table->json('variables')->nullable();

            // Audit timestamps
            $table->timestamps();
            $table->softDeletes();
            $table->timestamp('restored_at')->nullable();

            // Audit users
            $table->foreignId('created_by')->constrained('admins')->cascadeOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('admins')->nullOnDelete();
            $table->foreignId('deleted_by')->nullable()->constrained('admins')->nullOnDelete();
            $table->foreignId('restored_by')->nullable()->constrained('admins')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('email_templates');
    }
};


