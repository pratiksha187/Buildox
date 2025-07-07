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
        // Schema::create('selected_vendors', function (Blueprint $table) {
        //     $table->id();
        //     $table->timestamps();
        // });
        Schema::create('selected_vendors', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_id');
            $table->unsignedBigInteger('vendor_id');
            $table->unsignedBigInteger('document_id');
            $table->timestamps();

            // Optional: Add foreign keys if you have those tables
            // $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
            // $table->foreign('vendor_id')->references('id')->on('vendors')->onDelete('cascade');
            // $table->foreign('document_id')->references('id')->on('tender_documents')->onDelete('cascade');

            $table->unique(['project_id', 'vendor_id', 'document_id'], 'project_vendor_document_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('selected_vendors');
    }
};
