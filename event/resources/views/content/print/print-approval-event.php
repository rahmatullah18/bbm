<?php
 $row_detail = count($detail_rincian_event);
 
 $no = 0;
 $list_spare = '';
 $total = 0;
 $tipe_kegiatan = '';
 $tipe_display = "";
 //$hide_note_spv = "style='display:none;'";
 $hide_note_kacab = "style='display:none;'";
 $hide_note_marketing = "style='display:none;'";
 $hide_note_noh = "style='display:none;'";
 $hide_note_coo = "style='display:none;'";
 
 $checked_xpander = '';
 $checked_xpander_cross = '';
 $checked_pajero_sport = '';
 $checked_l300 = '';
 $checked_colt_diesel = '';
 $checked_fuso = '';
 $checked_eclipse_cross = '';
 $checked_triton_dc = '';
 $checked_triton_sc = '';
 
 $note_kacab = '';
 $note_marketing = '';
 $note_noh = '';
 $note_coo = '';
 
 $bs_no_event = str_replace("==","",base64_encode($list_event['cnmr_event']));
 
if($list_event['cnote_kacab'] != ""){
	$note_kacab = '<tr>
			<td>KEPALA CABANG</td>
			<td>:</td>
			<td>'.$list_event['cnote_kacab'].'</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>';
}

if($list_event['cnote_marketing'] != ""){
	$note_marketing = '<tr>
			<td>MARKETING</td>
			<td>:</td>
			<td>'.$list_event['cnote_marketing'].'</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>';	
}

if($list_event['cnote_noh'] != ""){
	$note_noh = '<tr>
			<td>NOH</td>
			<td>:</td>
			<td>'.$list_event['cnote_noh'].'</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>';	
}

if($list_event['cnote_coo'] != ""){
	$note_coo = '<!--<tr>
			<td>COO</td>
			<td>:</td>
			<td>'.$list_event['cnote_coo'].'</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>-->';	
}

if($list_event['csta_pengajuan'] == "1"){
	//kacab
	$approve_kacab = '<img src="http://202.157.184.167:8989/bbm/assets/img/locals/APPROVED.png" width="101px" />';
	$approve_marketing = '<br /><br /><br /><br /><br /><br />...........................<br /><br /><br />';
	$approve_noh = '<br /><br /><br /><br /><br /><br />...........................<br /><br /><br />';
	
}else if($list_event['csta_pengajuan'] == "2"){
	//marketing
	$approve_kacab = '<img src="http://202.157.184.167:8989/bbm/assets/img/locals/APPROVED.png" width="101px" />';
	$approve_marketing = '<img src="http://202.157.184.167:8989/bbm/assets/img/locals/APPROVED.png" width="101px" />';
	$approve_noh = '<br /><br /><br /><br /><br /><br />...........................<br /><br /><br />';
	
}else if($list_event['csta_pengajuan'] == "4"){
	//NOH
	$approve_kacab = '<img src="http://202.157.184.167:8989/bbm/assets/img/locals/APPROVED.png" width="101px" />';
	$approve_marketing = '<img src="http://202.157.184.167:8989/bbm/assets/img/locals/APPROVED.png" width="101px" />';
	$approve_noh = '<img src="http://202.157.184.167:8989/bbm/assets/img/locals/APPROVED.png" width="101px" />';
	
}else{
	//belum approve
	$approve_kacab = '<br /><br /><br /><br /><br /><br />...........................<br /><br /><br />';
	$approve_marketing = '<br /><br /><br /><br /><br /><br />...........................<br /><br /><br />';
	$approve_noh = '<br /><br /><br /><br /><br /><br />...........................<br /><br /><br />';
}


if($list_event['ctipe'] == "0"){
	$tipe_kegiatan = 'Pameran';
}else if($list_event['ctipe'] == "1"){
	$tipe_kegiatan = 'Display';	
}else if($list_event['ctipe'] == "2"){
	$tipe_kegiatan = 'Kanvasing';	
}else if($list_event['ctipe'] == "3"){
	$tipe_kegiatan = 'Gathering';	
}else if($list_event['ctipe'] == "4"){
	$tipe_kegiatan = 'Sponsorship';	
}else if($list_event['ctipe'] == "5"){
	$tipe_kegiatan = 'Showroom Event';	
}else if($list_event['ctipe'] == "6"){
	$tipe_kegiatan = 'Office Event';	
}else if($list_event['ctipe'] == "7"){
	$tipe_kegiatan = 'Public Area Event';	
}else if($list_event['ctipe'] == "8"){
	$tipe_kegiatan = 'Test Drive Event';	
}else if($list_event['ctipe'] == "9"){
	$tipe_kegiatan = 'Open Table';	
}else if($list_event['ctipe'] == "10"){
	$tipe_kegiatan = 'Above The Line';	
}

