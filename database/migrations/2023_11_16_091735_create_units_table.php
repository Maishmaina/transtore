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
        Schema::create('units', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('aisle_id')->index();
            $table->foreign('aisle_id')->references('id')->on('aisles')->onDelete('cascade');
            $table->string('size');
            $table->string('dimension');
            $table->string('weight');
            $table->decimal('price', 10, 2);
            $table->string('available_status')->default('1')->comment('0=booked,1=available');
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
