<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use League\Csv\Reader;
use App\Electeur;
class ElecteurTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $reader = Reader::createFromPath(base_path() . '/database/seeds/csvs/SouthernSliman1.csv', 'r+');
        $reader->setDelimiter(';');
        foreach ($reader as $index => $row) {
            if ($index != 0) {
                $date = $faker->dateTimeBetween('-7 days', '-5 days');
                if ($row[6] == '0') {
                    $gender = 'femme';
                } else {
                    $gender = 'homme';
                }
                $electeur = new Electeur([
                    'nom' => $row[5],
                    'prenom' => $row[2],
                    'prenom_pere' => $row[3],
                    'centre_de_vote' => $row[1],
                    'prenom_grand_pere' => $row[4],
                    'created_at' => $date,
                    'updated_at' => $date,
                    'gender' => $gender,
                    'isElecteur' => true
                ]);
                $electeur->save();
            }
        }
    }
}
