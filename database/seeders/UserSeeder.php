<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $user = [
            [
                'name'    => 'admin1111',
                'email'   => 'admin1111@gmail.com',
                'role_as' => '1',
                'password'=> bcrypt('123456789'),
                'user_type'=> 'Admin',
            ],
            [
                'name'  => 'test5564646',
                'email'   => 'test5564646@gmail.com',
                'role_as' => '0',
                'password'=> bcrypt('123456789'),
                'user_type'=>'Customer',
            ],
        ];
        foreach($user as $key => $value){
            User::create($value);
        }
    }
}
