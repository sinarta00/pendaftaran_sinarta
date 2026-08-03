<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreParticipantRequest;
use App\Mail\RegistrationConfirmation;
use App\Mail\RegistrationConfirmation2; // 👈 TAMBAH INI
use App\Models\Participant;
use App\Models\Payment;
use App\Models\TrainingSchedule;
use App\Models\ReferralCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AK3UController extends Controller
{
    public function showKemnakerForm()
    {
        $schedules = TrainingSchedule::where('type', 'kemnaker')
            ->where('is_active', true)
            ->get();
        
        return view('forms.kemnaker', compact('schedules'));
    }

    public function showBNSPForm()
    {
        $schedules = TrainingSchedule::where('type', 'bnsp')
            ->where('is_active', true)
            ->get();
        $referralCodes = ReferralCode::where('is_active', true)->get();
        
        return view('forms.bnsp', compact('schedules', 'referralCodes'));
    }

public function store(StoreParticipantRequest $request)
{
    $data = $request->validated();

    if ($data['type'] === 'bnsp' && !isset($data['participant_category'])) {
        $data['participant_category'] = 'personal';
        $data['golongan_darah'] = null;
    }

    try {
        $participant = DB::transaction(function () use ($data, $request) {
            $participant = Participant::create($data);

            $schedule = TrainingSchedule::find($request->training_schedule_id);

            if ($participant->participant_category === 'personal') {
                Payment::create([
                    'participant_id' => $participant->id,
                    'payment_type' => 'dp',
                    'amount' => 1000000,
                    'remaining_amount' => $schedule->price - 1000000,
                    'status' => 'pending',
                ]);
            }

            return $participant;
        });

        // Kirim email SETELAH transaksi DB sukses & di luar transaction
        if ($participant->type === 'kemnaker' && $participant->participant_category === 'company') {
            Mail::to($participant->email)->send(new RegistrationConfirmation2($participant));
        } else {
            Mail::to($participant->email)->send(new RegistrationConfirmation($participant));
        }

        return redirect()->route('registration.success')
            ->with('success', 'Pendaftaran berhasil! Silakan cek email Anda untuk konfirmasi.')
            ->with('participant', $participant);

    } catch (\Throwable $e) {
        Log::error('Registrasi gagal', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
            'data'  => $data,
        ]);

        return back()
            ->withInput()
            ->with('error', 'Terjadi kendala saat memproses pendaftaran. Silakan coba lagi. Jika Anda menerima email konfirmasi, pendaftaran Anda sudah berhasil.');
    }
}

    public function success()
    {
        return view('registration-success');
    }
}