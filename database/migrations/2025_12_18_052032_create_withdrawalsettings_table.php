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
        Schema::create('withdrawalsettings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sort_order')->default(0)->index();
            $table->string('setting_key', 100)->unique();
            $table->text('setting_value');
            $table->string('setting_type', 50)->default('string')->comment('string, number, boolean, json');
            $table->text('description')->nullable();
            $table->boolean('is_public')->default(false)->comment('Can be accessed by users');

            $table->softDeletes();
            $table->timestamps();

           $this->addMorphedAuditColumns($table);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('withdrawalsettings');
    }
};
