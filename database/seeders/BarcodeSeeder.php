<?php

namespace Database\Seeders;

use App\Models\Barcode;
use Illuminate\Database\Seeder;

class BarcodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $barcodes = [
            ['code' => 'BRG001', 'name' => 'Alat Tulis Kantor', 'description' => 'Perlengkapan alat tulis'],
            ['code' => 'BRG002', 'name' => 'Konsumsi', 'description' => 'Biaya konsumsi rapat'],
            ['code' => 'BRG003', 'name' => 'Kebersihan', 'description' => 'Perlengkapan kebersihan'],
            ['code' => 'BRG004', 'name' => 'Operasional', 'description' => 'Biaya operasional harian'],
            ['code' => 'BRG005', 'name' => 'Transportasi', 'description' => 'Biaya transportasi'],
        ];

        foreach ($barcodes as $barcode) {
            Barcode::create($barcode);
        }
    }
}
