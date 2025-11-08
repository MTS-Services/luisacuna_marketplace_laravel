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
        Schema::create('application_settings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sort_order')->default(0)->index();
            $table->string('key')->unique();
            $table->string('env_key')->nullable();


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
        Schema::dropIfExists('application_settings');
    }
};
