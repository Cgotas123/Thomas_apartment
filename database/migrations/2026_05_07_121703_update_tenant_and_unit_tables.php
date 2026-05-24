<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('tenants', function (Blueprint $table) {
            // move_in_date already added by previous migration 2026_05_07_054044
        });

        Schema::table('units', function (Blueprint $table) {
            // No changes needed for unit management yet
        });
        
        Schema::table('meter_readings', function (Blueprint $table) {
            if (!Schema::hasColumn('meter_readings', 'status')) {
                $table->enum('status', ['Draft', 'Posted'])->default('Draft')->after('cost');
            }
        });

        Schema::table('maintenance_requests', function (Blueprint $table) {
            $table->string('photo_path')->nullable()->after('description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tenants', function (Blueprint $table) {
            //
        });
    }
};
