<?php

namespace App\Http\Controllers;

use App\Models\Barcode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;

class BarcodeController extends Controller
{
    public function index()
    {
        $barcodes = Barcode::latest()->paginate(10);
        return view('barcodes.index', compact('barcodes'));
    }

    public function create()
    {
        if (!Auth::user()->isDeptPic()) {
            abort(403, 'Unauthorized action.');
        }
        
        return view('barcodes.create');
    }

    public function store(Request $request)
    {
        if (!Auth::user()->isDeptPic()) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'code' => 'required|string|max:255|unique:barcodes,code',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'amount_budget' => 'nullable|numeric|min:0',
            'year' => 'nullable|integer|min:2000|max:2100',
        ]);

        Barcode::create($validated);

        return redirect()->route('barcodes.index')->with('success', 'Barcode berhasil ditambahkan!');
    }

    public function show(Barcode $barcode)
    {
        $barcode->load(['cashExpenses' => function ($query) {
            $query->latest()->take(10);
        }]);
        
        return view('barcodes.show', compact('barcode'));
    }

    public function edit(Barcode $barcode)
    {
        if (!Auth::user()->isDeptPic()) {
            abort(403, 'Unauthorized action.');
        }
        
        return view('barcodes.edit', compact('barcode'));
    }

    public function update(Request $request, Barcode $barcode)
    {
        if (!Auth::user()->isDeptPic()) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'code' => 'required|string|max:255|unique:barcodes,code,' . $barcode->id,
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'amount_budget' => 'nullable|numeric|min:0',
            'year' => 'nullable|integer|min:2000|max:2100',
        ]);

        $barcode->update($validated);

        return redirect()->route('barcodes.index')->with('success', 'Barcode berhasil diupdate!');
    }

    public function destroy(Barcode $barcode)
    {
        if (!Auth::user()->isDeptPic()) {
            abort(403, 'Unauthorized action.');
        }

        $barcode->delete();

        return redirect()->route('barcodes.index')->with('success', 'Barcode berhasil dihapus!');
    }

    public function showUpload()
    {
        if (!Auth::user()->isDeptPic()) {
            abort(403, 'Unauthorized action.');
        }
        
        return view('barcodes.upload');
    }

    public function upload(Request $request)
    {
        if (!Auth::user()->isDeptPic()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv|max:2048',
        ]);

        $file = $request->file('file');
        $spreadsheet = IOFactory::load($file->getPathname());
        $worksheet = $spreadsheet->getActiveSheet();
        $rows = $worksheet->toArray();

        // Skip header row
        array_shift($rows);

        $imported = 0;
        $errors = [];

        foreach ($rows as $index => $row) {
            // Skip empty rows
            if (empty(array_filter($row))) {
                continue;
            }

            $rowNumber = $index + 2; // +2 because we shifted header and excel starts at 1

            try {
                Barcode::updateOrCreate(
                    ['code' => $row[0]], // barcode
                    [
                        'name' => $row[0], // use barcode as name if no separate name column
                        'description' => $row[1] ?? null, // deskripsi
                        'amount_budget' => $row[2] ?? null, // amount_budget
                        'year' => $row[3] ?? null, // tahun
                        'is_active' => true,
                    ]
                );
                $imported++;
            } catch (\Exception $e) {
                $errors[] = "Baris $rowNumber: " . $e->getMessage();
            }
        }

        if (count($errors) > 0) {
            return redirect()->route('barcodes.index')
                ->with('warning', "Berhasil import $imported data. Error: " . implode(', ', $errors));
        }

        return redirect()->route('barcodes.index')
            ->with('success', "Berhasil import $imported data barcode!");
    }

    public function downloadTemplate()
    {
        $filePath = public_path('barcode_template.xlsx');
        
        if (!file_exists($filePath)) {
            return redirect()->back()->with('error', 'Template file tidak ditemukan!');
        }

        return response()->download($filePath, 'barcode_template.xlsx');
    }
}