if($list_event['cxpander'] == "1"){

	$checked_xpander = 'checked="checked"';
}

if($list_event['cxpander_cross'] == "1"){

	$checked_xpander_cross = 'checked="checked"';
}
	
if($list_event['cpajero_sport'] == "1"){

	$checked_pajero_sport = 'checked="checked"';
}
	
if($list_event['cl300'] == "1"){

	$checked_l300 = 'checked="checked"';
}

if($list_event['ccolt_diesel'] == "1"){

	$checked_colt_diesel = 'checked="checked"';
}

if($list_event['cfuso'] == "1"){

	$checked_fuso = 'checked="checked"';
}

if($list_event['ceclipse_cross'] == "1"){

	$checked_eclipse_cross = 'checked="checked"';
}

if($list_event['ctriton_dc'] == "1"){

	$checked_triton_dc = 'checked="checked"';
}

if($list_event['ctriton_sc'] == "1"){

	$checked_triton_sc = 'checked="checked"';
}

 foreach($detail_rincian_event as $detail){
	
	$no++;
	
	if($detail['cstatus'] == '0'){
		$qty  = 0;
	}else{
		$qty  = $detail['nqty'];
	}
	
	$harga1 = number_format($detail['nhrg'],2,".",",");
	$harga2 = (((float)$detail['nhrg']) * $qty);
	$harga_ = number_format($harga2,2,".",",");
	
	$total = $total + $harga2;
	
	if($detail['cuom'] == "1"){
			
		$uom = 'PCS';
		
	}else if($detail['cuom'] == "2"){
		
		$uom = 'DRM';
		
	}else{
		
		$uom = 'LTR';
	}
	
	$list_spare .='<tr>
			<td style="border: 1px solid black;" align="center">'.$no.'</td>
			<td style="border: 1px solid black;">'.$detail['cnm_biaya'].'</td>
			<td style="border: 1px solid black;" align="center">'.($qty+0).'</td>
			<td style="border: 1px solid black;" align="center">'.$uom.'</td>
			<td style="border: 1px solid black;" align="right">'.$harga1.'</td>
			<td style="border: 1px solid black;" align="right">'.$harga_.'</td>
			<td style="border: 1px solid black;" align="right">'.$detail['cket_biaya'].'</td>
			</tr>';
 }
 
	function terbilang($i){
		$huruf = array(""," satu"," dua"," tiga"," empat"," lima"," enam"," tujuh"," delapan"," sembilan"," sepuluh"," sebelas");

		if ($i < 12) return "" .$huruf[$i];
		elseif ($i < 20) return terbilang($i - 10) . " belas";
		elseif ($i < 100) return terbilang($i / 10) . " puluh" . terbilang($i % 10);
		elseif ($i < 200) return " seratus" . terbilang($i - 100);
		elseif ($i < 1000) return terbilang($i / 100) . " ratus" . terbilang($i % 100);
		elseif ($i < 2000) return " seribu" . terbilang($i - 1000);
		elseif ($i < 1000000) return terbilang($i / 1000) . " ribu" . terbilang($i % 1000);
		elseif ($i < 1000000000) return terbilang($i / 1000000) . " juta" . terbilang($i % 1000000);
	}

	$terbilang = ucwords(terbilang(($total + 0))); 
	$per_database = $total / $list_event['ntarget_db'];
	$per_prospek = $total / $list_event['ntarget_prspk'];
	$per_spk = $total / ($list_event['nspk_onspot'] + $list_event['nspk_follow_up']);
	
?>
<style type="text/css">
	tr.border_bottom td {
	  border-bottom:0.8pt solid black;
	}
	
	tr.border_top td{
	  border-top:0.8pt solid black;
	}
	
	#item_part{
	  border-collapse: collapse;
	}
	
	#item_part tr td{
		height: 20px; 
	}
	
	#total_part{
	  border-collapse: collapse;
	}
	
	#total_part_left{
	  border-collapse: collapse;
	}
	
	#border_bawah{
	  border-style: solid;
	  border-left-style: dotted;
	}
	
	.rincian tr td{
		height: 20px; 
	}
	
	tableX tr td{
		border: 1px solid;
	}
	
</style>

