<?php

namespace App\Livewire;

use Livewire\Component;

class Footer extends Component
{
    public $rkv;
    public $page;
    public function mount()
    {
        $this->rkv = request()->query('rkv');
    }

    public function showStanje()
    {
        return redirect()->route('stanje', ['rkv' => $this->rkv]);
    }

    public function showProfil()
    {
        return redirect()->route('profil', ['rkv' => $this->rkv]);
    }
    public function render()
    {
        return view('livewire.footer');
    }
}
