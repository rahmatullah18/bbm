@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Managemen Event')

@section('vendor-style')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/bootstrap-select/bootstrap-select.css')}}" />
@endsection

@section('vendor-script')
<script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>
<script src="{{asset('assets/vendor/libs/bootstrap-select/bootstrap-select.js')}}"></script>
@endsection

@section('page-script')
<script src="{{asset('assets/js/form_event_ven.js')}}"></script>
@endsection

<style>
.input-error{
  outline: 1px solid red;
}
</style>

@php
$hide_op = "";
$hide_op1 = "";
$hide_op2 = "style='display:none;'";
$disable = "";
$disable1 = "";
$checked_mmksi = "";
$checked_ktb = "";
$checkeds = "";
$readonlys = "";

if($list_event['cstatus'] == '2'){
	
	$hide_op = "style='display:none;'";
	$hide_op1 = "style='display:none;'";
	$disable = "disabled";
	$disable1 = "disabled";
	$checkeds = "readonly2";
	$readonlys = "readonly";
	
}else if($list_event['cstatus'] == '1'){
	
	$hide_op = "style='display:none;'";
	$disable = "disabled";
	$checkeds = "readonly2";
	$readonlys = "readonly";
	
	if(session('username', '') == $list_event['cusercreate']){
		
		if($list_event['csta_pengajuan'] != '0' && $list_event['csta_pengajuan'] != ''){
			$disable1 = "disabled";
		}else{
			$hide_op2 = "";
		}
		
	}else{
		
		$disable1 = "disabled";
		
	}
	
}

if($list_event['ckat'] == "MMKSI"){
	$checked_mmksi = "checked";
}else if($list_event['ckat'] == "KTB"){
	$checked_ktb = "checked";
}

$no = 0;
$detail_biaya = '';

foreach($detail_rincian_event as $detail_rincian_event_){
	
	$no++;
	
	$stat_row = "";
	$qty = ((float)$detail_rincian_event_['nqty']);
	
	$harga1 = number_format($detail_rincian_event_['nhrg'],2,".",",");
	$harga2 = (((float)$detail_rincian_event_['nhrg']));
	$hargas = ($harga2 * $qty);
	$hargas_ = number_format(($harga2 * $qty),2,".",",");
	
	if($list_event['cstatus'] == '1' || $list_event['cstatus'] == '2'){
		
		if($detail_rincian_event_['cuom'] == "1"){
			
			$uom = '<option value="1" selected>PCS</option>';
			
		}else if($detail_rincian_event_['cuom'] == "2"){
			
			$uom = '<option value="2" selected>DRM</option>';
			
		}else{
			
			$uom = '<option value="3" selected>LTR</option>';
		}
		
	}else{
		
		if($detail_rincian_event_['cuom'] == "1"){
			
			$uom = '<option value="1" selected>PCS</option><option value="2">DRM</option><option value="3">LTR</option>';
			
		}else if($detail_rincian_event_['cuom'] == "2"){
			
			$uom = '<option value="1">PCS</option><option value="2" selected>DRM</option><option value="3">LTR</option>';
			
		}else{
			
			$uom = '<option value="1">PCS</option><option value="2">DRM</option><option value="3" selected>LTR</option>';
		}
		
	}
	
	if($detail_rincian_event_['cstatus'] == '0'){
		$stat_row = "table-danger";
	}
	
	$detail_biaya .='<tr class="list_biaya '.$stat_row.'">                                                                                                                                                                                                                                                                                                                           
					<td><input type="text" class="nomor" name="nomor" value="'.$no.'" hidden><center><font size="2">'.$no.'</font></center></td>
					<td><input type="text" style="" id="nama_biaya_'.$no.'" name="nama_biaya[]" class="form-control form-control-sm '.$readonlys.'" ondragstart="return false;" value="'.$detail_rincian_event_['cnm_biaya'].'" required /></td>
					<td><input type="text" style="" id="qty_'.$no.'" onkeyup="setInputFilterClassCustom(this, event);" onkeydown="setInputFilterClassCustom(this, event);" required ondragstart="return false;" name="qty[]" class="form-control kecil form-control-sm angka '.$readonlys.'" value="'.$qty.'"/></td>
					<td><select name="uom[]" id="uom_'.$no.'" class="form-control kecil form-control-sm" style="">'.$uom.'</select></td>
					<td><input type="text" style="" id="harga_'.$no.'" name="harga[]" class="form-control kecil form-control-sm '.$readonlys.'" ondragstart="return false;" onfocus="hargaFocus(this);" onblur="check_price(this);" onkeyup="setInputFilterClassCustom(this, event);" onkeydown="setInputFilterClassCustom(this, event);" value="'.$harga1.'" required />  <input type="hidden" id="harga1_'.$no.'" name="harga1[]" value="'.$harga2.'" /></td>
					<td><input type="text" style="" id="harga_tot_'.$no.'" name="harga_tot[]" class="form-control form-control-sm '.$readonlys.'" onkeypress="return false;" ondragstart="return false;" value="'.$hargas_.'"/> </td>
					<td><input type="text" style="" id="keterangan_'.$no.'" name="keterangan[]" class="form-control form-control-sm '.$readonlys.'" ondragstart="return false;" value="'.$detail_rincian_event_['cket_biaya'].'"/> <input type="hidden" id="jumlah1_'.$no.'" name="jumlah1[]" value="'.$hargas.'" /><input type="hidden" id="stat_'.$no.'" name="stat[]"  value="'.$detail_rincian_event_['cstatus'].'" /></td>
					</tr>';

}

@endphp



@section('content')
<h4 class="py-3 breadcrumb-wrapper mb-4">
  <span class="">Managemen Event</span>
</h4>

