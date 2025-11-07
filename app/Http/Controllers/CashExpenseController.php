<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCashExpenseRequest;
use App\Http\Requests\UpdateCashExpenseRequest;
use App\Models\Barcode;
use App\Models\CashExpense;
use App\Models\MasterCode;
use Illuminate\Support\Facades\Auth;

class CashExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $expenses = CashExpense::query()
            ->with(['barcode.masterCode'])
            ->latest()
            ->paginate(15);

        return view('cash-expenses.index', compact('expenses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Only Dept PIC can create
        if (! Auth::user()->isDeptPic()) {
            abort(403, 'Hanya Dept PIC yang dapat membuat pengeluaran baru');
        }

        $years = MasterCode::distinct()->pluck('year')->sort()->reverse()->values();
        $masterCodes = MasterCode::query()->where('is_active', true)->get();
        $barcodes = collect(); // Empty initially, will be loaded via AJAX
        $selectedBarcodeId = request('barcode');
        $selectedYear = request('year');
        $selectedMasterCodeId = request('master_code');

        // If barcode is preselected, load related data
        if ($selectedBarcodeId) {
            $selectedBarcode = Barcode::find($selectedBarcodeId);
            if ($selectedBarcode) {
                $selectedYear = $selectedBarcode->year;
                $selectedMasterCodeId = $selectedBarcode->master_code_id;
                $barcodes = Barcode::where('master_code_id', $selectedMasterCodeId)
                    ->where('year', $selectedYear)
                    ->where('is_active', true)
                    ->get();
            }
        }

        return view('cash-expenses.create', compact('years', 'masterCodes', 'barcodes', 'selectedBarcodeId', 'selectedYear', 'selectedMasterCodeId'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCashExpenseRequest $request)
    {
        // Only Dept PIC can create
        if (! Auth::user()->isDeptPic()) {
            abort(403, 'Hanya Dept PIC yang dapat membuat pengeluaran baru');
        }

        $cashExpense = CashExpense::create($request->validated());

        // Update barcode spent_amount
        $barcode = Barcode::find($cashExpense->barcode_id);
        if ($barcode) {
            $barcode->increment('spent_amount', $cashExpense->sebesar);
        }

        return redirect()
            ->route('cash-expenses.index')
            ->with('success', 'Data pengeluaran kas berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(CashExpense $cashExpense)
    {
        $cashExpense->load(['barcode']);

        return view('cash-expenses.show', compact('cashExpense'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CashExpense $cashExpense)
    {
        // Only Dept PIC can edit
        if (! Auth::user()->isDeptPic()) {
            abort(403, 'Hanya Dept PIC yang dapat mengedit pengeluaran');
        }

        $barcodes = Barcode::query()->where('is_active', true)->get();

        return view('cash-expenses.edit', compact('cashExpense', 'barcodes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCashExpenseRequest $request, CashExpense $cashExpense)
    {
        // Only Dept PIC can update
        if (! Auth::user()->isDeptPic()) {
            abort(403, 'Hanya Dept PIC yang dapat mengupdate pengeluaran');
        }

        $oldAmount = $cashExpense->sebesar;
        $oldBarcodeId = $cashExpense->barcode_id;

        $cashExpense->update($request->validated());

        // Update barcode spent_amount
        $newAmount = $cashExpense->sebesar;
        $newBarcodeId = $cashExpense->barcode_id;

        if ($oldBarcodeId == $newBarcodeId) {
            // Same barcode, adjust the difference
            $barcode = Barcode::find($oldBarcodeId);
            if ($barcode) {
                $difference = $newAmount - $oldAmount;
                $barcode->increment('spent_amount', $difference);
            }
        } else {
            // Different barcode, subtract from old and add to new
            $oldBarcode = Barcode::find($oldBarcodeId);
            if ($oldBarcode) {
                $oldBarcode->decrement('spent_amount', $oldAmount);
            }

            $newBarcode = Barcode::find($newBarcodeId);
            if ($newBarcode) {
                $newBarcode->increment('spent_amount', $newAmount);
            }
        }

        return redirect()
            ->route('cash-expenses.index')
            ->with('success', 'Data pengeluaran kas berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CashExpense $cashExpense)
    {
        // Only Dept PIC can delete
        if (! Auth::user()->isDeptPic()) {
            abort(403, 'Hanya Dept PIC yang dapat menghapus pengeluaran');
        }

        // Restore barcode spent_amount
        $barcode = Barcode::find($cashExpense->barcode_id);
        if ($barcode) {
            $barcode->decrement('spent_amount', $cashExpense->sebesar);
        }

        $cashExpense->delete();

        return redirect()
            ->route('cash-expenses.index')
            ->with('success', 'Data pengeluaran kas berhasil dihapus');
    }

    /**
     * Update approval status.
     */
    public function updateApproval(CashExpense $cashExpense, string $role, string $status)
    {
        // Check if user has permission to approve for this role
        if (! Auth::user()->canApproveAs($role)) {
            abort(403, 'Anda tidak memiliki akses untuk approval ini');
        }

        // Check approval order: bendahara -> sekretaris -> ketua
        if ($role === 'sekretaris' && $cashExpense->status_bendahara !== 'approved') {
            return redirect()
                ->back()
                ->with('error', 'Bendahara harus approve terlebih dahulu');
        }

        if ($role === 'ketua' && ($cashExpense->status_bendahara !== 'approved' || $cashExpense->status_sekretaris !== 'approved')) {
            return redirect()
                ->back()
                ->with('error', 'Bendahara dan Sekretaris harus approve terlebih dahulu');
        }

        $field = "status_{$role}";
        $dateField = "approved_{$role}_at";

        $cashExpense->update([
            $field => $status,
            $dateField => $status === 'approved' ? now() : null,
        ]);

        return redirect()
            ->back()
            ->with('success', "Status approval {$role} berhasil diupdate");
    }

    /**
     * Get master codes by year (AJAX).
     */
    public function getMasterCodesByYear($year)
    {
        $masterCodes = MasterCode::where('year', $year)
            ->where('is_active', true)
            ->get(['id', 'code', 'name']);

        return response()->json($masterCodes);
    }

    /**
     * Get barcodes by master code and year (AJAX).
     */
    public function getBarcodesByMasterCode($masterCodeId, $year)
    {
        $barcodes = Barcode::where('master_code_id', $masterCodeId)
            ->where('year', $year)
            ->where('is_active', true)
            ->get(['id', 'code', 'name', 'description', 'amount_budget', 'spent_amount']);

        return response()->json($barcodes);
    }

    /**
     * Download format Excel template.
     */
    public function downloadFormat()
    {
        $filePath = public_path('format.xlsx');

        if (! file_exists($filePath)) {
            return redirect()
                ->back()
                ->with('error', 'File format tidak ditemukan');
        }

        return response()->download($filePath, 'Format_Pengeluaran_Kas_DKM.xlsx');
    }

    /**
     * Export cash expenses to Excel.
     */
    public function export()
    {
        $expenses = CashExpense::with(['barcode.masterCode'])
            ->orderBy('tanggal', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet;
        $sheet = $spreadsheet->getActiveSheet();

        // Set header
        $headers = [
            'No',
            'Tanggal',
            'Master Code',
            'Nama Master Code',
            'Kode Barcode',
            'Nama Barcode',
            'Deskripsi Barcode',
            'Dibayarkan Kepada',
            'Jumlah (Rp)',
            'Terbilang',
            'Keterangan',
            'Status Bendahara',
            'Status Sekretaris',
            'Status Ketua',
            'Tahun',
        ];

        $column = 'A';
        foreach ($headers as $header) {
            $sheet->setCellValue($column.'1', $header);
            $column++;
        }

        // Style header
        $sheet->getStyle('A1:O1')->getFont()->setBold(true);
        $sheet->getStyle('A1:O1')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setRGB('4472C4');
        $sheet->getStyle('A1:O1')->getFont()->getColor()->setRGB('FFFFFF');

        // Fill data
        $row = 2;
        foreach ($expenses as $index => $expense) {
            $sheet->setCellValue('A'.$row, $index + 1);
            $sheet->setCellValue('B'.$row, $expense->tanggal->format('d/m/Y'));
            $sheet->setCellValue('C'.$row, $expense->barcode->masterCode ? $expense->barcode->masterCode->code : '-');
            $sheet->setCellValue('D'.$row, $expense->barcode->masterCode ? $expense->barcode->masterCode->name : '-');
            $sheet->setCellValue('E'.$row, $expense->barcode->code);
            $sheet->setCellValue('F'.$row, $expense->barcode->name);
            $sheet->setCellValue('G'.$row, $expense->barcode->description ?? '-');
            $sheet->setCellValue('H'.$row, $expense->dibayarkan_kepada);
            $sheet->setCellValue('I'.$row, $expense->sebesar);
            $sheet->setCellValue('J'.$row, $expense->terbilang);
            $sheet->setCellValue('K'.$row, $expense->keterangan2 ?? '-');
            $sheet->setCellValue('L'.$row, ucfirst($expense->status_bendahara));
            $sheet->setCellValue('M'.$row, ucfirst($expense->status_sekretaris));
            $sheet->setCellValue('N'.$row, ucfirst($expense->status_ketua));
            $sheet->setCellValue('O'.$row, $expense->year);
            $row++;
        }

        // Format currency column
        $lastRow = $row - 1;
        $sheet->getStyle('I2:I'.$lastRow)->getNumberFormat()
            ->setFormatCode('#,##0');

        // Auto-size columns
        foreach (range('A', 'O') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Add borders
        $sheet->getStyle('A1:O'.$lastRow)->getBorders()->getAllBorders()
            ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        // Create Excel file
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $fileName = 'Pengeluaran_Kas_'.date('Y-m-d_His').'.xlsx';
        $tempFile = tempnam(sys_get_temp_dir(), $fileName);

        $writer->save($tempFile);

        return response()->download($tempFile, $fileName)->deleteFileAfterSend(true);
    }
}
