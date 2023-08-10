<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\User;
use Carbon\Carbon;
 
class MovieService {
    
    public function search($request) {
        $data = Http::asJson()->get(config('services.tmdb.endpoint').'search/movie?api_key='.config('services.tmdb.api').'&query='.$request->get('term'));

        $body = $data->getBody();
        $data = json_decode($body);

     
        foreach($data->results as $post)
        {
            $year = date('Y', strtotime($post->release_date));
            
            if (isset($post->poster_path)) {
                $img = '<img src="' . config('services.tmdb.original_image_path') . $post->poster_path . '" width="80" />';
            } else {
                $img = '<img width="80" height="120" />';
            }

            $array[] = array('id' => $post->id, 'img' => $img, 'poster_path' =>  config('services.tmdb.original_image_path') . $post->poster_path, 'label' => $post->title . ' (' . $year . ')');
        }

        return $array;
    }
}
