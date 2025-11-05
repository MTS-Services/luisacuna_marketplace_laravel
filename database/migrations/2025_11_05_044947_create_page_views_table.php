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
        Schema::create('page_views', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('sort_order')->default(0);
            $table->string('viewable_type')->index();
            $table->unsignedBigInteger('viewable_id')->index();
            $table->string('viewer_type')->index()->nullable();
            $table->unsignedBigInteger('viewer_id')->index()->nullable();
            $table->string('ip_address');
            $table->text('user_agent')->nullable();
            $table->text('referrer')->nullable();

    
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
        Schema::dropIfExists('page_views');
    }
};