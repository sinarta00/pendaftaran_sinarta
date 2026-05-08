<?php
// database/migrations/xxxx_create_pop_participants_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pop_participants', function (Blueprint $table) {
            $table->id();
            $table->string('registration_number')->unique();
            $table->string('full_name');
            $table->string('email')->unique();
            $table->string('phone');
            $table->string('birth_place');
            $table->date('birth_date');
            $table->enum('education', ['SMA', 'D3', 'S1', 'S2', 'S3']);
            $table->enum('category', ['online', 'hybrid']); // Online: 3.8jt, Hybrid: 4.8jt
            $table->string('company_name')->nullable();
            $table->enum('information_source', ['rekan', 'poster', 'banner', 'mediasocial']);
            $table->string('referral_code')->nullable();
            $table->boolean('agreement_checkbox')->default(false);
            $table->enum('status', ['pending', 'dp_paid', 'full_paid'])->default('pending');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pop_participants');
    }
};