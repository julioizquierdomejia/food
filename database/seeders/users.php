<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class users extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();

        $user = new User;
        $user->name = 'Administrador';
        $user->email        = 'admin@gmail.com';
        $user->phone        = '111111111';
        $user->dni          = '11111111';
        $user->password     = bcrypt('12345678');
        $user->role         = 1;

        $user->save();
        
        
    }
}
