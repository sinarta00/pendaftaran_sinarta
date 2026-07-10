<?php
// app/Http/Controllers/SkpController.php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSkpRequest;
use App\Mail\SkpRegistrationConfirmation;
use App\Mail\SkpPaymentConfirmation;
use App\Models\SkpRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\Template;

class SkpController extends Controller
{
    public function showForm()
    {   
         $templates = Template::where('is_active', true)->get();
         

        return view('forms.skp', compact('templates'));
    }

    public function store(StoreSkpRequest $request)
    {
        $data = $request->validated();

        // Handle file uploads
        foreach ($request->allFiles() as $key => $file) {
            $path = $file->store('skp-documents', 'public');
            $data[$key] = $path;
        }

        $registration = SkpRegistration::create($data);

        // Send confirmation email
        Mail::to($registration->email)->send(new SkpRegistrationConfirmation($registration));

        return redirect()->route('skp.success')
            ->with('success', 'Pendaftaran SKP berhasil! Silakan cek email Anda dan tunggu konfirmasi admin via WhatsApp.');
    }

    public function success()
    {
        return view('registration-success', ['type' => 'SKP']);
    }
}