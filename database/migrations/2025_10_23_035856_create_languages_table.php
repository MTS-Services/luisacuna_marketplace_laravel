<?php

use App\Enums\LanguageStatus;
use App\Enums\LanguageDirection;
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
        Schema::create('languages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sort_order')->default(0);
            $table->string('locale')->unique();
            $table->string('name')->unique();
            $table->string('native_name')->nullabl();
            $table->string('status')->index()->default(LanguageStatus::ACTIVE->value);
            $table->boolean('is_active')->default(false);
            $table->string('direction')->index()->default(LanguageDirection::LTR->value);

            $table->timestamps();
            $table->softDeletes();
            $this->addMorphedAuditColumns($table);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('languages');
    }
};
