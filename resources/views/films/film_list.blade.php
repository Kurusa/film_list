@extends('layouts.app')

@section('content')
    <div class="container">
        @if ($message = Session::get('error'))
            <div class="alert alert-danger" role="alert">
                {{ $message }}
            </div>
        @endif

        <div class="row">
            @foreach($film_list as $film)
                <div class="card col film-card">
                    <img src="https://www.kinonews.ru/insimgs/poster/poster13096_1_prev.jpg" class="card-img-top"
                         alt="">
                    <div class="card-body">
                        <h4 class="card-title">{{ $film->title }}</h4>
                        <p class="card-text">{{ $film->about }}</p>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">@lang('Страна:') {{ $film->country }}</li>
                        <li class="list-group-item">@lang('Дата выхода:') {{ $film->date }} </li>
                    </ul>
                    <div class="card-body">
                        <a href="{{ route('film-page', ['id' => $film->id]) }}" class="card-link">@lang('Подробнее')</a>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="pagination-wrapper">
            {{ $film_list->links() }}
        </div>
    </div>
@endsection