<?php

use Illuminate\Database\Seeder;
use SiGeEdu\Models\User;

class TeachersTableSeeder extends Seeder
{
    /**
     * Run the database seeds for Teachers users.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class, 10)->create()->each(function (User $user){
            if (!$user->userable){
                User::assignRole($user, User::ROLE_TEACHER);
                User::assignEnrolment(new User(), User::ROLE_TEACHER);
                $user->save();
            }
        });
    }
}
