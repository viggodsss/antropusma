<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin Puskesmas',
            'email' => 'admin@puskesmas.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'status' => 'approved',
            'verified_at' => now(),
        ]);

        echo "✅ Admin user berhasil dibuat!\n";
        echo "Email: admin@puskesmas.com\n";
        echo "Password: admin123\n";
    }
}
