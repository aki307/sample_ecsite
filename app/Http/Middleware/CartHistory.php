<?php

namespace App\Http\Middleware;

use Closure;

use App\Item;
use App\User;
use Illuminate\Support\Facades\Session;

class CartHistory
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {   
        $browsing_items = Session::get('browsing',[]);
        $recently_items = [];
        foreach($browsing_items as $browsing_item_number){
            $recently_items[] = \App\Item::find($browsing_item_number);
        }            
        view()->share('recently_items', $recently_items);
            
            
        
        return $next($request);
    }
}
