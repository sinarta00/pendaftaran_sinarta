<?php
// database/seeders/TemplateSeeder.php

namespace Database\Seeders;

use App\Models\Template;
use Illuminate\Database\Seeder;

class TemplateSeeder extends Seeder
{
    public function run()
    {
        Template::create([
            'name' => 'Pakta Integritas AK3U',
            'type' => 'integrity_pact',
            'file_path' => 'templates/pakta-integritas-template.pdf',
            'is_active' => true
        ]);
    }
}