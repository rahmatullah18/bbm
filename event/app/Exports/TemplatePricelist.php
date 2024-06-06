<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TemplatePricelist implements FromCollection, WithHeadings
{
  /**
   * @return \Illuminate\Support\Collection
   */
  public function collection()
  {
    return collect([
      [
        "kode_tipe" => "TF01",
        "cabang" => 'MKS',
        "tahun" => "2024",
        "tebus" => 413750000,
        "deposit" => 0,
        "expedisi" => 4155600,
        "karoseri" => 0,
        "pemeliharaan_pdi" => 119000,
        "insentif" => 1400000,
        "by_tambahan" => 0,
        "bbn" => 53900000
      ],
      [
        "kode_tipe" => "TF02",
        "cabang" => 'MKS',
        "tahun" => "2024",
        "tebus" => 513750000,
        "deposit" => 0,
        "expedisi" => 5155600,
        "karoseri" => 0,
        "pemeliharaan_pdi" => 219000,
        "insentif" => 2400000,
        "by_tambahan" => 0,
        "bbn" => 63900000
      ]
    ]);
  }

  public function headings(): array
  {
    return ['Kode Tipe', 'Cabang', 'Tahun', 'Tebus', 'Deposit', 'Expedisi', 'Karoseri', 'Pemeliharaan PDI', 'Insentif', 'Biaya Tambahan', 'BBN'];
  }
}
