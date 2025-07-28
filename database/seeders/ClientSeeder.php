<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'ndiaga',
            'email' => 'ndiaga@gmail.com',
            'password' => Hash::make('passer0220'),
            'role' => 'client', // rôle client
        ]);
    }
}
