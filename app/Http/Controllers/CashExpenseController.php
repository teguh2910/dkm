<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCashExpenseRequest;
use App\Http\Requests\UpdateCashExpenseRequest;
use App\Models\Barcode;
use App\Models\CashExpense;
use App\Models\ExpenseCategory;
use Illuminate\Support\Facades\Auth;

class CashExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $expenses = CashExpense::query()
            ->with(['barcode', 'expenseCategory'])
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

        $barcodes = Barcode::query()->where('is_active', true)->get();
        $categories = ExpenseCategory::query()->where('is_active', true)->get();

        return view('cash-expenses.create', compact('barcodes', 'categories'));
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

        CashExpense::create($request->validated());

        return redirect()
            ->route('cash-expenses.index')
            ->with('success', 'Data pengeluaran kas berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(CashExpense $cashExpense)
    {
        $cashExpense->load(['barcode', 'expenseCategory']);

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
        $categories = ExpenseCategory::query()->where('is_active', true)->get();

        return view('cash-expenses.edit', compact('cashExpense', 'barcodes', 'categories'));
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

        $cashExpense->update($request->validated());

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
}
