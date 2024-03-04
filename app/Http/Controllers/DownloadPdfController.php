<?php

namespace App\Http\Controllers;

use App\Models\LabRequest;
use App\Models\LabResult;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Collection;
use LaravelDaily\Invoices\Invoice;
use Spatie\Browsershot\Browsershot;
use LaravelDaily\Invoices\Classes\Buyer;
use function Spatie\LaravelPdf\Support\pdf;
use LaravelDaily\Invoices\Classes\InvoiceItem;

class DownloadPdfController extends Controller
{
    public function download(Collection $records)
    {
        $data = [
            'title' => 'Met Report - Analysis Statistics',
            'customerName' => 'Kenneth Ekow Inkum',
            'records' => $records,
        ];

        $pdf = Pdf::loadView('PDF.MetReportPDF', $data);
        // return $pdf->download('met-report.pdf');
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'Met_Report_Analysis_Statistics_' . now() . '.pdf');
    }
}
