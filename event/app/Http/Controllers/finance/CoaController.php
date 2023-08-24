<?php

namespace App\Http\Controllers\finance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\LengthAwarePaginator;

class CoaController extends Controller
{
    public function getAllAkun()
    {
        // fetc data from api and paginate it
        $akuns = Http::get('http://v2.bbm-bams.co.id:8989/api-bams-finance/public/api/akun')->json();
        $dataAkun = Collection::make($akuns['data']);
        // $itemsPerPage = 10;
        // $totalItems = $akuns->count();
        // $currentPage = request()->input('page', 1);
        // $currentPageItems = $akuns->slice(($currentPage - 1) * $itemsPerPage, $itemsPerPage);

        // $dataAkun = new LengthAwarePaginator(
        //   $currentPageItems,
        //   $totalItems,
        //   $itemsPerPage,
        //   $currentPage,
        //   ['path' => request()->url(), 'query' => request()->query()]
        // );

        return view('content.pages.finance.pages-coa', compact('dataAkun'));
    }



    public function editCoa($id)
    {
        $akun = Http::get('http://v2.bbm-bams.co.id:8989/api-bams-finance/public/api/akun/'.$id)->json();
        $akun = $akun['data'];
        // dd($akun);

        $dataTipe = [
          'BALANCE SHEET',
          'PROFIT AND LOSE'
        ];

        $dataArusKas = [
          'Aktivitas Operasional',
          'Aktivitas Investasi',
          'Aktivitas Pendanaan',
          'Aktivitas Lainnya'
        ];

      // add $dataTipe and aruskas to $akun
      $akun['type'] = $dataTipe;
      $akun['aruskas'] = $dataArusKas;

        return view('content.pages.finance.pages-coa-edit', compact('akun'));
    }

    public function updateCoa(Request $request, $id)
    {
        $request->validate([
          'cAkun' => 'required',
          'cNama' => 'required',
          'cType' => 'required',
          'cAruskas' => 'required',
        ]);

        $response = Http::put('http://v2.bbm-bams.co.id:8989/api-bams-finance/public/api/akun/'.$id, [
          'cAkun' => $request->input('cAkun'),
          'cNama' => $request->input('cNama'),
          'cType' => $request->input('cType'),
          'cAruskas' => $request->input('cAruskas'),
        ]);

        // jika response status 200
        if ($response->status() == 200) {
          $message = $response['message'];
          return redirect()->route('finance-coa')->with('success', $message);
        } else {
          $message = $response['message'];
          return redirect()->route('finance-coa')->with('error', $message);
        }

        // $message = $response['message'];
        // return redirect()->route('finance-coa')->with('success', $message);


    }
}