<div style="height:98%;">
<table width="100%">
	<tr>
		<td width="30%" rowspan="4">
			&nbsp;
		</td>				
		<td rowspan="4" align="center" valign="top">
			<img src="http://202.157.184.167:8989/bbm/assets/img/locals/bos_2.png" width="170px">
			<br/><br />
			<img src="http://202.157.184.167:8989/bbm/assets/img/locals/bosowaf.png" width="250px"><br /><br />
			<b>SURAT PENGAJUAN EVENT<b/>
		</td>
		<td align="right" width="30%" height="30" >
			<barcode code="<?=$bs_no_event;?>" type="QR" size="0.7" error="M" />
		</td>
	</tr>
	<tr>
		<td></td>
	</tr>
	<tr>
		<td></td>
	</tr>
	<tr>
		<td></td>
	</tr>
</table>

<br /> 
<br />
<table width="100%">
<tr>
	<td>
		<table width="100%" align="left" class="rincian">
		  <tr>
			<td width="26%"><b>Rincian :</td>
			<td width="2%">&nbsp;</td>
			<td>&nbsp;</td>
			<td width="15%">&nbsp;</td>
			<td width="28%">&nbsp;</td>
		  </tr>
		  <tr>
			<td>No. Event</td>
			<td>:</td>
			<td><?=$list_event['cnmr_event'];?></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td>Tgl. Pengajuan</td>
			<td>:</td>
			<td><?=$list_event['dtgl_pengajuan'];?></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td>Kategori</td>
			<td>:</td>
			<td><?=$list_event['ckat'];?></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td>Tipe Kegiatan</td>
			<td>:</td>
			<td><?=$tipe_kegiatan;?></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td>Cabang</td>
			<td>:</td>
			<td><?=$list_event['cabang'];?></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td>Nama Supervisor</td>
			<td>:</td>
			<td><?=$list_event['cnama_spv'];?></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td>Tanggal Kegiatan</td>
			<td>:</td>
			<td><?=$list_event['dtgl_start'];?> S/D <?=$list_event['dtgl_finish'];?> </td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td>Lokasi Kegiatan</td>
			<td>:</td>
			<td><?=$list_event['lokasi'];?></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td>Tipe Kendaraan Yang Di Display</td>
			<td>:</td>
			<td colspan="3">
			
				<table width="100%" style="border-collapse: collapse;">
				  <tr>
					<td align="left" width="18%">
						<input name="tipe_xpander" type="checkbox" <?=$checked_xpander;?> />
						<label >
						  Xpander
						</label>
					</td>
					<td align="left" width="20%">
						<input name="tipe_xpander_cross" type="checkbox" <?=$checked_xpander_cross;?> />
						<label >
						  Xpander Cross
						</label>
					</td>
					<td align="left" width="20%">
						<input name="tipe_pajero_sport" type="checkbox" <?=$checked_pajero_sport;?> />
						<label >
						  Pajero Sport
						</label>
					</td>
					<td align="left" width="15%">
						<input name="tipe_l300" type="checkbox" <?=$checked_l300;?> />
						<label >
						  L300
						</label>
					</td>
					<td align="left">
						<input name="eclipse_cross" type="checkbox" <?=$checked_eclipse_cross;?> />
						<label >
						  Eclipse Cross
						</label>
					</td>
				  </tr>
				  <tr>
					<td align="left">
						<input name="tipe_colt_diesel" type="checkbox" <?=$checked_colt_diesel;?> />
						<label >
						  Canter
						</label>
					</td>
					<td align="left">
						<input name="tipe_fuso" type="checkbox" <?=$checked_fuso;?> />
						<label >
						  Fighter X
						</label>
					</td>
					<td align="left">
						<input name="triton_dc" type="checkbox" <?=$checked_triton_dc;?> />
						<label >
						  Triton DC
						</label>
					</td>
					<td align="left">
						<input name="triton_sc" type="checkbox" <?=$checked_triton_sc;?> />
						<label>
						  Triton SC
						</label>
					</td>
					<td align="left">
						&nbsp;
					</td>
				  </tr>
				</table>

			</td>
		  </tr>
		</table>
	</td>
</tr>
</table>
<br />


<table width="100%">
<tr>
	<td>
		<table width="100%" align="left" class="rincian">
		  <tr>
			<td width="26%"><b>Target :</td>
			<td width="2%">&nbsp;</td>
			<td>&nbsp;</td>
			<td width="15%">&nbsp;</td>
			<td width="28%">&nbsp;</td>
		  </tr>
		  <tr>
			<td>Database</td>
			<td>:</td>
			<td><?=$list_event['ntarget_db'];?></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td>Prospek</td>
			<td>:</td>
			<td><?=$list_event['ntarget_prspk'];?></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td>SPK On The Spot</td>
			<td>:</td>
			<td><?=$list_event['nspk_onspot'];?></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td>SPK Follow Up</td>
			<td>:</td>
			<td><?=$list_event['nspk_follow_up'];?></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		</table>
	</td>
</tr>
</table>
<br />

