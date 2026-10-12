<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('user')->insert([
            'nama' => 'E-commerce',
            'email' => 'Kelompok@gmail.com',
            'password' => Hash::make('123'),
        ]);
    }
}
