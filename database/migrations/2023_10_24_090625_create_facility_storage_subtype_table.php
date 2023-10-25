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
        Schema::create('facility_storage_subtype', function (Blueprint $table) {
            $table->foreignId('facility_id')->constrained('facilities');
            $table->foreignId('storage_subtype_id')->constrained('storage_subtypes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('facility_storage_subtype');
    }
};
