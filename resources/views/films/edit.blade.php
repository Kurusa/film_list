@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="mb-2">
            <a href="{{ route('admin-film-list') }}">@lang('&larr; к списку')</a>
        </div>

        @if ($message = Session::get('success'))
            <div class="alert alert-success" role="alert">
                {{ $message }}
            </div>
        @endif

        <form action="{{ route('film-edit-save', ['id' => $film_info[0]->id]) }}" method="post">
            @csrf

            <div class="form-group">
                <label for="title">@lang('Название')</label>
                <input id="title" name="title" value="{{$film_info[0]->title}}" required>
            </div>

            <div class="form-group">
                <label for="about">@lang('Описание')</label>
                <textarea id="about" name="about" required>
                    {{$film_info[0]->about}}
                </textarea>
            </div>

            <div class="form-group">
                <label for="release-date">@lang('Дата выхода')</label>
                <input id="release-date" type="date" name="release-date" value="{{$film_info[0]->date}}" required>
            </div>

            <div class="form-group">
                <label for="country">@lang('Страна')</label>
                <select class="select2-js" name="country" required>
                    @foreach($country_list as $country)
                        <option value="{{$country->id}}" {{ $country->id == $film_info[0]->country_id ? "selected" : "" }}>{{$country->name}}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="producer">@lang('Режиссер')</label>
                <select class="select2-js" name="producer" required>
                    @foreach($producer_list as $producer)
                        <option value="{{$producer->id}}" {{ $producer->id == $film_info[0]->producer_id ? "selected" : "" }}>{{$producer->name}}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="gender">@lang('Жанр')</label>
                <select class="select2-js" name="genders[]" multiple="multiple" required>
                    @foreach($gender_list as $gender)
                        @foreach($genders as $film_gender)
                            {{ $selected = $gender->id == $film_gender->gender_id ? "selected" : "" }}
                        @endforeach
                        <option value="{{$gender->id}}" {{ $selected }}>{{$gender->name}}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="actors">@lang('Актеры')</label>
                <select class="select2-js" name="actors[]" multiple="multiple" required>
                    @foreach($actors_list as $actor)
                        @foreach($actors as $film_actor)
                            {{ $selected = $actor->id == $film_actor->actor_id ? "selected" : "" }}
                        @endforeach
                        <option value="{{$actor->id}}" {{ $selected }}>{{$actor->name}}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="budget">@lang('Бюджет')</label>
                <input id="budget" type="number" name="budget" value="{{$film_info[0]->budget}}" min="1" required>
            </div>

            <button type="submit" class="btn btn-primary">Сохранить изменения</button>
        </form>
    </div>


    <script>
        $(document).ready(function () {
            $('.select2-js').select2();
        });
    </script>
@endsection
