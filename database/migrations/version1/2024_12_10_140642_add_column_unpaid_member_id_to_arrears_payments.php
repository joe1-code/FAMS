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
        Schema::table('arrears_payments', function (Blueprint $table) {
            $table->unsignedBigInteger('unpaid_member_id')->comment('the id of respective arrear month')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('arrears_payments', function (Blueprint $table) {
            $table->dropColumn('unpaid_member_id');
        });
    }
};
