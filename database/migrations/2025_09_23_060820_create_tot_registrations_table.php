<?php
// database/migrations/xxxx_create_tot_registrations_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tot_registrations', function (Blueprint $table) {
            $table->id();
            $table->string('registration_number')->unique();
            $table->string('full_name');
            $table->string('email');
            $table->string('phone');
            $table->string('nik', 20);
            $table->string('diploma_number');
            $table->string('birth_place');
            $table->date('birth_date');
            $table->enum('education', ['SMA', 'D3', 'S1', 'S2', 'S3']);
            $table->enum('level', ['3', '4', '5', '6']);
            $table->enum('information_source', ['rekan', 'poster', 'banner', 'mediasocial']);
            $table->string('referral_code')->nullable();
            $table->boolean('agreement_checkbox')->default(false);
            
            // File uploads
            $table->string('photo_file')->nullable();
            $table->string('ktp_file')->nullable();
            $table->string('diploma_file')->nullable();
            $table->string('tot_assistant_cert')->nullable(); // Level 3
            $table->string('tot_instructor_cert')->nullable(); // Level 4
            $table->string('kkni_level4_cert')->nullable(); // Level 5,6
            $table->string('work_exp_assistant')->nullable(); // Level 3
            $table->string('work_exp_instructor')->nullable(); // Level 4,5
            $table->string('work_exp_senior')->nullable(); // Level 6
            $table->string('senior_instructor_cert')->nullable();
            $table->string('master_instructor_cert')->nullable();
            
            $table->enum('status', ['pending', 'confirmed', 'paid'])->default('pending');
            $table->string('invoice_number')->nullable();
            $table->date('payment_date')->nullable();
            $table->decimal('total_payment', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tot_registrations');
    }
};