<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Mission;
use Carbon\Carbon;
class MissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $array = ["planifiée", "en cours", "terminée"];
        for ($i = 0; $i < 10; $i++) {
            $title = $faker->words(1, true);
            $description = $faker->sentence(6);
            $date = $faker->dateTimeBetween('-5 days', '-4 days');
            $starts_at = Carbon::createFromTimestamp($faker->dateTimeBetween('-4 days', '-2 days')->getTimestamp());
            $ends_at = Carbon::createFromFormat('Y-m-d H:i:s', $starts_at)->addHours(2);
            $status = $faker->randomElement($array);
            $user_id = $faker->numberBetween(1, 3);

            $mission = new Mission([
                "title" => $title,
                "description" => $description,
                "created_at" => $date,
                "updated_at" => $date,
                "starts_at" => $starts_at,
                "ends_at" => $ends_at,
                "status" => $status,
                "user_id" => $user_id
            ]);
            $mission->save();
        }
    }
}
