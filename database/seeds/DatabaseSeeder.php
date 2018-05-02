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
        $this->call(UserTableSeeder::class);
        /*$this->call(ElecteurTableSeeder::class);
        $this->call(UserElecteurSeeder::class);
        $this->call(MissionTableSeeder::class);
        $this->call(UserMissionSeeder::class);*/
    }
}