<div class="row">
  <div class="col-md-12">
    <div class="card mb-4">
      <h5 class="card-header">Update Data Event</h5>
      <div class="card-body">
		<form class="browser-default-validation" id="form_input_claim" action="{{url('/proses_update_event')}}" enctype="multipart/form-data" method="POST" autocomplete="off">
		{{ csrf_field() }}
		<div class="col-md-12">
			<div class="row col-md-3">
				<div class="col-md p-4">
					<label class="form-label fw-bold">Status</label>
					<select class="form-select" id="status" name="status" aria-label="Pilih Status Event">
						<option value="0" <?=$hide_op;?> >Pengajuan Baru</option>
						<option value="1" <?=$hide_op1;?> >Sedang Diproses</option>
						<option value="2" <?=$hide_op2;?> >Batal</option>
					</select>
				</div>
			</div>
			<div class="row col-md-6" id="cancelq">
				<div class="col-md p-4">
					<label class="form-label fw-bold">Keterangan</label>
					<textarea class="form-control" id="ket_cancel" name="ket_cancel" rows="2"><?=$list_event['cKetCancel'];?></textarea>
				</div>
			</div>
			<div class="row col-md-8">
				<div class="col-md p-4">
					<label class="form-label fw-bold">No. Event</label>
					<input type="text" class="form-control" id="no_event" name="no_event" placeholder="No Eevnt" aria-describedby="defaultFormControlHelp" value="<?=$list_event['cnmr_event'];?>" readonly />
				</div>
				<div class="col-md p-4">
					<label class="form-label fw-bold">Tgl. Pengajuan</label>
					@php
						if($list_event['cstatus'] == '00'){
							echo '<input class="form-control readonly" type="date" id="tgl_pengajuan" name="tgl_pengajuan" value="'.$list_event['dtgl_pengajuan'].'" />';
						}else{
							echo '<input class="form-control readonly" type="text" id="tgl_pengajuan" name="tgl_pengajuan" value="'.$list_event['dtgl_pengajuan'].'" />';
						}
					
					@endphp
					
				</div>
			</div>
			<div class="row col-md-5">
				<div class="col-md p-4">
					<label class="form-label fw-bold">Kategori</label>
					<div class="form-check mt-3">
						<input name="kategori" class="form-check-input <?=$checkeds;?>" type="radio" value="MMKSI" id="kategori_mmksi" <?=$checked_mmksi;?> />
						<label class="form-check-label" for="kategori_mmksi">
						  MMKSI
						</label>
					</div>
				</div>
				<div class="col-md p-4">
					<label class="form-label fw-bold">&nbsp;</label>
					<div class="form-check mt-3">
						<input name="kategori" class="form-check-input <?=$checkeds;?>" type="radio" value="KTB" id="kategori_ktb" <?=$checked_ktb;?> />
						<label class="form-check-label" for="kategori_ktb">
						  KTB
						</label>
					</div>
				</div>
			</div>
			<div class="row col-md-12">
				<div class="row"></div>
				<div class="row"></div>
				<div class="row col-md-12 p-4" style="padding-bottom:0px !important;">
					<label class="form-label fw-bold">Tipe Kegiatan</label>

					<div class="col-md">
						<div class="form-check mt-3">
							<input name="tipe_kegiatan" class="form-check-input <?=$checkeds;?>" type="radio" value="0" id="tipe_pameran" checked />
							<label class="form-check-label" for="tipe_pameran">
							  Pameran
							</label>
						</div>
					</div>
					<div class="col-md">
						<div class="form-check mt-3">
							<input name="tipe_kegiatan" class="form-check-input <?=$checkeds;?>" type="radio" value="1" id="tipe_display" />
							<label class="form-check-label" for="tipe_display">
							  Display
							</label>
						</div>
					</div>
					<div class="col-md">
						<div class="form-check mt-3">
							<input name="tipe_kegiatan" class="form-check-input <?=$checkeds;?>" type="radio" value="2" id="tipe_canvasing" />
							<label class="form-check-label" for="tipe_canvasing">
							  Kanvasing
							</label>
						</div>
					</div>
					<div class="col-md">
						<div class="form-check mt-3">
							<input name="tipe_kegiatan" class="form-check-input <?=$checkeds;?>" type="radio" value="3" id="tipe_gathering" />
							<label class="form-check-label" for="tipe_gathering">
							  Gathering
							</label>
						</div>
					</div>
					<div class="col-md">
						<div class="form-check mt-3">
							<input name="tipe_kegiatan" class="form-check-input <?=$checkeds;?>" type="radio" value="4" id="tipe_sponsorship" />
							<label class="form-check-label" for="tipe_sponsorship">
							  Sponsorship
							</label>
						</div>
					</div>
				</div>
				
				<div class="row col-md-12" style="padding-left:1.5rem !important;padding-right:1.5rem !important;">
					
					<div class="col-md">
						<div class="form-check mt-3">
							<input name="tipe_kegiatan" class="form-check-input <?=$checkeds;?>" type="radio" value="5" id="tipe_showroom" />
							<label class="form-check-label" for="tipe_showroom">
							  Showroom Event
							</label>
						</div>
					</div>
					<div class="col-md">
						<div class="form-check mt-3">
							<input name="tipe_kegiatan" class="form-check-input <?=$checkeds;?>" type="radio" value="6" id="tipe_office" />
							<label class="form-check-label" for="tipe_office">
							  Office Event
							</label>
						</div>
					</div>
					<div class="col-md">
						<div class="form-check mt-3">
							<input name="tipe_kegiatan" class="form-check-input <?=$checkeds;?>" type="radio" value="7" id="tipe_public_area" />
							<label class="form-check-label" for="tipe_public_area">
							  Public Area Event
							</label>
						</div>
					</div>
					<div class="col-md">
						<div class="form-check mt-3">
							<input name="tipe_kegiatan" class="form-check-input <?=$checkeds;?>" type="radio" value="8" id="tipe_test_drive" />
							<label class="form-check-label" for="tipe_test_drive">
							  Test Drive Event
							</label>
						</div>
					</div>
					<div class="col-md">
						<div class="form-check mt-3">
							<input name="tipe_kegiatan" class="form-check-input <?=$checkeds;?>" type="radio" value="9" id="tipe_open_table" />
							<label class="form-check-label" for="tipe_open_table">
							  Open Table
							</label>
						</div>
					</div>
					
				</div>
				
				<div class="row col-md-12 p-4" style="padding-top:0px !important;">
					<div class="col-md">
						<div class="form-check mt-3">
							<input name="tipe_kegiatan" class="form-check-input <?=$checkeds;?>" type="radio" value="10" id="tipe_above_line" />
							<label class="form-check-label" for="tipe_above_line">
							  Above The Line
							</label>
						</div>
					</div>
				</div>
			</div>
			
			<div class="row col-md-4">
				<div class="col-md p-4">
					<label class="form-label fw-bold">Cabang</label>
					<select class="form-select" id="cabang" name="cabang" aria-label="Pilih Cabang Event" required>
						
						@php
							
							if($list_event['cstatus'] == '0'){
								
								echo '<option selected value="">Pilih Cabang</option>';
								
								foreach ($cabang as $cabangs) {
									echo "<option value='".$cabangs['cloc']."'>".$cabangs['cnama']."</option>";
								}
							
							}else{
								
								foreach($cabang as $cabangs) {

									if($cabangs['cloc'] == $list_event['cloc']){
										echo "<option value='".$cabangs['cloc']."'>".$cabangs['cnama']."</option>";
									}
								}
								
							}
							
						@endphp
						
					</select>
				</div>
			</div>
			<div class="row col-md-4">
				<div class="col-md p-4">
					<label class="form-label fw-bold">Nama Supervisor</label>
					<input type="text" class="form-control" id="nm_spv" name="nm_spv" placeholder="Nama Supervisor" aria-describedby="defaultFormControlHelp" value="<?=$list_event['cnama_spv'];?>" readonly />
					<input type="text" class="ckode_spv" name="ckode_spv" value="<?=$list_event['ckode_spv'];?>" hidden>
				</div>
			</div>
			<div class="row col-md-6">
				<div class="col-md p-4">
					<label class="form-label fw-bold">Tanggal Kegiatan</label>
					<div class="input-group" id="">
						@php
						
							if($list_event['cstatus'] == '0'){
								echo '<input class="form-control readonly" type="date" value="'.$list_event['dtgl_start'].'" id="tgl_mulai" name="tgl_mulai" />
									  <span class="input-group-text">to</span>
									  <input class="form-control readonly" type="date" value="'.$list_event['dtgl_finish'].'" id="tgl_selesai" name="tgl_selesai" />';
							}else{
								
								echo '<input class="form-control readonly" type="text" value="'.$list_event['dtgl_start'].'" id="tgl_mulai" name="tgl_mulai" />
									  <span class="input-group-text">to</span>
									  <input class="form-control readonly" type="text" value="'.$list_event['dtgl_finish'].'" id="tgl_selesai" name="tgl_selesai" />';
							}
						
						@endphp
					</div>
				</div>
			</div>
			<div class="row col-md-4">
				<div class="col-md p-4">
					<label class="form-label fw-bold">Lokasi Kegiatan</label>
					<select class="select2 form-select" id="lokasi" name="lokasi" aria-label="Pilih Lokasi Kegiatan" required >
						@php
							
							if($list_event['cstatus'] == '0'){
								
								echo '<option selected value="">Pilih Lokasi</option>';
								
								foreach ($lokasi as $lokasis) {
									echo "<option value='".$lokasis['ckd_lokasi']."'>".$lokasis['cnm_lokasi']."</option>";
								}
								
							}else{
								
								foreach($lokasi as $lokasis){

									if($lokasis['ckd_lokasi'] == $list_event['ckd_lokasi']){
										echo "<option value='".$lokasis['ckd_lokasi']."'>".$lokasis['cnm_lokasi']."</option>";
									}
								}
								
							}
							
						@endphp
						
					</select>
				</div>
			</div>
			<div class="row col-md-12 tipe_kedaraan_div">
				<div class="row"></div>
				<div class="row"></div>
				<div class="row col-md-12 p-4" style="padding-bottom:0px !important;">
					<label class="form-label fw-bold">Tipe Kendaraan Yang Di Display</label>
					<div class="col-md">
						
						<div class="form-check mt-3">
							<input name="tipe_xforce" class="form-check-input tipe_ken_mmksi <?=$checkeds;?>" type="checkbox" value="1" id="tipe_xforce" <?=($list_event['cxforce'] == '1') ? 'checked' : '';?> />
							<label class="form-check-label" for="tipe_xforce">
							  XForce
							</label>
						</div>
					</div>
					<div class="col-md">
						
						<div class="form-check mt-3">
							<input name="tipe_xpander" class="form-check-input tipe_ken_mmksi <?=$checkeds;?>" type="checkbox" value="1" id="tipe_xpander" <?=($list_event['cxpander'] == '1') ? 'checked' : '';?> />
							<label class="form-check-label" for="tipe_xpander">
							  Xpander
							</label>
						</div>
					</div>
					<div class="col-md">
						
						<div class="form-check mt-3">
							<input name="tipe_xpander_cross" class="form-check-input tipe_ken_mmksi <?=$checkeds;?>" type="checkbox" value="1" id="tipe_xpander_cross" <?=($list_event['cxpander_cross'] == '1') ? 'checked' : '';?> />
							<label class="form-check-label" for="tipe_xpander_cross">
							  Xpander Cross
							</label>
						</div>
					</div>
					<div class="col-md">
						
						<div class="form-check mt-3">
							<input name="tipe_pajero_sport" class="form-check-input tipe_ken_mmksi <?=$checkeds;?>" type="checkbox" value="1" id="tipe_pajero_sport" <?=($list_event['cpajero_sport'] == '1') ? 'checked' : '';?> />
							<label class="form-check-label" for="tipe_pajero_sport">
							  Pajero Sport
							</label>
						</div>
					</div>
					<div class="col-md">
						
						<div class="form-check mt-3">
							<input name="tipe_l300" class="form-check-input tipe_ken_mmksi <?=$checkeds;?>" type="checkbox" value="1" id="tipe_l300" <?=($list_event['cl300'] == '1') ? 'checked' : '';?> />
							<label class="form-check-label" for="tipe_l300">
							  L300
							</label>
						</div>
					</div>
					<div class="col-md">
						
						<div class="form-check mt-3">
							<input name="eclipse_cross" class="form-check-input tipe_ken_mmksi <?=$checkeds;?>" type="checkbox" value="1" id="eclipse_cross" <?=($list_event['ceclipse_cross'] == '1') ? 'checked' : '';?> />
							<label class="form-check-label" for="eclipse_cross">
							  Eclipse Cross
							</label>
						</div>
					</div>
					<div class="col-md">
						
						<div class="form-check mt-3">
							<input name="tipe_colt_diesel" class="form-check-input tipe_ken_ktb <?=$checkeds;?>" type="checkbox" value="1" id="tipe_colt_diesel" <?=($list_event['ccolt_diesel'] == '1') ? 'checked' : '';?> />
							<label class="form-check-label" for="tipe_colt_diesel">
							  Canter
							</label>
						</div>
					</div>
					
				</div>
				<div class="row col-md-12 p-4">
					
					<div class="col-md">
						
						<div class="form-check">
							<input name="tipe_fuso" class="form-check-input tipe_ken_ktb <?=$checkeds;?>" type="checkbox" value="1" id="tipe_fuso" <?=($list_event['cfuso'] == '1') ? 'checked' : '';?> />
							<label class="form-check-label" for="tipe_fuso">
							  Fighter X
							</label>
						</div>
					</div>
					
					<div class="col-md">
						
						<div class="form-check">
							<input name="triton_dc" class="form-check-input tipe_ken_mmksi <?=$checkeds;?>" type="checkbox" value="1" id="triton_dc" <?=($list_event['ctriton_dc'] == '1') ? 'checked' : '';?> />
							<label class="form-check-label" for="triton_dc">
							 Triton DC
							</label>
						</div>
					</div>
					
					<div class="col-md">
						
						<div class="form-check">
							<input name="triton_sc" class="form-check-input tipe_ken_mmksi <?=$checkeds;?>" type="checkbox" value="1" id="triton_sc" <?=($list_event['ctriton_sc'] == '1') ? 'checked' : '';?> />
							<label class="form-check-label" for="triton_sc">
							  Triton SC
							</label>
						</div>
					</div>
					
					<div class="col-md">
						<div class="form-check">
							&nbsp;
						</div>
					</div>
					<div class="col-md">
						<div class="form-check">
							&nbsp;
						</div>
					</div>
					<div class="col-md">
						<div class="form-check">
							&nbsp;
						</div>
					</div>
					
				</div>
			</div>
			<div class="row col-md-6">
				<div class="col-md-12 p-4">
					<div class="col-md-12">
						<label class="form-label fw-bold">Target</label>
						<div class="row">
						  <label for="target_database" class="col-md-4 col-form-label">Database</label>
						  <div class="col-md-5">
							<input class="form-control <?=$readonlys;?>" type="text" value="<?=($list_event['ntarget_db']+0);?>" id="target_database" name="target_database" />
						  </div>
						</div>
					</div>
					<div class="col-md-12">
						<div class="row">
						  <label for="target_prospek" class="col-md-4 col-form-label">Prospek</label>
						  <div class="col-md-5">
							<input class="form-control <?=$readonlys;?>" type="text" value="<?=($list_event['ntarget_prspk']+0);?>" id="target_prospek" name="target_prospek" />
						  </div>
						</div>
					</div>
					<div class="col-md-12">
						<div class="row">
						  <label for="target_spk_ots" class="col-md-4 col-form-label">SPK On The Spot</label>
						  <div class="col-md-5">
							<input class="form-control <?=$readonlys;?>" type="text" value="<?=($list_event['nspk_onspot']+0);?>" id="target_spk_ots" name="target_spk_ots" />
						  </div>
						</div>
					</div>
					<div class="col-md-12">
						<div class="row">
						  <label for="target_spk_fu" class="col-md-4 col-form-label">SPK Follow Up</label>
						  <div class="col-md-5">
							<input class="form-control <?=$readonlys;?>" type="text" value="<?=($list_event['nspk_follow_up']+0);?>" id="target_spk_fu" name="target_spk_fu" />
						  </div>
						</div>
					</div>
				</div>
			</div>
			
			<div class="row col-md-12">
				<div class="col-md-12 p-4">
					<label class="form-label fw-bold">Rincian Biaya</label>
						<div class="row">
							<div class="col-md-6 col-12 mb-md-0 mb-4">
								<div class="btn-group mb-1">
									<button type="button" id="add_list" class="btn btn-success btn-sm" <?=$disable;?>>
										Tambah Baris
									</button>
									<button type="button" id="delete_list" class="btn btn-warning btn-sm" <?=$disable;?>>
										Hapus Baris
									</button>	
								</div>
							</div>
						</div>
					    <div class="table-responsive text-nowrap">
						  <table class="table table-bordered" style="overflow-x: scroll;min-width: 120%;">
							<thead>
							  <tr>
								<th style="width:5px;">No</th>
								<th style="width:200px;">Uraian</th>
								<th style="width:50px;">Item</th>
								<th style="width:50px;">Satuan</th>
								<th style="width:100px;">Nilai</th>
								<th style="width:100px;">Total Nilai</th>
								<th style="width:150px;">Keterangan</th>
							  </tr>
							</thead>
							<tbody class="table-border-bottom-0" id="item_event">    
							  
							  @php
								echo $detail_biaya;
							  @endphp
							  
							</tbody>
							<tfoot>
								<tr>                                                                                                                                                                                                                                                                                                                                     
									<td colspan="5">&nbsp;</td>
									<td>&nbsp;</td>
									<td style="border-right: none; border-bottom: hidden;">&nbsp;</td>
								</tr>
								<tr>                                                                                                                                                                                                                                                                                                                                     
									<td colspan="5"><center><font size="2">TOTAL</font></center></td>
									<td><input type="text" name="total" id="total" style="" class="form-control form-control-sm" ondragstart="return false;" readonly /></td>
									<td style="border-right: none; border-bottom: hidden;">&nbsp;</td>
								</tr>
								<!--<tr>                                                                                                                                                                                                                                                                                                                                     
									<td colspan="4">&nbsp;</td>
									<td>&nbsp;</td>
									<td style="border-right: none; border-bottom: hidden;">&nbsp;</td>
								</tr>-->
								<tr>                                                                                                                                                                                                                                                                                                                                     
									<td colspan="5"><center><font size="2">BIAYA PER DATABASE</font></center></td>
									<td><input type="text" name="per_database" id="per_database" style="" class="form-control form-control-sm" ondragstart="return false;" readonly /></td>
									<td style="border-right: none; border-bottom: hidden;">&nbsp;</td>
								</tr>
								<tr>                                                                                                                                                                                                                                                                                                                                     
									<td colspan="5"><center><font size="2">BIAYA PER PROSPEK</font></center></td>
									<td><input type="text" name="per_prspk" id="per_prspk" style="" class="form-control form-control-sm" ondragstart="return false;" readonly /></td>
									<td style="border-right: none; border-bottom: hidden;">&nbsp;</td>
								</tr>
								<tr>                                                                                                                                                                                                                                                                                                                                     
									<td colspan="5"><center><font size="2">BIAYA PER SPK</font></center></td>
									<td><input type="text" name="per_spk" id="per_spk" value="" style="" class="form-control form-control-sm" ondragstart="return false;" readonly /></td>
									<td style="border-right: none; border-bottom: hidden;">&nbsp;</td>
								</tr>
							</tfoot>
						  </table>
						</div>
				
				</div>
			</div>
			
			<div class="row col-md-8">
				<div class="col-md-12 p-4">
					<div class="col-md-12">
						<label class="form-label fw-bold">Lampiran</label>
						<div class="row">
						  <label for="upload_doc_1" class="col-md-6 col-form-label">1. Area Display</label>
						  <div class="col-md-6">
							<div class="input-group">
								<input class="form-control upload_file_docs <?=$checkeds;?>" type="file" id="upload_doc_1" name="area_display" rowz="1" />
								<a href="<?=url('storage_event')."/".$list_event['cfoto_area_dispaly'];?>" <?=($list_event['cfoto_area_dispaly'] == '') ? 'style="display:none"' : '';?> target="blank"><button class="btn btn-outline-primary" type="button" id="inputGroupFileAddon04">Show</button></a>
							</div>
							<p id="error1_1" style="display:none; color:#FF0000; font-size: 10px;">Invalid File Format! File Format Must Be JPG, JPEG, PNG, & PDF.</p><p id="error2_1" style="display:none; color:#FF0000; font-size: 10px;">Maximum File Size Limit is 1MB.</p>
						  </div>
						</div>
					</div>
					<div class="col-md-12">
						<div class="row">
						  <label for="upload_doc_2" class="col-md-6 col-form-label">2. Area Test Drive</label>
						  <div class="col-md-6">
							<div class="input-group">
								<input class="form-control upload_file_docs <?=$checkeds;?>" type="file" id="upload_doc_2" name="area_display2" rowz="2" />
								<a href="<?=url('storage_event')."/".$list_event['cfoto_area_display2'];?>" <?=($list_event['cfoto_area_display2'] == '') ? 'style="display:none"' : '';?> target="blank"><button class="btn btn-outline-primary" type="button" id="inputGroupFileAddon04">Show</button></a>
							</div>
							<p id="error1_2" style="display:none; color:#FF0000; font-size: 10px;">Invalid File Format! File Format Must Be JPG, JPEG, PNG, & PDF.</p><p id="error2_2" style="display:none; color:#FF0000; font-size: 10px;">Maximum File Size Limit is 1MB.</p>
						  </div>
						</div>
					</div>
					<div class="col-md-12">
						<div class="row">
						  <label for="upload_doc_3" class="col-md-6 col-form-label">3. Lokasi Pameran/Denah/Layout</label>
						  <div class="col-md-6">
							<div class="input-group">
								<input class="form-control upload_file_docs <?=$checkeds;?>" type="file" id="upload_doc_3" name="lokasi_pameran" rowz="3" />
								<a href="<?=url('storage_event')."/".$list_event['cfoto_lokasi_pameran'];?>" <?=($list_event['cfoto_lokasi_pameran'] == '') ? 'style="display:none"' : '';?> target="blank"><button class="btn btn-outline-primary" type="button" id="inputGroupFileAddon04">Show</button></a>
							</div>
							<p id="error1_3" style="display:none; color:#FF0000; font-size: 10px;">Invalid File Format! File Format Must Be JPG, JPEG, PNG, & PDF.</p><p id="error2_3" style="display:none; color:#FF0000; font-size: 10px;">Maximum File Size Limit is 1MB.</p>
						  </div>
						</div>
					</div>
					<div class="col-md-12">
						<div class="row">
						  <label for="upload_doc_5" class="col-md-6 col-form-label">4. Tampak Luar Gedung/Area Pameran</label>
						  <div class="col-md-6">
							<div class="input-group">
								<input class="form-control upload_file_docs <?=$checkeds;?>" type="file" id="upload_doc_5" name="tampak_luar" rowz="5" />
								<a href="<?=url('storage_event')."/".$list_event['cfoto_tampak_luar'];?>" <?=($list_event['cfoto_tampak_luar'] == '') ? 'style="display:none"' : '';?> target="blank"><button class="btn btn-outline-primary" type="button" id="inputGroupFileAddon04">Show</button></a>
							</div>
							<p id="error1_5" style="display:none; color:#FF0000; font-size: 10px;">Invalid File Format! File Format Must Be JPG, JPEG, PNG, & PDF.</p><p id="error2_5" style="display:none; color:#FF0000; font-size: 10px;">Maximum File Size Limit is 1MB.</p>
						  </div>
						</div>
					</div>
					<div class="col-md-12">
						<div class="row">
						  <label for="upload_doc_6" class="col-md-6 col-form-label">5. Screenshot Lokasi Pameran di GMaps</label>
						  <div class="col-md-6">
							<div class="input-group">
								<input class="form-control upload_file_docs <?=$checkeds;?>" type="file" id="upload_doc_6" name="lokasi_gmaps" rowz="6" />
								<a href="<?=url('storage_event')."/".$list_event['cfoto_lokasi_gmaps'];?>" <?=($list_event['cfoto_lokasi_gmaps'] == '') ? 'style="display:none"' : '';?> target="blank"><button class="btn btn-outline-primary" type="button" id="inputGroupFileAddon04">Show</button></a>
							</div>
							<p id="error1_6" style="display:none; color:#FF0000; font-size: 10px;">Invalid File Format! File Format Must Be JPG, JPEG, PNG, & PDF.</p><p id="error2_6" style="display:none; color:#FF0000; font-size: 10px;">Maximum File Size Limit is 1MB.</p>
						  </div>
						</div>
					</div>
					<div class="col-md-12">
						<div class="row">
						  <label for="upload_doc_4" class="col-md-6 col-form-label">6. Surat Penawaran</label>
						  <div class="col-md-6">
							<div class="input-group">
								<input class="form-control upload_file_docs <?=$checkeds;?>" type="file" id="upload_doc_4" name="surat_penawaran" rowz="4" />
								<a href="<?=url('storage_event')."/".$list_event['csurat_penawaran'];?>" <?=($list_event['csurat_penawaran'] == '') ? 'style="display:none"' : '';?> target="blank"><button class="btn btn-outline-primary" type="button" id="inputGroupFileAddon04">Show</button></a>
							</div>
							<p id="error1_4" style="display:none; color:#FF0000; font-size: 10px;">Invalid File Format! File Format Must Be JPG, JPEG, PNG, & PDF.</p><p id="error2_4" style="display:none; color:#FF0000; font-size: 10px;">Maximum File Size Limit is 1MB.</p>
						  </div>
						</div>
					</div>
				</div>
			</div>
			
			<div class="row col-md-6">
				<div class="col-md p-4">
					<label class="form-label fw-bold">Catatan SPV</label>
					<textarea class="form-control <?=$readonlys;?>" id="note_spv" name="note_spv" rows="2"><?=$list_event['cnote_spv'];?></textarea>
				</div>
			</div>
			
			<div class="row col-md-6" <?=($list_event['cnote_kacab'] == '') ? 'hidden' : '';?> >
				<div class="col-md p-4">
					<label class="form-label fw-bold">Catatan Kepala Cabang</label>
					<textarea class="form-control readonly" id="cnote_kacab" name="cnote_kacab" rows="2"><?=$list_event['cnote_kacab'];?></textarea>
				</div>
			</div>
			
			<div class="row col-md-6" <?=($list_event['cnote_marketing'] == '') ? 'hidden' : '';?> >
				<div class="col-md p-4">
					<label class="form-label fw-bold">Catatan Marketing</label>
					<textarea class="form-control readonly" id="cnote_marketing" name="cnote_marketing" rows="2"><?=$list_event['cnote_marketing'];?></textarea>
				</div>
			</div>
			
			<div class="row col-md-6" <?=($list_event['cnote_noh'] == '') ? 'hidden' : '';?> >
				<div class="col-md p-4">
					<label class="form-label fw-bold">Catatan NOH</label>
					<textarea class="form-control readonly" id="cnote_noh" name="cnote_noh" rows="2"><?=$list_event['cnote_noh'];?></textarea>
				</div>
			</div>
			
			<div class="row col-md-6" <?=($list_event['cnote_coo'] == '') ? 'hidden' : '';?>>
				<div class="col-md p-4">
					<label class="form-label fw-bold">Catatan COO</label>
					<textarea class="form-control readonly" id="cnote_coo" name="cnote_coo" rows="2"><?=$list_event['cnote_coo'];?></textarea>
				</div>
			</div>
			
			<div class="row">
				<div class="col-12 text-center">
				  <button id="simpan" type="submit" class="btn btn-primary" <?=$disable1;?> >SIMPAN</button>
				  <button id="kembali" type="button" onclick="window.location='/list_event'" class="btn btn-warning" >KEMBALI</button>
				</div>
			</div>
			
			<br/><br/>
		</div>
      </div>
	</form>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>

