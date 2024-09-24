<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::create([
            'email' => 'admin@gmail.com',
            'first_name' => 'Ezekielle',
            'last_name' => 'Cortez',
            'contact_number' => '09154879632',
            'password' => Hash::make('adminpassword'), 
        ]);
    }
}
