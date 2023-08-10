<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class TMDBController extends Controller
{
    public function fetch()
    {
        
        $tmdb_id = 21;
        
        $data = Http::asJson()->get(config('services.tmdb.endpoint').'movie/' . $tmdb_id . '/images?api_key='.config('services.tmdb.api'));

        $body = $data->getBody();
        $data = json_decode($body);

        echo '<pre>';
        var_dump($data);
        echo '</pre>';

        echo '<img src="https://image.tmdb.org/t/p/original/' . $data->posters->file_path . ' width="40">';
    }
}
