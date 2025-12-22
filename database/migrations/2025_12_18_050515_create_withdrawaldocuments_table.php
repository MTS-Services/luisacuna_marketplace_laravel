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
        Schema::create('withdrawaldocuments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sort_order')->default(0)->index();
            $table->unsignedBigInteger('withdrawal_request_id')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('verified_by')->nullable()->constrained('users')->onDelete('set null');
            $table->string('document_type', 100)->comment('e.g., ID proof, address proof');
            $table->string('file_path', 500);
            $table->string('file_name');
            $table->unsignedInteger('file_size');
            $table->string('mime_type', 100);
            $table->boolean('is_verified')->default(false);
            $table->timestamp('verified_at')->nullable();
            // $table->timestamp('created_at')->useCurrent();

            // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('withdrawal_request_id')->references('id')->on('withdrawal_requests')->onDelete('cascade');
            $table->foreign('verified_by')->references('id')->on('users')->onDelete('cascade');

            $table->softDeletes();
            $table->timestamps();

           $this->addMorphedAuditColumns($table);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('withdrawaldocuments');
    }
};
