<?php
// database/migrations/xxxx_create_participants_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('participants', function (Blueprint $table) {
            $table->id();
            $table->string('registration_number')->unique();
            $table->enum('type', ['kemnaker', 'bnsp']);
            $table->string('full_name');
            $table->string('email');
            $table->string('phone');
            $table->string('birth_place');
            $table->date('birth_date');
            $table->enum('education', ['D3', 'S1', 'S2', 'S3'])->nullable();
            $table->enum('education_bnsp', ['SMA', 'D3', 'S1', 'S2', 'S3'])->nullable();
            $table->foreignId('training_schedule_id')->constrained();
            $table->enum('shirt_size', ['S', 'M', 'L', 'XL', 'XXL']);
            $table->enum('participant_category', ['personal', 'company'])->nullable();
            $table->string('company_name')->nullable();
            $table->text('company_address')->nullable();
            $table->string('company_phone')->nullable();
            $table->enum('information_source', ['Rekan', 'Poster', 'Banner', 'Instagram', 'Facebook', 'Tiktok']);
            $table->string('referral_code')->nullable();
            $table->boolean('agreement_checkbox')->default(false);
            $table->enum('status', ['pending', 'dp_paid', 'full_paid'])->default('pending');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('participants');
    }
};