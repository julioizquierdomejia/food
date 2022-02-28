<?php

namespace Database\Seeders;

use App\Models\Dish;
use Illuminate\Database\Seeder;

class DishSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $plato = new Dish();
        $plato->name = 'Ceviche';
        $plato->type = 0;
        $plato->save();

        $plato = new Dish();
        $plato->name = 'Papa a la Huancaina';
        $plato->type = 0;
        $plato->save();

        $plato = new Dish();
        $plato->name = 'Ensalada Fresca';
        $plato->type = 0;
        $plato->save();

        $plato = new Dish();
        $plato->name = 'Arroz con Pollo';
        $plato->type = 1;
        $plato->save();

        $plato = new Dish();
        $plato->name = 'Pollo al horno';
        $plato->type = 1;
        $plato->save();

        $plato = new Dish();
        $plato->name = 'Pure de Papas';
        $plato->type = 1;
        $plato->save();

        $plato = new Dish();
        $plato->name = 'Aji de Gallina';
        $plato->type = 1;
        $plato->save();

        $plato = new Dish();
        $plato->name = 'Gelatina';
        $plato->type = 2;
        $plato->save();

        $plato = new Dish();
        $plato->name = 'Arroz con Leche';
        $plato->type = 2;
        $plato->save();

        $plato = new Dish();
        $plato->name = 'Fruta - Manzana';
        $plato->type = 2;
        $plato->save();

    }
}
