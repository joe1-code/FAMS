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
        Schema::create('wf_tracks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('status');
            $table->unsignedBigInteger('resource_id');
            $table->unsignedBigInteger('wf_definition_id');
            $table->text('comments');
            $table->integer('assigned');
            $table->integer('parent_id')->nullable();
            $table->dateTime('receive_date');
            $table->dateTime('forward_date');
            $table->string('payment_type')->nullable()->comment('1=>CRDB Account, 2=>UTT AMIS');
            $table->string('resource_type')->nullable();
            $table->string('allocated')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wf_tracks');
    }
};
