@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <h3>Edit User</h3>
            {!!
                form($form
                    ->add('btn_edit','submit', ['attr' => ['class' => 'btn btn-primary'], 'label' => 'Edit'])
                    ->add('btn_cancel', 'button', ['attr' => ['class' => 'btn btn-default'], 'label' => 'Cancel'])
                )
            !!}
        </div>
    </div>
@endsection