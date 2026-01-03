<?php

namespace App\Contracts;

interface StanDataProviderInterface
{
    public function getStanData($rkv):array;

    public function getProfileData($rkv):array;
}