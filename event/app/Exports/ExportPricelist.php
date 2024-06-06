<?php

namespace App\Exports;

use Illuminate\Support\Facades\Http;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportPricelist implements FromCollection, WithHeadings
{
  protected $tahun;

  function __construct($tahun)
  {
    $this->tahun = $tahun;
  }
  /**
   * @return \Illuminate\Support\Collection
   */
  public function collection()
  {
    // dd('masuk');
    $token = getToken();
    $url = getBaseUrlApi('/master/pl-unit/list');
    $payload = [
      "kode" => '',
      "merk" => '',
      "tipe" => '',
      "model" => '',
      "cabang" => '',
      "tahun" => $this->tahun ?? "",
      "detail" => 1,
      "limit" => 100,
      "page" => 1,
    ];
    // fetch data report do
    try {
      $response = Http::withHeaders([
        'Accept' => 'application/json',
        'Authorization' => 'Bearer ' . $token,
      ])->post($url, $payload);
      $data = $response->json();
      // dd($data);
    } catch (\Throwable $th) {
      toastr()->error("Data gagal export");
      return redirect()->route('pricelists');
    }
    $collect = collect($data['result']['data']);
    // dd($collect);
    $exportData = $collect->map(function ($item) {
      return [
        'kode' => $item['cKode'],
        'nama' => $item['cnama'],
        'merk' => $item['cmerk'],
        'tipe' => $item['ctipe'],
        'hpp_on' => $item['nhpp_on'] != 0 ? formatRupiahReport($item['nhpp_on']) : 0,
        'hpp_off' => $item['nhpp_off'] != 0 ? formatRupiahReport($item['nhpp_off']) : 0,
        'hrg_on' => $item['nhrg_on'] != 0 ? formatRupiahReport($item['nhrg_on']) : 0,
        'hrg_off' => $item['nhrg_off'] != 0 ? formatRupiahReport($item['nhrg_off']) : 0,
        'tebus' => $item['ntebus'] != 0 ? formatRupiahReport($item['ntebus']) : 0,
        'uang_kembali' => $item['ncash_back'],
        'expedisi' => $item['nexpedisi'] != 0 ? formatRupiahReport($item['nexpedisi']) : 0,
        'asuransi' => $item['nasuransi'] != 0 ? formatRupiahReport($item['nasuransi']) : 0,
        'karoseri' => $item['nkaroseri'] != 0 ? formatRupiahReport($item['nkaroseri']) : 0,
        'naksesoris' => $item['naksesoris'] != 0 ? formatRupiahReport($item['naksesoris']) : 0,
        'bunga_inventory' => $item['nbunga_inventory'] != 0 ? formatRupiahReport($item['nbunga_inventory']) : 0,
        'pemeliharaan_pdi' => $item['npemeliharaan_pdi'] != 0 ? formatRupiahReport($item['npemeliharaan_pdi']) : 0,
        'bbn' => $item['nbbn'] != 0 ? formatRupiahReport($item['nbbn']) : 0,
        'insentif' => $item['ninsentif'] != 0 ? formatRupiahReport($item['ninsentif']) : 0,
        'by_tambahan' => $item['nby_tambahan'] != 0 ? formatRupiahReport($item['nby_tambahan']) : 0,
        'tahun' => $item['ctahun'],
      ];
    });
    return $exportData;
  }

  public function headings(): array
  {
    return ['Kode', 'Cabang', 'Merk', 'Tipe',  'HPP ON', 'HPP OFF', 'HRG OTR', 'HRG OFF', 'Tebus', 'Cashback',  'Expedisi', 'Asuransi', 'Karoseri', 'Aksesoris', 'Bunga Inventory', 'Pemeliharaan PDI', 'BBN', 'Insentif', 'Biaya Tambahan', 'Tahun'];
  }
}
