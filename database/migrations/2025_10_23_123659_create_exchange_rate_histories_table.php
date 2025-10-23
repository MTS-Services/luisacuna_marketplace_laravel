<?php

use App\Traits\AuditColumnsTrait;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    use AuditColumnsTrait;
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('exchange_rate_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sort_order')->default(0);
            $table->unsignedBigInteger('base_currency');
            $table->unsignedBigInteger('target_currency');
            $table->decimal('rate', 10, 6);
            $table->timestamp('last_updated_at');


            $table->softDeletes();
            $table->timestamps();
            $this->addAdminAuditColumns($table);


            // indexs
            $table->index('sort_order');
            $table->index('last_updated_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exchange_rate_histories');
    }
};