<script>
$(document).ready(function() {
	var status_edt = document.getElementById('status');
	status_edt.value = '<?=$list_event['cstatus']?>';
	var cabang_edt = document.getElementById('cabang');
	cabang_edt.value = '<?=$list_event['cloc']?>';
	var lokasi_edt = document.getElementById('lokasi');
	lokasi_edt.value = '<?=$list_event['ckd_lokasi']?>';
	
	$("input[name=tipe_kegiatan][value=<?=$list_event['ctipe']?>]").prop('checked', true);
	
	if(document.getElementById("qty_1")){
		$('#qty_1').keyup();
	}
	
	
	var stat_ext = '<?=$list_event['cstatus']?>';
	if(stat_ext == '2'){
		$("#cancelq").show();
		$("#ket_cancel").addClass("readonly");
		document.getElementById("ket_cancel").required = true;
	}else{
		$("#cancelq").hide();
		document.getElementById("ket_cancel").required = false;
	
		if(stat_ext == '0'){
			var file_1 = '<?=$list_event['cfoto_area_dispaly']?>';
			if(file_1 == ''){
				document.getElementById("upload_doc_1").required = true;
			}
			var file_2 = '<?=$list_event['cfoto_area_display2']?>';
			if(file_2 == ''){
				document.getElementById("upload_doc_2").required = true;
			}
			var file_3 = '<?=$list_event['cfoto_lokasi_pameran']?>';
			if(file_3 == ''){
				document.getElementById("upload_doc_3").required = true;
			}
			var file_4 = '<?=$list_event['cfoto_tampak_luar']?>';
			if(file_4 == ''){
				document.getElementById("upload_doc_5").required = true;
			}
			var file_5 = '<?=$list_event['cfoto_lokasi_gmaps']?>';
			if(file_5 == ''){
				document.getElementById("upload_doc_6").required = true;
			}
			var file_6 = '<?=$list_event['csurat_penawaran']?>';
			if(file_6 == ''){
				document.getElementById("upload_doc_4").required = true;
			}
		}
	}
	
	$('#tgl_mulai').change(function() {
		
		var date_m = $(this).val();
		
		if(date_m != ''){
			//console.log(date_m);
			//$('#tgl_selesai').min = "2022-10-31";
			var x = document.getElementById("tgl_selesai").min = date_m;
			$('#tgl_selesai').val('');
		}

	});
	
	var ckat_eve = '<?=$list_event['ckat']?>';
	if (ckat_eve == 'MMKSI') {
		//alert('MMKSI');
		$('.tipe_ken_mmksi').attr('disabled',false);
		$('.tipe_ken_ktb').attr('disabled',true);
    }
    else if (ckat_eve == 'KTB') {
        //alert('KTB');
		$('.tipe_ken_mmksi').attr('disabled',true);
		$('.tipe_ken_ktb').attr('disabled',false);
    }
	
	$(".readonly").on('keydown paste', function(e){
		e.preventDefault();
	});
	
	$(".readonly2").on('keydown paste click', function(e){
		e.preventDefault();
	});
	
});

