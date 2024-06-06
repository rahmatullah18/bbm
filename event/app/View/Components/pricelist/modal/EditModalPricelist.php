<?php

namespace App\View\Components\pricelist\modal;

use Illuminate\View\Component;

class EditModalPricelist extends Component
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
        return view('components.pricelist.modal.edit-modal-pricelist');
    }
}
