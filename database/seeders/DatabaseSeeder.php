<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Mohammed Al-Qabbani',
            'email' => 'mohammed@listingmanager.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Demo Viewer',
            'email' => 'viewer@listingmanager.com',
            'password' => Hash::make('viewer123'),
            'role' => 'viewer',
        ]);
    }
}
