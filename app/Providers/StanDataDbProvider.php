<?php

namespace App\Providers;
use App\Contracts\StanDataProviderInterface;

class StanDataDbProvider implements StanDataProviderInterface
{
    public function getStanData($rkv):array
    {
        return [];
    }
}