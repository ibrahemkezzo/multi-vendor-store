<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name'=>'ibrahem',
            'email'=>'ibrahem@gmail.com',
            'password'=>Hash::make('12345678'),
            'phone_number'=>'1546238'
        ]);
        DB::table('users')->insert([
            'name'=>'ali',
            'email'=>'ali@gmail.com',
            'password'=>Hash::make('12345678'),
            'phone_number'=>'567942'
        ]);
    }
}
