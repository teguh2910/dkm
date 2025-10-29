<?php

namespace Database\Factories;

use App\Models\Barcode;
use App\Models\ExpenseCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CashExpense>
 */
class CashExpenseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'barcode_id' => Barcode::factory(),
            'tanggal' => $this->faker->date(),
            'dibayarkan_kepada' => $this->faker->name(),
            'sebesar' => $this->faker->randomFloat(2, 10000, 5000000),
            'terbilang' => 'Terbilang akan diisi otomatis',
            'expense_category_id' => ExpenseCategory::factory(),
            'keterangan2' => $this->faker->sentence(),
            'status_bendahara' => 'pending',
            'status_sekretaris' => 'pending',
            'status_ketua' => 'pending',
        ];
    }
}
