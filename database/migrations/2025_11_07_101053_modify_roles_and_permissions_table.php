<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Traits\AuditColumnsTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    use AuditColumnsTrait, SoftDeletes;
    public function up(): void
    {
        Schema::table('roles', function (Blueprint $table) {
            $table->unsignedBigInteger('sort_order')->default(0)->after('id')->index();
            $this->addAdminAuditColumns($table);
            $table->softDeletes();
        });
        Schema::table('permissions', function (Blueprint $table) {
            $table->unsignedBigInteger('sort_order')->default(0)->after('id')->index();
            $table->string('prefix')->index()->after('guard_name');
            $this->addAdminAuditColumns($table);
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('roles', function (Blueprint $table) {
            $table->dropColumn('sort_order');
            $this->dropAdminAuditColumns($table);
            $table->dropSoftDeletes();
        });
        Schema::table('permissions', function (Blueprint $table) {
            $table->dropColumn(['sort_order', 'prefix']);
            $this->dropAdminAuditColumns($table);
            $table->dropSoftDeletes();
        });
    }
};
