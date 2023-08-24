<?php

namespace App\Http\Controllers\finance;

use App\Exports\ArusKasExport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\LengthAwarePaginator;

class ArusKasController extends Controller
{

  public function index()
  {
    $aktivitasInvestasi = [];
    $aktivitasLainnya = [];
    $aktivitasPendanaan = [];
    $aktivitasOperasional = [];
    $aruskasBertambah = 0;
    $aruskasBerkurang = 0;

    return view(
      'content.pages.finance.pages-arus-kas',
      [
        'aktivitasInvestasi' => $aktivitasInvestasi,
        'aktivitasLainnya' => $aktivitasLainnya,
        'aktivitasPendanaan' => $aktivitasPendanaan,
        'aktivitasOperasional' => $aktivitasOperasional,
        'aruskasBertambah' => $aruskasBertambah,
        'aruskasBerkurang' => $aruskasBerkurang
      ]
    );
  }

  public function filterDataArusKas(Request $request)
  {
    // jangan lupa ganti
    // validasi input
    $request->validate([
      'start_postdate' => 'required',
      'end_postdate' => 'required'
    ]);
    $start_postdate = $request->input('2023-01-01 00:00:00');
    $end_postdate = $request->input('2023-01-01 00:00:00');

    $aruskas = Http::get('http://v2.bbm-bams.co.id:8989/api-bams-finance/public/api/get-arus-kas-example')->json();

    $groupedData = collect($aruskas)->groupBy('activity')->toArray();

    $aktivitasInvestasi = collect($groupedData['Aktivitas Investasi'][0])->toArray();
    $groupAktivitasInvestasi = collect($aktivitasInvestasi['details'])->groupBy('cAkun')->values()->toArray();

    $aktivitasLainnya = collect($groupedData['Aktivitas Lainnya'][0])->toArray();
    $groupAktivitasLainnya = collect($aktivitasLainnya['details'])->groupBy('cAkun')->values()->toArray();

    $aktivitasPendanaan = collect($groupedData['Aktivitas Pendanaan'][0])->toArray();
    $groupAktivitasPendanaan = collect($aktivitasPendanaan['details'])->groupBy('cAkun')->values()->toArray();

    $aktivitasOperasional = collect($groupedData['Aktivitas Operasional'][0])->toArray();
    $groupAktivitasOperasional = collect($aktivitasOperasional['details'])->groupBy('cAkun')->values()->toArray();

    // Mengubah string JSON menjadi array asosiatif

    $aruskasBertambah = $aktivitasOperasional['summary']['ndebet'] + $aktivitasPendanaan['summary']['ndebet'] + $aktivitasLainnya['summary']['ndebet'] + $aktivitasInvestasi['summary']['ndebet'];

    $aruskasBerkurang = $aktivitasOperasional['summary']['ncredit'] + $aktivitasPendanaan['summary']['ncredit'] + $aktivitasLainnya['summary']['ncredit'] + $aktivitasInvestasi['summary']['ncredit'];


    return view('content.pages.finance.pages-arus-kas', [
      'aktivitasInvestasi' => $this->addTotal($groupAktivitasInvestasi),
      'aktivitasLainnya' => $this->addTotal($groupAktivitasLainnya),
      'aktivitasPendanaan' =>  $this->addTotal($groupAktivitasPendanaan),
      'aktivitasOperasional' => $this->addTotal($groupAktivitasOperasional),
      'aruskasBertambah' => $aruskasBertambah,
      'aruskasBerkurang' => $aruskasBerkurang
    ]);
  }

  public function addTotal($groupAktivitasOperasional)
  {

    // Array untuk menyimpan total penjumlahan sum_namount pada setiap cAkun
    $totals = [];
    // Loop melalui setiap array dalam $data
    foreach ($groupAktivitasOperasional as $array) {
      // Loop melalui setiap objek dalam array
      foreach ($array as $item) {
        $cAkun = trim($item['cAkun']); // Menghapus spasi di sekitar cAkun
        $sum_namount = floatval($item['sum_namount']); // Mengubah sum_namount menjadi tipe float

        // Jika cAkun sudah ada dalam $totals, tambahkan sum_namount ke total yang ada
        if (isset($totals[$cAkun])) {
          $totals[$cAkun] += $sum_namount;
        } else {
          // Jika cAkun belum ada dalam $totals, inisialisasi dengan sum_namount
          $totals[$cAkun] = $sum_namount;
        }
      }
    }
    // Menambahkan total penjumlahan ke masing-masing array
    foreach ($groupAktivitasOperasional as &$array) {
      foreach ($array as &$item) {
        $cAkun = trim($item['cAkun']); // Menghapus spasi di sekitar cAkun
        // Jika cAkun ada dalam $totals, tambahkan total penjumlahan ke item array
        if (isset($totals[$cAkun])) {
          $item['total'] = $totals[$cAkun];
        }
      }
    }

    return $groupAktivitasOperasional;
  }

  public function aruskasExport()
  {
    return Excel::download(new ArusKasExport, 'aruskas.xlsx');
  }
}
