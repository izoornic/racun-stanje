<?php

namespace App\Services;

use App\Contracts\StanDataProviderInterface;

class StanDataService
{
    public function __construct(
        private StanDataProviderInterface $provider
    ) {}

    public function getStanData($rkv)
    {
        return $this->provider->getStanData($rkv);
    }

    public function getProfileData($rkv)
    {
        return $this->provider->getProfileData($rkv);
    }
}