var no = parseInt('<?=$no;?>');
$(document).on('click', '#add_list', function(){
	
	no++;
	var html = '';
	html += '<tr class="list_biaya">';                                                                                                                                                                                                                                                                                                                              
	html += '<td><input type="text" class="nomor" name="nomor" value="'+no+'" hidden><center><font size="2">'+no+'</font></center></td>';
	html += '<td><input type="text" style="" id="nama_biaya_'+no+'" name="nama_biaya[]" class="form-control form-control-sm" ondragstart="return false;" value="" required /></td>';
	html += '<td><input type="text" style="" id="qty_'+no+'" onkeyup="setInputFilterClassCustom(this, event);" onkeydown="setInputFilterClassCustom(this, event);" required ondragstart="return false;" name="qty[]" class="form-control kecil form-control-sm angka" value=""/></td>';
	html += '<td><select name="uom[]" id="uom_'+no+'" class="form-control kecil form-control-sm" style=""><option value="1" selected>PCS</option><option value="2">DRM</option><option value="3">LTR</option></select></td>';
	html += '<td><input type="text" style="" id="harga_'+no+'" name="harga[]" class="form-control kecil form-control-sm" ondragstart="return false;" onfocus="hargaFocus(this);" onblur="check_price(this);" onkeyup="setInputFilterClassCustom(this, event);" onkeydown="setInputFilterClassCustom(this, event);" value="" required />  <input type="hidden" id="harga1_'+no+'" name="harga1[]" /></td>';
	html += '<td><input type="text" style="" id="harga_tot_'+no+'" name="harga_tot[]" class="form-control form-control-sm" onkeypress="return false;" ondragstart="return false;" value="0"/></td>';
	html += '<td><input type="text" style="" id="keterangan_'+no+'" name="keterangan[]" class="form-control form-control-sm" ondragstart="return false;" value=""/> <input type="hidden" id="jumlah1_'+no+'" name="jumlah1[]" /> <input type="hidden" id="stat_'+no+'" name="stat[]" value="1" /></td>';
	html += '</tr>';
	$('#item_event').append(html);
});

	
$(document).on('click', '#delete_list', function(){
	var table = document.getElementById('item_event');
	var rowCount = table.rows.length;
  if(rowCount == 0){
	return false;    
  }else{
	table.deleteRow(rowCount -1);
  }
  if(no == 0){
	no == 0;
  }else{
	no--;
  }
  
  myTotal();
 });
