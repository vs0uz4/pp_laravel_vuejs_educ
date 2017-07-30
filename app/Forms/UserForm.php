<?php

namespace SiGeEdu\Forms;

use Kris\LaravelFormBuilder\Form;

class UserForm extends Form
{
    protected $formOptions = [
        'method' => 'GET',
        'url' => '/search'
    ];

    public function buildForm()
    {
        $id = $this->getData('id');
        $this
            ->add('name', 'text', [
                'attr' => [
                    'placeholder' => 'Enter the name'
                ],
                'rules'=>'required|max:255'
            ])
            ->add('email', 'email', [
                'attr' => [
                    'placeholder' => 'Enter the e-mail'
                ],
                'rules'=> 'required|max:255|unique:users,email,' . $id
            ])
            ->add('send_notification', 'checkbox', [
                'label' => 'Send welcome notification e-mail',
                'value' => true,
                'checked' => false
            ]);
    }
}
