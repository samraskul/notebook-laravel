<?php

namespace App\Http\Controllers;

use App\Models\NavbarMenu;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Services\NavbarService;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\NavbarMenuResource;
use Illuminate\Support\Facades\Log;

class NavbarMenuController extends Controller
{
    public function index()
    {
        $navbars = NavbarService::get(request());

        return NavbarMenuResource::collection($navbars);
    }

    public function store()
    {
        foreach(request()->data as $menu){
            if(! isset($menu['id'])){
                if(! empty($menu['name'])){
                    if(Auth::user()){
                        $m = new NavbarMenu;
                        $m->user_id = Auth::user()->id;
                        $m->name = $menu['name'];
                        $m->parent_id = $menu['parentId'];
                        // $m->icon = $menu['icon'];
                        if(! empty($menu['link'])){
                            $m->icon = 'far fa-edit';
                            $m->link = 'page';
                        }else{
                            $m->icon = 'fas fa-folder-open';
                            $m->link = null;
                        }
                        $m->order = $menu['order'];
                        $m->save();
                    }else{
                        abort(400, 'You have to login first');
                    }
                }

            }
        }
    
        $navbars = NavbarService::get(request());
        return NavbarMenuResource::collection($navbars);
    }

    public function update($menuId)
    {
        $navbar = NavbarMenu::find($menuId);
        
        if(($navbar->user_id != Auth::user()->id) && (Auth::user()->rule != 'admin')){
            abort(400, 'You don\'t have permission to do that...');
        }

        $r = request()->data;
        
        if($r && count($r) > 0){
            
            $r = $r[0];
            // dd(array_key_exists('name', $r));

            if(array_key_exists('name', $r) && strlen($r['name']) > 0){
                $navbar->name = $r['name'];
            }
    
            if(array_key_exists('parentId', $r)){
                $navbar->parent_id = $r['parentId'];

            }
    
            if(array_key_exists('icon', $r)){
                $navbar->icon = $r['icon'];
            }

            if(! empty($navbar->link)){
                $navbar->icon = 'far fa-edit';
            }else{
                $navbar->icon = 'fas fa-folder-open';
            }
    
            if(array_key_exists('link', $r)){
                $navbar->link = $r['link'];
            }
    
            if(array_key_exists('order', $r) && is_numeric($r['order'])){
                $navbar->order = $r['order'];
            }
    
            $navbar->save();
        }
        // return response()->json(['r'=>$r], 200);
        $navbars = NavbarService::get(request());
        return NavbarMenuResource::collection($navbars);
    }

    public function delete($menuId)
    {
        $navbar = NavbarMenu::find($menuId);

        if(($navbar->user_id != Auth::user()->id) && (Auth::user()->rule != 'admin')){
            abort(400, 'You don\'t have permission to do that...');
        }

        if($navbar){
            $navbar->delete();
        }

        NavbarMenu::where('parent_id', $menuId)->delete();

        // return response()->json([], 200);
        $navbars = NavbarService::get(request());
        Log::info('navbarrrrrrs delete');
        Log::info($navbars);
        
        return NavbarMenuResource::collection($navbars);
    }
}
