<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MachineLeftData;
use App\Models\MachineRightData;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;

class HistoryController extends Controller
{
    public function index(Request $request)
    {
        // LEFT
        $leftQuery = MachineLeftData::query();
        // RIGHT
        $rightQuery = MachineRightData::query();

        // Filters
        foreach ([$leftQuery, $rightQuery] as $query) {
            if ($request->filled('from')) {
                $query->whereDate('timestamp', '>=', $request->from);
            }

            if ($request->filled('to')) {
                $query->whereDate('timestamp', '<=', $request->to);
            }

            if ($request->status === 'alarm') {
                $query->where('alarm', true);
            } elseif ($request->status === 'normal') {
                $query->where(function ($q) {
                    $q->whereNull('alarm')->orWhere('alarm', false);
                });
            }

            if ($request->filled('min_rpm')) {
                $query->where('rpm', '>=', $request->min_rpm);
            }
        }

        $leftData = $leftQuery->orderBy('timestamp', 'desc')->paginate(20, ['*'], 'left_page')->appends($request->all());
        $rightData = $rightQuery->orderBy('timestamp', 'desc')->paginate(20, ['*'], 'right_page')->appends($request->all());

        return view('history', compact('leftData', 'rightData'));
    }

public function export(Request $request)
{
    // Apply same filters from the page
    $leftQuery = DB::table('machine_left_data');
    $rightQuery = DB::table('machine_right_data');

    if ($request->filled('from')) {
        $leftQuery->where('timestamp', '>=', $request->from);
        $rightQuery->where('timestamp', '>=', $request->from);
    }

    if ($request->filled('to')) {
        $leftQuery->where('timestamp', '<=', $request->to);
        $rightQuery->where('timestamp', '<=', $request->to);
    }

    if ($request->filled('status')) {
        $isAlarm = $request->status === 'alarm';
        $leftQuery->where('alarm', $isAlarm);
        $rightQuery->where('alarm', $isAlarm);
    }

    if ($request->filled('min_rpm')) {
        $leftQuery->where('rpm', '>=', $request->min_rpm);
        $rightQuery->where('rpm', '>=', $request->min_rpm);
    }

    $leftData = $leftQuery->get();
    $rightData = $rightQuery->get();

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Title
    $sheet->mergeCells('A1:E1');
    $sheet->setCellValue('A1', 'Left Stage');
    $sheet->mergeCells('G1:K1');
    $sheet->setCellValue('G1', 'Right Stage');

    // Header
    $headers = ['Timestamp', 'RPM', 'Total Revs', 'Load (kN)', 'Status'];
    $sheet->fromArray($headers, null, 'A2');
    $sheet->fromArray($headers, null, 'G2');

    // Style header
    $headerStyle = [
        'font' => ['bold' => true],
        'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
    ];
    $sheet->getStyle('A2:E2')->applyFromArray($headerStyle);
    $sheet->getStyle('G2:K2')->applyFromArray($headerStyle);

    // Insert data
    $row = 3;
    foreach ($leftData as $ld) {
        $sheet->fromArray([
            $ld->timestamp,
            $ld->rpm,
            $ld->total_revs,
            $ld->load_kn,
            $ld->alarm ? 'ALARM' : 'Normal',
        ], null, 'A' . $row);
        $row++;
    }

    $row = 3;
    foreach ($rightData as $rd) {
        $sheet->fromArray([
            $rd->timestamp,
            $rd->rpm,
            $rd->total_revs,
            $rd->load_kn,
            $rd->alarm ? 'ALARM' : 'Normal',
        ], null, 'G' . $row);
        $row++;
    }

    // Apply border to data
    $leftEnd = 2 + count($leftData);
    $rightEnd = 2 + count($rightData);
    $sheet->getStyle("A2:E$leftEnd")->applyFromArray(['borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]]);
    $sheet->getStyle("G2:K$rightEnd")->applyFromArray(['borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]]);

    // Auto size
    foreach (range('A', 'E') as $col) {
        $sheet->getColumnDimension($col)->setAutoSize(true);
    }
    foreach (range('G', 'K') as $col) {
        $sheet->getColumnDimension($col)->setAutoSize(true);
    }

    // Output
    $writer = new Xlsx($spreadsheet);
    $filename = 'DurabilityHistory_' . now()->format('Ymd_His') . '.xlsx';
    $tempPath = storage_path("app/public/$filename");
    $writer->save($tempPath);

    return Response::download($tempPath)->deleteFileAfterSend(true);
}


}
