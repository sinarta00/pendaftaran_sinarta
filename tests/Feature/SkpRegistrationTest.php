<?php

namespace Tests\Feature;

use App\Mail\SkpRegistrationConfirmation;
use App\Models\SkpRegistration;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class SkpRegistrationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');
        Mail::fake();
    }

    /**
     * Helper: data valid dasar untuk form SKP (tanpa file).
     */
    private function validSkpData(array $overrides = []): array
    {
        return array_merge([
            'full_name' => 'Budi Santoso',
            'phone' => '81234567890',
            'email' => 'budi@example.com',
            'nik' => '6401011234567890',
            'diploma_number' => 'IJZ-2020-001',
            'gender' => 'L',
            'blood_type' => 'A',
            'education' => 'S1',
            'type' => 'penerbitan',
            'company_name' => 'PT Contoh Sejahtera',
            'company_address' => 'Jl. Contoh No. 1, Samarinda',
            'old_sk_number' => null,
            'old_license_number' => null,
        ], $overrides);
    }

    /**
     * Helper: file dummy untuk field-field upload yang wajib di StoreSkpRequest,
     * berlaku untuk SEMUA jenis layanan (penerbitan maupun perpanjangan).
     */
    private function validSkpFiles(): array
    {
        return [
            'ktp_file' => UploadedFile::fake()->create('ktp.pdf', 500, 'application/pdf'),
            'work_certificate' => UploadedFile::fake()->create('sk-kerja.pdf', 500, 'application/pdf'),
            'diploma_file' => UploadedFile::fake()->create('ijazah.pdf', 500, 'application/pdf'),
            'ak3u_certificate' => UploadedFile::fake()->create('ak3u.pdf', 500, 'application/pdf'),
            'photo_file' => UploadedFile::fake()->image('foto.jpg'),
            'full_work_certificate' => UploadedFile::fake()->create('sk-kerja-penuh.pdf', 500, 'application/pdf'),
            'company_application_later' => UploadedFile::fake()->create('surat-permohonan.pdf', 500, 'application/pdf'),
        ];
    }

    /**
     * Helper: file dummy khusus untuk field yang HANYA wajib saat type = perpanjangan.
     */
    private function renewalOnlyFiles(): array
    {
        return [
            'skp_later' => UploadedFile::fake()->create('skp-lama.pdf', 500, 'application/pdf'),
            'license_later' => UploadedFile::fake()->create('lisensi-lama.pdf', 500, 'application/pdf'),
        ];
    }

    // ---------------------------------------------------------------------
    // HAPPY PATH
    // ---------------------------------------------------------------------

    public function test_berhasil_submit_pendaftaran_skp_dengan_data_dan_file_valid(): void
    {
        $payload = array_merge($this->validSkpData(), $this->validSkpFiles());

        $response = $this->post(route('skp.store'), $payload);

        $response->assertRedirect(route('skp.success'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('skp_registrations', [
            'full_name' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'nik' => '6401011234567890',
            'type' => 'penerbitan',
        ]);

        $registration = SkpRegistration::first();

        // registration_number otomatis ter-generate sesuai format SKP-{tahun}-{4 digit}
        $this->assertMatchesRegularExpression(
            '/^SKP-' . date('Y') . '-\d{4}$/',
            $registration->registration_number
        );

        // File tersimpan di disk 'public' pada folder skp-documents
        Storage::disk('public')->assertExists($registration->ktp_file);
        Storage::disk('public')->assertExists($registration->photo_file);

        // Email konfirmasi terkirim ke email pendaftar
        Mail::assertSent(SkpRegistrationConfirmation::class, function ($mail) use ($registration) {
            return $mail->hasTo($registration->email);
        });
    }

    public function test_menyimpan_path_file_dari_folder_skp_documents(): void
    {
        $payload = array_merge($this->validSkpData(), $this->validSkpFiles());

        $this->post(route('skp.store'), $payload);

        $registration = SkpRegistration::first();

        $this->assertStringContainsString('skp-documents/', $registration->ktp_file);
    }

    // ---------------------------------------------------------------------
    // VALIDASI FIELD TEKS WAJIB
    // ---------------------------------------------------------------------

    /**
     * @dataProvider requiredTextFieldsProvider
     */
    public function test_menolak_submit_jika_field_teks_wajib_kosong(string $field): void
    {
        $payload = array_merge($this->validSkpData(), $this->validSkpFiles(), [$field => '']);

        $response = $this->post(route('skp.store'), $payload);

        $response->assertSessionHasErrors($field);
        $this->assertDatabaseCount('skp_registrations', 0);
    }

    public static function requiredTextFieldsProvider(): array
    {
        return [
            'full_name' => ['full_name'],
            'phone' => ['phone'],
            'email' => ['email'],
            'nik' => ['nik'],
            'diploma_number' => ['diploma_number'],
            'gender' => ['gender'],
            'blood_type' => ['blood_type'],
            'education' => ['education'],
            'type' => ['type'],
            'company_name' => ['company_name'],
            'company_address' => ['company_address'],
        ];
    }

    public function test_menolak_email_yang_formatnya_tidak_valid(): void
    {
        $payload = array_merge($this->validSkpData(['email' => 'bukan-email']), $this->validSkpFiles());

        $response = $this->post(route('skp.store'), $payload);

        $response->assertSessionHasErrors('email');
    }

    public function test_menolak_email_yang_sudah_terdaftar_sebelumnya(): void
    {
        SkpRegistration::factory()->create(['email' => 'sudah-ada@example.com']);

        $payload = array_merge($this->validSkpData(['email' => 'sudah-ada@example.com']), $this->validSkpFiles());

        $response = $this->post(route('skp.store'), $payload);

        $response->assertSessionHasErrors('email');
    }

    /**
     * @dataProvider invalidEnumValuesProvider
     */
    public function test_menolak_nilai_yang_tidak_ada_dalam_pilihan(string $field, string $invalidValue): void
    {
        $payload = array_merge($this->validSkpData([$field => $invalidValue]), $this->validSkpFiles());

        $response = $this->post(route('skp.store'), $payload);

        $response->assertSessionHasErrors($field);
    }

    public static function invalidEnumValuesProvider(): array
    {
        return [
            'gender' => ['gender', 'X'],
            'blood_type' => ['blood_type', 'Z'],
            'education' => ['education', 'SD'],
            'type' => ['type', 'lainnya'],
        ];
    }

    // ---------------------------------------------------------------------
    // VALIDASI FILE WAJIB
    // ---------------------------------------------------------------------

    /**
     * @dataProvider requiredFileFieldsProvider
     */
    public function test_menolak_submit_jika_ada_file_wajib_yang_tidak_diupload(string $fileField): void
    {
        $files = $this->validSkpFiles();
        unset($files[$fileField]);

        $payload = array_merge($this->validSkpData(), $files);

        $response = $this->post(route('skp.store'), $payload);

        $response->assertSessionHasErrors($fileField);
        $this->assertDatabaseCount('skp_registrations', 0);
    }

    public static function requiredFileFieldsProvider(): array
    {
        return [
            'ktp_file' => ['ktp_file'],
            'work_certificate' => ['work_certificate'],
            'diploma_file' => ['diploma_file'],
            'ak3u_certificate' => ['ak3u_certificate'],
            'photo_file' => ['photo_file'],
            'full_work_certificate' => ['full_work_certificate'],
            'company_application_later' => ['company_application_later'],
        ];
    }

    public function test_menolak_file_dengan_format_yang_tidak_diizinkan(): void
    {
        $files = $this->validSkpFiles();
        $files['ktp_file'] = UploadedFile::fake()->create('ktp.docx', 500, 'application/msword');

        $payload = array_merge($this->validSkpData(), $files);

        $response = $this->post(route('skp.store'), $payload);

        $response->assertSessionHasErrors('ktp_file');
    }

    public function test_menolak_foto_dengan_format_pdf(): void
    {
        $files = $this->validSkpFiles();
        $files['photo_file'] = UploadedFile::fake()->create('foto.pdf', 500, 'application/pdf');

        $payload = array_merge($this->validSkpData(), $files);

        $response = $this->post(route('skp.store'), $payload);

        $response->assertSessionHasErrors('photo_file');
    }

    public function test_menolak_file_yang_ukurannya_melebihi_2mb(): void
    {
        $files = $this->validSkpFiles();
        // max:2048 dalam KB -> 2049 KB akan gagal
        $files['ktp_file'] = UploadedFile::fake()->create('ktp.pdf', 2049, 'application/pdf');

        $payload = array_merge($this->validSkpData(), $files);

        $response = $this->post(route('skp.store'), $payload);

        $response->assertSessionHasErrors('ktp_file');
    }

    // ---------------------------------------------------------------------
    // FIELD KHUSUS PERPANJANGAN (skp_later & license_later)
    // ---------------------------------------------------------------------

    public function test_berhasil_submit_perpanjangan_lengkap_dengan_skp_later_dan_license_later(): void
    {
        $payload = array_merge(
            $this->validSkpData([
                'type' => 'perpanjangan',
                'old_sk_number' => 'SK-LAMA-001',
                'old_license_number' => 'LSN-LAMA-001',
            ]),
            $this->validSkpFiles(),
            $this->renewalOnlyFiles()
        );

        $response = $this->post(route('skp.store'), $payload);

        $response->assertRedirect(route('skp.success'));
        $this->assertDatabaseHas('skp_registrations', [
            'type' => 'perpanjangan',
            'old_sk_number' => 'SK-LAMA-001',
        ]);
    }

    /**
     * @dataProvider renewalOnlyFieldsProvider
     */
    public function test_menolak_submit_perpanjangan_jika_file_khusus_perpanjangan_tidak_diupload(string $renewalField): void
    {
        $renewalFiles = $this->renewalOnlyFiles();
        unset($renewalFiles[$renewalField]);

        $payload = array_merge(
            $this->validSkpData(['type' => 'perpanjangan']),
            $this->validSkpFiles(),
            $renewalFiles
        );

        $response = $this->post(route('skp.store'), $payload);

        $response->assertSessionHasErrors($renewalField);
        $this->assertDatabaseCount('skp_registrations', 0);
    }

    public static function renewalOnlyFieldsProvider(): array
    {
        return [
            'skp_later' => ['skp_later'],
            'license_later' => ['license_later'],
        ];
    }

    public function test_tidak_mewajibkan_skp_later_dan_license_later_saat_type_penerbitan(): void
    {
        $payload = array_merge(
            $this->validSkpData(['type' => 'penerbitan']),
            $this->validSkpFiles()
            // sengaja tanpa skp_later & license_later
        );

        $response = $this->post(route('skp.store'), $payload);

        $response->assertRedirect(route('skp.success'));
        $this->assertDatabaseCount('skp_registrations', 1);
    }

    /**
     * g-recaptcha-response saat ini tidak divalidasi di StoreSkpRequest maupun
     * di controller. Kalau kamu menambahkan validasi reCAPTCHA di backend nanti
     * (misal lewat custom rule atau middleware), tambahkan test baru untuk
     * memastikan request tanpa token yang valid ditolak.
     */
}