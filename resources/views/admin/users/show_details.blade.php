@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <h3>User - {{ $user->name }}</h3>
            {!! Button::normal('User list')
                      ->appendIcon(Icon::thList())
                      ->asLinkTo(route('admin.users.index'))
                      ->addAttributes([
                        'class' => 'hidden-print'
                      ])
            !!}
        </div>
        <div class="row">
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <th scope="row">Enrolment</th>
                        <td>{{ $user->enrolment }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Name</th>
                        <td>{{ $user->name }}</td>
                    </tr>
                    <tr>
                        <th scope="row">E-mail</th>
                        <td>{{ $user->email }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Password</th>
                        <td>{!! Badge::withContents($user->password) !!}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection