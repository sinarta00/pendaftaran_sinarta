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
        Schema::table('participants', function (Blueprint $table) {
            //
             $table->enum('gender', ['L', 'P'])->nullable()->after('full_name');

            $table->string('domisili_kota')->nullable()->after('birth_date');
    
            $table->string('jurusan')->nullable()->after('education');
    
            $table->enum('employment_status', [
                'Belum bekerja',
                'Karyawan',
                'Fresh Graduate',
                'Kontrak'
            ])->nullable()->after('jurusan');
    
            $table->string('work_company_name')->nullable()->after('employment_status');
    
            $table->enum('training_purpose', [
                'Syarat kerja',
                'Upgrade Skill',
                'Syarat Tender'
            ])->nullable()->after('work_company_name');
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('participants', function (Blueprint $table) {
            //
        });
    }
};
