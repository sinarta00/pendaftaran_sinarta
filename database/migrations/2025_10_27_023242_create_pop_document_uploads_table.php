<?php
// database/migrations/xxxx_create_pop_document_uploads_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pop_document_uploads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pop_participant_id')->constrained('pop_participants')->onDelete('cascade');
            $table->string('ktp_number');
            $table->string('diploma_number');
            $table->string('scan_ktp'); // Scan KTP
            $table->string('scan_diploma'); // Ijazah minimal SMA
            $table->string('cv_file'); // CV
            $table->string('work_certificate')->nullable(); // SK Kerja (optional)
            $table->string('mining_experience_letter'); // Surat pengalaman kerja di tambang
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pop_document_uploads');
    }
};