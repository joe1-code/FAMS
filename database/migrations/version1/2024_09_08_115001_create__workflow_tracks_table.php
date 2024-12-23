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
        Schema::create('workflow_tracks', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('status');
            $table->integer('resource_id');
            $table->integer('wf_definition_id');
            $table->text('comments');
            $table->integer('assigned');
            $table->integer('parent_id')->nullable();
            $table->dateTime('receive_date');
            $table->dateTime('forward_date');
            $table->integer('payment_type')->nullable();
            $table->foreign('payment_type')->references('id')->on('payment_types')->onDelete('cascade');
            $table->integer('resource_type')->nullable();
            $table->integer('allocated')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workflow_tracks');
    }
};
