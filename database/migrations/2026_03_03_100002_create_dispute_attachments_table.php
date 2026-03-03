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
        Schema::create('dispute_attachments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sort_order')->default(0)->index();

            $table->unsignedBigInteger('dispute_id')->index();
            $table->unsignedBigInteger('uploaded_by')->index();

            $table->string('disk')->nullable();
            $table->string('path');
            $table->string('original_name')->nullable();
            $table->string('mime_type')->nullable();
            $table->unsignedBigInteger('size')->nullable();

            $table->string('attachment_type')->nullable()->index();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('dispute_id')
                ->references('id')
                ->on('disputes')
                ->onDelete('cascade');

            $table->foreign('uploaded_by')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dispute_attachments');
    }
};

