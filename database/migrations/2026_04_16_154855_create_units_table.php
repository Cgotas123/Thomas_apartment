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
        Schema::create('units', function (Illuminate\Database\Schema\Blueprint $table) {
            $table->id();
            $table->string('unit_number')->unique();
            $table->integer('floor')->default(1);
            $table->enum('type', ['AC', 'Non-AC'])->default('Non-AC');
            $table->decimal('base_rent', 10, 2);
            $table->enum('status', ['Vacant', 'Occupied', 'Maintenance'])->default('Vacant');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('units');
    }
};
