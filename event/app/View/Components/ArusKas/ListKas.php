<?php

namespace App\View\Components\ArusKas;

use Illuminate\View\Component;

class ListKas extends Component
{
  /**
   * Create a new component instance.
   *
   * @return void
   */
  public function __construct(public $aruskasBertambah, public $aruskasBerkurang)
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
    return view('components.arus-kas.list-kas');
  }
}
