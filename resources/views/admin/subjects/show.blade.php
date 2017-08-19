@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3><span class="glyphicon glyphicon-list-alt"></span> View Subject</h3>
                </div>
                <div class="panel-body">
                    @php
                        !$_REQUEST ? $page=1 : $page=$_REQUEST['page'];
                        $linkBack   = route('admin.subjects.index', ['page' => $page]);
                        $linkEdit   = route('admin.subjects.edit', ['subject' => $subject->id, 'page' => $page]);
                        $linkDelete = route('admin.subjects.destroy', ['subject' => $subject->id, 'page' => $page]);

                        $formDelete = FormBuilder::plain([
                            'id'    => 'form-delete',
                            'url'   => $linkDelete,
                            'method'=> 'DELETE',
                            'style' => 'display:none'
                        ])
                    @endphp

                    {!! Button::normal('Back')->prependIcon(Icon::chevronLeft())->asLinkTo($linkBack) !!}
                    {!! Button::success('Edit')->prependIcon(Icon::edit())->asLinkTo($linkEdit) !!}
                    {!!
                        Button::danger('Delete')->prependIcon(Icon::removeSign())->asLinkTo($linkDelete)
                            ->addAttributes([
                                'onclick' => "event.preventDefault();document.getElementById(\"form-delete\").submit();"
                            ])
                    !!}
                    {!! form($formDelete) !!}
                </div>

                {!!
                    Table::withContents([$subject])
                        ->withClassOnCellsInColumn(['Created At', 'Updated At'], 'text-center')
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