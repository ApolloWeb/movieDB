<?php
  
namespace App\Http\Controllers;
  
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\User;
use App\Services\MovieService;
use Carbon\Carbon;
  
class SearchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function __construct(private MovieService $movieService)
     {
     }

    public function index()
    {
        return view('autocompleteSearch');
    }
    
    
    public function autocomplete(Request $request)
    {
        return ($this->movieService->search($request));
    }
}