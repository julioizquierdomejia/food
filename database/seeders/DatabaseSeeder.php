<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(users::class);
        $this->call(CountrySeeder::class);
        $this->call(JimSeeder::class);
        $this->call(RaffleSeeder::class);
        $this->call(OfferSeeder::class);
        
    }
}
