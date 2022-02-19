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
        

        if (config('variables.WITH_FAKER')) {
            // FAKE data
        }

        DB::unprepared(file_get_contents(__dir__ . '/categories.sql'));
    }
}
