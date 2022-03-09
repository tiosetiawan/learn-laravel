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
        $data = $request->session()->has('token');
        if($data){
            $token = $request->session()->get('token');
        }else{
            $token = 'Tidak ada token dalam session.';
        }
        $posts = DB::table('informations')
        ->select(
            'inf_judul',
            'inf_deskripsi',
            'inf_gambar',
            'inf_tanggal',
            'inf_jenis',
            'inf_kategori',
            'inf_perusahaan',
            'inf_header_aktif',
            'inf_status'
            )
        ->whereIn('inf_perusahaan', [0,7])
        ->limit(10)
        ->get();

        return response([
            'UserName'          => $request->get('UserName'),
            'MessageType'       => "success",
            'TokenUrl'          =>  $accessToken,
            'TokenJwt'          =>  $token,
            'MessageTitle'      => "GetList success",
            'Message'           => "OK",
            'AlertMessage'      => true,
            'Secure'            => false,
            'Data'              => $posts
        ], 200);
    }

}