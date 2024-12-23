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
            $table->unsignedBigInteger('penalty')->comment('incremental penalties for unpaid arrears')->nullable();
            $table->unsignedBigInteger('total_arrears')->comment('total monthly arrears + daily penalties')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('unpaid_members', function (Blueprint $table) {
            $table->dropColumn('penalty');
            $table->dropColumn('total_arrears');
        });
    }
};
