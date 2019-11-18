<?php

use Illuminate\Database\Seeder;
use \App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        $password = 'password';

        User::create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt($password)
        ]);

        for($i = 1; $i < 5; $i++) {
            $email = $faker->email;
            User::create([
                'name' => $faker->name,
                'email' => $email,
                'password' => bcrypt($password)
            ]);
        }
    }
}
