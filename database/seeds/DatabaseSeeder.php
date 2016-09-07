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
    	DB::unprepared(file_get_contents('./database/seeds/dump/2016_09_05.sql'));
    	$this->command->info('Seed: column added successfully.');
    }

}