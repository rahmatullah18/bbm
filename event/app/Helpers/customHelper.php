<?php
   function formatRupiah($number)
  {
      $rupiah = number_format($number, 0, ',', '.');
      return 'Rp. ' . $rupiah;
  }
?>
