<?php

namespace SiGeEdu\Forms;

use Kris\LaravelFormBuilder\Form;

class SubjectForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('name', 'text', [
                'label' => 'Name',
                'attr' => [
                    'placeholder' => 'Enter the name'
                ],
                'rules' => 'required|max:255'
            ]);
    }
}
