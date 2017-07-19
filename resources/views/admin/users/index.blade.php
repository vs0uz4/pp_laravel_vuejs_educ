@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3>Users</h3>
                </div>
                <div class="panel-body">
                    {!! Button::primary('New User')->asLinkTo(route('admin.users.create')) !!}
                </div>

                {!!
                    Table::withContents($users->items())
                        ->hover()
                        ->withClassOnCellsInColumn(['ID','Actions'], 'text-center')
                        ->callback('Actions', function ($field, $row){
                            (!$_REQUEST) ? $page = 1 : $page = $_REQUEST['page'];
                            $linkEdit = route('admin.users.edit', ['user' => $row->id, 'page' => $page]);
                            $linkShow = route('admin.users.show', ['user' => $row->id, 'page' => $page]);

                            return Button::link('Edit')->asLinkTo($linkEdit). '|' . Button::link('View')->asLinkTo($linkShow);
                        })
                !!}
            </div>
            <div class="row text-center">
                {!! $users->links() !!}
            </div>
        </div>
    </div>
@endsection