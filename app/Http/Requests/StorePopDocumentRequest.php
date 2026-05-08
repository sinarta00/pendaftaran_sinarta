<?php
// app/Http/Requests/StorePopDocumentRequest.php

namespace App\Http\Requests;

use App\Rules\Recaptcha;
use Illuminate\Foundation\Http\FormRequest;

class StorePopDocumentRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'ktp_number' => 'required|string|max:20',
            'diploma_number' => 'required|string|max:50',
            'scan_ktp' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'scan_diploma' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'cv_file' => 'required|file|mimes:pdf|max:2048',
            'work_certificate' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'mining_experience_letter' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'g-recaptcha-response' => ['required', new Recaptcha],
        ];
    }

    public function messages()
    {
        return [
            'g-recaptcha-response.required' => 'Harap centang "I\'m not a robot" untuk melanjutkan.',
        ];
    }
}