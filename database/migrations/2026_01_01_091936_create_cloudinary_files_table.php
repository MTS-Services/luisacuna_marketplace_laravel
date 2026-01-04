<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cloudinary_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');

            // Cloudinary fields
            $table->string('public_id')->unique();
            $table->text('url');
            $table->string('resource_type')->default('image'); // image, video, raw
            $table->string('format')->nullable(); // jpg, png, mp4, pdf, etc.
            $table->string('folder')->nullable();

            // File metadata
            $table->unsignedBigInteger('size')->nullable(); // Size in bytes
            $table->unsignedInteger('width')->nullable(); // For images/videos
            $table->unsignedInteger('height')->nullable(); // For images/videos
            $table->decimal('duration', 10, 2)->nullable(); // For videos/audio in seconds

            // Additional metadata
            $table->string('original_filename')->nullable();
            $table->text('description')->nullable();
            $table->json('tags')->nullable();
            $table->json('metadata')->nullable(); // Store any additional Cloudinary metadata

            // Soft deletes
            $table->softDeletes();
            $table->timestamps();

            // Indexes
            $table->index('user_id');
            $table->index('resource_type');
            $table->index('folder');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cloudinary_files');
    }
};
