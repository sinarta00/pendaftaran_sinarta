<?php
// database/migrations/xxxx_create_training_schedules_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('training_schedules', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->date('start_date');
            $table->date('end_date');
            $table->string('location');
            $table->enum('type', ['kemnaker', 'bnsp']);
            $table->decimal('price', 10, 2);
            $table->integer('max_participants')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('training_schedules');
    }
};