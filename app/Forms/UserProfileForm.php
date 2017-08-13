<?php

namespace SiGeEdu\Forms;

use Kris\LaravelFormBuilder\Form;

class UserProfileForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('address', 'text', [
                'label' => 'Address',
                'attr' => [
                    'placeholder' => 'Enter the address'
                ],
                'rules' => 'required|max:255'
            ])
            ->add('postal_code', 'text',[
                'label' => 'Postal Code',
                'attr' => [
                    'placeholder' => 'Enter the postal code'
                ],
                'rules' => 'required|max:8'
            ])
            ->add('number', 'text',[
                'label' => 'Number',
                'attr' => [
                    'placeholder' => 'Enter the address number'
                ],
                'rules' => 'required|max:255'
            ])
            ->add('complement', 'text',[
                'label' => 'Complement',
                'attr' => [
                    'placeholder' => 'Enter the address complement.'
                ],
                'rules' => 'max:255'
            ])
            ->add('city', 'text',[
                'label' => 'City',
                'attr' => [
                    'placeholder' => 'Enter the city'
                ],
                'rules' => 'required|max:255'
            ])
            ->add('neighborhood', 'text',[
                'label' => 'Neighborhood',
                'attr' => [
                    'placeholder' => 'Enter the neighborhood'
                ],
                'rules' => 'required|max:255'
            ])
            ->add('state', 'text',[
                'label' => 'State',
                'attr' => [
                    'placeholder' => 'Enter the state'
                ],
                'rules' => 'required|max:255'
            ]);
    }
}
