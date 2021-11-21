<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class ApiAuthController extends Controller
{
    public function login(Request $request)
    {
        $username = $request->username;
        $password = $request->password;
        $req = Http::post(env('APP_URL') . '/oauth/token', [
            "grant_type" => "password",
            "client_id" => 2,
            "client_secret" => env('CLIENT_SECRET'),
            "username" => $username,
            "password" => $password
        ]);

        // $res = json_decode( $req->body());
        // dd($res);
        // $accessToken = $res->access_token;
        // dd($accessToken);
        // $req = Http::withToken($accessToken)->acceptJson()->get(env('APP_URL') . '/api/user');

        // dd($res->status());
        // $user = $req->body();
        // dd($user);
        // $userObj = new \stdClass;
        // $userObj->id = $user['id'];
        // $userObj->accessToken = $accessToken;
        // dd($userObj);
        return $req->body();

    }

    public function register(Request $request)
    {
        $username = $request->username;
        $password = $request->password;
        $passwordConfirm = $request->passwordConfirm;
        $type = $request->type;

        if(empty($username) || empty($password) || empty($passwordConfirm) || empty($type)){
            abort(400, 'Please fill all the fields');
        }

        if($password !== $passwordConfirm){
            abort(400, 'Password confirm is not matched');
        }

        // dd($username);
        // dd($password);
        // dd($passwordConfirm);
        // dd($type);
        $user = User::where('email', $username)->first();
        // dd($user);
        
        if($user){
            $userIsValid = Auth::once(['email'=>$username,'password' => $password]);
            if(! $userIsValid){

                abort(400, 'This email is already exist');
            }
            
        }else{
            $user = new User;
            $user->name = '';
            $user->email = $username;
            $user->rule = 'user';
            $user->type = $type;
            $user->password = Hash::make($password);
            $user->save();
        }
        
        $req = Http::post(env('APP_URL') . '/oauth/token', [
            "grant_type" => "password",
            "client_id" => 2,
            "client_secret" => "r36gKazDFlNNvPkPQuCWMua8uymGFHJ5S3hb0qVw",
            "username" => $username,
            "password" => $password
        ]);
        
        return $req->body();
    }
}
