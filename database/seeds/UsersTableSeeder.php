<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\SiGeEdu\Models\User::class)->create([
            'name'  => 'Administrator',
            'email' => 'admin@user.com'
        ]);

        factory(\SiGeEdu\Models\User::class)->create([
            'name'  => 'vSouza',
            'email' => 'vitor.rodrigues@gmail.com'
        ]);
    }
}
