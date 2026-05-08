<?php
// database/seeders/ReferralCodeSeeder.php

namespace Database\Seeders;

use App\Models\ReferralCode;
use Illuminate\Database\Seeder;

class ReferralCodeSeeder extends Seeder
{
    public function run()
    {
        ReferralCode::create([
            'code' => 'EARLY2025',
            'description' => 'Diskon Early Bird 2025',
            'discount_amount' => 500000,
            'discount_percentage' => 0,
            'is_active' => true
        ]);

        ReferralCode::create([
            'code' => 'CORP10',
            'description' => 'Diskon Corporate 10%',
            'discount_amount' => 0,
            'discount_percentage' => 10,
            'is_active' => true
        ]);
    }
}