<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TokenIsValid
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
        $username   = $request->header('UserName');
        $token      = $request->header('token');

        //cek data in database
        $posts = DB::table('tokens')
        ->select('access_token')
        ->where('access_token', $token)
        ->where('access_name', $username)
        ->first();
        
        if($posts){
            if ($request->header('token') != $posts->access_token) {
                return response()->json(['status' => 'Token is Invalid']);
            }else{
                $request->session()->put('token', $posts->access_token);
            }
        }else{
            return response()->json(['status' => 'Authorization Token not found']);
        }

        return $next($request);
    }
}
