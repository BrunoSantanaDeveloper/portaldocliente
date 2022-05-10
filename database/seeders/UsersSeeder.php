<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Bruno Santana',
            'email'=> 'bruno.santana@lasdobrasil.com.br',
            'password' => bcrypt('102030'),
        ]);
    }
}
