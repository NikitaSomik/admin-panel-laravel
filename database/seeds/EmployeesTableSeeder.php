<?php

use Illuminate\Database\Seeder;
use \App\Models\Company;
use App\Models\Employee;

class EmployeesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        $companies = Company::cursor()->each(function($company) {
            $company->employees()->saveMany(
                factory(Employee::class, 10)->make()->each(function($employee) use ($company) {
                    $employee->company_id = $company->id;
                }));
        });


//        foreach ($companies as $company) {
//             $company->id;
//
//        }
    }
}
