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

class ValidateController extends Controller
{
    function getValidateData(Request $request){
        //get header param
        $key            = $request->get('ModelCode');
        $Token          = $request->get('Token');
        $data           = $request->get('ParameterData');
        $user           = $data[0]['UserName'];

        //get params
        $data           = $request->session()->has('token');

        //validate ModelCode
        if($key == 'News'){
           return $this->getDataNews($key, $Token, $user);
        }
        elseif($key == 'Regulation'){
            return $this->getDataRegulation($key, $Token, $user);
        }
        elseif($key == 'eLearning'){
            return $this->getDataLearning($key, $Token, $user);
        }
        elseif($key == 'CompanyProfile'){
            return $this->getDataPerusahaan($key, $Token, $user);
        }
        else{
            return response()->json([
                'success' => false,
                'message' => 'ModelCode Tidak Ditemukan'
            ], 401);
        }
    }

    function getDataNews($key, $Token, $user){

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
            'UserName'          => $user,
            'MessageType'       => "success",
            'ModelCode'         => $key,
            'Token'             => $Token,
            'MessageTitle'      => "GetList success",
            'Message'           => "OK",
            'AlertMessage'      => true,
            'Secure'            => false,
            'Data'              => $posts
        ], 200);
    }

    function getDataRegulation($key, $Token, $user){

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
            'UserName'          => $user,
            'MessageType'       => "success",
            'ModelCode'         => $key,
            'Token'             => $Token,
            'MessageTitle'      => "GetRegulation success",
            'Message'           => "OK",
            'AlertMessage'      => true,
            'Secure'            => false,
            'Data'              => $posts
        ], 200);
    }

    function getDataLearning($key, $Token, $user){

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
            'UserName'          => $user,
            'MessageType'       => "success",
            'ModelCode'         => $key,
            'Token'             => $Token,
            'MessageTitle'      => "GetLearning success",
            'Message'           => "OK",
            'AlertMessage'      => true,
            'Secure'            => false,
            'Data'              => $posts
        ], 200);
    }

    function getDataPerusahaan($key, $Token, $user){

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
            'UserName'          => $user,
            'MessageType'       => "success",
            'ModelCode'         => $key,
            'Token'             => $Token,
            'MessageTitle'      => "GetPerusahaan success",
            'Message'           => "OK",
            'AlertMessage'      => true,
            'Secure'            => false,
            'Data'              => $posts
        ], 200);
    }
}
