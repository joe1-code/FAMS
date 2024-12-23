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
        Schema::create('current_monthly_arrears', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('outstanding_amount')->comment('The amount a user is owed on monthly basis')->nullable();
            $table->dateTime('pay_date')->comment('The date when monthly contribution was approved')->nullable();
            $table->unsignedBigInteger('approval_id')->nullable();
            $table->foreign('approval_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('monthly_payments_id')->comment('the id for the transactional payment')->nullable();
            $table->foreign('monthly_payments_id')->references('id')->on('monthly_payments')->onDelete('cascade');
            $table->unsignedBigInteger('previous_monthly_arrears_id')->comment('the id for previous months that were not paid')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('current_monthly_arrears');
    }
};
