<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Movie;

class FetchApiData extends Command
{
    const API_KEY = '9f72e720a712b60c0e998e14939b3be9';

    const URL = 'https://api.themoviedb.org';
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:apidata';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch data from an external API';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $numberOfPages = 10;

        for ($pageIndex=1; $pageIndex<=$numberOfPages;$pageIndex++) {
            $response = Http::get(
                sprintf(
                    '%s/3/trending/all/day?page=%d&api_key=%s',
                    self::URL,
                    $pageIndex,
                    self::API_KEY
                )
            );
        
            $movies = $response->object()->results;
    
            if ($response->successful()) {
                foreach ($movies as $movie) {
                    if (property_exists($movie, 'title')) {
                        Movie::create([
                            'id' => $movie->id,
                            'title' => $movie->title
                        ]);
                    }
                }
            } else {
                $this->error('Erreur lors de la récupération des données : ' . $response->status());
            }
        }
    }
}
