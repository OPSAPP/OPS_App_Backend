<?php

use Illuminate\Database\Seeder;
use App\User;
use Faker\Factory as Faker;
use Carbon\Carbon;

class UserMissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $faker = Faker::create();
        for ($i = 0; $i < 400; $i++) {
            $date= $faker->dateTimeBetween('-4 days', '-2 days');
            $user_id = $faker->numberBetween(4,10);
            $latitude = "36." . $faker->numberBetween(697000, 697800);
            $longitude = "10." . $faker->numberBetween(490900,492000);
            DB::table('user_mission')->insert([
                "created_at" => $date,
                "updated_at" => $date,
                "user_id" => $user_id,
                "location_lat" => $latitude,
                "location_long" => $longitude
            ]);
        }


    }
}
