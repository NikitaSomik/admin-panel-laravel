<?php

use Illuminate\Database\Seeder;
use \App\Models\User;
use \App\Models\Role;
use \Carbon\Carbon;
use \Illuminate\Support\Arr;

class RoleUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::cursor();
        $roles = Role::cursor()->toArray();

        foreach ($users as $key => $user) {
            $role = $user->name === 'admin' ? Arr::first($roles) : Arr::random($roles);
            $user->roles()->attach($role['id'], [
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
