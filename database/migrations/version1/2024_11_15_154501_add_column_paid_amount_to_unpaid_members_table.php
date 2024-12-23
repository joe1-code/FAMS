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
        Schema::table('unpaid_members', function (Blueprint $table) {
            $table->unsignedBigInteger('paid_amount')->comment('the amount which a user paid for both monthly fees and arrears')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('unpaid_members', function (Blueprint $table) {
            $table->dropColumn('paid_amount');
        });
    }
};
