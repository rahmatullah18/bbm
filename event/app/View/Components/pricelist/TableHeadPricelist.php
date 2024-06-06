<?php

namespace App\View\Components\pricelist;

use Illuminate\View\Component;

class TableHeadPricelist extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.pricelist.table-head-pricelist');
    }
}
