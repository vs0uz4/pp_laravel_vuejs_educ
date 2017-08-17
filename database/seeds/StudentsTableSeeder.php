<?php

use Illuminate\Database\Seeder;
use SiGeEdu\Models\User;
use SiGeEdu\Models\UserProfile;

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
                // Create Faker User Profiles
                $profile = factory(UserProfile::class)->make();
                $user->profile()->create($profile->toArray());
                // Assign Role for user
                User::assignRole($user, User::ROLE_STUDENT);
                // Assign Enrolment for user
                User::assignEnrolment(new User(), User::ROLE_STUDENT);
                $user->save();
            }
        });
    }
}
