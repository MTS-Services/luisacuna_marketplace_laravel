<?php

use App\Enums\SellerKycStatus;
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
        Schema::create('seller_kycs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sort_order')->default(0)->index();
            $table->unsignedBigInteger('seller_id')->index();
            
            $table->string('first_name')->nullable()->index();
            $table->string('last_name')->nullable()->index();
            $table->date('dob')->nullable();
            $table->string('nationality')->nullable();
            $table->string('address');
            $table->string('city');
            $table->unsignedBigInteger('country_id');
            $table->string('postal_code');
            // $table->string('document_type'); //DocumentTyp Enum
            $table->string('front_image');
            $table->string('selfie_image')->nullable();
            $table->string('seller_experience')->nullable(); //SellerExperience Enum
            //if Company 

            $table->string('company_name')->nullable();
            // $table->string('company_name')->nullable();
            $table->string('company_license_number')->nullable();
            $table->string('company_tax_number')->nullable();


            $table->string('status')->index()->default(SellerKycStatus::PENDING->value);



            $table->softDeletes();
            $table->timestamps();

            $table->foreign('seller_id')->references('id')->on('users')->onDeleteNull();
            $table->foreign('country_id')->references('id')->on('countries')->onDeleteNull();
            
            $this->addMorphedAuditColumns($table);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seller_kycs');
    }
};
