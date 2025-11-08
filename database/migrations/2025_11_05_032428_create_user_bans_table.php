<?php

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
        Schema::create('user_bans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sort_order')->default(0)->index();
            $table->unsignedBigInteger('user_id')->index();
            $table->unsignedBigInteger('banned_by');
            $table->text('reason');
            $table->string('type')->index();
            $table->timestamp('expires_at')->index()->nullable();
            $table->unsignedBigInteger('unbanned_by')->nullable();
            $table->timestamp('unbanned_at')->nullable();
            $table->text('unban_reason')->nullable();



            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('banned_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('unbanned_by')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('user_bans');
    }
};
