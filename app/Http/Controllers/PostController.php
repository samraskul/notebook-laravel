<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\PostResource;
use App\Http\Services\PostService;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index(){}

    public function store(){}

    public function show($link){
        // $posts = Post::where('link', $link)->get();
        $posts = PostService::get($link, request());
        return PostResource::collection($posts)->response();
    }

    public function update($link, Request $request){
        $posts = Post::where('link', $link)->delete();
        foreach($request->data as $post){
            // Log::info('$request->data');
            Log::info(Auth::user());
            if(strlen($post['content']) > 0){
                Log::info($post);
                if(Auth::check()){
                    Post::insert([
                        'user_id' => Auth::user()->id,
                        'content' =>  $post['content'],
                        'link' => $post['link'],
                        'order' => $post['order'],
                        'type' => $post['type'],
                        'code_programming_language' => $post['code_programming_language'],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }

            }
            // Log::info($posts);
        }
        $posts = PostService::get($link, request());
        return PostResource::collection($posts)->response();
    }

    public function destroy(){}
}