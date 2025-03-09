<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    public function index()
    {
        if (!Session::has('token')) {
            return redirect()->route('login');
        }

        // Make the API request to get the user details using the token
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . Session::get('token'), // Get token from session
        ])->get('https://dummyjson.com/auth/me');

        $userData = $response->successful() ? $response->json() : null;

        // Fetch the list of products from the API
        $productsResponse = Http::get('https://dummyjson.com/products');
        $productsData = $productsResponse->successful() ? $productsResponse->json()['products'] : [];

        // Pass the user data and products data to the view
        return view('dashboard', compact('userData', 'productsData'));
    }

}
