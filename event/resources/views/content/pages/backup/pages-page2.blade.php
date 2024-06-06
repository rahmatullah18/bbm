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

@section('content')
<h4 class="py-3 breadcrumb-wrapper mb-4">
  <span class="">Managemen Event</span>
</h4>

<div class="row">
  <div class="col-md-12">
    <div class="card mb-4">
      <h5 class="card-header">Input Data Event</h5>
      <div class="card-body">
		<form class="browser-default-validation" id="form_input_claim" action="{{url('/proses_save_event')}}" enctype="multipart/form-data" method="POST" autocomplete="off">
		{{ csrf_field() }}
		<div class="col-md-12">
			<div class="row col-md-3">
				<div class="col-md p-4">
					<label class="form-label fw-bold">Status</label>
					<select class="form-select" id="status" name="status" aria-label="Pilih Status Event">
						<option value="0">Pengajuan Baru</option>
						<option selected value="1">Sedang Diproses</option>
					</select>
				</div>
			</div>
			<div class="row col-md-8">
				<div class="col-md p-4">
					<label class="form-label fw-bold">No. Event</label>
					<input type="text" class="form-control" id="no_event" name="no_event" placeholder="No Eevnt" aria-describedby="defaultFormControlHelp" value="<?=$no_event;?>" readonly />
				</div>
				<div class="col-md p-4">
					<label class="form-label fw-bold">Tgl. Pengajuan</label>
					<input class="form-control" type="date" value="<?=date('Y-m-d');?>" id="tgl_pengajuan" name="tgl_pengajuan" required readonly />
				</div>
			</div>
			<div class="row col-md-5">
				<div class="col-md p-4">
					<label class="form-label fw-bold">Kategori</label>
					<div class="form-check mt-3">
						<input name="kategori" class="form-check-input" type="radio" value="MMKSI" id="kategori_mmksi" checked />
						<label class="form-check-label" for="kategori_mmksi">
						  MMKSI
						</label>
					</div>
				</div>
				<div class="col-md p-4">
					<label class="form-label fw-bold">&nbsp;</label>
					<div class="form-check mt-3">
						<input name="kategori" class="form-check-input" type="radio" value="KTB" id="kategori_ktb" />
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
								<input name="tipe_kegiatan" class="form-check-input" type="radio" value="0" id="tipe_pameran" checked />
								<label class="form-check-label" for="tipe_pameran">
								  Pameran
								</label>
							</div>
						</div>
						<div class="col-md">
							<div class="form-check mt-3">
								<input name="tipe_kegiatan" class="form-check-input" type="radio" value="1" id="tipe_display" />
								<label class="form-check-label" for="tipe_display">
								  Display
								</label>
							</div>
						</div>
						<div class="col-md">
							<div class="form-check mt-3">
								<input name="tipe_kegiatan" class="form-check-input" type="radio" value="2" id="tipe_canvasing" />
								<label class="form-check-label" for="tipe_canvasing">
								  Kanvasing
								</label>
							</div>
						</div>
						<div class="col-md">
							<div class="form-check mt-3">
								<input name="tipe_kegiatan" class="form-check-input" type="radio" value="3" id="tipe_gathering" />
								<label class="form-check-label" for="tipe_gathering">
								  Gathering
								</label>
							</div>
						</div>
						<div class="col-md">
							<div class="form-check mt-3">
								<input name="tipe_kegiatan" class="form-check-input" type="radio" value="4" id="tipe_sponsorship" />
								<label class="form-check-label" for="tipe_sponsorship">
								  Sponsorship
								</label>
							</div>
						</div>
					
				</div>
				
				<div class="row col-md-12" style="padding-left:1.5rem !important;padding-right:1.5rem !important;">
					
					<div class="col-md">
						<div class="form-check mt-3">
							<input name="tipe_kegiatan" class="form-check-input" type="radio" value="5" id="tipe_showroom" />
							<label class="form-check-label" for="tipe_showroom">
							  Showroom Event
							</label>
						</div>
					</div>
					<div class="col-md">
						<div class="form-check mt-3">
							<input name="tipe_kegiatan" class="form-check-input" type="radio" value="6" id="tipe_office" />
							<label class="form-check-label" for="tipe_office">
							  Office Event
							</label>
						</div>
					</div>
					<div class="col-md">
						<div class="form-check mt-3">
							<input name="tipe_kegiatan" class="form-check-input" type="radio" value="7" id="tipe_public_area" />
							<label class="form-check-label" for="tipe_public_area">
							  Public Area Event
							</label>
						</div>
					</div>
					<div class="col-md">
						<div class="form-check mt-3">
							<input name="tipe_kegiatan" class="form-check-input" type="radio" value="8" id="tipe_test_drive" />
							<label class="form-check-label" for="tipe_test_drive">
							  Test Drive Event
							</label>
						</div>
					</div>
					<div class="col-md">
						<div class="form-check mt-3">
							<input name="tipe_kegiatan" class="form-check-input" type="radio" value="9" id="tipe_open_table" />
							<label class="form-check-label" for="tipe_open_table">
							  Open Table
							</label>
						</div>
					</div>
					
				</div>
				
				<div class="row col-md-12 p-4" style="padding-top:0px !important;">
					<div class="col-md">
						<div class="form-check mt-3">
							<input name="tipe_kegiatan" class="form-check-input" type="radio" value="10" id="tipe_above_line" />
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
						<option selected value="">Pilih Cabang</option>
						<?php
							
							//var_dump($cabang)
							
							foreach ($cabang as $cabangs) {
								echo "<option value='".$cabangs['cloc']."'>".$cabangs['cnama']."</option>";;
							}
							
						?>
						
					</select>
				</div>
			</div>
			<div class="row col-md-4">
				<div class="col-md p-4">
					<label class="form-label fw-bold">Nama Supervisor</label>
					<input type="text" class="form-control" id="nm_spv" name="nm_spv" placeholder="Nama Supervisor" aria-describedby="defaultFormControlHelp" value="<?=$nm_spv;?>" readonly />
					<input type="text" class="ckode_spv" name="ckode_spv" value="<?=$kd_spv;?>" hidden>
				</div>
			</div>
			<div class="row col-md-6">
				<!--<div class="col-md p-4">
					<label class="form-label fw-bold">Tanggal Kegiatan</label>
					<input class="form-control" type="date" value="" id="tgl_mulai" name="tgl_mulai" />
				</div>
				<div class="col-md p-4">
					<label class="form-label fw-bold">&nbsp;</label>
					<label class="form-control fw-bold" style="border: none">S/D</label>
				</div>
				<div class="col-md p-4">
					<label class="form-label fw-bold">&nbsp;</label>
					<input class="form-control" type="date" value="" id="tgl_selesai" name="tgl_selesai" />
				</div>-->
				<div class="col-md p-4">
					<label class="form-label fw-bold">Tanggal Kegiatan</label>
					<div class="input-group" id="">
					  <input class="form-control" type="date" value="" id="tgl_mulai" name="tgl_mulai" required/>
					  <span class="input-group-text">to</span>
					  <input class="form-control" type="date" value="" id="tgl_selesai" name="tgl_selesai" required/>
					</div>
				</div>
			</div>
			<div class="row col-md-5">
				<div class="col-md p-4">
					<label class="form-label fw-bold">Kota Kegiatan</label>
					<select class="select3 form-select" id="kota" name="kota" aria-label="Pilih Kota Kegiatan" required >
						<option selected value="">Pilih Kota</option>
						<?php							
							foreach ($kota as $kotas) {
								echo "<option value='".$kotas['CityCode']."'>".$kotas['CityName']."</option>";
							}
							
						?>
						
					</select>
				</div>
			</div>
			<div class="row col-md-5">
				<div class="col-md p-4">
					<label class="form-label fw-bold">Lokasi Kegiatan</label>
					<select class="select2 form-select" id="lokasi" name="lokasi" aria-label="Pilih Lokasi Kegiatan" required >
						<option selected value="">Pilih Lokasi</option>
						<?php							
							foreach ($lokasi as $lokasis) {
								echo "<option value='".$lokasis['ckd_lokasi']."'>".$lokasis['cnm_lokasi']."</option>";;
							}
							
						?>
						
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
							<input name="tipe_xforce" class="form-check-input tipe_ken_mmksi" type="checkbox" value="1" id="tipe_xforce" />
							<label class="form-check-label" for="tipe_xforce">
							  XForce
							</label>
						</div>
					</div>
					<div class="col-md">
						
						<div class="form-check mt-3">
							<input name="tipe_xpander" class="form-check-input tipe_ken_mmksi" type="checkbox" value="1" id="tipe_xpander" />
							<label class="form-check-label" for="tipe_xpander">
							  Xpander
							</label>
						</div>
					</div>
					<div class="col-md">
						
						<div class="form-check mt-3">
							<input name="tipe_xpander_cross" class="form-check-input tipe_ken_mmksi" type="checkbox" value="1" id="tipe_xpander_cross" />
							<label class="form-check-label" for="tipe_xpander_cross">
							  Xpander Cross
							</label>
						</div>
					</div>
					<div class="col-md">
						
						<div class="form-check mt-3">
							<input name="tipe_pajero_sport" class="form-check-input tipe_ken_mmksi" type="checkbox" value="1" id="tipe_pajero_sport" />
							<label class="form-check-label" for="tipe_pajero_sport">
							  Pajero Sport
							</label>
						</div>
					</div>
					<div class="col-md">
						
						<div class="form-check mt-3">
							<input name="tipe_l300" class="form-check-input tipe_ken_mmksi" type="checkbox" value="1" id="tipe_l300" />
							<label class="form-check-label" for="tipe_l300">
							  L300
							</label>
						</div>
					</div>
					<div class="col-md">
						
						<div class="form-check mt-3">
							<input name="eclipse_cross" class="form-check-input tipe_ken_mmksi" type="checkbox" value="1" id="eclipse_cross" />
							<label class="form-check-label" for="eclipse_cross">
							  Eclipse Cross
							</label>
						</div>
					</div>
					
					<div class="col-md">
						
						<div class="form-check mt-3">
							<input name="tipe_colt_diesel" class="form-check-input tipe_ken_ktb" type="checkbox" value="1" id="tipe_colt_diesel" />
							<label class="form-check-label" for="tipe_colt_diesel">
							  Canter
							</label>
						</div>
					</div>
				</div>
				
				<div class="row col-md-12 p-4">
				
					<div class="col-md">
						
						<div class="form-check">
							<input name="tipe_fuso" class="form-check-input tipe_ken_ktb" type="checkbox" value="1" id="tipe_fuso" />
							<label class="form-check-label" for="tipe_fuso">
							  Fighter X
							</label>
						</div>
					</div>
					
					<div class="col-md">
						
						<div class="form-check">
							<input name="triton_dc" class="form-check-input tipe_ken_mmksi" type="checkbox" value="1" id="triton_dc" />
							<label class="form-check-label" for="triton_dc">
							  Triton DC
							</label>
						</div>
					</div>
					<div class="col-md">
						
						<div class="form-check">
							<input name="triton_sc" class="form-check-input tipe_ken_mmksi" type="checkbox" value="1" id="triton_sc" />
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
							<input class="form-control" type="text" value="" id="target_database" name="target_database" />
						  </div>
						</div>
					</div>
					<div class="col-md-12">
						<div class="row">
						  <label for="target_prospek" class="col-md-4 col-form-label">Prospek</label>
						  <div class="col-md-5">
							<input class="form-control" type="text" value="" id="target_prospek" name="target_prospek" />
						  </div>
						</div>
					</div>
					<div class="col-md-12">
						<div class="row">
						  <label for="target_spk_ots" class="col-md-4 col-form-label">SPK On The Spot</label>
						  <div class="col-md-5">
							<input class="form-control" type="text" value="" id="target_spk_ots" name="target_spk_ots" />
						  </div>
						</div>
					</div>
					<div class="col-md-12">
						<div class="row">
						  <label for="target_spk_fu" class="col-md-4 col-form-label">SPK Follow Up</label>
						  <div class="col-md-5">
							<input class="form-control" type="text" value="" id="target_spk_fu" name="target_spk_fu" />
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
									<button type="button" id="add_list" class="btn btn-success btn-sm">
										Tambah Baris
									</button>
									<button type="button" id="delete_list" class="btn btn-warning btn-sm">
										Hapus Baris
									</button>	
								</div>
							</div>
						</div>
					    <div class="table-responsive text-nowrap">
						  <table class="table table-bordered" style="overflow-x: scroll;min-width: 120%;" >
							<thead>
							  <tr>
								<th style="width:5px;">No</th>
								<th style="width:200px;">Uraian</th>
								<th style="width:70px;">Item</th>
								<th style="width:70px;">Satuan</th>
								<th style="width:120px;">Nilai</th>
								<th style="width:120px;">Total Nilai</th>
								<th style="width:170px;">Keterangan</th>
							  </tr>
							</thead>
							<tbody class="table-border-bottom-0" id="item_event">    
							  
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
						  <div class="col-md-5">
							<input class="form-control upload_file_docs" type="file" id="upload_doc_1" name="area_display" rowz="1" required />
							<p id="error1_1" style="display:none; color:#FF0000; font-size: 10px;">Invalid File Format! File Format Must Be JPG, JPEG, PNG, & PDF.</p><p id="error2_1" style="display:none; color:#FF0000; font-size: 10px;">Maximum File Size Limit is 1MB.</p>
						  </div>
						</div>
					</div>
					<div class="col-md-12">
						<div class="row">
						  <label for="upload_doc_2" class="col-md-6 col-form-label">2. Area Test Drive</label>
						  <div class="col-md-5">
							<input class="form-control upload_file_docs" type="file" id="upload_doc_2" name="area_display2" rowz="2" required />
							<p id="error1_2" style="display:none; color:#FF0000; font-size: 10px;">Invalid File Format! File Format Must Be JPG, JPEG, PNG, & PDF.</p><p id="error2_2" style="display:none; color:#FF0000; font-size: 10px;">Maximum File Size Limit is 1MB.</p>
						  </div>
						</div>
					</div>
					<div class="col-md-12">
						<div class="row">
						  <label for="upload_doc_3" class="col-md-6 col-form-label">3. Lokasi Pameran/Denah/Layout</label>
						  <div class="col-md-5">
							<input class="form-control upload_file_docs" type="file" id="upload_doc_3" name="lokasi_pameran" rowz="3" required />
							<p id="error1_3" style="display:none; color:#FF0000; font-size: 10px;">Invalid File Format! File Format Must Be JPG, JPEG, PNG, & PDF.</p><p id="error2_3" style="display:none; color:#FF0000; font-size: 10px;">Maximum File Size Limit is 1MB.</p>
						  </div>
						</div>
					</div>
					<div class="col-md-12">
						<div class="row">
						  <label for="upload_doc_5" class="col-md-6 col-form-label">4. Tampak Luar Gedung/Area Pameran</label>
						  <div class="col-md-5">
							<input class="form-control upload_file_docs" type="file" id="upload_doc_5" name="tampak_luar" rowz="5" required />
							<p id="error1_5" style="display:none; color:#FF0000; font-size: 10px;">Invalid File Format! File Format Must Be JPG, JPEG, PNG, & PDF.</p><p id="error2_5" style="display:none; color:#FF0000; font-size: 10px;">Maximum File Size Limit is 1MB.</p>
						  </div>
						</div>
					</div>
					<div class="col-md-12">
						<div class="row">
						  <label for="upload_doc_6" class="col-md-6 col-form-label">5. Screenshot Lokasi Pameran di GMaps</label>
						  <div class="col-md-5">
							<input class="form-control upload_file_docs" type="file" id="upload_doc_6" name="lokasi_gmaps" rowz="6" required />
							<p id="error1_6" style="display:none; color:#FF0000; font-size: 10px;">Invalid File Format! File Format Must Be JPG, JPEG, PNG, & PDF.</p><p id="error2_6" style="display:none; color:#FF0000; font-size: 10px;">Maximum File Size Limit is 1MB.</p>
						  </div>
						</div>
					</div>
					<div class="col-md-12">
						<div class="row">
						  <label for="upload_doc_4" class="col-md-6 col-form-label">6. Surat Penawaran</label>
						  <div class="col-md-5">
							<input class="form-control upload_file_docs" type="file" id="upload_doc_4" name="surat_penawaran" rowz="4" required />
							<p id="error1_4" style="display:none; color:#FF0000; font-size: 10px;">Invalid File Format! File Format Must Be JPG, JPEG, PNG, & PDF.</p><p id="error2_4" style="display:none; color:#FF0000; font-size: 10px;">Maximum File Size Limit is 1MB.</p>
						  </div>
						</div>
					</div>
				</div>
			</div>
			
			<div class="row col-md-6">
				<div class="col-md p-4">
					<label class="form-label fw-bold">Catatan</label>
					<textarea class="form-control" id="note_spv" name="note_spv" rows="2"></textarea>
				</div>
			</div>
			
			<div class="row">
				<div class="col-12 text-center">
				  <button id="simpan" type="submit" class="btn btn-primary">SIMPAN</button>
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
	$('#lokasi').empty();
	////console.log('jalanja');

	var date = new Date();
	var last = new Date(date.getTime() + (7 * 24 * 60 * 60 * 1000));
	var finalDate = last.getFullYear() +'-'+ ((last.getMonth() + 1) < 10 ? '0' : '') + (last.getMonth() + 1) +'-'+ (last.getDate() < 10 ? '0' : '') + last.getDate();
	var xy = document.getElementById("tgl_mulai").min = finalDate;
	
	$('#tgl_mulai').change(function() {
		
		var date_m = $(this).val();
		
		if(date_m != ''){
			//console.log(date_m);
			//$('#tgl_selesai').min = "2022-10-31";
			var x = document.getElementById("tgl_selesai").min = date_m;
			$('#tgl_selesai').val('');
		}

	});
	
	$('.tipe_ken_mmksi').attr('disabled',false);
	$('.tipe_ken_ktb').attr('disabled',true);
	
});

var no = 0;
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
	html += '<td><input type="text" style="" id="keterangan_'+no+'" name="keterangan[]" class="form-control form-control-sm" ondragstart="return false;" value=""/> <input type="hidden" id="jumlah1_'+no+'" name="jumlah1[]" /></td>';
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
  var nomor = document.getElementsByClassName("nomor");
  for(i=1; i<=nomor.length; i++){
    var cek = document.getElementById("harga_"+i).value;
	
	var qty = document.getElementById("qty_"+i).value.split(',').join("");
    qtys = parseFloat(qty);
	
	if(cek != '' && qty != 0 && !isNaN(qty)){
	
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
    $(document).on('change', '#kota', function(){
      var kota = $('#kota').val();
	  
	  $('#lokasi').empty();
	
		$.getJSON("/get_list_option_lokasi?kota="+kota, function(data){
			$.each(data, function (index, value) {
				
				$('#lokasi').append($("<option></option>").attr("value", value.CityCode).text(value.CityName));
			});
		});
		
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