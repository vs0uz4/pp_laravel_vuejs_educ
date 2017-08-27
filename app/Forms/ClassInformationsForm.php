<?php

namespace SiGeEdu\Forms;

use Carbon\Carbon;
use Kris\LaravelFormBuilder\Form;

class ClassInformationsForm extends Form
{
    public function buildForm()
    {
        $formatDate = function ($value){
            return ($value && $value instanceof Carbon) ? $value->format('Y-m-d') : $value;
        };

        $this
            ->add('date_start', 'date', [
                'wrapper' => [
                    'class' => 'form-group col-md-6 no-padding-left'
                ],
                'label' => 'Start Date',
                'rules' => 'required|date',
                'value' => $formatDate,
            ])
            ->add('date_end', 'date', [
                'wrapper' => ['class' => 'form-group col-md-6 no-padding-right'],
                'label' => 'End Date',
                'rules' => 'required|date',
                'value' => $formatDate,
            ])
            ->add('cycle', 'number', [
                'wrapper' => [
                    'class' => 'form-group col-md-3 no-padding-left'
                ],
                'attr'=> [
                    'min' => 1,
                    'max' => 8,
                    'step' => 1,
                ],
                'label' => 'Cycle',
                'rules' => 'required|integer',
            ])
            ->add('subdivision', 'number', [
                'wrapper' => [
                    'class' => 'form-group col-md-3'
                ],
                'attr'=> [
                    'min' => 1,
                    'max' => 16,
                    'step' => 1,
                ],
                'label' => 'Subdivision',
                'rules' => 'integer',
            ])
            ->add('semester', 'number', [
                'wrapper' => [
                    'class' => 'form-group col-md-3'
                ],
                'attr'=> [
                    'min' => 1,
                    'max' => 2,
                    'step' => 1,
                ],
                'label' => 'Semester (1 or 2)',
                'rules' => 'required|in:1,2',
            ])
            ->add('year', 'number', [
                'wrapper' => [
                    'class' => 'form-group col-md-3 no-padding-right'
                ],
                'attr'=> [
                    'min' => Carbon::now()->year,
                    'step' => 1,
                ],
                'label' => 'Year',
                'rules' => 'required|integer'
            ]);
    }
}
