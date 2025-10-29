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
            ['code' => 'DKM-001', 'name' => 'DAKWAH', 'description' => 'DAKWAH'],
            ['code' => 'DKM-002', 'name' => 'SARPRAS', 'description' => 'SARPRAS'],
            ['code' => 'DKM-003', 'name' => 'SOSMAS', 'description' => 'SOSMAS'],
            ['code' => 'DKM-004', 'name' => 'PENSI', 'description' => 'PENSI'],
            ['code' => 'DKM-005', 'name' => 'KEMUSLIMAHAN', 'description' => 'KEMUSLIMAHAN'],
            ['code' => 'DKM-006', 'name' => 'BANK', 'description' => 'BANK'],
            ['code' => 'DKM-007', 'name' => 'BANTUAN', 'description' => 'BANTUAN'],
        ];

        foreach ($barcodes as $barcode) {
            Barcode::create($barcode);
        }
    }
}
