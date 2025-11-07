<?php

namespace App\Http\Controllers;

use App\Models\MasterCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\IOFactory;

class MasterCodeController extends Controller
{
    public function index()
    {
        $masterCodes = MasterCode::latest()->paginate(10);

        return view('master-codes.index', compact('masterCodes'));
    }

    public function create()
    {
        if (! Auth::user()->isDeptPic()) {
            abort(403, 'Unauthorized action.');
        }

        return view('master-codes.create');
    }

    public function store(Request $request)
    {
        if (! Auth::user()->isDeptPic()) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'code' => 'required|string|max:255|unique:master_codes,code',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'year' => 'required|integer|min:2000|max:2100',
        ]);

        MasterCode::create($validated);

        return redirect()->route('master-codes.index')->with('success', 'Master Code berhasil ditambahkan!');
    }

    public function edit(MasterCode $masterCode)
    {
        if (! Auth::user()->isDeptPic()) {
            abort(403, 'Unauthorized action.');
        }

        return view('master-codes.edit', compact('masterCode'));
    }

    public function update(Request $request, MasterCode $masterCode)
    {
        if (! Auth::user()->isDeptPic()) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'code' => 'required|string|max:255|unique:master_codes,code,'.$masterCode->id,
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'year' => 'required|integer|min:2000|max:2100',
        ]);

        $masterCode->update($validated);

        return redirect()->route('master-codes.index')->with('success', 'Master Code berhasil diupdate!');
    }

    public function destroy(MasterCode $masterCode)
    {
        if (! Auth::user()->isDeptPic()) {
            abort(403, 'Unauthorized action.');
        }

        $masterCode->delete();

        return redirect()->route('master-codes.index')->with('success', 'Master Code berhasil dihapus!');
    }

    public function showUploadForm()
    {
        if (! Auth::user()->isDeptPic()) {
            abort(403, 'Unauthorized action.');
        }

        return view('master-codes.upload');
    }

    public function upload(Request $request)
    {
        if (! Auth::user()->isDeptPic()) {
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
                MasterCode::updateOrCreate(
                    ['code' => $row[0]], // code
                    [
                        'name' => $row[1] ?? $row[0], // name or use code as fallback
                        'description' => $row[2] ?? null, // description
                        'year' => $row[3] ?? date('Y'), // year or current year
                        'is_active' => true,
                    ]
                );
                $imported++;
            } catch (\Exception $e) {
                $errors[] = "Baris $rowNumber: ".$e->getMessage();
            }
        }

        if (count($errors) > 0) {
            return redirect()->route('master-codes.index')
                ->with('warning', "Berhasil import $imported data. Error: ".implode(', ', $errors));
        }

        return redirect()->route('master-codes.index')
            ->with('success', "Berhasil import $imported data master code!");
    }

    public function downloadTemplate()
    {
        $filePath = public_path('master_code_template.xlsx');

        if (! file_exists($filePath)) {
            return redirect()->back()->with('error', 'Template file tidak ditemukan!');
        }

        return response()->download($filePath, 'master_code_template.xlsx');
    }
}
