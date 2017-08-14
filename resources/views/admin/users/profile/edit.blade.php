@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @component('admin.users.components.tabs', ['user' => $form->getModel()])
                {!!
                    form($form
                        ->add('btn_cancel', 'button', ['attr' => ['class' => 'btn btn-default', 'onclick' => 'event.preventDefault();history.back();'], 'label' => '<span class="glyphicon glyphicon-chevron-left"></span> Cancel'])
                        ->add('btn_edit','submit', ['attr' => ['class' => 'btn btn-primary'], 'label' => '<span class="glyphicon glyphicon-edit"></span> Edit'])
                    )
                !!}
            @endcomponent
        </div>
    </div>
@endsection