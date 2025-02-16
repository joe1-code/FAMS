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
        Schema::create('user_particulars', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('country_id')->nullable();
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
            $table->unsignedBigInteger('tin_no')->comment('Indicates the TIN NO. from TRA')->nullable();
            $table->text('nin')->comment('Indicates the NIDA NO. from NIDA')->nullable();
            $table->unsignedBigInteger('passport_no')->comment('Indicates the PASSPORT NO. from immigrations')->nullable();
            $table->text('address')->comment('shows the address of a member i.e p.o.box')->nullable();
            $table->string('fax')->nullable();
            $table->integer('location_type')->comment('1 => Surveyed Area, 2 => Unsurveyed Area')->nullable();
            $table->text('unsurveyed_area_description')->comment('description for unsurveyed area')->nullable();
            $table->text('road')->comment('to show the near road')->nullable();
            $table->string('plot_no')->comment('to show the plot number')->nullable();
            $table->string('block_no')->nullable();
            $table->string('street')->nullable();
            $table->text('surveyed_area_description')->comment('description for surveyed area')->nullable();
            $table->text('job_description')->comment('to briefly explain what a member does at work')->nullable();
            $table->text('business_name')->comment("the name of a member's business if any")->nullable();
            $table->text('business_nature')->comment("the nature of a member's business if any")->nullable();
            $table->text('foundation_education')->comment("the primary school where a member attended")->nullable();
            $table->date('foundation_start_date')->comment('the date when a member started a foundation edu')->nullable();
            $table->date('foundation_end_date')->comment('the date when a member completed a foundation edu')->nullable();
            $table->text('secondary_education')->comment("the secondary school where a member attended")->nullable();
            $table->date('secondary_start_date')->comment('the date when a member started a secondary edu')->nullable();
            $table->date('secondary_end_date')->comment('the date when a member completed a secondary edu')->nullable();
            $table->text('college_education')->comment("the college where a member attended for a certificate/diploma")->nullable();
            $table->date('college_start_date')->comment('the date when a member started a college edu')->nullable();
            $table->date('college_end_date')->comment('the date when a member completed a college edu')->nullable();
            $table->text('university_education')->comment("the university where a member attended for a degree/masters/phD")->nullable();
            $table->date('university_start_date')->comment('the date when a member started a university edu')->nullable();
            $table->date('university_end_date')->comment('the date when a member completed a university edu')->nullable();
            $table->integer('education_level')->comment("the latest education level of a member")->nullable();
            $table->string('diploma_degree_name')->comment("the latest degree or diploma certificate acquired by the user ")->nullable();
            $table->date('edu_completion_date')->comment("the latest date a user completed bachelor or diploma")->nullable();
            $table->unsignedBigInteger('family_group_id')->nullable();
            $table->integer('monthly_earning')->nullable();
            $table->foreign('family_group_id')->references('id')->on('family_groups')->onDelete('cascade');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_particulars');
    }
};
