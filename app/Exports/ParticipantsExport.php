<?php

namespace App\Exports;

use App\Models\Participant;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ParticipantsExport implements FromCollection, WithHeadings, WithMapping
{
    protected $type;

    public function __construct($type = null)
    {
        $this->type = $type;
    }

    public function collection()
    {
        $query = Participant::with(['trainingSchedule', 'documentUploads']);
        
        // Filter berdasarkan type jika ada
        if ($this->type) {
            $query->where('type', $this->type);
        }
        
        return $query->get();
    }
    
    public function headings(): array
    {
        return [
            'No. Registrasi',
            'Jenis AK3U',
            'Kategori',
            'Nama Lengkap',
            'Email',
            'Telepon',
            'Tempat Lahir',
            'Tanggal Lahir',
            'Jenis Kelamin',        
            'Golongan Darah',
            'Kota Domisili',        
            'Jurusan',              
            'Nama Institusi',       
            'Status Pekerjaan',    
            'Nama Perusahaan Kerja',
            'Tujuan Pelatihan',    
            'Pendidikan',
            'Jadwal Pelatihan',
            'Ukuran Baju',
            'Sumber Informasi',
            'Nama Perusahaan',
            'Alamat Perusahaan',
            'Nomor Telepon Perusahaan',
            'Status',
            'Tanggal Daftar',
        ];
    }

    public function map($participant): array
    {
        return [
            $participant->registration_number,
            strtoupper($participant->type),
            $participant->participant_category === 'company' ? 'Perusahaan' : 'Personal',
            $participant->full_name,
            $participant->email,
            $participant->phone,
            $participant->birth_place,
            $participant->birth_date ? $participant->birth_date->format('d-m-Y') : '-',
            $participant->gender === 'L' ? 'Laki-laki' : 'Perempuan', // ✅ tambah
            $participant->golongan_darah ?? '-',
            $participant->domisili_kota ?? '-',                        // ✅ tambah
            $participant->jurusan ?? '-',                              // ✅ tambah
            $participant->institution_name ?? '-',                     // ✅ tambah
            $participant->employment_status ?? '-',                    // ✅ tambah
            $participant->work_company_name ?? '-',                    // ✅ tambah
            $participant->training_purpose ?? '-',                     // ✅ tambah
            $participant->education ?? $participant->education_bnsp ?? '-',
            $participant->trainingSchedule->name ?? '-',
            $participant->shirt_size,
            $participant->information_source ?? '-',
            $participant->company_name ?? '-',
            $participant->company_address ?? '-',
            $participant->company_phone ?? '-',
            $this->getStatusLabel($participant->status),
            $participant->created_at->format('d-m-Y H:i'),
        ];
    }

    private function getStatusLabel($status)
    {
        return match($status) {
            'pending' => 'Pending',
            'documents_uploaded' => 'Dokumen Diupload',
            'documents_verified' => 'Dokumen Terverifikasi',
            'invoice_sent' => 'Invoice Terkirim',
            'dp_paid' => 'DP Dibayar',
            'full_paid' => 'Lunas',
            default => $status,
        };
    }
}