<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Parameter;


class ParameterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        
        $parametro = new Parameter();
        $parametro->cancelTime = 60;
        $parametro->freeCant = 15;

        $parametro->save();

    }
}
