<?php

namespace App\Http\Controllers;

use App\Http\Resources\MovieCrudResource;
use App\Models\Movie;
use App\Http\Requests\StoreMovieRequest;
use App\Http\Requests\UpdateMovieRequest;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    const API_KEY = '9f72e720a712b60c0e998e14939b3be9';

    const URL = 'https://api.themoviedb.org';

    public function index()
    {
        $query = Movie::query();

        if (request("title")) {
            $query->where("title", "like", "%" . request("title") . "%");
        }
        
        $movies = $query
            ->paginate(10)
            ->onEachSide(1);
        
        return inertia("Movie/Index", [
            "movies" => MovieCrudResource::collection($movies),
            'queryParams' => request()->query() ?: null,
            'success' => session('success'),
        ]);
    }

    public function store(StoreMovieRequest $request)
    {
        $data = $request->validated();

        Movie::create($data);

        return to_route('movie.index')
            ->with('success', 'Movie was created');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($user, Request $request)
    {
        $response = Http::get(
            sprintf(
                '%s/3/movie/%s?api_key=%s',
                self::URL,
                $user,
                self::API_KEY
            )
        );
        
        return inertia('Movie/Edit', [
            'user' => new MovieCrudResource($response->object()),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMovieRequest $request, Movie $movie)
    {
        $data = $request->validated();

        $movie->update($data);

        return to_route('movie.index')
            ->with('success', "User \"$movie->title\" was updated");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Movie $movie)
    {
        $title = $movie->title;

        return to_route('movie.index')
            ->with('success', "User \"$title\" was deleted");
    }
}
