<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Jim;

class JimSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $jim = new Jim;
        $jim->cant = 1;
        $jim->valor = 0.01;

        $jim->save();
    }
}
