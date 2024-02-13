<?php

namespace App\Http\Controllers;

use App\Enums\Roles;
use App\Models\User;
use App\Models\Client;
use App\Models\Effect;
use App\Models\WashType;
use App\Models\WashOrder;
use App\Enums\OrderStatus;
use App\Models\AccountMovement;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Date;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:' . Roles::ADMIN->value)
            ->only(['generalReportCount']);
    }

    public function washOrderReport(Request $request, $washOrderId)
    {
        $userId = $request->get('userId');
        $user = User::find($userId);

        $washOrder = WashOrder::find($washOrderId);

        if ($washOrder->status === OrderStatus::CREATED->value) {
            abort(403, 'No tienes permiso.');
        }

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

    public function accountMovementsByDateRangeReport(Request $request, $clientId)
    {
        $userId = $request->get('userId');
        $user = User::find($userId);

        $client = Client::find($clientId);

        $defaultRawDate = Date::now()->toDateString();

        $rawStartDate = $request->get('startDate', $defaultRawDate);
        $rawEndDate = $request->get('endDate', $defaultRawDate);

        $startDate = Date::parse($rawStartDate);
        $endDate = Date::parse($rawEndDate);

        $movements = AccountMovement::getAccountMovements($clientId, $startDate, $endDate);
        $balanceUntilDate = AccountMovement::getBalanceUntilDate($clientId, $startDate);
        $balance = $balanceUntilDate;
        $detailedMovements = AccountMovement::getDetailedMovements($movements, $balance);
        $processedMovements = AccountMovement::getProcessedMovements($detailedMovements);

        $data = [
            'user' => $user,
            'client' => $client,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'startBalance' => $balanceUntilDate,
            'finalBalance' => $balance,
            'processedMovements' => $processedMovements
        ];

        $pdf = Pdf::loadView('reports/account-movements', $data)
            ->setPaper('a4', 'portrait');

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
