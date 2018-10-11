<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //$this->call(UserSeeder::class);
        // $this->call(AuthorsSeeder::class);
         $this->call(KeywordSeeder::class);
        //$this->call(NotAvailSeeder::class);
        // $this->call(NotAvailAdvanceSeeder::class);
        // $this->call(ResearchPaperSeeder::class);
    }
}
