<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class OauthController extends Controller
{
    public function redirectGithub(Request $request)
    {
        return Socialite::driver('github')->redirect();
    }

    public function callback(Request $request)
    {
        $response = Socialite::driver('github')->user();

        $user = User::firstOrCreate([
            'email' => $response->getEmail()
        ], [
            'name' => $response->getName(),
            'password' => 'testroot',
            'role' => User::CUSTOMER
        ]);

        Auth::login($user);
        
        return redirect('/home');
    }
}
