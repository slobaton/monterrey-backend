<?php

namespace App\Http\Controllers;

use App\Enums\Roles;
use App\Models\User;
use App\Models\Client;
use App\Models\Effect;
use App\Models\WashType;
use App\Models\WashOrder;
use App\Models\AccountMovement;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
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

        if (!$user) {
            abort(404, 'User not found.');
        }

        $washOrder = WashOrder::with(['client', 'washType', 'details'])->find($washOrderId);
        if (!$washOrder) {
            abort(404, 'Wash Order not found.');
        }

        $washOrder->checkPermissionOrFail();

        $washOrder->checkIfUserCanPrint($washOrder, $user);

        $washOrder->recordPrintHistory($userId);

        $data = $washOrder->prepareReportData($user);

        $pdf = Pdf::loadView('reports/wash-order', $data)
            ->setPaper('letter', 'landscape');

        $timestamp = Carbon::now()->timestamp;

        return $pdf->stream("invoice-{$timestamp}.pdf");
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

        $pdf = Pdf::loadView('reports/account-movements', $data);
        $pdf->setPaper('letter', 'portrait');
        $this->addPagination($pdf);
        $this->addExtraInfo($pdf, $user);

        $timestamp = Carbon::now()->timestamp;

        return $pdf->stream("movements-{$timestamp}.pdf");
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

    private function addPagination($pdf)
    {
        $dompdf = $pdf->getDomPDF();
        $dompdf->render();
        $canvas = $dompdf->getCanvas();
        $canvas->page_script(function ($pageNumber, $pageCount, $canvas, $fontMetrics) {
            $text = "Página $pageNumber de $pageCount";
            $font = $fontMetrics->getFont('monospace');
            $pageHeight = $canvas->get_height();
            $size = 9;
            $canvas->text(20, $pageHeight - 20, $text, $font, $size);
        });
    }

    private function addExtraInfo($pdf, $user)
    {
        $date = Carbon::now();

        $dompdf = $pdf->getDomPDF();
        $dompdf->render();
        $canvas = $dompdf->getCanvas();
        $canvas->page_script(function ($pageNumber, $pageCount, $canvas, $fontMetrics) use ($user, $date) {
            $text = "U: {$user->name} - F: {$date->format('d/m/Y H:m:s')}";
            $font = $fontMetrics->getFont('monospace');
            $pageWidth = $canvas->get_width();
            $pageHeight = $canvas->get_height();
            $size = 9;
            $width = $fontMetrics->getTextWidth($text, $font, $size);
            $canvas->text($pageWidth - $width - 20, $pageHeight - 20, $text, $font, $size);
        });
    }
}
