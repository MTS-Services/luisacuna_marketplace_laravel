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
        Schema::create('kyc_form_fields', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('sort_order')->default(0);
            $table->unsignedBigInteger('section_id');
            $table->string('field_key');
            $table->string('label');
            $table->string('input_type');
            $table->boolean('is_required')->default(false);
            $table->json('validation_rules')->nullable()->comment('{"min": 2, "max": 20, "regex": "^[A-Z0-9]+$"}');
            $table->json('options')->nullable()->comment('["for dropdown/radio"]');
            $table->string('example');
            

            $table->foreign('section_id')->references('id')->on('kyc_form_sections')->cascadeOnDelete()->cascadeOnUpdate();
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
        Schema::dropIfExists('kyc_form_fields');
    }
};