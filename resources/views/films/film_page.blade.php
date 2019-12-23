@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="row no-gutters">
                <div class="col-md-4">
                    <img src="https://www.kinonews.ru/insimgs/poster/poster13096_1_prev.jpg" class="card-img-top"
                         alt="">
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <h5 class="card-title">{{ $film_info[0]->title }}</h5>
                        <p class="card-text">{{ $film_info[0]->about }}</p>
                        <table class="table">
                            <tbody>
                            <tr>
                                <td>@lang('Дата выхода')</td>
                                <td>{{  $film_info[0]->date  }}</td>
                            </tr>
                            <tr>
                                <td>@lang('Страна')</td>
                                <td>{{ $film_info[0]->country }}</td>
                            </tr>
                            <tr>
                                <td>@lang('Режиссер')</td>
                                <td>{{ $film_info[0]->producer }}</td>
                            </tr>
                            <tr>
                                <td>@lang('Жанр')</td>
                                <td>
                                    @foreach($genders as $key => $gender)
                                        {{ $gender->name }} @if(!$loop->last), @endif
                                    @endforeach
                                </td>
                            </tr>
                            <tr>
                                <td>@lang('Актеры')</td>
                                <td>
                                    @foreach($actors as $key => $actor)
                                        {{ $actor->name }} @if(!$loop->last), @endif
                                    @endforeach
                                </td>
                            </tr>
                            <tr>
                                <td>@lang('Бюджет')</td>
                                <td>{{ $film_info[0]->budget }}$</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection