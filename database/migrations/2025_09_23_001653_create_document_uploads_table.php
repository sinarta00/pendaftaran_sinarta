<?php
// database/migrations/xxxx_create_document_uploads_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('document_uploads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('participant_id')
      ->constrained('participants')
      ->onDelete('cascade');
            $table->string('ktp_number')->nullable();
            $table->string('diploma_number')->nullable();
            $table->string('scan_diploma')->nullable();
            $table->string('scan_ktp')->nullable();
            $table->string('scan_photo')->nullable();
            $table->string('health_certificate')->nullable();
            $table->string('cv_file')->nullable();
            $table->string('integrity_pact')->nullable();
            $table->string('work_certificate')->nullable();
            $table->string('company_npwp')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('document_uploads');
    }
};