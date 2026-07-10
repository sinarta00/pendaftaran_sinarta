<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("
            ALTER TABLE participants
            MODIFY COLUMN information_source ENUM(
                'Rekan',
                'Poster',
                'Banner',
                'Instagram',
                'Facebook',
                'Tiktok'
            ) NOT NULL
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
         Schema::table('participants', function (Blueprint $table) {
            $table->enum('information_source', [
                'Rekan',
                'Poster',
                'Banner'
            ])->change();
        });
    }
};
