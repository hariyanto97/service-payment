<?php

use Illuminate\Support\Facades\Http;

function getFood($foodId) {
    $url = env('SERVICE_FOOD_URL').'api/foods/'.$foodId;

    try {
        $response = Http::timeout(10)->get($url);
        $data = $response->json();
        $data['http_code'] = $response->getStatusCode();
        return $data['data'];
    } catch (\Throwable $th) {
       return [
        'status' => 'error',
        'http_code' => 500,
        'message' => $url
       ];
    }
}

function getUser($userId) {
    $url = env('SERVICE_USER_URL').'users/'.$userId;

    try {
        $response = Http::timeout(10)->get($url);
        $data = $response->json();
        $data['http_code'] = $response->getStatusCode();
        return $data['data'];
    } catch (\Throwable $th) {
       return [
        'status' => 'error',
        'http_code' => 500,
        'message' => $url
       ];
    }
}