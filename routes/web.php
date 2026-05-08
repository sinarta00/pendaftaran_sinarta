<?php
// routes/web.php

use App\Http\Controllers\AK3UController;
use App\Http\Controllers\DocumentController;
use Illuminate\Support\Facades\Route;
use App\Models\DocumentUpload;
use App\Models\Participant;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\TotController;
use App\Http\Controllers\SkpController;
use App\Http\Controllers\PopController;
use App\Http\Controllers\PopDocumentController;
$zip = new \ZipArchive();


Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/ak3u-kemnaker', [AK3UController::class, 'showKemnakerForm'])->name('ak3u.kemnaker');
Route::get('/ak3u-bnsp', [AK3UController::class, 'showBNSPForm'])->name('ak3u.bnsp');
Route::post('/ak3u/register', [AK3UController::class, 'store'])->name('ak3u.store');
Route::get('/registration-success', [AK3UController::class, 'success'])->name('registration.success');

Route::get('/documents/{participant}', [DocumentController::class, 'show'])->name('documents.show');
Route::post('/documents/{participant}', [DocumentController::class, 'store'])->name('documents.store');
Route::get('/template/{template}/download', [DocumentController::class, 'downloadTemplate'])->name('template.download');

// TOT Routes
Route::get('/tot', [TotController::class, 'showForm'])->name('tot.form');
Route::post('/tot/register', [TotController::class, 'store'])->name('tot.store');
Route::get('/tot-success', [TotController::class, 'success'])->name('tot.success');

// SKP Routes
Route::get('/skp', [SkpController::class, 'showForm'])->name('skp.form');
Route::post('/skp/register', [SkpController::class, 'store'])->name('skp.store');
Route::get('/skp-success', [SkpController::class, 'success'])->name('skp.success');

// POP Routes
Route::get('/pop-bnsp', [PopController::class, 'showForm'])->name('pop.form');
Route::post('/pop/register', [PopController::class, 'store'])->name('pop.store');
Route::get('/pop-success', [PopController::class, 'success'])->name('pop.success');

// POP Document Routes
Route::get('/pop-documents/{participant}', [PopDocumentController::class, 'show'])->name('pop.documents.show');
Route::post('/pop-documents/{participant}', [PopDocumentController::class, 'store'])->name('pop.documents.store');

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    
});