</script>

<script>

// Restricts input for the given textbox to the given inputFilter.
function setInputFilter(textbox, inputFilter, errMsg) {
  ["input", "keydown", "keyup", "mousedown", "mouseup", "select", "contextmenu", "drop", "focusout"].forEach(function(event) {
  //["keydown", "keyup"].forEach(function(event) {
  textbox.addEventListener(event, function(e) {
      if (inputFilter(this.value)) {
        // Accepted value
        if (["keydown","mousedown","focusout"].indexOf(e.type) >= 0){
          this.classList.remove("input-error");
          this.setCustomValidity("");
        }
        this.oldValue = this.value;
        this.oldSelectionStart = this.selectionStart;
        this.oldSelectionEnd = this.selectionEnd;
		
		myTotal();
      } else if (this.hasOwnProperty("oldValue")) {
        // Rejected value - restore the previous one
        this.classList.add("input-error");
        this.setCustomValidity(errMsg);
        this.reportValidity();
        this.value = this.oldValue;
        this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
      } else {
        // Rejected value - nothing to restore
        this.value = "";
		//this.oldValue = this.value;
      }
    });
  });
}

// Restricts input for the given textbox to the given inputFilter.
/*function setInputFilterClass(arg, e) {
  //console.log(arg.value);
  
	if(/^\d*$/.test(arg.value)){
		arg.classList.remove("input-error");
        arg.setCustomValidity("");
		arg.oldValue = arg.value;
        arg.oldSelectionStart = arg.selectionStart;
        arg.oldSelectionEnd = arg.selectionEnd;
		
	}else if (arg.hasOwnProperty("oldValue")) {
		arg.classList.add("input-error");
        arg.setCustomValidity("Harap menginputkan bilangan & lebih besar dari 0");
        arg.reportValidity();
        arg.value = arg.oldValue;
        arg.setSelectionRange(arg.oldSelectionStart, arg.oldSelectionEnd);
		
	}else{
		// Rejected value - nothing to restore
        arg.value = "";
  
	}
}*/

