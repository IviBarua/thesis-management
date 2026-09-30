<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'first_name' => 'Admin',
            'last_name' => 'User',
            'birth' => '1990-01-01',
            'gender' => 'other',
            'email' => 'admin@gmail.com',
            'phone' => '0000000000',
            'department' => 'CSE',
            'degree' => 'M.Sc.',
            'batch' => 2020,
            'session' => 'spring',
            'designation' => 'Administrator',
            'teacher_id' => 'ADMIN001',
            'password' => Hash::make('admin12345'),
            'role' => 'admin',
        ]);
    }
}
