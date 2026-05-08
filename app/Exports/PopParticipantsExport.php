<?php
// app/Exports/PopParticipantsExport.php

namespace App\Exports;

use App\Models\PopParticipant;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PopParticipantsExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return PopParticipant::with(['documentUploads', 'payments'])->get();
    }

    public function headings(): array
    {
        return [
            'No. Registrasi',
            'Nama Lengkap',
            'Email',
            'Telepon',
            'Tempat Lahir',
            'Tanggal Lahir',
            'Pendidikan',
            'Jadwal Training',
            'Tanggal Pelatihan',
            'Kategori',
            'Perusahaan',
            'Status',
            'Tanggal Daftar',
        ];
    }

    public function map($participant): array
    {
        return [
            $participant->registration_number,
            $participant->full_name,
            $participant->email,
            $participant->phone,
            $participant->birth_place,
            $participant->birth_date->format('d-m-Y'),
            $participant->education,
            $participant->trainingSchedule->name ?? '-',
            $participant->category === 'online' ? 'Online (3.8jt)' : 'Hybrid (4.8jt)',
            $participant->company_name ?? '-',
            $this->getStatusLabel($participant->status),
            $participant->created_at->format('d-m-Y H:i'),
        ];
    }

    private function getStatusLabel($status)
    {
        return match($status) {
            'pending' => 'Pending',
            'dp_paid' => 'DP Dibayar',
            'full_paid' => 'Lunas',
            default => $status,
        };
    }
}