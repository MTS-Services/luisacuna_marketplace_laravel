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
        Schema::create('emial_templates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sort_order')->default(0);
            $table->string('key')->unique();
            $table->string('name');
            $table->string('subject')->nullable();
            $table->longText('template')->nullable();
            $table->json('variables')->nullable();


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
        Schema::dropIfExists('emial_templates');
    }
};
