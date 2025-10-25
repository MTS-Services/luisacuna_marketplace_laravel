<?php
 
use App\Enums\SubmittedKycStatus;
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
        Schema::create('submitted_kycs', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('sort_order')->default(0);
            $table->unsignedBigInteger('kyc_setting_id');
            $table->unsignedBigInteger('ckyc_setting_id');
            $table->integer('version');
            $table->string('type');
            $table->string('status')->index()->default(SubmittedKycStatus::PENDING->value);
            $table->json('submitted_data');
            $table->longText('note')->nullable();




 
            $table->foreign('kyc_setting_id')->references('id')->on('kyc_settings')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('ckyc_setting_id')->references('id')->on('country_kyc_settings')->cascadeOnDelete()->cascadeOnUpdate();
    
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
        Schema::dropIfExists('submitted_kycs');
    }
};