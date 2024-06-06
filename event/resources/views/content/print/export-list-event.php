<?php
	$no = 0;
	$list_event_table = '';
	
	for($x = 0; $x < count($list_event); $x++) {
		$no++;
		$list_event_table .='<tr>
				<td style="border: 1px solid black;" align="center">'.$no.'</td>
				<td style="border: 1px solid black;" align="center">'.$list_event[$x]['cnmr_event'].'</td>
				<td style="border: 1px solid black;" align="center">'.$list_event[$x]['status'].'</td>
				<td style="border: 1px solid black;" align="center">'.$list_event[$x]['sta_pengajuan'].'</td>
				<td style="border: 1px solid black;" align="center">'.$list_event[$x]['dtgl_pengajuan'].'</td>
				<td style="border: 1px solid black;" align="center">'.$list_event[$x]['ckat'].'</td>
				<td style="border: 1px solid black;" align="center">'.$list_event[$x]['tipe'].'</td>
				<td style="border: 1px solid black;" align="center">'.$list_event[$x]['cabang'].'</td>
				<td style="border: 1px solid black;">'.$list_event[$x]['cnama_spv'].'</td>
				<td style="border: 1px solid black;" align="center">'.$list_event[$x]['dtgl_kegiatan'].'</td>
				<td style="border: 1px solid black;">'.str_replace('&', 'DAN', $list_event[$x]['lokasi']).'</td>
				</tr>';	
	}

?>
<table>
	<tr>
		<td style="color:#82b597; font-size:20px;" colspan="3">Laporan List Event</td>
	</tr>
	<tr>
		<td style="" colspan="3">Tanggal Kegiatan : 2024-03-12 - 2024-03-12</td>
	</tr>
	<tr>
		<td style="" colspan="3">No. Event : KDI-EVT-23-00002</td>
	</tr>
</table>

<table>
    <thead>
    <tr>
		<th style="border: 1px solid black; background-color: #82b597;" width="30px" align="center">NO</th>
        <th style="border: 1px solid black; background-color: #82b597;" width="180px" align="center">NO. EVENT</th>
		<th style="border: 1px solid black; background-color: #82b597;" width="150px" align="center">STATUS</th>
		<th style="border: 1px solid black; background-color: #82b597;" width="200px" align="center">DIPROSES OLEH</th>
		<th style="border: 1px solid black; background-color: #82b597;" width="130px" align="center">TGL. PENGAJUAN</th>
		<th style="border: 1px solid black; background-color: #82b597;" width="130px" align="center">KATEGORI</th>
        <th style="border: 1px solid black; background-color: #82b597;" width="150px" align="center">TIPE</th>
		<th style="border: 1px solid black; background-color: #82b597;" width="200px" align="center">CABANG</th>
		<th style="border: 1px solid black; background-color: #82b597;" width="200px" align="center">SUPERVISOR</th>
		<th style="border: 1px solid black; background-color: #82b597;" width="200px" align="center">TGL. KEGIATAN</th>
		<th style="border: 1px solid black; background-color: #82b597;" width="250px" align="center">LOKASI</th>
    </tr>
    </thead>
    <tbody>
		<?=$list_event_table;?>
    </tbody>
</table>



