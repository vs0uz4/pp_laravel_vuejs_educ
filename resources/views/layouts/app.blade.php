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
                $links = [
                    ['link' => route('admin.users.index'),  'title' => '<span class=\'glyphicon glyphicon-user\'></span> Users'],
                    ['link' => route('admin.systeminfo'),   'title' => '<span class=\'glyphicon glyphicon-info-sign\'></span> System Info'],
                ];

                $linksRight = [
                    [
                        '<span class="glyphicon glyphicon-user"></span> ' . Auth::user()->name,
                        [
                            [
                                'link' => route('auth.logout'),
                                'title' => '<span class="glyphicon glyphicon-log-out"></span> Logout',
                                'linkAttributes' => [
                                    'onclick' => "event.preventDefault(); document.getElementById(\"form-logout\").submit();"
                                ],
                            ]

                        ]
                    ]
                ];

                $navbar->withContent(Navigation::links($links))
                       ->withContent(Navigation::links($linksRight)
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

    <script>
        $('#flash-overlay-modal').modal();
    </script>
</body>
</html>
