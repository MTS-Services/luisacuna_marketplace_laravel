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
        Schema::create('message_participants', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sort_order')->default(0)->index();
            $table->unsignedBigInteger('message_id')->nullable();
            $table->unsignedBigInteger('participant_id')->nullable();
            $table->string('participant_type')->nullable();



            $table->foreign('message_id')->references('id')->on('messages')->onDelete('cascade');
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
        Schema::dropIfExists('message_participants');
    }
};
