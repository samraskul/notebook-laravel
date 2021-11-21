<?php

namespace App\Http\Services;

use App\Models\User;
use App\Models\NavbarMenu;
use Illuminate\Support\Facades\Auth;

class NavbarService 
{
    public static function get($request)
    {
        $navbars=[];

        $userId = $request->user;
        if($userId){
            $user = User::find($userId);
            if($user){
                if($user->type == "public"){
                    $navbars = NavbarMenu::where('user_id', $user->id)->orderBy('order')->get();
                }else{
                    // this user is private
                }
            }else{
                // this user does not exist
            }
        }else{
            if(Auth::check()){
                $navbars = NavbarMenu::where('user_id', Auth::user()->id)->orderBy('order')->get();
            }else{
                //in order to use website you should signup or login
            }
        }

        return $navbars;
    }
}