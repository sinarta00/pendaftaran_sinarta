<?php
// database/migrations/xxxx_add_training_schedule_id_to_pop_participants_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('pop_participants', function (Blueprint $table) {
            $table->foreignId('training_schedule_id')->nullable()->after('education')->constrained('training_schedules');
        });
    }

    public function down()
    {
        Schema::table('pop_participants', function (Blueprint $table) {
            $table->dropForeign(['training_schedule_id']);
            $table->dropColumn('training_schedule_id');
        });
    }
};