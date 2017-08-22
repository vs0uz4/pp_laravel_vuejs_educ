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
        $type = $this->getModel()?$this->getModel()->userable_type:null;
        $this
            ->add('name', 'text', [
                'label' => 'Name',
                'attr' => [
                    'placeholder' => 'Enter the name'
                ],
                'rules'=> 'required|max:255'
            ])
            ->add('email', 'email', [
                'label' => 'Email',
                'attr' => [
                    'placeholder' => 'Enter the e-mail'
                ],
                'rules'=> 'required|max:255|unique:users,email,' . $id
            ])
            ->add('type', 'select', [
                'label' => 'Type of User',
                'attr' =>[
                    'placeholder' => 'Select type of user'
                ],
                'choices' => $this->roles(),
                'rules' => 'required|in:1,2,3'. implode(',', array_keys($this->roles())),
                'selected' => function() use ($type) {
                    if ($type){
                        $type = explode('\\', $type )[2];
                        $type_selected = implode('', array_keys($this->roles(), $type));
                        return $type_selected;
                    }
                }
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
