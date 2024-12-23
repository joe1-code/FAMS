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
        Schema::create('monthly_payments', function (Blueprint $table) {
            $table->id();
            $table->integer('payment_type');
            $table->foreign('payment_type')->references('id')->on('payment_types')->onDelete('cascade');
            $table->integer('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('document_id')->nullable();
            $table->foreign('document_id')->references('id')->on('notification_documents')->onDelete('cascade');
            $table->unsignedBigInteger('paid_amount');
            $table->unsignedBigInteger('entitled_amount');
            $table->dateTime('pay_date');
            $table->boolean('payment_status');
            $table->integer('payment_method_id')->nullable()->comment('1=>CRDB Account, 2=>UTT AMIS Account');
            $table->foreign('payment_method_id')->references('id')->on('payment_methods')->onDelete('cascade');
            $table->boolean('doc_used');
            $table->boolean('approval_status');
            $table->unsignedBigInteger('total_contributions')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('monthly_payments');
    }
};
