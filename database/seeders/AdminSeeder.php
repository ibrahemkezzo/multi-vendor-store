<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::create([
            'name'=>'admin',
            'username'=>'admin',
            'super_admin'=>'1',
            'email'=>'admin@gmail.com',
            'password'=>Hash::make('password'),
            'phone_number'=>'1546238'
        ]);
    }
}
