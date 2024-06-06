<?php

namespace App\Http\Controllers\authentications;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class LoginBasic extends Controller
{
  public function index(Request $request)
  {
    if (isset($request->login_msg)) {
      $err_massage = $request->login_msg;
    } else {
      $err_massage = '';
    }

    $pageConfigs = ['myLayout' => 'blank'];
    return view('content.authentications.auth-login-basic', ['pageConfigs' => $pageConfigs, 'err_massage' => $err_massage]);
  }

  public function login_proses(Request $request)
  {
    //var_dump($request->input('username'));

    // $url = 'https://bbm-bams.co.id/sparepart_api/v1/login_auth';
    $url = 'http://bbm-bams.co.id/sparepart_api/v1/login_auth';
    // $url = 'https://gkm.latto.co.id/api/v2/auth/token';
    // $url = 'https://gkm-bams.co.id/bbm_reserve/sparepart_api/v1/login_auth';

    $response = Http::post($url, [
      'json' => [
        'username' => $request->input('usernames'),
        'passwords' => $request->input('passwords'),
      ],
      'headers' => [
        'Content-Type' => 'application/json',
      ]
    ]);

    // dd($response['result']);

    if (!$response->successful()) {

      $err_msg = 'Gagal Login akibat koneksi server.';

      redirect()->route('auth-login', ['login_msg' => $err_msg])->send();
    } else {

      if ($response['message'] == 'Success' &&  isset($response['result']['username'])) {

        session([
          'username' => $response['result']['username'],
          'kode_peg' => $response['result']['kode_peg'],
          'divisi' => $response['result']['divisi'],
          'cnm_lengkap' => $response['result']['cnm_lengkap'],
          'cloc' => $response['result']['cloc'],
          'cjab' => $response['result']['cjab'],
          'cabang' => $response['result']['cabang'],
          'token_api' => $response['result']['token']
        ]);

        //$data = session()->all();

        redirect()->route('pages-portal')->send();
      } else {

        $err_msg = $response['message'];

        redirect()->route('auth-login', ['login_msg' => $err_msg])->send();
      }
    }
  }

  public function logout_proses(Request $request)
  {
    session()->pull('username');
    session()->pull('kode_peg');
    session()->pull('divisi');
    session()->pull('cnm_lengkap');
    session()->pull('cloc');
    session()->pull('cjab');

    redirect()->route('pages-home')->send();
  }

  public function log_to_in_proses(Request $request)
  {
    $user = $request->input('userw');
    $cloc = $request->input('cloc');
    $divq = $request->input('divq');
    $cnm_lengkap = $request->input('cnm_lengkap');
    $cjab = $request->input('cjab');
    $ckode_peg = $request->input('ckode_peg');
    $cabang = $request->input('cabang');

    if (isset($user) && $user != "" && isset($cloc) && $cloc != "" && isset($divq) && $divq != "" && isset($cnm_lengkap) && $cnm_lengkap != "" && isset($cjab) && $cjab != "" && isset($ckode_peg) && $ckode_peg != "" && isset($cabang) && $cabang != "") {

      session([
        'username' => $user,
        'kode_peg' => $ckode_peg,
        'divisi' => $divq,
        'cnm_lengkap' => $cnm_lengkap,
        'cloc' => $cloc,
        'cjab' => $cjab,
        'cabang' => $cabang
      ]);

      return "Berhasil Login";
    } else {

      return "Gagal Login";
    }
  }

  public function test_login_proses(Request $request)
  {
    //var_dump($request->input('username'));

    $url = 'https://bbm-bams.co.id/sparepart_api/v1/login_auth';
    // $url = 'https://gkm.latto.co.id/api/v2/auth/token';
    // $url = 'https://gkm-bams.co.id/bbm_reserve/sparepart_api/v1/login_auth';

    $response = Http::post($url, [
      'json' => [
        'username' => 'fakhri.faiz',
        'passwords' => 'faiz',
      ],
      'headers' => [
        'Content-Type' => 'application/json',
      ]
    ]);

    //var_dump($response['result']);

    if (!$response->successful()) {

      echo 'Gagal Login akibat koneksi server.';
    } else {

      var_dump($response['result']['cnm_lengkap']);
    }
  }
}
