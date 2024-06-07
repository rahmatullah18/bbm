<?php

use Illuminate\Support\Facades\Http;

function formatRupiah($number)
{
  $rupiah = number_format($number, 0, ',', '.');
  return 'Rp. ' . $rupiah;
}

function getToken()
{
  $token = session()->get('token_api');
  return $token;
}

function getBaseUrlApi($url)
{
  return 'http://bbm-bams.co.id:1122' . $url;
}

function formatRupiahReport($angka)
{
  $formattedNumber = number_format(floor($angka), 0, ',', ',');
  return $formattedNumber;
}

function getLimitData($url, $payload, $redirect = '/pricelist')
{
  $token = getToken();
  try {
    $response = Http::withHeaders([
      'Accept' => 'application/json',
      'Authorization' => 'Bearer ' . $token,
    ])->post($url, $payload);
    $data = $response->json();
    return collect($data['result']['total']);
  } catch (\Throwable $th) {
    toastr()->error("Data gagal export");
    return redirect()->route($redirect);
  }
}
