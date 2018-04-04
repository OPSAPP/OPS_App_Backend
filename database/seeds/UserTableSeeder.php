<?php

use Illuminate\Database\Seeder;
use App\User;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Hash;
class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $nomArray = array('Machkena', 'Boulabiar', 'Bouslama');
        $prenomArray = array('Zied', 'Marwen', 'Bahaeddine');

        // for Adding Admins
        for($i = 0; $i < 3; $i++) {
            $user = new User([
                'nom' => $nomArray[$i],
                'prenom' => $prenomArray[$i],
                'login' => $faker->userName(),
                'password' => Hash::make('helloworld'),
                'role' => 'admin',
                'created_at' => $faker->dateTimeBetween('-7 days', '-6 days'),
                'updated_at' => $faker->dateTimeBetween('-7 days', '-6 days')
            ]);
            $user->save();
        }
        for($i = 0; $i < 100; $i++) {
            $nom = $faker->lastName();
            $prenom = $faker->firstName();
            $login = $faker->userName();
            // $password = Hash::make($faker->password());
            $date = $faker->dateTimeBetween('-7 days', '-6 days');

            $user = new User([
                'nom' => $nom,
                'prenom' => $prenom,
                'login' => $login,
                'password' => Hash::make('helloworld'),
                'role' => 'agent',
                'created_at' => $date,
                'updated_at' => $date,
                "status" => "disponible",
            ]);
            $user->save();
        }
    }
}
