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
   
  /*public function collection()
  {
    //$aruskas = Http::get('http://v2.bbm-bams.co.id:8989/api-bams-finance/public/api/get-all-details')->json();
    return collect($this->list_event);
  }

  public function headings(): array
  {
    return [
      "cnmr_event",
      "dtgl_pengajuan",
      "ckat",
      "tipe",
      "sta_pengajuan",
      "cabang",
      "cnama_spv",
      "dtgl_kegiatan",
      "lokasi",
      "status"
    ];
  }

  public function columnWidths(): array
  {
    return [
      'A' => 30,
      'B' => 30,
      'C' => 30,
      'D' => 30,
      'E' => 30,
      'F' => 30,
      'G' => 30,
      'H' => 30,
      'I' => 30,
      'J' => 30
    ];
  }*/
}
