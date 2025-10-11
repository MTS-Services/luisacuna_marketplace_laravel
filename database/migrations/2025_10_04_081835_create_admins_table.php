<?php

use App\Enums\AdminStatus;
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
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->timestamp('last_synced_at')->nullable();

            $table->string('otp')->nullable();
            $table->timestamp('otp_expires_at')->nullable();

            $table->string('phone')->index()->nullable();
            $table->text('address')->nullable();
            $table->string('status')->index()->default(AdminStatus::ACTIVE->value);
            $table->string('avatar')->nullable();

            $table->rememberToken();
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
        Schema::dropIfExists('admins');
    }
};