function addCommas(nStr){
	nStr += '';
	x = nStr.split('.');
	x1 = x[0];
	x2 = x.length > 1 ? '.' + x[1] : '';
	var rgx = /(\d+)(\d{3})/;
	while (rgx.test(x1)) {
		x1 = x1.replace(rgx, '$1' + ',' + '$2');
	}
	return x1 + x2;
}

</script>

<script>
$(document).ready(function() {
	setInputFilter(document.getElementById("target_database"), function(value) {
	  return /^\d*$/.test(value); }, "Harap menginputkan bilangan & lebih besar dari 0");

	setInputFilter(document.getElementById("target_prospek"), function(value) {
	  return /^\d*$/.test(value); }, "Harap menginputkan bilangan & lebih besar dari 0");
	  
	setInputFilter(document.getElementById("target_spk_ots"), function(value) {
	  return /^\d*$/.test(value); }, "Harap menginputkan bilangan & lebih besar dari 0");
	  
	setInputFilter(document.getElementById("target_spk_fu"), function(value) {
	  return /^\d*$/.test(value); }, "Harap menginputkan bilangan & lebih besar dari 0");
});
</script>

<script>
function setInputFilterClassCustom(arg, e) {
  
	if(/^\d*$/.test(arg.value)){
		arg.classList.remove("input-error");
        arg.setCustomValidity("");
		arg.oldValue = arg.value;
        arg.oldSelectionStart = arg.selectionStart;
        arg.oldSelectionEnd = arg.selectionEnd;
		
		var id = arg.getAttribute('id');
		var value = arg.value;
		id_arr = id.split("_");
		element_id = id_arr[id_arr.length-1];
		 
		var harga_s = document.getElementById("harga_"+element_id).value.split(',').join("");
		var qty_s = document.getElementById("qty_"+element_id).value;

		if(qty_s == ""){
			qty_s = 0;
		}
		  
		if(harga_s == ""){
			harga_s = 0;
		}
		  
		var harga = parseFloat(harga_s).toFixed(2);
		var qty = parseFloat(qty_s);
		  
		if(!isNaN(qty) && !isNaN(harga)){

			var jumlah = harga * qty;
			var jumlah__ = addCommas(jumlah.toFixed(2));
			document.getElementById("jumlah1_"+element_id).value = jumlah;
			document.getElementById("harga_tot_"+element_id).value = jumlah__;
		  
			myTotal();
		}
		
		
	}else if (arg.hasOwnProperty("oldValue")) {
		arg.classList.add("input-error");
        arg.setCustomValidity("Harap menginputkan bilangan & lebih besar dari 0");
        arg.reportValidity();
        arg.value = arg.oldValue;
        arg.setSelectionRange(arg.oldSelectionStart, arg.oldSelectionEnd);
		
	}else{
		// Rejected value - nothing to restore
        arg.value = "";
  
	}
}
</script>

