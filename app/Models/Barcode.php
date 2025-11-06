<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Barcode extends Model
{
    /** @use HasFactory<\Database\Factories\BarcodeFactory> */
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'description',
        'amount_budget',
        'spent_amount',
        'year',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'amount_budget' => 'decimal:2',
            'spent_amount' => 'decimal:2',
        ];
    }

    public function cashExpenses(): HasMany
    {
        return $this->hasMany(CashExpense::class);
    }

    public function getRemainingBudgetAttribute(): float
    {
        return $this->amount_budget - $this->spent_amount;
    }

    public function getBudgetPercentageAttribute(): float
    {
        if ($this->amount_budget == 0) {
            return 0;
        }
        return ($this->spent_amount / $this->amount_budget) * 100;
    }
}
