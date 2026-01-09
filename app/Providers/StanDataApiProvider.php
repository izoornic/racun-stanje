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
                $this->logToDatabase('Unable to connect to the API or receive invalid response.');
                return [];
            }
        }catch(ConnectionException $e) {
            // Handle the connection exception
            $this->logToDatabase($e->getMessage());
            return ['error' => 'Unable to connect to the API. Please try again later.'];
        }
    }

    public function getProfileData($rkv):array
    {
        try {
            $response = Http::post(config( 'services.stan_api.url').'profile.php', ['stan_key' => $rkv]);
            if ($response && $response->successful()) {
                return $response->json() ?? [];
            } else {
                $this->logToDatabase('Unable to connect to the API or receive invalid response.');
                return [];
            }
        }catch(ConnectionException $e) {
            // Handle the connection exception
            $this->logToDatabase($e->getMessage());
            return ['error' => 'Unable to connect to the API. Please try again later.'];
        }
    }

    public function getPoslovanjeData($rkv):array
    {
        try {
            $response = Http::post(config( 'services.stan_api.url').'poslovanje.php', ['stan_key' => $rkv]);
            if ($response && $response->successful()) {
                return $response->json() ?? [];
            } else {
                $this->logToDatabase('Unable to connect to the API or receive invalid response.');
                return [];
            }
        }catch(ConnectionException $e) {
            // Handle the connection exception
            $this->logToDatabase($e->getMessage());
            return ['error' => 'Unable to connect to the API. Please try again later.'];
        }
    }

    private function logToDatabase($message) {
        //TODO
    }
}   

