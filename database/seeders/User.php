<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class User extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => 'Raja Jawa',
                'email' => 'RajaJawa@gmail.com',
                'password' => Hash::make('rajajawa')
            ],
            [
                'name' => 'Satrio Piningit',
                'email' => 'satriopiningit@gmail.com',
                'password' => Hash::make('satrio')
            ],
        ];

        DB::table('users')->insert($data);
    }
}
