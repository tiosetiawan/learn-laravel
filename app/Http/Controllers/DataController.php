<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DataController extends Controller
{
    public function index()
    {
        $apiURL = 'http://127.0.0.1:8000/api/news/';
        $postInput = [
            'CommandName' => 'Hardik',
            'ModelCode' => 'Savani',
            'UserName' => 'example@gmail.com'
        ];
        $headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'Content-Type',
            'Authorization' => 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC8xMjcuMC4wLjE6ODAwMFwvYXBpXC9sb2dpbiIsImlhdCI6MTY0NjYxNTk4NiwiZXhwIjoxNjQ2NjE3Nzg2LCJuYmYiOjE2NDY2MTU5ODYsImp0aSI6InYwSmx3WmpmNmZtcHNHNloiLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjcifQ.hGCoVM-eIuzilkWYX211fduQqEgvV8AbEcgbhd5MX8w'
        ];
        $response = Http::withHeaders($headers)->post($apiURL, $postInput);

        $statusCode = $response->status();

        $responseBody = json_decode($response->getBody(), true);
        dd($responseBody);

    }
}
