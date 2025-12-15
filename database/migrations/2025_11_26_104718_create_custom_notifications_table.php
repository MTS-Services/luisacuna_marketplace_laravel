<?php

use App\Enums\CustomNotificationType;
use App\Traits\AuditColumnsTrait;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    use AuditColumnsTrait;
    
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('custom_notifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sort_order')->default(0);

            $table->unsignedBigInteger('sender_id')->nullable()->index();
            $table->string('sender_type')->nullable()->index();

            $table->unsignedBigInteger('receiver_id')->nullable()->index();
            $table->string('receiver_type')->nullable()->index();

            $table->string('type')->default(CustomNotificationType::PUBLIC)->index();
            $table->boolean('is_announced')->default(false);
            $table->string('action')->nullable();
            
            // JSON columns for structured data
            $table->json('data')->nullable();
            $table->json('additional')->nullable();

            $table->timestamps();
        });

        // Add virtual/generated columns for fast searching
        DB::statement('
            ALTER TABLE custom_notifications 
            ADD COLUMN title_searchable VARCHAR(500) 
            GENERATED ALWAYS AS (JSON_UNQUOTE(JSON_EXTRACT(data, "$.title"))) STORED
        ');

        DB::statement('
            ALTER TABLE custom_notifications 
            ADD COLUMN message_searchable TEXT 
            GENERATED ALWAYS AS (JSON_UNQUOTE(JSON_EXTRACT(data, "$.message"))) STORED
        ');

        DB::statement('
            ALTER TABLE custom_notifications 
            ADD COLUMN description_searchable TEXT 
            GENERATED ALWAYS AS (JSON_UNQUOTE(JSON_EXTRACT(data, "$.description"))) STORED
        ');

        // Add indexes on generated columns for ultra-fast searching
        Schema::table('custom_notifications', function (Blueprint $table) {
            $table->index('title_searchable');
            $table->fullText(['title_searchable', 'message_searchable', 'description_searchable'], 'notifications_fulltext_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop indexes first
        Schema::table('custom_notifications', function (Blueprint $table) {
            $table->dropIndex(['title_searchable']);
            $table->dropFullText('notifications_fulltext_index');
        });

        // Drop generated columns
        DB::statement('ALTER TABLE custom_notifications DROP COLUMN title_searchable');
        DB::statement('ALTER TABLE custom_notifications DROP COLUMN message_searchable');
        DB::statement('ALTER TABLE custom_notifications DROP COLUMN description_searchable');

        Schema::dropIfExists('custom_notifications');
    }
};