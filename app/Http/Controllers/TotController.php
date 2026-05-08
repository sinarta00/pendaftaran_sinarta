<?php
// app/Http/Controllers/TotController.php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTotRequest;
use App\Mail\TotRegistrationConfirmation;
use App\Mail\TotPaymentConfirmation;
use App\Models\TotRegistration;
use App\Models\ReferralCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class TotController extends Controller
{
    public function showForm()
    {
        $referralCodes = ReferralCode::where('is_active', true)->get();
        return view('forms.tot', compact('referralCodes'));
    }

    public function store(StoreTotRequest $request)
    {
        $data = $request->validated();
        
        // Handle file uploads
        foreach ($request->allFiles() as $key => $file) {
            $path = $file->store('tot-documents', 'public');
            $data[$key] = $path;
        }

        $registration = TotRegistration::create($data);

        // Send confirmation email
        Mail::to($registration->email)->send(new TotRegistrationConfirmation($registration));

        return redirect()->route('tot.success')
            ->with('success', 'Pendaftaran TOT berhasil! Silakan cek email Anda dan tunggu konfirmasi admin via WhatsApp.');
    }

    public function success()
    {
        return view('registration-success', ['type' => 'TOT']);
    }
}