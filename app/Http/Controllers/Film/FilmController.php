<?php

namespace App\Http\Controllers\Film;

use App\Http\Controllers\Controller;
use App\Models\Actor;
use App\Models\Country;
use App\Models\Film;
use App\Models\FilmActors;
use App\Models\FilmGenders;
use App\Models\Gender;
use App\Models\Producer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class FilmController extends Controller {

    /**
     * @return View
     */
    public function filmListPage()
    {
        $film_list = Film::select('films.id', 'films.title', 'films.release_date', 'films.about', 'films.image', 'films.mime',
            'C.name AS country')
            ->leftJoin('countries as C', 'films.country_id', '=', 'C.id')
            ->paginate(4);

        return view('films.film_list', [
            'film_list' => $film_list
        ]);
    }

    /**
     * @return View
     */
    public function adminFilmListPage()
    {
        $film_list = Film::select('films.id', 'films.title')->paginate(9);

        return view('films.admin_film_list', [
            'film_list' => $film_list
        ]);
    }

    /**
     * @param int $id
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function filmPage($id, Request $request)
    {
        if (Film::find($id)) {
            $film_info = Film::select('films.title', 'films.release_date', 'films.budget', 'films.about', 'films.image', 'films.mime',
                'C.name AS country', 'P.name AS producer')
                ->leftJoin('countries as C', 'films.country_id', '=', 'C.id')
                ->leftJoin('producers as P', 'films.producer_id', '=', 'P.id')
                ->where('films.id', $id)
                ->get();

            // actors
            $film_actors = DB::table('film_actors')
                ->leftJoin('actors as A', 'A.id', '=', 'film_actors.actor_id')
                ->select('A.name')
                ->where('film_actors.film_id', $id)
                ->get();
            // genders
            $film_genders = DB::table('film_genders')
                ->leftJoin('genders as G', 'G.id', '=', 'film_genders.gender_id')
                ->select('G.name')
                ->where('film_genders.film_id', $id)
                ->get();

            return view('films.film_page', [
                'film_info' => $film_info,
                'actors' => $film_actors,
                'genders' => $film_genders,
            ]);
        }

        return redirect()->route('film-list')->with('error', __('Фильм не найден'));
    }

    /**
     * @param int $id
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function edit($id, Request $request)
    {
        if (Film::find($id)) {
            $film_info = Film::select('films.id', 'films.title', 'films.release_date', 'films.budget', 'films.about', 'films.image', 'films.mime',
                'films.country_id', 'films.producer_id')
                ->where('films.id', $id)
                ->get();

            // actors
            $film_actors = DB::table('film_actors')
                ->leftJoin('actors as A', 'A.id', '=', 'film_actors.actor_id')
                ->select('film_actors.actor_id', 'A.name')
                ->where('film_actors.film_id', $id)
                ->get();
            // genders
            $film_genders = DB::table('film_genders')
                ->leftJoin('genders as G', 'G.id', '=', 'film_genders.gender_id')
                ->select('film_genders.gender_id', 'G.name')
                ->where('film_genders.film_id', $id)
                ->get();

            return view('films.edit', [
                'film_info' => $film_info,
                'actors' => $film_actors,
                'genders' => $film_genders,
                'actors_list' => Actor::all(),
                'gender_list' => Gender::all(),
                'country_list' => Country::all(),
                'producer_list' => Producer::all(),
            ]);
        }
        return redirect()->route('admin-film-list')->with('error', __('Фильм не найден'));
    }

    /**
     * @param int $id
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save($id, Request $request)
    {
        $film = Film::find($id);
        if ($film) {
            Validator::make($request->all(), [
                'title' => ['required', 'string', 'max:255'],
                'release-date' => ['required', 'date', 'before:today'],
                'country' => ['required', 'int', 'exists:countries,id'],
                'producer' => ['required', 'int', 'exists:producers,id'],
                'genders.*' => ['required', 'int', 'exists:genders,id'],
                'actors.*' => ['required', 'int', 'exists:actors,id'],
                'budget' => ['required', 'int']
            ]);

            $film->title = $request->input('title');
            $film->release_date = date("Y-m-d H:i:s", strtotime($request->input('release-date')));
            $film->country_id = $request->input('country');
            $film->producer_id = $request->input('producer');
            $film->budget = $request->input('budget');
            $film->save();

            FilmGenders::where('film_id', $id)->delete();
            foreach ($request->input('genders.*') as $key => $gender_id) {
                FilmGenders::create([
                    'film_id' => $id,
                    'gender_id' => $gender_id,
                ]);
            }

            FilmActors::where('film_id', $id)->delete();
            foreach ($request->input('actors.*') as $key => $actor_id) {
                FilmActors::create([
                    'film_id' => $id,
                    'actor_id' => $actor_id,
                ]);
            }

            return redirect()->back()->with('success', __('Фильм оновлен'));
        }

        return redirect()->route('admin-film-list')->with('error', __('Фильм не найден'));
    }

    /**
     * @param int $id
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id, Request $request)
    {
        $film = Film::find($id);
        if ($film) {
            $film->delete();
            return redirect()->back()->with('success', __('Фильм удален'));
        }
        return redirect()->route('admin-film-list')->with('error', __('Фильм не найден'));
    }
}
