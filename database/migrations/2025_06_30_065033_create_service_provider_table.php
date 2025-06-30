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
        Schema::create('service_provider', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('mobile');
        $table->string('email')->unique();
        $table->string('business_name')->nullable();
        $table->string('gst_number')->nullable();
        $table->string('location');
        $table->string('password');
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_provider');
    }
};
