<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        //set validation
        $validator = Validator::make($request->all(), [
            'email'     => 'required',
            'password'  => 'required'
        ]);

        //if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //get credentials from request
        $credentials = $request->only('email', 'password');

        //set time
        $myTTL = 10; //minutes
        JWTAuth::factory()->setTTL($myTTL);

        //if auth failed
        if(!$token = JWTAuth::attempt($credentials)) {
          
            return response()->json([
                'success' => false,
                'message' => 'Email atau Password Anda salah'
            ], 401);
        }
      
        $request->session()->put('token', $token);
        //if auth success
        return response()->json([
            'success' => "success",
            'data'    => array(
                'user'    => auth()->user(),  
                'token'   => $token
            ),
        ], 200);
    }
}


//session sintaks
// $request->session()->has('token');
// $request->session()->get('token'); -> ambil data
// $request->session()->put('token','halo'); -> simpan session
// $request->session()->forget('token'); -> hapus data session

// new project add sintak dibawah kedalam kernel.php protected $middleware
// \Illuminate\Session\Middleware\StartSession::class,
// \Illuminate\View\Middleware\ShareErrorsFromSession::class,