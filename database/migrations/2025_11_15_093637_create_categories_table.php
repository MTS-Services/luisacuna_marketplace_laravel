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
        Schema::create('categories', function (Blueprint $table) {
    $table->id();

            $table->integer('sort_order')->default(0);
            $table->string('name', 100);
            $table->string('slug', 100)->unique();
            $table->text('description')->nullable();
            $table->string('meta_title', 255)->nullable();
            $table->text('meta_description')->nullable();
            $table->string('icon', 255)->nullable();

            $table->boolean('is_featured')->default(false);

            // ENUM status
            $table->enum('status', ['active', 'inactive', 'draft'])->default('active');

            // User activity tracking
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->unsignedBigInteger('restored_by')->nullable();

            // Timestamps
            $table->timestamps();
            $table->softDeletes();
            $table->timestamp('restored_at')->nullable();

            // Indexes
            $table->index('slug', 'idx_slug');
            $table->index('status', 'idx_status');
            $table->index('sort_order', 'idx_sort_order');

            // Foreign keys
            $table->foreign('created_by')->references('id')->on('admins');
            $table->foreign('updated_by')->references('id')->on('admins');
            $table->foreign('deleted_by')->references('id')->on('admins');
            $table->foreign('restored_by')->references('id')->on('admins');
    
           // $this->addMorphedAuditColumns($table);
            // $this->addAdminAuditColumns($table);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
