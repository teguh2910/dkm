<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CashExpense extends Model
{
    /** @use HasFactory<\Database\Factories\CashExpenseFactory> */
    use HasFactory;

    protected $fillable = [
        'barcode_id',
        'tanggal',
        'dibayarkan_kepada',
        'sebesar',
        'terbilang',
        'expense_category_id',
        'keterangan2',
        'status_bendahara',
        'status_sekretaris',
        'status_ketua',
        'approved_bendahara_at',
        'approved_sekretaris_at',
        'approved_ketua_at',
    ];

    protected function casts(): array
    {
        return [
            'tanggal' => 'date',
            'sebesar' => 'decimal:2',
            'approved_bendahara_at' => 'datetime',
            'approved_sekretaris_at' => 'datetime',
            'approved_ketua_at' => 'datetime',
        ];
    }

    public function barcode(): BelongsTo
    {
        return $this->belongsTo(Barcode::class);
    }

    public function expenseCategory(): BelongsTo
    {
        return $this->belongsTo(ExpenseCategory::class);
    }

    public function isFullyApproved(): bool
    {
        return $this->status_bendahara === 'approved'
            && $this->status_sekretaris === 'approved'
            && $this->status_ketua === 'approved';
    }

    public function hasRejection(): bool
    {
        return $this->status_bendahara === 'rejected'
            || $this->status_sekretaris === 'rejected'
            || $this->status_ketua === 'rejected';
    }
}
