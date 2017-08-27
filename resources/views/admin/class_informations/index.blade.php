@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3><span class="glyphicon glyphicon-blackboard"></span> Class Informations</h3>
                </div>
                <div class="panel-body">
                    {!! Button::success('New Class Informations')->prependIcon(Icon::plusSign())->asLinkTo(route('admin.class_informations.create')) !!}
                </div>

                {!!
                    // ID	Start Date	End Date	Cycle	Subdivision	Semester	Year	Actions
                    Table::withContents($class_informations->items())
                        ->hover()
                        ->withClassOnCellsInColumn(['ID', 'Start Date', 'End Date', 'Cycle', 'Subdivision', 'Semester', 'Year', 'Actions'], 'text-center')
                        ->callback('Actions', function ($field, $row){
                            (!$_REQUEST) ? $page = 1 : $page = $_REQUEST['page'];
                            $linkEdit = route('admin.class_informations.edit', ['class_information' => $row->id, 'page' => $page]);
                            $linkShow = route('admin.class_informations.show', ['class_information' => $row->id, 'page' => $page]);

                            return Button::link('Edit')->prependIcon(Icon::edit())->asLinkTo($linkEdit). '|' . Button::link('View')->prependIcon(Icon::eyeOpen())->asLinkTo($linkShow);
                        })
                !!}
            </div>
            <div class="row text-center">
                {!! $class_informations->links() !!}
            </div>
        </div>
    </div>
@endsection