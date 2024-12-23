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
        Schema::create('arrears_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('payment_type')->comment('1 => monthly payments, 2 => Arrears payments, 3 => Debt payments')->nullable();
            $table->foreign('payment_type')->references('id')->on('payment_types')->onDelete('cascade');
            $table->unsignedBigInteger('paid_amount')->comment('The amount a user is owed on monthly basis')->nullable();
            $table->unsignedBigInteger('document_id')->comment('id of the document used for arrears payments')->nullable();
            $table->boolean('doc_used')->comment('a flag to show if the document is already used on a workflow')->nullable();
            $table->dateTime('pay_date')->comment('the date when arrears payment was approved on a workflow')->nullable();
            $table->integer('payment_method_id')->comment('1 => paid via CRDB Account, 2 => paid via UTT AMIS Account')->nullable();
            $table->foreign('payment_method_id')->references('id')->on('payment_methods')->onDelete('cascade');
            $table->unsignedBigInteger('total_arrears')->comment('all the accumulative arrears for previous months')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('previous_monthly_arrears');
    }
};
