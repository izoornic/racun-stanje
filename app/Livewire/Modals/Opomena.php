<?php

namespace App\Livewire\Modals;

use Cloudstudio\Modal\LivewireModal;

class Opomena extends LivewireModal
{
    public $data;

    public function mount($data)
    {
        $this->data = $data;
    }
    public function render()
    {
        return view('livewire.modals.opomena');
    }
}
