@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3>View User</h3>
                </div>
                <div class="panel-body">
                    @php
                        !$_REQUEST ? $page=1 : $page=$_REQUEST['page'];
                        $linkBack = route('admin.users.index', ['page' => $page]);
                        $linkEdit = route('admin.users.edit', ['user' => $user->id, 'page' => $page]);
                        $linkDelete = route('admin.users.destroy', ['user' => $user->id, 'page' => $page]);

                        $formDelete = FormBuilder::plain([
                            'id'    => 'form-delete',
                            'url'   => $linkDelete,
                            'method'=> 'DELETE',
                            'style' => 'display:none'
                        ])
                    @endphp

                    {!! Button::normal('Back')->asLinkTo($linkBack) !!}
                    {!! Button::warning('Edit')->asLinkTo($linkEdit) !!}
                    {!!
                        Button::danger('Delete')->asLinkTo($linkDelete)
                            ->addAttributes([
                                'onclick' => "event.preventDefault();document.getElementById(\"form-delete\").submit();"
                            ])
                    !!}
                    {!! form($formDelete) !!}
                </div>

                {!!
                    Table::withContents([$user])
                        ->withClassOnCellsInColumn(['ID','Created At', 'Updated At'], 'text-center')
                        ->callback('Created At', function ($field, $row) {
                            return $row->created_at->diffForHumans();
                        })
                        ->callback('Updated At', function ($field, $row) {
                            return $row->updated_at->diffForHumans();
                        })
                !!}
            </div>
        </div>
    </div>
@endsection