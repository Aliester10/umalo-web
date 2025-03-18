<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('t_users')->insert([
            'name' => 'Admin',
            'email' => 'admin@umalo.id',
            'password' => Hash::make('password'), // Password untuk admin
            'type' => 1, // Menandakan sebagai admin
            'is_verified' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
