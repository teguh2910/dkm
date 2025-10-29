<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCashExpenseRequest;
use App\Http\Requests\UpdateCashExpenseRequest;
use App\Models\Barcode;
use App\Models\CashExpense;
use App\Models\ExpenseCategory;

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
        $barcodes = Barcode::query()->where('is_active', true)->get();
        $categories = ExpenseCategory::query()->where('is_active', true)->get();

        return view('cash-expenses.create', compact('barcodes', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCashExpenseRequest $request)
    {
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
        $barcodes = Barcode::query()->where('is_active', true)->get();
        $categories = ExpenseCategory::query()->where('is_active', true)->get();

        return view('cash-expenses.edit', compact('cashExpense', 'barcodes', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCashExpenseRequest $request, CashExpense $cashExpense)
    {
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
}
