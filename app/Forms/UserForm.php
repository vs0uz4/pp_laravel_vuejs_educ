<?php

namespace SiGeEdu\Forms;

use Kris\LaravelFormBuilder\Form;
use SiGeEdu\Models\User;

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
                'rules'=> 'required|max:255'
            ])
            ->add('email', 'email', [
                'attr' => [
                    'placeholder' => 'Enter the e-mail'
                ],
                'rules'=> 'required|max:255|unique:users,email,' . $id
            ])
            ->add('type', 'select', [
                'label' => 'Tipo de Usuário',
                'choices' => $this->roles(),
                'rules' => 'required|in:1,2,3'. implode(',', array_keys($this->roles()))
            ])
            ->add('send_notification', 'checkbox', [
                'label' => 'Send welcome notification e-mail',
                'value' => true,
                'checked' => false
            ]);
    }

    /**
     * @return array
     */
    protected function roles(){
        return [
            User::ROLE_ADMIN => 'Administrator',
            User::ROLE_TEACHER => 'Teacher',
            User::ROLE_STUDENT => 'Student'
        ];
    }
}
