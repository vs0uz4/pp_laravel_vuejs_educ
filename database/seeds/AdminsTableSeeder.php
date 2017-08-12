<?php

use Illuminate\Database\Seeder;
use SiGeEdu\Models\User;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds for Administrators users.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class)->create([
            'name'      => 'Administrator',
            'email'     => 'admin@user.com',
            'enrolment' => '100001'
        ])->each(function(User $user){
            if (!$user->userable) {
                User::assignRole($user, User::ROLE_ADMIN);
                $user->save();
            }
        });

        factory(User::class)->create([
            'name'      => 'vSouza',
            'email'     => 'vitor.rodrigues@gmail.com',
            'enrolment' => '100002'
        ])->each(function(User $user){
            if (!$user->userable) {
                User::assignRole($user, User::ROLE_ADMIN);
                $user->save();
            }
        });
    }
}
