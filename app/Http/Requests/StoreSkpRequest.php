<?php
// app/Http/Requests/StoreSkpRequest.php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSkpRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'full_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|unique:skp_registrations,email',
            'nik' => 'required|string|max:20',
            'diploma_number' => 'required|string|max:50',
            'gender' => 'required|in:L,P',
            'blood_type' => 'required|in:A,B,AB,O',
            'education' => 'required|in:SMA,D3,S1,S2,S3',
            'type' => 'required|in:perpanjangan,penerbitan',
            'company_name' => 'required|string|max:255',
            'company_address' => 'required|string',
            'old_sk_number' => 'nullable|string|max:100',
            'old_license_number' => 'nullable|string|max:100',
            
            // File uploads
            'ktp_file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'work_certificate' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'diploma_file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'ak3u_certificate' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'photo_file' => 'required|file|mimes:jpg,jpeg,png|max:2048',
            'full_work_certificate' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'company_application_later' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'skp__later' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'license_later' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'activity_report_later' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048'
        ];
    }
}