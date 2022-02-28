<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Area;

class AreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $area = new Area();
        $area->name = 'Gerencia';
        $area->save();

        $area = new Area();
        $area->name = 'Contabilidad';
        $area->save();

        $area = new Area();
        $area->name = 'Administración';
        $area->save();

        $area = new Area();
        $area->name = 'Alamcen';
        $area->save();

        $area = new Area();
        $area->name = 'Planta';
        $area->save();
    }
}
