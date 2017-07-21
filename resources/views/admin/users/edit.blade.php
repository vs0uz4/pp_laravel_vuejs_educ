@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3><span class="glyphicon glyphicon-user"></span> Edit User</h3>
                </div>
                <div class="panel-body">
                    {!!
                        form($form
                            ->add('btn_cancel', 'button', ['attr' => ['class' => 'btn btn-default', 'onclick' => 'event.preventDefault();history.back();'], 'label' => '<span class="glyphicon glyphicon-chevron-left"></span> Cancel'])
                            ->add('btn_edit','submit', ['attr' => ['class' => 'btn btn-primary'], 'label' => '<span class="glyphicon glyphicon-edit"></span> Edit'])
                        )
                    !!}
                </div>
            </div>
        </div>
    </div>
@endsection