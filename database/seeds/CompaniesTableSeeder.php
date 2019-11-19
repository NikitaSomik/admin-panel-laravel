<?php

use \Carbon\Carbon;
use Illuminate\Database\Seeder;
use  \Illuminate\Support\Facades\DB;

class CompaniesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $companies = [];
        $faker = Faker\Factory::create();

        for($i = 1; $i < 100; $i++) {

            $logo = $faker->image('public/storage/images',640,480, null, false);
            $company = [
                'name' => $faker->name,
                'email' => $faker->email,
                'logo' => $logo,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];

            array_push($companies, $company);
        }

        DB::table('companies')->insert($companies);
    }
}
