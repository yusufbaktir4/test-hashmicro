<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Chart extends Component
{
    public $chartData = [];
    public $width = 400;
    public $height = 400;

    public function mount($data)
    {
        $this->chartData = $data;
    }

    public function render()
    {
        return view('livewire.chart');
    }
}
