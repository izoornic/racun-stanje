<?php

namespace App\Livewire\Modals;

use Cloudstudio\Modal\LivewireModal;
use tbQuar\Facades\Quar;
//use Illuminate\View\View;

class QrModal extends LivewireModal
{
    public $data;
    public $qr_data;
    public $qr_txt;
    public $qrCode;

    public $poziv_na_broj_display;

    public function mount($data, $qr_data)
    {
        $qr_poziv_na_broj = "00".$data['mid'].sprintf('%03d', $qr_data['spb']).sprintf('%03d', $qr_data['zid']);
        $this->poziv_na_broj_display = $data['mid'].'-'.sprintf('%03d', $qr_data['spb']).'-'.sprintf('%03d', $qr_data['zid']);
        $tr_for_q = str_replace("-","",$qr_data['tr']);
        $qr_iznos = str_replace(".",",",$data['zaduzeno']);
        $qr_K = "K:PR|";
        $qr_V = "V:01|";
        $qr_C = "C:1|";
        $qr_R = "R:{$tr_for_q}|";
        $qr_N = "N:SZ ".$qr_data['naziv']."|";
        $qr_I = "I:RSD{$qr_iznos}|";
        $qr_P = "P:".$qr_data['vl_adresa_qr']."|";
        $qr_SF = "SF:189|";
        $qr_S = "S:Račun za ".$data['m_naziv'].' '.$data['year']."|";
        $qr_RO = "RO:{$qr_poziv_na_broj}";
        
        $qr_txt = $this->cleanSpecialChars($qr_K.$qr_V.$qr_C.$qr_R.$qr_N.$qr_I.$qr_P.$qr_SF.$qr_S.$qr_RO);

        //$qr_txt = mb_convert_encoding($qr_txt, "ISO-8859-15", "UTF-8");
        $qrCode = Quar::format('svg')->size(300)->generate($qr_txt);
	    
        //$qrCode = QrCode::size(250)->generate($qr_txt);
        $qr_str = strval($qrCode);
        $qr_clear = str_replace('<?xml version="1.0" encoding="UTF-8"?>', '', $qr_str);
         $this->qrCode = preg_replace('/\s+/', ' ', $qr_clear);
        //dd($this->qrCode);
        //dd($this->data['mid']);
    }

    private function cleanSpecialChars($string) {
        $tr2lt = [ "Š" => "S", "š" => "s", "Đ" => "Dj", "đ" => "dj", "Č" => "C", "č" => "c", "Ć" => "C", "ć" => "c", "Ž" => "Z", "ž" => "z" ];
        return strtr($string, $tr2lt);
    }

    public static function destroyOnClose(): bool
    {
        return true;
    }

    /* public static function modalFlyout(): bool
    {
        return true;
    } */

   /*  public static function modalFlyoutPosition(): string
    {
        return 'top';
    } */
    public function render()
    {
        return view('livewire.modals.qr-modal');
    }
}
