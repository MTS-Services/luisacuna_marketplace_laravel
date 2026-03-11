<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->unsignedTinyInteger('cancel_attempts')->default(0)->after('is_disputed');
            $table->unsignedTinyInteger('delivery_attempts')->default(0)->after('cancel_attempts');
            $table->string('cancel_requested_by', 20)->nullable()->after('delivery_attempts')
                ->comment('buyer or seller — who initiated the cancel request');
            $table->timestamp('auto_cancels_at')->nullable()->after('auto_completes_at');

            $table->index('auto_cancels_at');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropIndex(['auto_cancels_at']);
            $table->dropColumn([
                'cancel_attempts',
                'delivery_attempts',
                'cancel_requested_by',
                'auto_cancels_at',
            ]);
        });
    }
};
