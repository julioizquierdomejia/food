<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Country;
class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $pais = new Country;
        $pais->name = 'Peru';
        $pais->code = '51';
        $pais->save();

        $pais = new Country;
        $pais->name = 'Ecuador';
        $pais->code = '593';
        $pais->save();
    }
}
