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
        Schema::create('exchange_rates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sort_order')->default(0)->index();
            $table->unsignedBigInteger('base_currency');
            $table->unsignedBigInteger('target_currency');
            $table->decimal('rate', 20, 6);
            $table->timestamp('last_updated_at')->index();


            $table->softDeletes();
            $table->timestamps();
            $this->addAdminAuditColumns($table);


            $table->foreign('base_currency')->references('id')->on('currencies')->onDelete('cascade');
            $table->foreign('target_currency')->references('id')->on('currencies')->onDelete('cascade');


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exchange_rates');
    }
};
