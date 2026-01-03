<?php

namespace App\Providers;
use App\Contracts\StanDataProviderInterface;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Config;
class StanDataApiProvider implements StanDataProviderInterface
{
    public function getStanData($rkv):array
    {
        try {
            $response = Http::post(config( 'services.stan_api.url'), ['stan_key' => $rkv]);
            if ($response && $response->successful()) {
                return $response->json() ?? [];
            } else {
                // Handle the error
                return [];
            }
        }catch(ConnectionException $e) {
            // Handle the connection exception
            //TODO log to database
           
            //dd( $e, response());
            return ['error' => 'Unable to connect to the API. Please try again later.'];
        }
    }

    public function getProfileData($rkv):array
    {
        try {
            $response = Http::post(config( 'services.stan_api.url').'profile/', ['stan_key' => $rkv]);
            if ($response && $response->successful()) {
                return $response->json() ?? [];
            } else {
                // Handle the error
                return [];
            }
        }catch(ConnectionException $e) {
            // Handle the connection exception
            //TODO log to database
           
            //dd( $e, response());
            return ['error' => 'Unable to connect to the API. Please try again later.'];
        }
    }
}   

