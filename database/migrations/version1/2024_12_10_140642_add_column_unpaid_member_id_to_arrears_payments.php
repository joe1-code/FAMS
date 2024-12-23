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
            $table->unsignedBigInteger('unpaid_member_id')->comment('status for the payment of arrears, has he/she paid any amount so far')->nullable();
            $table->unsignedBigInteger('payment_status')->comment('status for the payment of arrears, has he/she paid any amount so far')->nullable();
            $table->unsignedBigInteger('completion_status')->comment('Has the member with arrears completed paying all his arrears?')->nullable();
            $table->unsignedBigInteger('approval_status')->comment('Has the member with arrears completed paying all his arrears?')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('arrears_payments', function (Blueprint $table) {
            $table->dropColumn('unpaid_member_id');
            $table->dropColumn('payment_status');
            $table->dropColumn('completion_status');
            $table->dropColumn('approval_status');
        });
    }
};
