<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Effect;
use App\Models\User;
use App\Models\WashOrder;
use App\Models\WashType;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function washOrderReport(Request $request, $washOrderId)
    {
        $userId = $request->get('userId');
        $user = User::find($userId);

        $washOrder = WashOrder::find($washOrderId);

        $washOrder->client;
        $washOrder->washType;
        $washOrder->details;

        $data = [
            'user' => $user,
            'client' => $washOrder->client,
            'washOrder' => $washOrder,
            'details' => $washOrder->details
        ];

        $pdf = Pdf::loadView('reports/wash-order', $data)
            ->setPaper('a4', 'landscape');

        return $pdf->stream('invoice.pdf');
    }

    public function generalReportCount(Request $request)
    {
        $data = [
            'clients' => [
                'active' => Client::getActiveClientsCount(),
                'inactive' => Client::getInactiveClientsCount()
            ],
            'orders' => [
                'count' => WashOrder::getOrdersCount(),
                'revenue' => WashOrder::getOrdersTotalRevenue()
            ],
            'wash_types' => [
                'active' => WashType::getActiveCount(),
                'inactive' => WashType::getInactiveCount()
            ],
            'effects' => [
                'active' => Effect::getActiveCount(),
                'inactive' => Effect::getInactiveCount()
            ]
        ];

        return $this->respondWithSuccess($data);
    }
}
