<?php

namespace App\Exports;

use Illuminate\Support\Facades\Http;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;

class ArusKasExport implements FromCollection, WithHeadings, WithColumnWidths
{
  /**
   * @return \Illuminate\Support\Collection
   */
  public function collection()
  {
    $aruskas = Http::get('http://v2.bbm-bams.co.id:8989/api-bams-finance/public/api/get-all-details')->json();
    return collect($aruskas);
  }

  public function headings(): array
  {
    return [
      "cJournalNum",
      "postdate",
      "cNarasi",
      "cAkun",
      "NamaAkun",
      "cloc",
      "namount",
      "sum_namount",
      "cnmr_bukti",
      "cPos_4",
      "cPos_3",
      "cPos_2",
      "pos_aruskas",
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
      'J' => 30,
      'K' => 30,
      'L' => 30,
      'M' => 30,
    ];
  }
}
