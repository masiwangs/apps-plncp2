<?php

namespace App\View\Components\Modal;

use Illuminate\View\Component;

class HapusKartuPdp extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $url;
    public $cj70;
    public function __construct($url,$cj70)
    {
        $this->url = $url;
        $this->cj70 = $cj70;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.modal.hapus-kartu-pdp');
    }
}
