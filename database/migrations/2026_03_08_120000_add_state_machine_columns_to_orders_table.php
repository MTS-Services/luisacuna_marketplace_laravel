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
        Schema::table('orders', function (Blueprint $table) {
            $table->timestamp('delivered_at')->nullable()->after('paid_at');
            $table->timestamp('auto_completes_at')->nullable()->after('delivered_at');
            $table->timestamp('escalated_at')->nullable()->after('auto_completes_at');
            $table->timestamp('resolved_at')->nullable()->after('escalated_at');

            $table->string('resolution_type', 50)->nullable()->after('resolved_at');
            $table->decimal('resolution_buyer_amount', 20, 2)->nullable()->after('resolution_type');
            $table->decimal('resolution_seller_amount', 20, 2)->nullable()->after('resolution_buyer_amount');
            $table->unsignedBigInteger('resolved_by')->nullable()->after('resolution_seller_amount');
            $table->text('resolution_notes')->nullable()->after('resolved_by');

            $table->index('delivered_at');
            $table->index('auto_completes_at');
            $table->index('escalated_at');
            $table->index('resolved_at');
            $table->index('resolution_type');

            $table->foreign('resolved_by')
                ->references('id')
                ->on('admins')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['resolved_by']);

            $table->dropIndex(['delivered_at']);
            $table->dropIndex(['auto_completes_at']);
            $table->dropIndex(['escalated_at']);
            $table->dropIndex(['resolved_at']);
            $table->dropIndex(['resolution_type']);

            $table->dropColumn([
                'delivered_at',
                'auto_completes_at',
                'escalated_at',
                'resolved_at',
                'resolution_type',
                'resolution_buyer_amount',
                'resolution_seller_amount',
                'resolved_by',
                'resolution_notes',
            ]);
        });
    }
};
