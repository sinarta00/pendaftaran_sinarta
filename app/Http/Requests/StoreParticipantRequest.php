<?php
// app/Http/Requests/StoreParticipantRequest.php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\ReferralCode; // 👈 TAMBAH INI

class StoreParticipantRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    // 👇 TAMBAH METHOD INI (SEBELUM rules())
    protected function prepareForValidation()
    {
        // Auto-set participant_category = 'personal' untuk BNSP
        if ($this->type === 'bnsp') {
            $this->merge([
                'participant_category' => 'personal'
            ]);
        }
    }

    public function rules()
    {
        $rules = [
            'type' => 'required|in:kemnaker,bnsp',
        
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:participants,email',
            'phone' => 'required|string|max:20',
        
            'birth_place' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'golongan_darah' => 'nullable|in:A,B,AB,O',
        
            'gender' => 'required|in:L,P',
            'domisili_kota' => 'required|string|max:255',
            'jurusan' => 'required|string|max:255',
            'institution_name' => 'required|string|max:255',
        
            'employment_status' => 'nullable|in:Belum bekerja,Karyawan,Fresh Graduate,Kontrak',
            'training_purpose' => 'required|in:Syarat kerja,Upgrade Skill,Syarat Tender',
        
            'training_schedule_id' => 'required|exists:training_schedules,id',
            'shirt_size' => 'required|in:S,M,L,XL,XXL',
            'information_source' => 'required|in:Rekan,Poster,Banner,Instagram,Facebook,Tiktok',
        
            'referral_code' => [
                'nullable',
                'string',
                'max:50',
                function ($attribute, $value, $fail) {
                    if ($value && !ReferralCode::where('code', $value)->where('is_active', true)->exists()) {
                        $fail('Kode referral tidak valid.');
                    }
                }
            ],
        
            'agreement_checkbox' => 'required|accepted',
            'referral_info' => ['nullable', 'string', 'max:255'],
          ];
          
         if (in_array($this->employment_status, ['Karyawan', 'Kontrak'])) {
            $rules['work_company_name'] = 'required|string|max:255';
        } else {
            $rules['work_company_name'] = 'nullable|string|max:255';
        }

        if ($this->type === 'kemnaker') {
            $rules['education'] = 'required|in:D3,S1,S2,S3';
            $rules['participant_category'] = 'required|in:personal,company';
            
            if ($this->participant_category === 'company') {
                $rules['company_name'] = 'required|string|max:255';
                $rules['company_address'] = 'required|string';
                $rules['company_phone'] = 'required|string|max:20';
            }
        }

        if ($this->type === 'bnsp') {
            $rules['education_bnsp'] = 'required|in:SMA,D3,S1,S2,S3';
        }

        return $rules;
    }
}