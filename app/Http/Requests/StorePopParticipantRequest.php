<?php
// app/Http/Requests/StorePopParticipantRequest.php

namespace App\Http\Requests;

use App\Rules\Recaptcha;
use Illuminate\Foundation\Http\FormRequest;

class StorePopParticipantRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:pop_participants,email',
            'phone' => 'required|string|max:20',
            'birth_place' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'education' => 'required|in:SMA,D3,S1,S2,S3',
            'training_schedule_id' => 'required|exists:training_schedules,id', // ✅ TAMBAHKAN INI
            'category' => 'required|in:online,hybrid',
            'company_name' => 'nullable|string|max:255',
            'information_source' => 'required|in:rekan,poster,banner,mediasocial',
            'referral_code' => 'nullable|string|max:50',
            'agreement_checkbox' => 'required|accepted',
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