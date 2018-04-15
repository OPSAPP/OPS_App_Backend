<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Electeur;
use App\User;
class UserElecteurSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $centre_de_vote = array('14 janvier', 'Sidi el khaffi', '02 Mars', 'El Dhehari');
        $orientation_de_vote = array('Slimen fel 9alb', 'Tayar', 'Machrou3', 'Jackie', 'Nahdha', 'Slimen el mezyena', 'Jabha', 'Nahdha', 'Nidaa', 'El amal', 'El mosta9bel');
        $intention_de_vote = array('a l\'intention de voter', 'n\a pas l\intention de voter', 'pas encore');
        $situation_familiale = array('célibataire', 'marié', 'divorcé');
        $situation_pro = array('étudiant', 'chômeur', 'employé');
        $niveau_academique = array('niveau bac', 'bac +3', 'bac +5', 'bac +11');
        for($i = 0; $i < 50; $i++) {
            $electeur_id = $faker->numberBetween(1, 189); // For selecting Electeur Id
            $lat = $faker->numberBetween(697000, 697800);
            $long = $faker->numberBetween(490900,492000);
            $CDV = $faker->randomElement($centre_de_vote);
            $ODV = $faker->randomElement($orientation_de_vote);
            $IDV = $faker->randomElement($intention_de_vote);
            $SF = $faker->randomElement($situation_familiale);
            $SP = $faker->randomElement($situation_pro);
            $NA = $faker->randomElement($niveau_academique);
            $date = $faker->dateTimeBetween('-4 days', 'now');
            $user_id = $faker->numberBetween(4, 103);
            $latitude = "36." . $lat;
            $longitude = "10." . $long;
            $electeur = Electeur::find($electeur_id);

            $electeur->orientation_de_vote = $ODV;
            $electeur->intention_de_vote = $IDV;
            $electeur->centre_de_vote = $CDV;
            $electeur->situation_familiale = $SF;
            $electeur->situation_pro = $SP;
            $electeur->niveau_academique = $NA;
            $electeur->updated_at = $date;

            if($electeur->save()){
                DB::table('user_electeur')->insert([
                    'user_id' => $user_id,
                    'electeur_id' => $electeur_id,
                    'location_lat' => $latitude,
                    'location_long' => $longitude,
                    'created_at' => $date,
                    'updated_at' => $date
                ]);
            }


        }
    }
}
