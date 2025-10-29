<?php

namespace Database\Seeders;

use App\Models\ExpenseCategory;
use Illuminate\Database\Seeder;

class ExpenseCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Pembelian ATK', 'description' => 'Pembelian alat tulis kantor'],
            ['name' => 'Konsumsi Rapat', 'description' => 'Konsumsi untuk rapat atau kegiatan'],
            ['name' => 'Biaya Kebersihan', 'description' => 'Pembelian alat kebersihan'],
            ['name' => 'Biaya Transportasi', 'description' => 'Transportasi untuk kegiatan DKM'],
            ['name' => 'Infaq & Sedekah', 'description' => 'Penyaluran infaq dan sedekah'],
            ['name' => 'Pemeliharaan Masjid', 'description' => 'Biaya pemeliharaan dan perbaikan'],
            ['name' => 'Listrik & Air', 'description' => 'Pembayaran utilitas'],
            ['name' => 'Lain-lain', 'description' => 'Pengeluaran lain-lain'],
        ];

        foreach ($categories as $category) {
            ExpenseCategory::create($category);
        }
    }
}
