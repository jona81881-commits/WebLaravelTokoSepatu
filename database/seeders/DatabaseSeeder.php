<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // akun admin untuk halaman backpage
        User::create([
            'name' => 'Admin Josepa',
            'email' => 'admin@josepa.test',
            'password' => 'password',
        ])->forceFill(['is_admin' => true])->save();

        // akun pelanggan biasa
        User::create([
            'name' => 'Pelanggan',
            'email' => 'user@josepa.test',
            'password' => 'password',
        ]);

        $this->call([
            CategorySeeder::class,
            ProductSeeder::class,
        ]);
    }
}
