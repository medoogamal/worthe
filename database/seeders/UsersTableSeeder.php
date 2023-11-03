<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'first_name' => 'super',
            'last_name'  => 'admin',
            'email'      => 'super@app.com',
            'password'   => bcrypt('123456')
        ]);


        $user->addRole('super_admin');
    } //end of run
}