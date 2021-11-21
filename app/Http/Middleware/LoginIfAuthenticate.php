<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class LoginIfAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // dd('hi');
        if(request()->bearerToken() && (strlen(request()->bearerToken() > 100))){
            $res = Http::withHeaders(['Authorization' => 'Bearer ' . request()->bearerToken()])->get(env('APP_URL') . '/api/user');
            $userArray = $res->json();
            if( (!empty($userArray)) && (array_key_exists('id', $userArray))){
                $user = User::find($userArray['id']);
                if($user){
                    Auth::login($user);
                }
            }
        }
        
        return $next($request);
    }
}
