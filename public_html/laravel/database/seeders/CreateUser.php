<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Carbon\Carbon;

class CreateUser extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = [
        [
            'username'=>'admin@gmail.com',
            'name'=>'Admin',
            'email'=>'drama2713@gmail.com',
            'jenis_kelamin'=>'l',
            'user_level'=>'1',
            'photo'=>'',
            'is_active'=>'1',
            'password'=>bcrypt('admin')
        ],
        [
            'username'=>'user@gmail.com',
            'name'=>'User',
            'email'=>'',
            'jenis_kelamin'=>'l',
            'user_level'=>'2',
            'photo'=>'',
            'is_active'=>'1',
            'password'=>bcrypt('user')
        ]
        ];
        foreach ($user as $key => $value) {
            User::create($value);
        }
    }
}
