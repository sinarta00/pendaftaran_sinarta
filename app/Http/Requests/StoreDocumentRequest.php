<?php
// app/Http/Requests/StoreDocumentRequest.php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDocumentRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $participant = $this->route('participant');
        
        $rules = [
            'ktp_number' => 'required|string|max:20',
            'diploma_number' => 'required|string|max:50',
            'scan_diploma' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'scan_ktp' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'scan_photo' => 'required|file|mimes:jpg,jpeg,png|max:2048',
            'cv_file' => 'required|file|mimes:pdf|max:2048',
            'integrity_pact' => 'required|file|mimes:pdf|max:2048',
        ];

        if ($participant->type === 'kemnaker') {
            $rules['health_certificate'] = 'required|file|mimes:pdf,jpg,jpeg,png|max:2048';
            
            if ($participant->participant_category === 'company') {
                $rules['work_certificate'] = 'required|file|mimes:pdf,jpg,jpeg,png|max:2048';
                $rules['company_npwp'] = 'required|file|mimes:pdf,jpg,jpeg,png|max:2048';
            }
        }
        if ($participant->type === 'bnsp') {
    $rules['work_certificate'] = 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048';
}

        return $rules;
    }
}