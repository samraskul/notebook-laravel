<?php

namespace App\Http\Services;

use App\Models\User;
use App\Models\NavbarMenu;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class PostService 
{
    public static function get($link, $request)
    {
        $posts = [];

        $userId = $request->user;
        if($userId){
            $user = User::find($userId);
            if($user){
                if($user->type == "public"){
                    $posts = Post::where('user_id', $user->id)->where('link', $link)->get();
                }else{
                    // this user is private
                }
            }else{
                // this user does not exist
            }
        }else{
            if(Auth::check()){
                $posts = Post::where('user_id', Auth::user()->id)->where('link', $link)->get();
            }else{
                //in order to use website you should signup or login
            }
        }

        return $posts;
    }
}