<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SkpRegistration>
 */
class SkpRegistrationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'full_name' => $this->faker->name(),
            'phone' => '0812' . $this->faker->numerify('########'),
            'email' => $this->faker->unique()->safeEmail(),
            'nik' => $this->faker->numerify('################'),
            'diploma_number' => 'DIP-' . $this->faker->numerify('#####'),
            'gender' => $this->faker->randomElement(['L', 'P']),
            'blood_type' => $this->faker->randomElement(['A', 'B', 'AB', 'O']),
            'education' => $this->faker->randomElement(['SMA', 'D3', 'S1', 'S2', 'S3']),
            'type' => 'penerbitan',
            'company_name' => $this->faker->company(),
            'company_address' => $this->faker->address(),
            'ktp_file' => 'skp-documents/ktp.pdf',
            'work_certificate' => 'skp-documents/work.pdf',
            'diploma_file' => 'skp-documents/diploma.pdf',
            'ak3u_certificate' => 'skp-documents/ak3u.pdf',
            'photo_file' => 'skp-documents/photo.jpg',
            'full_work_certificate' => 'skp-documents/full_work.pdf',
            'company_application_later' => 'skp-documents/company_app.pdf',
        ];
    }
}
