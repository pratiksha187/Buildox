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
        Schema::create('tender_documents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_id');

            $table->string('emd_receipt')->nullable();
            $table->string('company_profile')->nullable();
            $table->string('address_proof')->nullable();
            $table->string('gst_certificate')->nullable();
            $table->string('work_experience')->nullable();
            $table->string('financial_capacity')->nullable();
            $table->string('declaration')->nullable();
            $table->string('boq_file')->nullable();

            $table->timestamps();

            $table->foreign('project_id')->references('id')->on('projects_details')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tender_documents');
    }
};
