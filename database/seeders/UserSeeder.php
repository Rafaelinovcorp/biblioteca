<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // ADMIN
        User::updateOrCreate(
            ['email' => 'rafaalexandrecosta26@gmail.com'],
            [
                'name' => 'Administrador',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ]
        );

        // CIDADÃO
        User::updateOrCreate(
            ['email' => 'rafael.costa@trainee.inovcorp.com'],
            [
                'name' => 'João Silva',
                'password' => Hash::make('password'),
                'role' => 'cidadao',
            ]
        );
    }
}
