<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        @php
            $navbar = Navbar::withBrand('<span class=\'glyphicon glyphicon-education\'></span> ' . config('app.name'), route('admin.dashboard') );

            if(Auth::check()){
                if(Gate::allows('administration')){
                    $links = [
                        ['link' => route('admin.users.index'),  'title' => '<span class=\'glyphicon glyphicon-user\'></span> Users'],
                        ['link' => route('admin.subjects.index'), 'title' => '<span class=\'glyphicon glyphicon-list-alt\'></span> Subjects'],
                        ['link' => route('admin.class_informations.index'), 'title' => '<span class=\'glyphicon glyphicon-blackboard\'></span> Class Informations'],
                        ['link' => route('admin.systeminfo'),   'title' => '<span class=\'glyphicon glyphicon-info-sign\'></span> System Info'],
                    ];

                    $navbar->withContent(Navigation::links($links));
                }

                $linksRight = [
                    [
                        '<span class="glyphicon glyphicon-chevron-right"></span> ' . Auth::user()->name,
                        [
                            [
                                'link'  => route('admin.users.settings.edit'),
                                'title' => '<span class="glyphicon glyphicon-cog"></span> Settings',
                            ],

                            [
                                'link'  => route('admin.users.profile.edit', ['user' => Auth::user()->id]),
                                'title' => '<span class="glyphicon glyphicon-user"></span> My Profile',
                            ],

                            [
                                'link'  => route('auth.logout'),
                                'title' => '<span class="glyphicon glyphicon-log-out"></span> Logout',
                                'linkAttributes' => [
                                    'onclick' => "event.preventDefault(); document.getElementById(\"form-logout\").submit();"
                                ],
                            ]

                        ]
                    ]
                ];

                $navbar->withContent(Navigation::links($linksRight)
                       ->right());

                $formLogout = FormBuilder::plain([
                    'id'     => 'form-logout',
                    'url'    => route('auth.logout'),
                    'method' => 'POST',
                    'style'  => 'display:none'
                ]);
            }else{
                $linksRight = [
                    ['link' => route('auth.login'),  'title' => '<span class=\'glyphicon glyphicon-log-in\'></span> Login'],
                ];

                $navbar->withContent(Navigation::links($linksRight)->right());
            }
        @endphp
        {!! $navbar !!}

        @if(Auth::check())
            {!! form($formLogout) !!}
        @endif

        <div class="container hidden-print">
            <div class="row">
                @include('flash::message')
            </div>
        </div>

        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>

    @if(config('app.env') == 'local')
        <script src="http://localhost:35729/livereload.js"></script>
    @endif
</body>
</html>
