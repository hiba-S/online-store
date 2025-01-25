<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'name'=>'Admin',
                'email'=>'admin@mail.com',
                'role'=> 1,
                'password'=> bcrypt('12345678'),
            ],
            [
                'name'=>'Cashier',
                'email'=>'cashier@mail.com',
                'role'=> 2,
                'password'=> bcrypt('12345678'),
             ],
            [
               'name'=>'User',
               'email'=>'user@mail.com',
               'role'=> 0,
               'password'=> bcrypt('12345678'),
            ],
            
            
        ];
    
        foreach ($users as $user) 
        {
            User::create($user);
        }
    }
}
