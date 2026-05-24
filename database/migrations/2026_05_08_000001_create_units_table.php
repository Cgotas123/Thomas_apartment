<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('units', function (Blueprint $table) {
            $table->id();
            $table->string('unit_number')->unique();
            $table->integer('floor');
            $table->enum('type', ['studio', '1br', '2br', '3br'])->default('studio');
            $table->decimal('monthly_rent', 10, 2);
            $table->enum('status', ['vacant', 'occupied', 'maintenance'])->default('vacant');
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('units');
    }
};
