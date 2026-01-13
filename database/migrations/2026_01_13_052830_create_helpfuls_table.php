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
        Schema::create('helpfuls', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sort_order')->default(0)->index();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('ip_address')->index();
            $table->string('type')->index();
            $table->timestamps();
            $table->unsignedBigInteger('cms_id')->index();
           $this->addMorphedAuditColumns($table);
            // $this->addAdminAuditColumns($table);

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('cms_id')->references('id')->on('cms')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('helpfuls');
    }
};
