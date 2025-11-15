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
        Schema::create('category_translations', function (Blueprint $table) {
             $table->id();

            // Relations
            $table->foreignId('game_category_id')
                ->constrained('categories')
                ->cascadeOnDelete();

            $table->foreignId('language_id')
                ->constrained('languages')
                ->cascadeOnDelete();

            // Content fields
            $table->string('name', 100);
            $table->text('description')->nullable();
            $table->string('meta_title', 255)->nullable();
            $table->text('meta_description')->nullable();

            $table->boolean('is_auto_translated')->default(true);

            // Audit timestamps
            $table->timestamps();
            $table->softDeletes(); // deleted_at
            $table->timestamp('restored_at')->nullable();

            // Audit by columns
            $table->foreignId('created_by')
                ->constrained('admins');

            $table->foreignId('updated_by')
                ->nullable()
                ->constrained('admins');

            $table->foreignId('deleted_by')
                ->nullable()
                ->constrained('admins');

            $table->foreignId('restored_by')
                ->nullable()
                ->constrained('admins');

            // Unique constraint
            $table->unique(['game_category_id', 'language_id'], 'unique_category_language');
           // $this->addMorphedAuditColumns($table);
            // $this->addAdminAuditColumns($table);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('category_translations');
    }
};
