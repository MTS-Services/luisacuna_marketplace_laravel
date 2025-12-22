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
        Schema::create('withdrawal_status_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sort_order')->default(0)->index();
            $table->unsignedBigInteger('withdrawal_request_id');
            $table->unsignedBigInteger('changed_by')->nullable();
            $table->string('from_status', 50)->nullable();
            $table->string('to_status', 50);
            $table->text('notes')->nullable();
            $table->json('metadata')->nullable()->comment('Additional data about status change');
            $table->timestamp('created_at')->useCurrent();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('withdrawal_request_id')->references('id')->on('withdrawal_requests')->onDelete('cascade');
            $table->foreign('changed_by')->references('id')->on('users')->onDelete('cascade');

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
        Schema::dropIfExists('withdrawal_status_histories');
    }
};
