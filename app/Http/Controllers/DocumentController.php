<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDocumentRequest;
use App\Models\DocumentUpload;
use App\Models\Participant;
use App\Models\Template;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function show(Participant $participant)
{
    // Validasi akses berdasarkan kategori
    if ($participant->participant_category === 'personal') {
        // Personal: harus DP dulu
        if ($participant->status !== 'dp_paid') {
            return redirect()->route('home')
                ->with('error', 'Silakan selesaikan pembayaran DP terlebih dahulu.');
        }
    } else {
        // Company: bisa upload selama belum lunas
        if (!in_array($participant->status, ['pending', 'documents_uploaded', 'documents_verified', 'invoice_sent'])) {
            return redirect()->route('home')
                ->with('error', 'Upload dokumen sudah tidak tersedia.');
        }
    }

    $templates = Template::where('is_active', true)->get();
    $existingDocuments = DocumentUpload::where('participant_id', $participant->id)->first();
    
    return view('documents.upload', compact('participant', 'templates', 'existingDocuments'));
}

    public function store(StoreDocumentRequest $request, Participant $participant)
    {
        $documentData = ['participant_id' => $participant->id];
        
        // Handle file uploads
        foreach ($request->allFiles() as $key => $file) {
            $path = $file->store('documents/' . $participant->registration_number, 'public');
            $documentData[$key] = $path;
        }

        // Handle non-file fields
        $documentData['ktp_number'] = $request->ktp_number;
        $documentData['diploma_number'] = $request->diploma_number;

        DocumentUpload::updateOrCreate(
            ['participant_id' => $participant->id],
            $documentData
        );

        // 👇 UPDATE STATUS JIKA COMPANY
        if ($participant->participant_category === 'company' && $participant->status === 'pending') {
            $participant->update(['status' => 'documents_uploaded']);
        }

        return redirect()->back()->with('success', 'Dokumen berhasil diupload!');
    }

    public function downloadTemplate(Template $template)
    {
        return Storage::disk('public')->download($template->file_path);
    }
}