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
        Schema::table('notification_documents', function (Blueprint $table) {
            $table->integer('document_type')->comment('this shows the type of document')->nullable();

            $table->foreign('document_type')->references('id')->on('documents')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('notification_documents', function (Blueprint $table) {
            $table->dropColumn('document_type');
        });
    }
};
