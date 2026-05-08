<?php
// app/Http/Controllers/PopDocumentController.php

namespace App\Http\Controllers;

use App\Http\Requests\StorePopDocumentRequest;
use App\Models\PopDocumentUpload;
use App\Models\PopParticipant;
use Illuminate\Http\Request;

class PopDocumentController extends Controller
{
    public function show(PopParticipant $participant)
    {
        // Cek apakah DP sudah dibayar
        if ($participant->status !== 'dp_paid') {
            return redirect()->route('home')
                ->with('error', 'Silakan selesaikan pembayaran DP terlebih dahulu.');
        }

        $existingDocuments = PopDocumentUpload::where('pop_participant_id', $participant->id)->first();
        
        return view('documents.pop-upload', compact('participant', 'existingDocuments'));
    }

    public function store(StorePopDocumentRequest $request, PopParticipant $participant)
    {
        $documentData = ['pop_participant_id' => $participant->id];
        
        // Handle file uploads
        foreach ($request->allFiles() as $key => $file) {
            $path = $file->store('pop_documents/' . $participant->registration_number, 'public');
            $documentData[$key] = $path;
        }

        $documentData['ktp_number'] = $request->ktp_number;
        $documentData['diploma_number'] = $request->diploma_number;

        PopDocumentUpload::updateOrCreate(
            ['pop_participant_id' => $participant->id],
            $documentData
        );

        return redirect()->back()->with('success', 'Dokumen berhasil diupload!');
    }
}