<b>Rincian Biaya :<b/>
<table width="100%" align="left" id="item_part">
  <tr>
	<td style="border: 1px solid black;" width="3%" align="center">NO</td>
	<td style="border: 1px solid black;" align="center">URAIAN</td>
	<td style="border: 1px solid black;" width="7%" align="center">ITEM</td>
	<td style="border: 1px solid black;" width="7%" align="center">SATUAN</td>
	<td style="border: 1px solid black;" width="12%" align="center">NILAI</td>
	<td style="border: 1px solid black;" width="15%" align="center">TOTAL NILAI</td>
	<td style="border: 1px solid black;" width="25%" align="center">KETERANGAN</td>
  </tr>  
  
	<?=$list_spare;?>
	
	<tr>                                                                                                                                                                                                                                                                                                                                     
		<td style="border: 1px solid black;" colspan="5">&nbsp;</td>
		<td style="border: 1px solid black;">&nbsp;</td>
		<td style="border: 1px solid black; border-right: none; border-bottom: hidden;">&nbsp;</td>
	</tr>
	<tr>                                                                                                                                                                                                                                                                                                                                     
		<td style="border: 1px solid black;" colspan="5"><center><b>TOTAL</b></center></td>
		<td style="border: 1px solid black;" align="right"><?=number_format($total,2,".",",");?></td>
		<td style="border: 1px solid black; border-right: none; border-bottom: hidden;">&nbsp;</td>
	</tr>
	<tr>                                                                                                                                                                                                                                                                                                                                     
		<td style="border: 1px solid black;" colspan="5"><center><b>BIAYA PER DATABASE</b></center></td>
		<td style="border: 1px solid black;" align="right"><?=number_format($per_database,2,".",",");?></td>
		<td style="border: 1px solid black; border-right: none; border-bottom: hidden;">&nbsp;</td>
	</tr>
	<tr>                                                                                                                                                                                                                                                                                                                                     
		<td style="border: 1px solid black;" colspan="5"><center><b>BIAYA PER PROSPEK</b></center></td>
		<td style="border: 1px solid black;" align="right"><?=number_format($per_prospek,2,".",",");?></td>
		<td style="border: 1px solid black; border-right: none; border-bottom: hidden;">&nbsp;</td>
	</tr>
	<tr>                                                                                                                                                                                                                                                                                                                                     
		<td style="border: 1px solid black;" colspan="5"><center><b>BIAYA PER SPK</b></center></td>
		<td style="border: 1px solid black;" align="right"><?=number_format($per_spk,2,".",",");?></td>
		<td style="border: 1px solid black; border-right: none; border-bottom: hidden;">&nbsp;</td>
	</tr>
	
</table>
<br/>


<table width="100%">
<tr>
	<td>
		<table width="100%" align="left" class="rincian">
		  <tr>
			<td width="20%"><b>Catatan :</td>
			<td width="2%">&nbsp;</td>
			<td>&nbsp;</td>
			<td width="15%">&nbsp;</td>
			<td width="28%">&nbsp;</td>
		  </tr>
		  <tr>
			<td>SPV</td>
			<td>:</td>
			<td><?=$list_event['cnote_spv'];?></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		  <?=$note_kacab;?>
		  <?=$note_marketing;?>
		  <?=$note_noh;?>
		  <?=$note_coo;?>
		</table>
	</td>
</tr>
</table>
<br/>
<br/><br/><br/>
<br/>
<table width="100%">
	<tr>
		<!--<td width="10%">&nbsp;</td>-->
		<!--<td width="90%">-->
		<td align="center">
			<table width="70%" style="border-collapse: collapse;">
			  <tr>
				<!--<td align="center" width="20%" style="border: 1px solid black;"><br /><br /><b>Di Buat Oleh<br /></b>
					<br /><br /><br /><br /><br /><br />...........................<br /><br /><br />
				</td>-->
				<td align="center" width="33%" style="border: 1px solid black;"><br /><b>Menyetujui<br />Kepala Cabang<br /></b>
					<?=$approve_kacab;?>
				</td>
				<td align="center" width="33%" style="border: 1px solid black;"><br /><b>Menyetujui<br />Marketing<br /></b>
					<?=$approve_marketing;?>
				</td>
				<td align="center" width="33%" style="border: 1px solid black;"><br /><b>Menyetujui<br />NOH<br /></b>
					<?=$approve_noh;?>
				</td>
				<!--<td align="center" width="20%" style="border: 1px solid black;"><br /><b>Menyetujui<br />COO<br /></b>
					<br /><br /><br /><br /><br /><br />...........................<br /><br /><br />
				</td>-->
			  </tr>
			</table>
		</td>
	</tr>
</table>

<br/>
<br/>

</div>
