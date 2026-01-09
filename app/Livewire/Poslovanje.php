<?php

namespace App\Livewire;

use Livewire\Component;
use App\Services\StanDataService;
use Illuminate\Support\Carbon;

class Poslovanje extends Component
{
    public $rkv;

    public $stanData;
    public $dataError = false;
    public $zgrada;
    public $stanje_zgrada;

    public $ulpateDisplay = false;
    public $poslovanje;

     public function mount(StanDataService $service)
    {
       $this->rkv = request()->query('rkv');

       $this->stanData = $service->getPoslovanjeData($this->rkv);
       $this->dataError = count($this->stanData) ? false : true;
       if($this->dataError || isset($this->stanData['error'])){
            abort(408);
           return;
       }
       
       $this->zgrada = $this->stanData['zgrada'];
       $this->stanje_zgrada = [];
       $zgrada_ukupno = 0;
       foreach($this->stanData['stanje_zgrada'] as $stanje){
            if($stanje['fid'] == '1') $stanje['fond'] = 'Tekuće održavanje';
            if($stanje['fid'] == '2') $stanje['fond'] = 'Ivesticiono održavanje';
            $zgrada_ukupno += $stanje['pocetno_stanje'];
            $stanje['stanja_formated'] = number_format($stanje['pocetno_stanje'], '2', ',', ' ');
            $this->stanje_zgrada[] = $stanje;
       }
       $this->stanje_zgrada[] = ['ukupno' => number_format($zgrada_ukupno, '2', ',', ' '),
                                'fond' => 'Ukupno stambena zajednica',
                                'poslednje_knjizenje' => Carbon::parse($this->stanData['poslednje_knjizenje']['datum'])->setTimezone('Europe/Belgrade')->translatedFormat('d. m. Y.')
                            ];
       
        $this->poslovanje = [];
        foreach($this->stanData['poslovanje'] as $transakcija) {
            $transakcija['datum_display'] = Carbon::parse($transakcija['datum'])->setTimezone('Europe/Belgrade')->translatedFormat('d. m. Y.');
            $transakcija['vrsta'] = ($transakcija['uplata'] > 0) ? 'Uplata' : 'Isplata';
            $transakcija['bg'] = ($transakcija['uplata'] > 0) ? 'bg-green-500' : 'bg-red-500';
            $iznos = ($transakcija['uplata'] > 0) ? $transakcija['uplata'] : $transakcija['isplata'];
            $transakcija['iznos_display'] = number_format($iznos, '2', ',', ' ');
            $transakcija['fond'] = ($transakcija['fid'] == '1') ? 'Tekuće održavanje' : 'Ivesticiono održavanje';
            $this->poslovanje[] = $transakcija;
        }
        //dd($this->poslovanje);
    }

    public function showUplate()
    {
        $this->ulpateDisplay = !$this->ulpateDisplay;
    }
    public function render()
    {
        return view('livewire.poslovanje');
    }
}
