<?php
// app/Http/Requests/StoreTotRequest.php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Http;

class StoreTotRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'full_name'            => 'required|string|max:255|regex:/^[\pL\s\'\-\.\,]+$/u',
            'email'                => 'required|email|unique:tot_registrations,email',
            'phone'                => 'required|string|max:20',
            'nik'                  => 'required|string|max:20',
            'diploma_number'       => 'required|string|max:50',
            'birth_place'          => 'required|string|max:255',
            'birth_date'           => 'required|date',
            'education'            => 'required|in:SMA,D3,S1,S2,S3',
            'level'                => 'required|in:3,4,5,6',
            'information_source'   => 'required|in:rekan,poster,banner,mediasocial',
            'referral_code'        => 'nullable|string|max:50',
            'agreement_checkbox'   => 'required|accepted',
            'g-recaptcha-response' => 'required',

            // Required files for all levels
            'photo_file'    => 'required|file|mimes:jpg,jpeg,png|max:2048',
            'ktp_file'      => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'diploma_file'  => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ];

        $level = $this->input('level');

        if ($level == '3') {
            $rules['tot_assistant_cert'] = 'required|file|mimes:pdf,jpg,jpeg,png|max:2048';
            $rules['work_exp_assistant'] = 'required|file|mimes:pdf,jpg,jpeg,png|max:2048';
        }

        if ($level == '4') {
            $rules['tot_instructor_cert']  = 'required|file|mimes:pdf,jpg,jpeg,png|max:2048';
            $rules['work_exp_instructor']  = 'required|file|mimes:pdf,jpg,jpeg,png|max:2048';
        }

        if (in_array($level, ['5', '6'])) {
            $rules['kkni_level4_cert'] = 'required|file|mimes:pdf,jpg,jpeg,png|max:2048';
        }

        if ($level == '5') {
            $rules['work_exp_instructor'] = 'required|file|mimes:pdf,jpg,jpeg,png|max:2048';
        }

        if ($level == '6') {
            $rules['work_exp_senior'] = 'required|file|mimes:pdf,jpg,jpeg,png|max:2048';
        }

        return $rules;
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {

            // 1. Honeypot check — jika field ini terisi, pasti bot
            if ($this->filled('website_url')) {
                abort(403);
            }

            // 2. Validasi reCAPTCHA ke server Google
            $recaptcha = $this->input('g-recaptcha-response');
            if ($recaptcha) {
                $response = Http::post('https://www.google.com/recaptcha/api/siteverify', [
                    'secret'   => config('services.recaptcha.secret_key'),
                    'response' => $recaptcha,
                    'remoteip' => $this->ip(),
                ]);

                if (!$response->json('success')) {
                    $validator->errors()->add('g-recaptcha-response', 'Verifikasi reCAPTCHA gagal. Silakan coba lagi.');
                }
            }

            // 3. Block email disposable
            $blockedDomains = [
                'mailinator.com', 'tempmail.com', 'guerrillamail.com',
                'yopmail.com', 'throwam.com', 'sharklasers.com',
            ];
            $email = $this->input('email');
            if ($email) {
                $domain = strtolower(substr(strrchr($email, '@'), 1));
                if (in_array($domain, $blockedDomains)) {
                    $validator->errors()->add('email', 'Email disposable tidak diizinkan. Gunakan email aktif.');
                }
            }
        });
    }

    public function messages()
    {
        return [
            'g-recaptcha-response.required' => 'Harap centang verifikasi "I\'m not a robot".',
            'agreement_checkbox.required'   => 'Anda harus menyetujui pernyataan di atas.',
            'agreement_checkbox.accepted'   => 'Anda harus menyetujui pernyataan di atas.',
            'email.unique'                  => 'Email ini sudah terdaftar.',
        ];
    }
}