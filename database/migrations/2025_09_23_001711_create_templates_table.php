<?php
// database/migrations/xxxx_create_templates_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('templates', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type'); // 'integrity_pact', etc
            $table->string('file_path');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('templates');
    }
};