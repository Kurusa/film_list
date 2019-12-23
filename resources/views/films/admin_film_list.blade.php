@extends('layouts.app')

@section('content')
    <div class="container">
        @if ($message = Session::get('error'))
            <div class="alert alert-danger" role="alert">
                {{ $message }}
            </div>
        @endif

        @if ($message = Session::get('success'))
            <div class="alert alert-success" role="alert">
                {{ $message }}
            </div>
        @endif
        <h1 class="mb-4">@lang('Управление фильмами')</h1>

        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th>@lang('#')</th>
                    <th>@lang('Название')</th>
                    <th></th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($film_list as $film)
                    <tr>
                        <td>{{$film->id}}</td>
                        <td><a href="{{ route('film-page', ['id' => $film->id]) }}"
                               class="card-link">{{$film->title}}</a></td>
                        <td>
                        <td><a href="{{ route('film-edit', ['id' => $film->id]) }}"
                               class="card-link"><i class="fa fa-edit"></i></a>
                        </td>
                        <td><a href="{{ route('film-delete', ['id' => $film->id]) }}"
                               class="card-link"><i class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="pagination-wrapper">
            {{ $film_list->links() }}
        </div>
    </div>
@endsection