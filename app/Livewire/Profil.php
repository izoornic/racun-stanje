<?php

namespace App\Livewire;

use Livewire\Component;
use App\Services\StanDataService;

class Profil extends Component
{
    public $rkv;
    public $stanData;
    public $dataError;

    public $vlasnik;
    public $zgrada; 
    public $garaze = [];

    public function mount(StanDataService $service)
    {
        $this->rkv = request()->query('rkv');

       $this->stanData = $service->getProfileData($this->rkv);
       $this->dataError = count($this->stanData) ? false : true;
       if($this->dataError || isset($this->stanData['error'])){
            abort(408);
           return;
       }

       $this->vlasnik = $this->stanData['vlasnik'];
       $this->zgrada = $this->stanData['zgrada'];
       if(\count($this->stanData['garaze']) > 0){
            $this->garaze = $this->stanData['garaze'];
       }
       
    }
    public function render()
    {
        return view('livewire.profil');
    }
}
