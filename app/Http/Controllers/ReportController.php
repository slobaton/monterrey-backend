<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function washOrderReport(Request $request)
    {
        $userId = $request->get('userId');

        $clients = Client::all();

        $data = [
            'userId' => $userId,
            'clients' => $clients
        ];

        $pdf = Pdf::loadView('client-report', $data)
            ->setPaper('a4', 'landscape');

        return $pdf->stream('invoice.pdf');
    }
}
