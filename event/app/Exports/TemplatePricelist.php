<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TemplatePricelist implements FromCollection, WithHeadings
{
  public function collection()
  {
    return collect([
      [
        "kode" => "DR21",
        "cabang" => "MKS",
        "tahun" => "2024",
        "tebus" => 190850000,
        "deposit" => 1000000,
        "expedisi" => 3852600,
        "karoseri" => 0,
        "aksesoris" => 0,
        "pemeliharaan_pdi" => 119000,
        "insentif" => 1000000,
        "bbn" => 23100000,
        "tambahan_harga" => 600000
      ],
    ]);
  }

  public function headings(): array
  {
    return [
      'Kode Tipe', 'Cabang', 'Tahun', 'Tebus', 'Deposit', 'Expedisi', 'Karoseri',
      'Aksesoris', 'Pemeliharaan PDI', 'Insentif', 'BBN', 'Tambahan Harga',
    ];
  }
}
