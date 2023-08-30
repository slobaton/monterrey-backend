<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function downloadReport(Request $request)
    {
        $clients = Client::all();

        $data = [
            'clients' => $clients
        ];

        $pdf = Pdf::loadView('client-report', $data)
            ->setPaper('a4', 'landscape');

        return $pdf->download('invoice.pdf');
    }
}
