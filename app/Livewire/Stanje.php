<?php

namespace App\Livewire;

use Livewire\Component;
use App\Services\StanDataService;
use Illuminate\Support\Carbon;
use Illuminate\Support\Arr;

use SimpleSoftwareIO\QrCode\Facades\QrCode;

class Stanje extends Component
{
    public $rkv;

    public $stanData;
    public $dataError = false;

    public $vlasnik;
    public $zgrada;
    public $stanje_zgrada;
    public $zgrada_visible = false;

    public $dug_stanje;
    public $posledenje_knjizenje;
    public $dug_labels; 
    public $stari_dug;
    public $ukupno_dug;

    public $ulpateDisplay = false;

    public $qr_data;

    public $uplate = [];

    public function mount(StanDataService $service)
    {
       $this->rkv = request()->query('rkv');

       $this->stanData = $service->getStanData($this->rkv);
       $this->dataError = count($this->stanData) ? false : true;
       if($this->dataError || isset($this->stanData['error'])){
            abort(408);
           return;
       }
       
       //dd($this->stanData);
       
       $this->dug_labels = [];
       $this->vlasnik = $this->stanData['vlasnik'];
       $this->zgrada = $this->stanData['zgrada'];
       if(isset($this->stanData['stanje_izvod']) || isset($this->stanData['stanje_poslovanje'])){
            $this->stanje_zgrada = $this->stanData['stanje_izvod'] ?? $this->stanData['stanje_poslovanje'];
            $this->stanje_zgrada['stanja_formated'] = number_format($this->stanje_zgrada['stanja_novo'], '2', ',', ' ');
            $this->stanje_zgrada['datum_display'] = Carbon::parse($this->stanje_zgrada['datum'])->setTimezone('Europe/Belgrade')->translatedFormat('d. m. Y.');
            $this->zgrada_visible = true;
       }
       
        //QR data
        $this->qr_data = [];
        $this->qr_data['spb'] = $this->vlasnik['spb'];
        $this->qr_data['zid'] = $this->zgrada['zid'];
        $this->qr_data['tr'] = $this->zgrada['tr'];
        $this->qr_data['naziv'] = $this->zgrada['naziv'].' '.$this->zgrada['zip'].' '.$this->zgrada['sediste'];
        $this->qr_data['vl_adresa_qr'] = $this->vlasnik['vlasnik']. ' ';
        $this->qr_data['vl_adresa_qr'] .= ($this->vlasnik['adresa'] == '') ? $this->zgrada['adresa'].'-'.$this->vlasnik['stanbr'].' '.$this->zgrada['zip'].' '.$this->zgrada['sediste'] : $this->vlasnik['adresa'].' '.$this->zgrada['zip'].' '.$this->zgrada['sediste'];

       $this->dug_stanje = $this->stanData['ukupno'];
       $this->dug_stanje['saldo_formated'] = number_format($this->dug_stanje['saldo'], '2', ',', ' ');  
       $this->posledenje_knjizenje = Carbon::parse($this->stanData['poslednje_knjizenje']['datum'])->setTimezone('Europe/Belgrade')->translatedFormat('d. m. Y.');
       if($this->dug_stanje['saldo'] > 0){
            $this->dug_labels = ['prefix' =>'+', 'bg' => 'bg-green-500', 'label' => 'preplata'];
       }elseif($this->dug_stanje['saldo'] == 0){
           $this->dug_labels = ['prefix' =>'', 'bg' => 'bg-yellow-500', 'label' => 'nema dugovanja'];
        }else{
            $this->dug_labels = ['prefix' =>'-', 'bg' => 'bg-red-500', 'label' => 'dug'];
       }

       $this->uplate =[];
       foreach($this->stanData['zaduzenja'] as $uplata){
            $uplata['year'] = Carbon::parse($uplata['datum'])->setTimezone('Europe/Belgrade')->format('Y');
            $uplata['datum'] = Carbon::parse($uplata['datum'])->setTimezone('Europe/Belgrade')->translatedFormat('d.m.y.');
            $uplata['zaduzeno_formated'] = number_format($uplata['zaduzeno'], '2', ',', ' ');
            $uplata['r_date'] = Carbon::parse($uplata['r_date'])->setTimezone('Europe/Belgrade')->translatedFormat('d.m.y.');
            $uplata['razduzeno_formated'] = number_format($uplata['razduzeno'], '2', ',', ' ');
            $uplata['mesec'] = $uplata['m_naziv'];

            $uplata['saldo_formated'] = number_format($uplata['saldo'], '2', ',', ' ');

            if($uplata['saldo'] > 0){
                $uplata['saldo_prefix'] = '+';
                $uplata['saldo_bg'] = 'bg-green-500';
            }elseif($uplata['saldo'] == 0){
                $uplata['saldo_prefix'] = '';
                $uplata['saldo_bg'] = 'bg-yellow-500';
            }else{
                $uplata['saldo_prefix'] = '-';
                $uplata['saldo_bg'] = 'bg-red-500';
            }

            array_push($this->uplate, $uplata);
       }
        
       $this->stari_dug = $this->stanData['stari_dug'];
       $this->stari_dug['zaduzeno_formated'] =  number_format($this->stari_dug['zaduzeno'], '2', ',', ' ') ?? 0;
       $this->stari_dug['razduzeno'] =  number_format($this->stari_dug['razduzeno'], '2', ',', ' ') ?? 0;
       $this->stari_dug['saldo_formated'] =  number_format($this->stari_dug['saldo'], '2', ',', ' ') ?? 0;

       if($this->stari_dug['saldo'] > 0){
            $this->stari_dug['saldo_prefix'] = '+';
            $this->stari_dug['saldo_bg'] = 'bg-green-500';
        }elseif($this->stari_dug['saldo'] == 0){
            $this->stari_dug['saldo_prefix'] = '';
            $this->stari_dug['saldo_bg'] = 'bg-yellow-500';
        }else{
            $this->stari_dug['saldo_prefix'] = '-';
            $this->stari_dug['saldo_bg'] = 'bg-red-500';
       }

       $this->ukupno_dug = $this->stanData['ukupno'];
       $this->ukupno_dug['zaduzeno'] = number_format($this->ukupno_dug['zaduzeno'], '2', ',', ' ');
       $this->ukupno_dug['razduzeno'] = number_format($this->ukupno_dug['razduzeno'], '2', ',', ' ');
       $this->ukupno_dug['saldo_formated'] = number_format($this->ukupno_dug['saldo'], '2', ',', ' ');

       if($this->ukupno_dug['saldo'] > 0){
            $this->ukupno_dug['saldo_prefix'] = '+';
            $this->ukupno_dug['saldo_bg'] = 'bg-green-500';
        }elseif($this->ukupno_dug['saldo'] == 0){
            $this->ukupno_dug['saldo_prefix'] = '';
            $this->ukupno_dug['saldo_bg'] = 'bg-yellow-500';
        }else{
            $this->ukupno_dug['saldo_prefix'] = '-';
            $this->ukupno_dug['saldo_bg'] = 'bg-red-500';
       }
    }

     public function showUplate()
    {
        $this->ulpateDisplay = !$this->ulpateDisplay;
    }

    public function showQr($mid)
    {
        /* $qrCode = QrCode::format('svg')->size(250)->generate('Neki tekst za QR kod');
        //$qrCode->toString();
        $qr_str = strval($qrCode);
        $qr_clear = str_replace('<?xml version="1.0" encoding="UTF-8"?>', '', $qr_str);
         $qr_clear = preg_replace('/\s+/', ' ', $qr_clear);
        dd($qr_clear); */

        $data= Arr::first($this->uplate, function ($uplata) use ($mid) {
            return $uplata['mid'] == $mid;
        });
        if(empty($data)){
            return;
        }
        //dd($this->qr_data);
        $this->dispatch('openModal', 'modals.qr-modal', ['data' => $data, 'qr_data' => $this->qr_data] );
    }

    public function render()
    {
        return view('livewire.stanje');
    }
}
