<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Ubah enum status menggunakan raw SQL
        DB::statement("ALTER TABLE participants MODIFY COLUMN status ENUM('pending', 'documents_uploaded', 'documents_verified', 'invoice_sent', 'dp_paid', 'full_paid') DEFAULT 'pending'");
        
        // Tambah field invoice_file
        Schema::table('participants', function (Blueprint $table) {
            $table->string('invoice_file')->nullable()->after('status');
        });
    }

    public function down()
    {
        // Kembalikan ke enum lama
        DB::statement("ALTER TABLE participants MODIFY COLUMN status ENUM('pending', 'dp_paid', 'full_paid') DEFAULT 'pending'");
        
        // Hapus field invoice_file
        Schema::table('participants', function (Blueprint $table) {
            $table->dropColumn('invoice_file');
        });
    }
};