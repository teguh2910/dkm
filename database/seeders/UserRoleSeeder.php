<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Dept PIC',
                'email' => 'pic@dkm.com',
                'password' => Hash::make('password'),
                'role' => 'dept_pic',
            ],
            [
                'name' => 'Bendahara DKM',
                'email' => 'bendahara@dkm.com',
                'password' => Hash::make('password'),
                'role' => 'bendahara',
            ],
            [
                'name' => 'Sekretaris DKM',
                'email' => 'sekretaris@dkm.com',
                'password' => Hash::make('password'),
                'role' => 'sekretaris',
            ],
            [
                'name' => 'Ketua DKM',
                'email' => 'ketua@dkm.com',
                'password' => Hash::make('password'),
                'role' => 'ketua',
            ],
        ];

        foreach ($users as $userData) {
            User::updateOrCreate(
                ['email' => $userData['email']],
                $userData
            );
        }
    }
}