<script>
function hargaFocus(arg){
  var id = arg.getAttribute('id');
  var value = arg.value;
  id_arr = id.split("_");
  element_id = id_arr[id_arr.length-1];
  element_id1 = id_arr[0];
 
  var harga1 = document.getElementById("harga_"+element_id).value.split(',').join("");
  $('#harga_'+element_id).val(harga1);
  
}
</script>

<script>
function check_price(arg){
  var id = arg.getAttribute('id');
  var value = arg.value;
  id_arr = id.split("_");
  element_id = id_arr[id_arr.length-1];
  element_id1 = id_arr[0];
 
  var harga1 = document.getElementById("harga_"+element_id).value.split(',').join("");
  
  if(harga1 == ""){
	harga1 = 0;
  }
  
  var harga = parseFloat(harga1);
  
  if(!isNaN(harga)){
	  
	  $('#harga1_'+element_id).val(harga);
	  var harga_str = addCommas(harga.toFixed(2));
	  $('#harga_'+element_id).val(harga_str);
	  
	  $("#qty_"+element_id).keyup();
  }else{
	 alert('Harap mengisi nilai dengan benar.');	  
  }
}
</script>

<script>
function myTotal(){
  total_semua = 0;
  per_prospek = 0;
  per_spk = 0;
  per_database = 0;
  var status = $('#status').val();
  var nomor = document.getElementsByClassName("nomor");
  for(i=1; i<=nomor.length; i++){
    var cek = document.getElementById("harga_"+i).value;
	var stat = document.getElementById("stat_"+i).value;
	
	var qty = document.getElementById("qty_"+i).value.split(',').join("");
    qtys = parseFloat(qty);
	
	if(cek != '' && qty != 0 && !isNaN(qty) && (stat == '1' || status == '0')){
	
		var jml = document.getElementById("harga1_"+i).value;
		if(jml == ""){
			jml = 0;
		}
		total_semua = (total_semua + (parseFloat(jml) * qtys));
	}
  }  
	  var bilangan = addCommas(total_semua);
	  document.getElementById("total").value = bilangan; 
	  
	  var database = document.getElementById("target_database").value.split(',').join("");  
	  if(database == ""){
		database = 0;
	  }
	  databases = parseFloat(database);
	  
	  var prospek = document.getElementById("target_prospek").value.split(',').join("");  
	  if(prospek == ""){
		prospek = 0;
	  }
	  prospeks = parseFloat(prospek);
	  
	  var spk_ots = document.getElementById("target_spk_ots").value.split(',').join("");
	  if(spk_ots == ""){
		spk_ots = 0;
	  }
	  spk_otss = parseFloat(spk_ots);
	  
	  var spk_fu = document.getElementById("target_spk_fu").value.split(',').join("");
	  if(spk_fu == ""){
		spk_fu = 0;
	  }
	  spk_fus = parseFloat(spk_fu);
	  
	  if(database > 0){
	  
		per_database = total_semua / database; 
		var per_database_ = addCommas(per_database.toFixed());
		document.getElementById("per_database").value = per_database_;
	  }else{
		document.getElementById("per_database").value = 0;
	  }
	  
	  if(prospek > 0){
	  
		per_prospek = total_semua / prospek; 
		var per_prospek_ = addCommas(per_prospek.toFixed());
		document.getElementById("per_prspk").value = per_prospek_;
	  }else{
		document.getElementById("per_prspk").value = 0;
	  }
	  
	  //console.log(spk_otss+spk_fus);
	  if((spk_otss+spk_fus) > 0){
		per_spk = total_semua / (spk_otss+spk_fus);
		var per_spk_ = addCommas(per_spk.toFixed());
		document.getElementById("per_spk").value = per_spk_; 
	  }else{
		document.getElementById("per_spk").value = 0;
	  }
}
</script>

