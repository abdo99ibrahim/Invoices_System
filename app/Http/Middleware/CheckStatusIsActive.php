<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class CheckStatusIsActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // // Declared but not used
        // $id = auth()->id();
        // // If agent belongs to a user
        // if (User::where('id', $id)->first()->status == 'مفعل') {
        //     return $next($request);
        // }
        // session()->flash('notActive');

        // return back();


        if(auth()->user()->status == 'غير مفعل'){
            session()->flash('notActive');
            // return route('login');
            return redirect('/login');
        }
        else{

            return $next($request);
        }
    }
}
