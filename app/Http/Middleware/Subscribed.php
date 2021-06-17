<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class Subscribed
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
        if($request->user()->trial_ends_at){
            if(strtotime(now()) > strtotime($request->user()->trial_ends_at)){
                Session::flash('unauthorized','Your free trial has been expired. Please select your plan');
                return redirect(route('admin.free-trial-expired'));
            }
        }
        return $next($request);
    }
}
