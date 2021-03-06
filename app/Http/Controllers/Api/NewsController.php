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
        ->limit(10)
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

    function getDataLearning(Request $request, $accessToken){

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
        $posts = DB::table('learnings')
        ->select(
            'lng_judul as judul',
            'lng_video_id as video_id',
            'lng_url as url',
            'lng_date as date',
            'lng_status as status',
            'jns_learning_nama as jenis_learning'
            )
        ->leftJoin('jenis_learning', 'learnings.jns_learning_id', '=', 'jenis_learning.id_jns_learning')
        ->limit(10)
        ->get();

        // response
        return response([
            'UserName'          => $request->get('UserName'),
            'MessageType'       => "success",
            'ModelCode'         => $key,
            'TokenUrl'          => $accessToken,
            'TokenJwt'          => $tokenJwt,
            'MessageTitle'      => "GetLearning success",
            'Message'           => "OK",
            'AlertMessage'      => true,
            'Secure'            => false,
            'Data'              => $posts
        ], 200);
    }

    function getDataPerusahaan(Request $request, $accessToken){

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
        $posts = DB::table('profile_perusahaan')
        ->select(
            'nama_perusahaan',
            'image_perusahaan',
            'contact',
            'about',
            'url'
            )
        ->limit(10)
        ->get();

        // response
        return response([
            'UserName'          => $request->get('UserName'),
            'MessageType'       => "success",
            'ModelCode'         => $key,
            'TokenUrl'          => $accessToken,
            'TokenJwt'          => $tokenJwt,
            'MessageTitle'      => "GetPerusahaan success",
            'Message'           => "OK",
            'AlertMessage'      => true,
            'Secure'            => false,
            'Data'              => $posts
        ], 200);
    }

}