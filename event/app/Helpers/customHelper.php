<?php

use Illuminate\Support\Facades\Http;

function formatRupiah($number)
{
  $rupiah = number_format($number, 0, ',', '.');
  return 'Rp. ' . $rupiah;
}

function getToken()
{
  $tokenExample = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJiYW1zLWJibSIsInN1YiI6eyJ1c2VybmFtZSI6ImlsaGFtLnN1cmlhbnRvIiwic3RhdHVzIjoibG9naW4iLCJrb2RlX3BlZyI6IkstMTktMDAxMTEiLCJkaXZpc2kiOiIxIiwiY25tX2xlbmdrYXAiOiJJTEhBTSBTVVJJQU5UTyIsImNsb2MiOiJNS1MiLCJjamFiIjoiSVQiLCJja29kZV9qYWIiOiI5OSIsImNhYmFuZyI6Ik1BS0FTU0FSIFVSSVAifSwiaWF0IjoxNzIyOTIyNDUxLCJleHAiOjE3MjgxMDY0NTF9.hspHxZlt3_gO2UfRHwuJPLOum39fUT3r4BEUUyJQF_Y";
  $token = session()->get('token_api');
  return $tokenExample;
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
