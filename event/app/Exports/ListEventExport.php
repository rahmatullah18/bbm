<?php

namespace App\Exports;

use Illuminate\Support\Facades\Http;
//use Maatwebsite\Excel\Concerns\WithHeadings;
//use Maatwebsite\Excel\Concerns\FromCollection;
//use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

//class ListEventExport implements FromCollection, WithHeadings, WithColumnWidths, FromView
class ListEventExport implements FromView
{
  /**
   * @return \Illuminate\Support\Collection
   */

  private $list_event;

  public function __construct(array $list_event_)
  {
    $this->list_event = $list_event_;
  }

  public function view(): View
  {
    //@dd($this->list_event);

    return view('content.print.export-list-event', [
      'list_event' => $this->list_event
    ]);
  }
}
