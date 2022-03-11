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
        $token          = $request->get('Token');
        $username       = $request->get('UserName');
        $data           = $request->get('ParameterData');

        $statik_token   = config('app.token_imipinfo');

        //cek data in database
        $posts = DB::table('tokens')
        ->select('access_token')
        ->where('access_token', $token)
        ->where('access_name', $username)
        ->first();
        
        if($statik_token){
            if ($request->get('Token') != $statik_token) {
                return response()->json(['status' => 'Token is Invalid']);
            }else{
                $request->session()->put('token', $statik_token);
            }
        }else{
            return response()->json(['status' => 'Authorization Token not found']);
        }

        return $next($request);
    }
}
