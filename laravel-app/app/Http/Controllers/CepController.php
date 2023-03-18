<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Redis;

class CepController extends Controller
{
    private const URL = "https://viacep.com.br/ws/%s/json/";

    public function get($cep)
    {
        $cached = Redis::get('cep:'.$cep);

        if ($cached)
            return response()->json(json_decode($cached));

        $response = (new Client())->request('GET', sprintf(self::URL, $cep));

        if ($response->getStatusCode() == 200) {

            $jsonResponse = $response->getBody();
            $result = json_decode($jsonResponse);

            if(isset($result->erro))
                return response()->json(['message' => 'The zip code entered was not found.'], 404);

            Redis::set('cep:'.$cep, $jsonResponse);

            return $result;

        } else {
            return response()->json(['message' => 'The zip code entered was not found.'], 404);
        }
    }
}
