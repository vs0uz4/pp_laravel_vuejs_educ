<?php

use Illuminate\Database\Seeder;
use SiGeEdu\Models\User;

class StudentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds for Students users.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class, 20)->create()->each(function (User $user){
            if (!$user->userable){
                User::assignRole($user, User::ROLE_STUDENT);
                User::assignEnrolment(new User(), User::ROLE_STUDENT);
                $user->save();
            }
        });
    }
}
