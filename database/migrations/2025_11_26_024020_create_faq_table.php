<?php

use App\Enums\FaqStatus;
use App\Enums\FaqType;
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
        Schema::create('faq', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sort_order')->default(0)->index();
            $table->string('status')->index()->default(FaqStatus::ACTIVE->value);
            $table->string('type')->index()->default(FaqType::BUYER->value);
            $table->string('question');
            $table->text('answer');

            $table->softDeletes();
            $table->timestamps();

           // $this->addMorphedAuditColumns($table);
            $this->addAdminAuditColumns($table);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('faq');
    }
};
