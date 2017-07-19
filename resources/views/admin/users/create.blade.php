@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <h3>New User</h3>
            {!!
                form($form
                    ->add('btn_save','submit', ['attr' => ['class' => 'btn btn-primary'], 'label' => 'Save'])
                    ->add('btn_cancel', 'button', ['attr' => ['class' => 'btn btn-default'], 'label' => 'Cancel'])
                )
            !!}
        </div>
    </div>
@endsection