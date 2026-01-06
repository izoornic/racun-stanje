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

    public $ulpateDisplay = true;

    public $qr_data;

    public $uplate = [];
    public $opomene = [];
    public $aktivna_opomena;

    private $opomena_txt = [
        'Poštovani,',
        'Prema našoj evidenciji Vaš dug iznosi', 
        'dinara.',
        'Kako bi ste izbegli dodatne troškove prinudne naplate, molimo Vas da Vaš dug u ukupnom iznosu izmirite u roku od 15 dana.',
        'Molimo Vas da Vaš dug u ukupnom iznosu izmirite u roku od 15 dana.',
        'Ukoliko Vaša evidencija pokazuje drugačije stanje, molimo Vas da kontaktirate upravnika zgrade kako bi usaglasili evidencije.'
    ];

    const DUG_BG = 'bg-red-500';
    const PREPLATA_BG = 'bg-purple-500';
    const NEMA_DUGOVANJA_BG = 'bg-green-500';

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
       
       $this->dug_labels = $this->setFormatinForSaldo($this->dug_stanje['saldo']);
      
       $this->uplate =[];
       foreach($this->stanData['zaduzenja'] as $uplata){
            $uplata['year'] = Carbon::parse($uplata['datum'])->setTimezone('Europe/Belgrade')->format('Y');
            $uplata['datum'] = Carbon::parse($uplata['datum'])->setTimezone('Europe/Belgrade')->translatedFormat('d.m.y.');
            $uplata['zaduzeno_formated'] = number_format($uplata['zaduzeno'], '2', ',', ' ');
            $uplata['r_date'] = (isset($uplata['r_date'])) ? Carbon::parse($uplata['r_date'])->setTimezone('Europe/Belgrade')->translatedFormat('d.m.y.') : ' - ';
            $uplata['razduzeno_formated'] = number_format($uplata['razduzeno'], '2', ',', ' ');
            $uplata['mesec'] = $uplata['m_naziv'];
            $uplata['saldo_formated'] = number_format($uplata['saldo'], '2', ',', ' ');
            
            $uplata = [
                ...$uplata,
                ...$this->setFormatinForSaldo($uplata['saldo'])
            ];
            array_push($this->uplate, $uplata);
       }
       
       $this->stari_dug = $this->stanData['stari_dug'];
       $this->stari_dug['zaduzeno_formated'] =  number_format($this->stari_dug['zaduzeno'], '2', ',', ' ') ?? 0;
       $this->stari_dug['razduzeno'] =  number_format($this->stari_dug['razduzeno'], '2', ',', ' ') ?? 0;
       $this->stari_dug['saldo_formated'] =  number_format($this->stari_dug['saldo'], '2', ',', ' ') ?? 0;
       $this->stari_dug = [
           ...$this->stari_dug,
           ...$this->setFormatinForSaldo($this->stari_dug['saldo'])
       ];
       
       $this->ukupno_dug = $this->stanData['ukupno'];
       $this->ukupno_dug['zaduzeno'] = number_format($this->ukupno_dug['zaduzeno'], '2', ',', ' ');
       $this->ukupno_dug['razduzeno'] = number_format($this->ukupno_dug['razduzeno'], '2', ',', ' ');
       $this->ukupno_dug['saldo_formated'] = number_format($this->ukupno_dug['saldo'], '2', ',', ' ');

       $this->ukupno_dug = [
           ...$this->ukupno_dug,
           ...$this->setFormatinForSaldo($this->ukupno_dug['saldo'])
       ];

       //OPOMENE
       if(isset($this->stanData['opomene']) && \count($this->stanData['opomene']) > 0){
            $saldo_za_opomenu = abs($this->ukupno_dug['saldo']);
            //Ako nije razduzeno zadnje zaduzenje nije ukljucena u opomenu
            if($this->uplate[0]['razduzeno'] == 0){
                $saldo_za_opomenu = $saldo_za_opomenu - $this->uplate[0]['zaduzeno'];
            }

            $this->opomene = $this->stanData['opomene'];
            foreach($this->opomene as $opomena){
                if($saldo_za_opomenu > $opomena['op_iznos']){
                    $this->aktivna_opomena = $opomena;
                }
            }
            if(isset($this->aktivna_opomena)){
                $this->aktivna_opomena['saldo'] = number_format($saldo_za_opomenu, '2', ',', ' ');
                $this->aktivna_opomena['naslov'] = ($opomena['rbr'] == '1')? 'Opomena za dugovanje': 'Opomena pred utuženje';
                $this->aktivna_opomena['text'] = $this->opomena_txt; 
            }
            //dd($this->aktivna_opomena);
       }
    }

    private function setFormatinForSaldo($saldo){
        if($saldo > 0){
            return [
                'prefix' => '+',
                'bg' => self::PREPLATA_BG,
                'label' => 'preplata'
            ];
        }elseif($saldo == 0){
            return [
                'prefix' => '',
                'bg' => self::NEMA_DUGOVANJA_BG,
                'label' => 'nema dugovanja'
            ];
        }else{
            return [
                'prefix' => '-',
                'bg' => self::DUG_BG,
                'label' => 'dug'
            ];
        }
    }

    public function showOpomena()
    {
        $this->dispatch('openModal', 'modals.opomena', ['data' => $this->aktivna_opomena] );
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
