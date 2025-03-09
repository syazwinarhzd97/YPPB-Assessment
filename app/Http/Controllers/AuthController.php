<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('index');
    }

    public function login(Request $request)
    {
        // Validate the request
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        // Make a POST request to the Dummy JSON API for authentication
        $response = Http::post('https://dummyjson.com/user/login', [
            'username' => $request->input('username'),
            'password' => $request->input('password'),
        ]);

         // Check if the login request was successful
         if ($response->successful()) {
         // Save the token in the session
         $data = $response->json();
         // Access token from the response 
         if (isset($data['accessToken'])) {
         Session::put('token', $data['accessToken']); // Store token in session
         
        // Redirect to dashboard
        return redirect('/dashboard');
         }  // If token isn't present in the response, return an error
         return back()->withErrors(['login_error' => 'Token not found in response.']);
         } else {
        // If authentication fails, redirect back with an error message
        return redirect()->route('login')->withErrors(['login_error' => 'Invalid credentials. Please try again.']);
         }
    }

    public function logout()
    {
        // Clear all session data
        Session::flush(); 
        return redirect()->route('login');
    }
}
