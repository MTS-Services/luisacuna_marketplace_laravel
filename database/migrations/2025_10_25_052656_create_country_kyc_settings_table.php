<?php
 
use App\Traits\AuditColumnsTrait;
use App\Enums\CountryKycSettingStatus;
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
        Schema::create('country_kyc_settings', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('sort_order')->default(0);
            $table->unsignedBigInteger('kyc_setting_id');
            $table->unsignedBigInteger('country_id');
    

            $table->string('type');
            $table->string('status')->index()->default(CountryKycSettingStatus::ACTIVE->value);
            $table->integer('version')->default(1);
            




            $table->foreign('kyc_setting_id')->references('id')->on('kyc_settings')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('country_id')->references('id')->on('countries')->cascadeOnDelete()->cascadeOnUpdate();


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
        Schema::dropIfExists('country_kyc_settings');
    }
};