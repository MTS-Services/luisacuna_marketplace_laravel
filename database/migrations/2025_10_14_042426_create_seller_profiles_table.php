<?php

use App\Enums\SellerLevel;
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
        Schema::create('seller_profiles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sort_order')->default(0)->index();
            $table->unsignedBigInteger('user_id');
            $table->string('country');
            $table->boolean('account_type');
            $table->string('first_name')->nullable();
            $table->string( 'last_name')->nullable();
            $table->string('date_of_birth')->nullable();
            $table->string('nationality')->nullable()->index();
            $table->text('street_address');
            $table->string('city')->index();
            $table->string('postal_code');
            $table->boolean('is_experienced_seller')->index()->default(false);
            $table->string('identification')->comment("Accepted documents: Driver's license, Government issued ID or Passport, international student ID. Max:10MB file size.");
            $table->string('selfie_image')->nullable();

            $table->string('company_documents')->nullable();
            $table->string('company_name')->nullable();
            $table->string('company_license_number')->nullable();
            $table->string('company_tax_number')->nullable();

            $table->boolean('id_verified')->index()->default(false);
            $table->timestamp('id_verified_at')->nullable();
            $table->boolean('seller_verified')->index()->default(false);
            $table->timestamp('seller_verified_at')->nullable();

            $table->string('seller_level')->default(SellerLevel::BRONZE->value);

            $table->decimal('commission_rate', 15, 2)->default(0.00);
            $table->decimal('minimum_payout', 15, 2)->default(0.00);

            $table->timestamps();
            $table->softDeletes();
            $this->addMorphedAuditColumns($table);

            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete()->cascadeOnUpdate();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seller_profiles');
    }
};