<script>
$("#form_input_claim").submit(function(e){
	var table = document.getElementById('item_event');
	var rowCount = table.rows.length;
	
	//console.log(rowCount);
	if(rowCount != 0){
		if(confirm('Apakah anda ingin menyimpan data ?')){
			$('#simpan').prop('disabled', true);
			return true;
		}else{
			return false;
		}
		
		//return confirm('Apakah anda ingin menyimpan data ?');
	}else{
		alert("Klik 'Tambah Baris' untuk menambah item biaya.");
		e.preventDefault();
	}
});
</script>

<script>
  $(document).ready(function(){
	//binds to onchange event of your input field
	$(document).on('change', '.upload_file_docs', function(){
		var a=0;
		var rowz = $(this).attr('rowz');
		
		//var rowz = $(this).parent().parent().find(".nomor_docs").val();
		//console.log(rowz);

		if ($('button:submit').attr('disabled',false)){
			$('button:submit').attr('disabled',true);
		}
		
		var ext = $('#upload_doc_'+rowz).val().split('.').pop().toLowerCase();
		if ($.inArray(ext, ['png','jpg','jpeg', 'pdf']) == -1){
			$('#error1_'+rowz).slideDown("slow");
			$('#error2_'+rowz).slideUp("slow");
			a=0;
		}else{
			var picsize = (this.files[0].size);
			if (picsize > 1000000){
				$('#error2_'+rowz).slideDown("slow");
				a=0;
			}else{
				a=1;
				$('#error2_'+rowz).slideUp("slow");
			}
			$('#error1_'+rowz).slideUp("slow");
			if (a==1){
				$('button:submit').attr('disabled',false);
			}
		}
	});
  });
</script>

<script>
  $(document).ready(function(){
    $(document).on('change', '#status', function(){
      var status = $('#status').val();
	  
	  if(status == "2"){
		$("#cancelq").show();
		 document.getElementById("ket_cancel").required = true;
	  }else{
		 document.getElementById("ket_cancel").required = false;
		$("#cancelq").hide();
	  }
		
    });  
  });
</script>

<script>
$('input[type=radio][name=kategori]').change(function() {
	
	$('.tipe_kedaraan_div').find('input[type=checkbox]:checked').each(function() { 
		this.checked = false; 
	});
	
    if (this.value == 'MMKSI') {
		//alert('MMKSI');
		$('.tipe_ken_mmksi').attr('disabled',false);
		$('.tipe_ken_ktb').attr('disabled',true);
    }
    else if (this.value == 'KTB') {
        //alert('KTB');
		$('.tipe_ken_mmksi').attr('disabled',true);
		$('.tipe_ken_ktb').attr('disabled',false);
    }
});
</script>

@endsection