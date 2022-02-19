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
        
        $data = [];
        
        for ($i = 1; $i <= 1 ; $i++) {
            array_push($data, [
                'name'     => 'Administrador',
                'email'    => 'admin@gmail.com',
                'phone'    => '998913140',
                'dni'    => '06813928',
                'password' => bcrypt('998913140'),
                'role'     => 10,
                'bio'      => $faker->realText(),
            ]);
        }

        /*
        for ($i = 1; $i <= 10 ; $i++) {
            array_push($data, [
                'name'     => $faker->name(),
                'email'    => $faker->email,
                'password' => bcrypt('123456'),
                'role'     => 0,
                'bio'      => $faker->realText(),
            ]);
        }
        */
        
        User::insert($data);
    }
}
