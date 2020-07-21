<?php

use App\Patient;
use App\Treatment;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        factory(Patient::class, 20)->create()->each(function($p) {
            $p->treatments()
              ->saveMany(
                  factory(Treatment::class, rand(1,5))->make()
              );
    });
    }
}
