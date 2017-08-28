<?php

use Illuminate\Database\Seeder;

class ClassInformationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $students = \SiGeEdu\Models\Student::all();

        factory(\SiGeEdu\Models\ClassInformation::class, 50)
            ->create()
            ->each(function (\SiGeEdu\Models\ClassInformation $model) use ($students){
                /** @var \Illuminate\Support\Collection $studentsCollections */
                $studentsCollections = $students->random(10);
                $model->students()->attach($studentsCollections->pluck('id'));
            });
    }
}
