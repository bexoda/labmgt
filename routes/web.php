<?php

use App\Http\Controllers\DownloadPdfController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    // return view('welcome');
    return redirect()->route('filament.admin.auth.login');
});

// Route::get('/met-report-daily', function () {
//     return view('PDF.MetReportPDF');
// })->name('met-report');

// Route::get('/met-report-daily', [DownloadPdfController::class, 'download'])->name('met-report');


