<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buat akun Staff Admin
        User::create([
            'name' => 'Staff Administrasi',
            'username' => 'admin',
            'password' => Hash::make('password'),
            'role' => 'staff admin',
        ]);

        // Buat akun Direktur
        User::create([
            'name' => 'Direktur',
            'username' => 'direktur',
            'password' => Hash::make('password'),
            'role' => 'direktur',
        ]);
    }
}
