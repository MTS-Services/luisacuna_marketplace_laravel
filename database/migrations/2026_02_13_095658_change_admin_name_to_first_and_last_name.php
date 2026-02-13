<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('admins', function (Blueprint $table) {
            // Add new columns
            $table->string('first_name')->nullable()->after('role_id');
            $table->string('last_name')->nullable()->after('first_name');
        });

        // Migrate data from name to first_name and last_name
        DB::table('admins')->get()->each(function ($admin) {
            $nameParts = explode(' ', $admin->name, 2);
            $firstName = $nameParts[0] ?? '';
            $lastName = $nameParts[1] ?? '';

            DB::table('admins')
                ->where('id', $admin->id)
                ->update([
                    'first_name' => $firstName,
                    'last_name' => $lastName,
                ]);
        });

        // Drop old column
        Schema::table('admins', function (Blueprint $table) {
            $table->dropColumn('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('admins', function (Blueprint $table) {
            // Add back the name column
            $table->string('name')->after('role_id');
        });

        // Merge first_name and last_name back into name
        DB::table('admins')->get()->each(function ($admin) {
            $fullName = trim("{$admin->first_name} {$admin->last_name}");

            DB::table('admins')
                ->where('id', $admin->id)
                ->update(['name' => $fullName]);
        });

        // Drop the new columns
        Schema::table('admins', function (Blueprint $table) {
            $table->dropColumn(['first_name', 'last_name']);
        });
    }
};
