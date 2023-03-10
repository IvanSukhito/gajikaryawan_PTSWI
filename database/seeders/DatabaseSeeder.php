<?php

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
        $this->call(\Database\Seeders\InstallingSeeder::class);
        $this->call(\Database\Seeders\PTKPSeeder::class);
        $this->call(\Database\Seeders\TunjBerkalaSeeder::class);
        $this->call(\Database\Seeders\BPJSSeeder::class);
    }
}
