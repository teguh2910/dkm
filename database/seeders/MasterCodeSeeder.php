<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class MasterCodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $masterCodes = [
            [
                'code' => 'MC-2025-001',
                'name' => 'Master Code Operasional 2025',
                'description' => 'Master code untuk budget operasional tahun 2025',
                'year' => 2025,
                'is_active' => true,
            ],
            [
                'code' => 'MC-2025-002',
                'name' => 'Master Code Proyek 2025',
                'description' => 'Master code untuk budget proyek tahun 2025',
                'year' => 2025,
                'is_active' => true,
            ],
            [
                'code' => 'MC-2024-001',
                'name' => 'Master Code Operasional 2024',
                'description' => 'Master code untuk budget operasional tahun 2024',
                'year' => 2024,
                'is_active' => true,
            ],
        ];

        foreach ($masterCodes as $masterCode) {
            \App\Models\MasterCode::create($masterCode);
        }
    }
}
