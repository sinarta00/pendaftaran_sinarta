<?php

namespace Tests\Feature;

use App\Mail\Ak3uBnspRenewalConfirmation;
use App\Models\Ak3uBnspRenewal;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class Ak3uBnspRenewalTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');
        Mail::fake();
    }

    private function validData(array $overrides = []): array
    {
        return array_merge([
            'full_name' => 'Budi Santoso',
            'phone' => '81234567890',
            'email' => 'budi.bnsp@example.com',
            'nik' => '6401011234567890',
            'diploma_number' => 'IJZ-2020-001',
            'gender' => 'L',
            'blood_type' => 'A',
            'education' => 'S1',
            'company_name' => 'PT Contoh Sejahtera',
            'company_address' => 'Jl. Contoh No. 1, Samarinda',
            'old_sk_number' => 'BNSP-2023-001',
            'old_license_number' => 'LIC-2023-001',
        ], $overrides);
    }

    private function validFiles(): array
    {
        return [
            'ktp_file' => UploadedFile::fake()->create('ktp.pdf', 500, 'application/pdf'),
            'work_certificate' => UploadedFile::fake()->create('sk-kerja.pdf', 500, 'application/pdf'),
            'diploma_file' => UploadedFile::fake()->create('ijazah.pdf', 500, 'application/pdf'),
            'ak3u_certificate' => UploadedFile::fake()->create('ak3u.pdf', 500, 'application/pdf'),
            'photo_file' => UploadedFile::fake()->image('foto.jpg'),
            'full_work_certificate' => UploadedFile::fake()->create('sk-kerja-penuh.pdf', 500, 'application/pdf'),
            'company_application_later' => UploadedFile::fake()->create('surat-permohonan.pdf', 500, 'application/pdf'),
            'skp__later' => UploadedFile::fake()->create('sertifikat-lama.pdf', 500, 'application/pdf'),
            'license_later' => UploadedFile::fake()->create('lisensi-lama.pdf', 500, 'application/pdf'),
            'activity_report_later' => UploadedFile::fake()->create('laporan-kegiatan.pdf', 500, 'application/pdf'),
        ];
    }

    public function test_halaman_form_perpanjangan_ak3u_bnsp_dapat_diakses(): void
    {
        $response = $this->get(route('ak3u.bnsp.perpanjangan'));
        $response->assertStatus(200);
        $response->assertSee('Pendaftaran Perpanjangan AK3U BNSP');
    }

    public function test_berhasil_submit_perpanjangan_ak3u_bnsp_lengkap(): void
    {
        $payload = array_merge($this->validData(), $this->validFiles());

        $response = $this->post(route('ak3u.bnsp.perpanjangan.store'), $payload);

        $response->assertRedirect(route('ak3u.bnsp.perpanjangan.success'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('ak3u_bnsp_renewals', [
            'email' => 'budi.bnsp@example.com',
            'full_name' => 'Budi Santoso',
            'company_name' => 'PT Contoh Sejahtera',
            'status' => 'pending',
        ]);

        $record = Ak3uBnspRenewal::where('email', 'budi.bnsp@example.com')->first();
        $this->assertNotNull($record);
        $this->assertStringStartsWith('BNSP-EXT-', $record->registration_number);

        Storage::disk('public')->assertExists($record->ktp_file);
        Storage::disk('public')->assertExists($record->skp__later);
        Storage::disk('public')->assertExists($record->activity_report_later);

        Mail::assertSent(Ak3uBnspRenewalConfirmation::class, function ($mail) use ($record) {
            return $mail->hasTo('budi.bnsp@example.com')
                && $mail->registration->id === $record->id;
        });
    }

    public function test_gagal_submit_jika_field_wajib_kosong(): void
    {
        $payload = array_merge($this->validData(['email' => '']), $this->validFiles());

        $response = $this->post(route('ak3u.bnsp.perpanjangan.store'), $payload);

        $response->assertSessionHasErrors(['email']);
        $this->assertDatabaseCount('ak3u_bnsp_renewals', 0);
    }
}
