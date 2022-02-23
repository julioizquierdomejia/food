<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Offer;

class OfferSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $oferta = new Offer();
        $oferta->name = '1 BOLETO';
        $oferta->cost_us = 1;
        $oferta->cant = 1;

        $oferta->save();

        $oferta = new Offer();
        $oferta->name = '7 BOLETO';
        $oferta->cost_us = 5;
        $oferta->cant = 7;

        $oferta->save();

        $oferta = new Offer();
        $oferta->name = '15 BOLETO';
        $oferta->cost_us = 10;
        $oferta->cant = 15;

        $oferta->save();

        $oferta = new Offer();
        $oferta->name = '30 BOLETO';
        $oferta->cost_us = 20;
        $oferta->cant = 30;

        $oferta->save();

        $oferta = new Offer();
        $oferta->name = '75 BOLETO';
        $oferta->cost_us = 50;
        $oferta->cant = 75;

        $oferta->save();

        $oferta = new Offer();
        $oferta->name = '175 BOLETO';
        $oferta->cost_us = 100;
        $oferta->cant = 175;

        $oferta->save();
    }
}
