<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Database\Seeder;

class GestionnaireLouisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'louis2@burger.com'],
            [
                'name' => 'Louis',
                'password' => Hash::make('passer0220'),
                'role' => 'gestionnaire', // ou 'gestionnaire' si tu utilises ce terme dans ta app
            ]
        );
    }
}
