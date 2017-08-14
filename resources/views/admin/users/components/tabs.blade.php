@php
    $tabs = [
        [
            'title' => '<h4>Edit User</h4>',
            'link'  => route('admin.users.edit', ['user' => $user->id])
        ],
        [
            'title'  => '<h4>Edit User Profile</h4>',
            'link'  => route('admin.users.profile.edit', ['user' => $user->id])
        ],
    ]
@endphp

<div class="panel panel-default">
    <div class="panel-heading">
        <h3><span class="glyphicon glyphicon-user"></span> Manage Users</h3>
            {{--
            {!! Button::normal('Users list')
                ->appendIcon(Icon::thList())
                ->asLinkTo(route('admin.users.index'))
            !!}
            --}}
    </div>
    <div class="panel-body tab-content">
        {!! \Navigation::tabs($tabs) !!}
        <div class="tab-panel-slot">
            {!! $slot !!}
        </div>
    </div>
</div>