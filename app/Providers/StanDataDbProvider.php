<?php

namespace App\Providers;
use App\Contracts\StanDataProviderInterface;

class StanDataDbProvider implements StanDataProviderInterface
{
    public function getStanData($rkv):array
    {
        //TODO convert to array as it in in API provider
        return [];
    }

    public function getProfileData($rkv):array
    {
        return [];
    }

    public function getPoslovanjeData($rkv):array
    {
        return [];
    }
}