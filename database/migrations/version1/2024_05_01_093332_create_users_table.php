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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username')->nullable();
            $table->string('ad_username')->nullable();
            $table->string('password');
            $table->string('firstname');
            $table->string('middlename');
            $table->integer('unit_id');
            $table->integer('designation_id');
            $table->string('email')->nullable();
            $table->integer('phone');
            $table->integer('gender_id');
            $table->integer('external_id')->nullable();
            $table->boolean('active');
            $table->boolean('available');
            $table->date('last_login')->nullable();
            $table->string('remember_token')->nullable();
            $table->string('modified_by')->nullable();
            $table->date('modified')->nullable();
            $table->integer('task_id')->nullable();
            $table->string('report_to')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
