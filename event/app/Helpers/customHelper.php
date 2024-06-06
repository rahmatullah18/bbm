<?php
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
