<?php
// database/seeders/TrainingScheduleSeeder.php

namespace Database\Seeders;

use App\Models\TrainingSchedule;
use Illuminate\Database\Seeder;

class TrainingScheduleSeeder extends Seeder
{
    public function run()
    {
        TrainingSchedule::create([
            'name' => 'AK3U Kemnaker Batch 1',
            'start_date' => '2025-10-15',
            'end_date' => '2025-10-18',
            'location' => 'Jakarta',
            'type' => 'kemnaker',
            'price' => 5500000,
            'max_participants' => 30,
            'is_active' => true
        ]);

        TrainingSchedule::create([
            'name' => 'AK3U BNSP Batch 1',
            'start_date' => '2025-11-01',
            'end_date' => '2025-11-05',
            'location' => 'Surabaya',
            'type' => 'bnsp',
            'price' => 4800000,
            'max_participants' => 25,
            'is_active' => true
        ]);
    }
}