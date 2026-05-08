<?php
// app/Http/Controllers/PopController.php

namespace App\Http\Controllers;

use App\Http\Requests\StorePopParticipantRequest;
use App\Mail\PopRegistrationConfirmation;
use App\Models\PopParticipant;
use App\Models\PopPayment;
use App\Models\TrainingSchedule; // ✅ TAMBAHKAN INI
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PopController extends Controller
{
    public function showForm()
    {
        // ✅ AMBIL SCHEDULE DENGAN TYPE 'pop'
        $schedules = TrainingSchedule::where('type', 'pop')
            ->where('is_active', true)
            ->get();
        
        return view('forms.pop', compact('schedules'));
    }

    public function store(StorePopParticipantRequest $request)
    {
        $participant = PopParticipant::create($request->validated());
        
        // Hitung harga berdasarkan kategori
        $price = $participant->category === 'online' ? 3800000 : 4800000;
        
        // Buat payment record untuk DP (1 juta)
        PopPayment::create([
            'pop_participant_id' => $participant->id,
            'payment_type' => 'dp',
            'amount' => 1000000,
            'remaining_amount' => $price - 1000000,
            'status' => 'pending'
        ]);

        // Kirim email konfirmasi pendaftaran
        Mail::to($participant->email)->send(new PopRegistrationConfirmation($participant));

        return redirect()->route('pop.success')
            ->with('success', 'Pendaftaran berhasil! Silakan cek email Anda untuk konfirmasi.')
            ->with('participant', $participant);
    }

    public function success()
    {
        return view('pop-registration-success');
    }
}