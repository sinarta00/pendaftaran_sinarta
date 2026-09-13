<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ak3u_bnsp_renewals', function (Blueprint $table) {
            $table->id();
            $table->string('registration_number')->unique();
            $table->string('full_name');
            $table->string('phone');
            $table->string('email');
            $table->string('nik', 20);
            $table->string('diploma_number');
            $table->enum('gender', ['L', 'P']);
            $table->enum('blood_type', ['A', 'B', 'AB', 'O']);
            $table->enum('education', ['SMA', 'D3', 'S1', 'S2', 'S3']);
            $table->string('company_name');
            $table->text('company_address');
            $table->string('old_sk_number')->nullable();
            $table->string('old_license_number')->nullable();
            
            // File uploads
            $table->string('ktp_file')->nullable();
            $table->string('work_certificate')->nullable();
            $table->string('diploma_file')->nullable();
            $table->string('ak3u_certificate')->nullable();
            $table->string('photo_file')->nullable();
            $table->string('full_work_certificate')->nullable();
            $table->string('company_application_later')->nullable();
            $table->string('skp__later')->nullable();
            $table->string('license_later')->nullable();
            $table->string('activity_report_later')->nullable();
            
            $table->enum('status', ['pending', 'confirmed', 'paid'])->default('pending');
            $table->string('invoice_number')->nullable();
            $table->date('payment_date')->nullable();
            $table->decimal('total_payment', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ak3u_bnsp_renewals');
    }
};
