<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAk3uBnspRenewalRequest;
use App\Mail\Ak3uBnspRenewalConfirmation;
use App\Models\Ak3uBnspRenewal;
use App\Models\Template;
use Illuminate\Support\Facades\Mail;

class Ak3uBnspRenewalController extends Controller
{
    public function showForm()
    {
        $templates = Template::where('is_active', true)->get();

        return view('forms.ak3u-bnsp-perpanjangan', compact('templates'));
    }

    public function store(StoreAk3uBnspRenewalRequest $request)
    {
        $data = $request->validated();

        // Handle file uploads
        foreach ($request->allFiles() as $key => $file) {
            $path = $file->store('ak3u-bnsp-renewals', 'public');
            $data[$key] = $path;
        }

        $registration = Ak3uBnspRenewal::create($data);

        // Send confirmation email
        Mail::to($registration->email)->send(new Ak3uBnspRenewalConfirmation($registration));

        return redirect()->route('ak3u.bnsp.perpanjangan.success')
            ->with('success', 'Pendaftaran Perpanjangan AK3U BNSP berhasil! Silakan cek email Anda dan tunggu konfirmasi admin via WhatsApp.');
    }

    public function success()
    {
        return view('registration-success', ['type' => 'Perpanjangan AK3U BNSP']);
    }
}
