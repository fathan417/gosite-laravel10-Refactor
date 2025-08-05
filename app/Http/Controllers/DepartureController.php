<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Http;

class DepartureController extends Controller{

    public function index(){
        
            // Make HTTP request to JSON API
            $response = Http::get('https://hasanuddin-airport.co.id/data-airline/dep');
            
            // Extract JSON data from response
            $jsonData = $response->json();
            
            // Pass data to Blade view and return view
            return view('departure', ['jsonData' => $jsonData['data']]);

    }

}
