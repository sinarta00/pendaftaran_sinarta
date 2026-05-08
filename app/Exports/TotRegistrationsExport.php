<?php

namespace App\Exports;

use App\Models\TotRegistration;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TotRegistrationsExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    public function collection()
    {
        return TotRegistration::orderBy('created_at', 'desc')->get();
    }

    public function headings(): array
    {
        return [
            'No. Registrasi',
            'Nama Lengkap',
            'Email',
            'No. Telepon',
            'Level TOT',
            'Status',
            'Invoice Number',
            'Payment Date',
            'Total Payment',
            'Tanggal Daftar',
            'Terakhir Update'
        ];
    }

    public function map($registration): array
    {
        return [
            $registration->registration_number,
            $registration->full_name,
            $registration->email,
            "'" . $registration->phone,
            'Level ' . $registration->level,
            match($registration->status) {
                'pending' => 'Pending',
                'confirmed' => 'Dikonfirmasi',
                'paid' => 'Lunas',
                default => $registration->status
            },
            $registration->invoice_number ?? '-',
            $registration->payment_date ? $registration->payment_date->format('d/m/Y') : '-',
            $registration->total_payment ? 'Rp ' . number_format($registration->total_payment, 0, ',', '.') : '-',
            $registration->created_at->format('d/m/Y H:i'),
            $registration->updated_at->format('d/m/Y H:i'),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}