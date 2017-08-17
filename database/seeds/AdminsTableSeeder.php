<?php

use Illuminate\Database\Seeder;
use SiGeEdu\Models\User;
use SiGeEdu\Models\UserProfile;

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
                // Create Faker User Profiles
                $profile = factory(UserProfile::class)->make();
                $user->profile()->create($profile->toArray());
                // Assign Role for user
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
                // Create Faker User Profiles
                $profile = factory(UserProfile::class)->make();
                $user->profile()->create($profile->toArray());
                // Assign Role for user
                User::assignRole($user, User::ROLE_ADMIN);
                $user->save();
            }
        });
    }
}
