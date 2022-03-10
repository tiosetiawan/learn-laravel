<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Blog;
use App\Models\Information;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\DB;


class NewsController extends Controller
{
    function getDataNews(Request $request, $accessToken){

        //get header param
        $key            = $request->header('ModelCode');
        $tokenJwt       = $request->header('Authorization');
        
        //get params
        $data           = $request->session()->has('token');

        // cek token session
        if($data){
            $token      = $request->session()->get('token');
        }else{
            $token      = 'Tidak ada token dalam session.';
        }

        // get data DB
        $posts = DB::table('informations')
        ->select(
            'inf_judul as title',
            'inf_deskripsi as description',
            'inf_gambar as image',
            'inf_tanggal as created_on',
            'inf_jenis as jenis',
            'inf_kategori as kategori',
            'inf_perusahaan as perusahaan',
            'inf_header_aktif as header_aktif',
            'inf_status as status'
            )
        ->whereIn('inf_perusahaan', [0,7])
        ->limit(10)
        ->get();

        // response
        return response([
            'UserName'          => $request->get('UserName'),
            'MessageType'       => "success",
            'ModelCode'         => $key,
            'TokenUrl'          => $accessToken,
            'TokenJwt'          => $tokenJwt,
            'MessageTitle'      => "GetList success",
            'Message'           => "OK",
            'AlertMessage'      => true,
            'Secure'            => false,
            'Data'              => $posts
        ], 200);
    }

    function getDataRegulation(Request $request, $accessToken){

        //get header param
        $key            = $request->header('ModelCode');
        $tokenJwt       = $request->header('Authorization');
        
        //get params
        $data           = $request->session()->has('token');

        // cek token session
        if($data){
            $token      = $request->session()->get('token');
        }else{
            $token      = 'Tidak ada token dalam session.';
        }

        // get data DB
        $posts = DB::table('regulations')
        ->select(
            'title',
            'file',
            'description',
            'perusahaan',
            'status',
            )
        ->whereIn('perusahaan', [0,7])
        ->get();

        // response
        return response([
            'UserName'          => $request->get('UserName'),
            'MessageType'       => "success",
            'ModelCode'         => $key,
            'TokenUrl'          => $accessToken,
            'TokenJwt'          => $tokenJwt,
            'MessageTitle'      => "GetRegulation success",
            'Message'           => "OK",
            'AlertMessage'      => true,
            'Secure'            => false,
            'Data'              => $posts
        ], 200);
    }

}