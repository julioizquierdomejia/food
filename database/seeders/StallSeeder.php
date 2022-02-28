<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Stall;

class StallSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $cargo = new Stall();
        $cargo->name = 'Gerente';
        $cargo->save();

        $cargo = new Stall();
        $cargo->name = 'Supervisor';
        $cargo->save();

        $cargo = new Stall();
        $cargo->name = 'Jefe de área';
        $cargo->save();

        $cargo = new Stall();
        $cargo->name = 'Empelado';
        $cargo->save();
    }
}
