<?php

namespace App\View\Components\Coa;

use Illuminate\View\Component;

class TableCoa extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        public $dataAkun
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
        return view('components.coa.table-coa');
    }
}
