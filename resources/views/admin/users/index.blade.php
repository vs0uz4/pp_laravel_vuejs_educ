@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3><span class="glyphicon glyphicon-user"></span> Users</h3>
                </div>
                <div class="panel-body">
                    {!! Button::success('New User')->prependIcon(Icon::plusSign())->asLinkTo(route('admin.users.create')) !!}
                </div>

                {!!
                    Table::withContents($users->items())
                        ->hover()
                        ->ignore(['Enrolment'])
                        ->withClassOnCellsInColumn(['ID','Actions'], 'text-center')
                        ->callback('Actions', function ($field, $row){
                            (!$_REQUEST) ? $page = 1 : $page = $_REQUEST['page'];
                            $linkEdit = route('admin.users.edit', ['user' => $row->id, 'page' => $page]);
                            $linkShow = route('admin.users.show', ['user' => $row->id, 'page' => $page]);

                            return Button::link('Edit')->prependIcon(Icon::edit())->asLinkTo($linkEdit). '|' . Button::link('View')->prependIcon(Icon::eyeOpen())->asLinkTo($linkShow);
                        })
                !!}
            </div>
            <div class="row text-center">
                {!! $users->links() !!}
            </div>
        </div>
    </div>
@endsection