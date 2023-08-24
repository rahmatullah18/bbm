<?php

namespace App\View\Components\ArusKas;

use Illuminate\View\Component;

class TableAktivitasFinancial extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        public $dummyData
    ) {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.arus-kas.table-aktivitas-financial');
    }
}
