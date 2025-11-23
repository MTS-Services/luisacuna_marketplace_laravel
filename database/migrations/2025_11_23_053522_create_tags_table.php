<?php

use App\Enums\TagStatus;
use App\Traits\AuditColumnsTrait;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    use AuditColumnsTrait;
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sort_order')->default(0)->index();
            $table->string('name');
            $table->string('slug')->unique()->index();
            $table->string('status')->index()->default(TagStatus::ACTIVE->value);
            $table->string('icon')->nullable();
            $table->string('text_color')->nullable();
            $table->string('bg_color')->nullable();

            $table->softDeletes();
            $table->timestamps();
            $this->addAdminAuditColumns($table);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tags');
    }
};
