<?php

namespace App\Exports;

use App\Models\Ak3uBnspRenewal;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class Ak3uBnspRenewalsExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    public function collection()
    {
        return Ak3uBnspRenewal::orderBy('created_at', 'desc')->get();
    }

    public function headings(): array
    {
        return [
            'No. Registrasi',
            'Nama Lengkap',
            'Email',
            'No. Telepon',
            'NIK',
            'Pendidikan',
            'Perusahaan',
            'No SK Lama',
            'No Lisensi Lama',
            'Status',
            'Invoice Number',
            'Payment Date',
            'Total Payment',
            'Tanggal Daftar',
        ];
    }

    public function map($renewal): array
    {
        return [
            $renewal->registration_number,
            $renewal->full_name,
            $renewal->email,
            "'" . $renewal->phone,
            "'" . $renewal->nik,
            $renewal->education,
            $renewal->company_name,
            $renewal->old_sk_number ?? '-',
            $renewal->old_license_number ?? '-',
            match($renewal->status) {
                'pending' => 'Pending',
                'confirmed' => 'Dikonfirmasi',
                'paid' => 'Lunas',
                default => $renewal->status
            },
            $renewal->invoice_number ?? '-',
            $renewal->payment_date ? $renewal->payment_date->format('d/m/Y') : '-',
            $renewal->total_payment ? 'Rp ' . number_format($renewal->total_payment, 0, ',', '.') : '-',
            $renewal->created_at->format('d/m/Y H:i'),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
