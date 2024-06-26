<?php

namespace App\Http\Controllers\pricelist;

use App\Exports\ExportPricelist;
use App\Exports\TemplatePricelist;
use App\Http\Controllers\Controller;
use App\Imports\PricelistImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Maatwebsite\Excel\Facades\Excel;

class PricelistController extends Controller
{
  public function index()
  {
    $dataPricelist = [];
    return view('content.pages.pricelist.pages-pricelist', ['dataPricelist' => $dataPricelist]);
  }

  public function templateImport(Request $request)
  {
    return Excel::download(new TemplatePricelist(), 'Import Daftar Harga ' . '.xlsx');
  }

  // import api controller
  public function importPricelist(Request $request)
  {
    $excelFile = $request->file('excel');
    $data = Excel::toCollection(new PricelistImport, $excelFile);
    // return response()->json($data);
    $token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJiYW1zLWJibSIsInN1YiI6eyJ1c2VybmFtZSI6ImlsaGFtLnN1cmlhbnRvIiwic3RhdHVzIjoibG9naW4iLCJrb2RlX3BlZyI6IkstMTktMDAxMTEiLCJkaXZpc2kiOiIxIiwiY25tX2xlbmdrYXAiOiJJTEhBTSBTVVJJQU5UTyIsImNsb2MiOiJQUlQiLCJjamFiIjoiSVQiLCJja29kZV9qYWIiOiI5OSIsImNhYmFuZyI6IktJTUEifSwiaWF0IjoxNzE1NjUwNTg0LCJleHAiOjE3MjA4MzQ1ODR9.A64iJDLnvuaek2yFGuHUw8xvf_kfW2lswHYm8_kSZ30';
    // $token = getToken();

    $url = getBaseUrlApi('/master/price_unit/perhitungan');
    $payload = $data->flatten(1)->map(function ($item) {
      return [
        "kode" => (string)$item['kode_tipe'] ?? '',
        "cabang" => $item['cabang'] ?? '',
        "tahun" =>  (string)$item['tahun'] ?? '',
        "tebus" => $item['tebus'] ?? 0,
        "deposit" => $item['deposit'] ?? 0,
        "expedisi" => $item['expedisi'] ?? 0,
        "karoseri" => $item['karoseri'] ?? 0,
        "pemeliharaan_pdi" => $item['pemeliharaan_pdi'] ?? 0,
        "insentif" => $item['insentif'] ?? 0,
        "by_tambahan" => $item['biaya_tambahan'] ?? 0,
        "bbn" => $item['bbn'] ?? 0
      ];
    });

    // return response()->json($payload);

    // fetch api perhitungan
    try {
      $response = Http::withHeaders([
        'Accept' => 'application/json',
        'Authorization' => 'Bearer ' . $token,
      ])->post($url, $payload);
      $result = $response->json();
      if (!$result['error']) {
        return response()->json($result['result']);
      } else {
        return response()->json($result);
        // throw new \Exception('Terjadi kesalahan dalam pengambilan data. Silahkan coba lagi.');
      }
    } catch (\Throwable $th) {
      toastr()->error('Data gagal');
      return redirect()->route('pricelists');
    }
    // return response()->json($data);
  }

  public function exportPricelist(Request $request)
  {
    return Excel::download(new ExportPricelist($request->tahun), 'Daftar Harga Kendaraan ' . "$request->tahun" . '.xlsx');
  }
}
