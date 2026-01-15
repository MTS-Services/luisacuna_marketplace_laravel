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
        Schema::create('hero_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sort_order')->default(0)->index();
            $table->unsignedBigInteger('language_id')->index();
            $table->unsignedBigInteger('hero_id')->index();

            $table->string('title')->nullable();
            $table->text('content')->nullable();
            $table->string('action_title')->nullable();

            $table->foreign('hero_id')->references('id')->on('heroes')->onDelete('cascade');
            $table->foreign('language_id')->references('id')->on('languages')->onDelete('cascade');


            $table->timestamps();

           // $this->addMorphedAuditColumns($table);
            // $this->addAdminAuditColumns($table);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hero_translations');
    }
};
