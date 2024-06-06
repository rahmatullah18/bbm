@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Managemen Event')

@section('vendor-style')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/flatpickr/flatpickr.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/apex-charts/apex-charts.css')}}" />
@endsection

@section('vendor-script')
<script src="{{asset('assets/vendor/libs/datatables/jquery.dataTables.js')}}"></script>
<script src="{{asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js')}}"></script>
<script src="{{asset('assets/vendor/libs/datatables-responsive/datatables.responsive.js')}}"></script>
<script src="{{asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.js')}}"></script>
<!-- Flat Picker -->
<script src="{{asset('assets/vendor/libs/moment/moment.js')}}"></script>
<script src="{{asset('assets/vendor/libs/flatpickr/flatpickr.js')}}"></script>
<script src="{{asset('assets/vendor/libs/apex-charts/apexcharts.js')}}"></script>
<script src="{{asset('assets/vendor/libs/chartjs/chartjs.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chartjs-plugin-datalabels/2.2.0/chartjs-plugin-datalabels.min.js" integrity="sha512-JPcRR8yFa8mmCsfrw4TNte1ZvF1e3+1SdGMslZvmrzDYxS69J7J49vkFL8u6u8PlPJK+H3voElBtUCzaXj+6ig==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@endsection

@section('page-script')
<script src="{{asset('assets/js/tables_list_event.js')}}"></script>
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
      <!--<h5 class="card-header">List Data Event</h5>-->
      <div class="card-body">
			<div class="card">
			  <h5 class="card-header">List Data Event</h5>
			  <div class="card-datatable text-nowrap">
				<div class="row col-md-8" style="float:right;">
					<form id="export_form_event" class="row" action="{{url('/export_data_event')}}" method="GET" autocomplete="off" style="margin-top:-6px;;padding-right: 0px;padding-left: 0px;">
					{{ csrf_field() }}
					<div class="col-md-7">
						<label class="form-label fw-bold">Tanggal Kegiatan</label>
						<div class="input-group" id="">
						  <input class="form-control" type="date" value="" id="tgl_mulai" name="tgl_mulai"/>
						  <span class="input-group-text">to</span>
						  <input class="form-control" type="date" value="" id="tgl_selesai" name="tgl_selesai"/>
						</div>
					</div>
					<div class="col-md-5">
						<label class="form-label fw-bold">No. Event</label>
						<div class="input-group" id="">
						  <input type="text" class="form-control" id="cari_event" name="cari_event" placeholder="No Event" />
						  <button type="button" class="btn btn-icon btn-primary" id="btn_search" name="btn_search">
							<span class="tf-icons bx bx-search-alt"></span>
						  </button>
						  <button type="submit" class="btn btn-icon btn-success" id="btn_export_xcl" name="btn_export_xcl">
							<span class="tf-icons bx bx-export"></span>
						  </button>
						</div>
					</div>
					</form>
				</div>
				<table class="datatables-ajax table table-bordered">
				  <thead>
					<tr>
					  <th>No. Event</th>
					  <th>Status</th>
					  <th>Diproses Oleh</th>
					  <th>Tgl. Pengajuan</th>
					  <th>Kategori</th>
					  <th>Tipe</th>
					  <th>Cabang</th>
					  <th>Supervisor</th>
					  <th>Tgl. Kegiatan</th>
					  <th>Lokasi</th>
					  <th>Aksi</th>
					</tr>
				  </thead>
				</table>
			  </div>
			</div>
	  </div>
    </div>
  </div>
</div>

<!-- Modal Report 1-->
<div class="modal fade" id="modalReport1" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-simple modal-enable-otp modal-dialog-centered">
    <div class="modal-content p-3 p-md-5">
      <div class="modal-body">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        <div class="text-center mb-4">
          <h3 class="mb-4" id="header_report">Upload Dokumen Laporan</h3>
        </div>
        <h6 id="no_event_p">No. Event :</h6>
        <form id="upload_report" class="row g-3 mt-3" action="" enctype="multipart/form-data" method="POST" autocomplete="off">
          <div class="col-12">
            <label class="form-label" for="upload_doc_1">Upload File Laporan 1</label>
            <div class="input-group">
			  <input class="form-control upload_file_docs" type="file" id="upload_doc_1" name="upload_doc_1" rowz="1" />
			  
			  <a href="" id="report_show_1" target="_blank"><button class="btn btn-outline-primary" type="button">Show</button></a>
			  <input class="form-control" type="hidden" id="no_event" name="no_event" /> 
            </div>
			<p id="error1_1" style="display:none; color:#FF0000; font-size: 10px;">Invalid File Format! File Format Must Be JPG, JPEG, PNG, & PDF.</p><p id="error2_1" style="display:none; color:#FF0000; font-size: 10px;">Maximum File Size Limit is 1MB.</p>
		  </div>
		  <div class="col-12">
            <label class="form-label" for="upload_doc_2">Upload File Laporan 2</label>
            <div class="input-group">
			  <input class="form-control upload_file_docs" type="file" id="upload_doc_2" name="upload_doc_2" rowz="2" />
			  
			  <a href="" id="report_show_2" target="_blank"><button class="btn btn-outline-primary" type="button">Show</button></a>
            </div>
			<p id="error1_2" style="display:none; color:#FF0000; font-size: 10px;">Invalid File Format! File Format Must Be JPG, JPEG, PNG, & PDF.</p><p id="error2_2" style="display:none; color:#FF0000; font-size: 10px;">Maximum File Size Limit is 1MB.</p>
		  </div>
		  <div class="col-12">
            <label class="form-label" for="upload_doc_3">Upload File Laporan 3</label>
            <div class="input-group">
			  <input class="form-control upload_file_docs" type="file" id="upload_doc_3" name="upload_doc_3" rowz="3" />
			  
			  <a href="" id="report_show_3" target="_blank"><button class="btn btn-outline-primary" type="button">Show</button></a>
            </div>
			<p id="error1_3" style="display:none; color:#FF0000; font-size: 10px;">Invalid File Format! File Format Must Be JPG, JPEG, PNG, & PDF.</p><p id="error2_3" style="display:none; color:#FF0000; font-size: 10px;">Maximum File Size Limit is 1MB.</p>
		  </div>
		  <div class="col-12">
            <label class="form-label" for="upload_doc_4">Upload File Laporan 4</label>
            <div class="input-group">
			  <input class="form-control upload_file_docs" type="file" id="upload_doc_4" name="upload_doc_4" rowz="4" />
			  
			  <a href="" id="report_show_4" target="_blank"><button class="btn btn-outline-primary" type="button">Show</button></a>
            </div>
			<p id="error1_4" style="display:none; color:#FF0000; font-size: 10px;">Invalid File Format! File Format Must Be JPG, JPEG, PNG, & PDF.</p><p id="error2_4" style="display:none; color:#FF0000; font-size: 10px;">Maximum File Size Limit is 1MB.</p>
		  </div>
		  <div class="col-12">
            <label class="form-label" for="upload_doc_5">Upload File Laporan 5</label>
            <div class="input-group">
			  <input class="form-control upload_file_docs" type="file" id="upload_doc_5" name="upload_doc_5" rowz="5" />
			  
			  <a href="" id="report_show_5" target="_blank"><button class="btn btn-outline-primary" type="button">Show</button></a>
            </div>
			<p id="error1_5" style="display:none; color:#FF0000; font-size: 10px;">Invalid File Format! File Format Must Be JPG, JPEG, PNG, & PDF.</p><p id="error2_5" style="display:none; color:#FF0000; font-size: 10px;">Maximum File Size Limit is 1MB.</p>
		  </div>
		  <div class="col-12">
            <label class="form-label" for="upload_doc_6">Upload File Laporan 6</label>
            <div class="input-group">
			  <input class="form-control upload_file_docs" type="file" id="upload_doc_6" name="upload_doc_6" rowz="6" />
			  
			  <a href="" id="report_show_6" target="_blank"><button class="btn btn-outline-primary" type="button">Show</button></a>
            </div>
			<p id="error1_6" style="display:none; color:#FF0000; font-size: 10px;">Invalid File Format! File Format Must Be JPG, JPEG, PNG, & PDF.</p><p id="error2_6" style="display:none; color:#FF0000; font-size: 10px;">Maximum File Size Limit is 1MB.</p>
		  </div>
		  <div class="col-12">
            <label class="form-label" for="upload_doc_7">Upload File Laporan 7</label>
            <div class="input-group">
			  <input class="form-control upload_file_docs" type="file" id="upload_doc_7" name="upload_doc_7" rowz="7" />
			  
			  <a href="" id="report_show_7" target="_blank"><button class="btn btn-outline-primary" type="button">Show</button></a>
            </div>
			<p id="error1_7" style="display:none; color:#FF0000; font-size: 10px;">Invalid File Format! File Format Must Be JPG, JPEG, PNG, & PDF.</p><p id="error2_7" style="display:none; color:#FF0000; font-size: 10px;">Maximum File Size Limit is 1MB.</p>
		  </div>
		  <div class="col-12">
            <label class="form-label" for="upload_doc_8">Upload File Laporan 8</label>
            <div class="input-group">
			  <input class="form-control upload_file_docs" type="file" id="upload_doc_8" name="upload_doc_8" rowz="8" />
			  
			  <a href="" id="report_show_8" target="_blank"><button class="btn btn-outline-primary" type="button">Show</button></a>
            </div>
			<p id="error1_8" style="display:none; color:#FF0000; font-size: 10px;">Invalid File Format! File Format Must Be JPG, JPEG, PNG, & PDF.</p><p id="error2_8" style="display:none; color:#FF0000; font-size: 10px;">Maximum File Size Limit is 1MB.</p>
		  </div>
		  <div class="col-12">
            <label class="form-label" for="upload_doc_9">Upload File Laporan 9</label>
            <div class="input-group">
			  <input class="form-control upload_file_docs" type="file" id="upload_doc_9" name="upload_doc_9" rowz="9" />
			  
			  <a href="" id="report_show_9" target="_blank"><button class="btn btn-outline-primary" type="button">Show</button></a>
            </div>
			<p id="error1_9" style="display:none; color:#FF0000; font-size: 10px;">Invalid File Format! File Format Must Be JPG, JPEG, PNG, & PDF.</p><p id="error2_9" style="display:none; color:#FF0000; font-size: 10px;">Maximum File Size Limit is 1MB.</p>
		  </div>
		  <div class="col-12">
            <label class="form-label" for="upload_doc_10">Upload File Laporan 10</label>
            <div class="input-group">
			  <input class="form-control upload_file_docs" type="file" id="upload_doc_10" name="upload_doc_10" rowz="10" />
			  
			  <a href="" id="report_show_10" target="_blank"><button class="btn btn-outline-primary" type="button">Show</button></a>
            </div>
			<p id="error1_10" style="display:none; color:#FF0000; font-size: 10px;">Invalid File Format! File Format Must Be JPG, JPEG, PNG, & PDF.</p><p id="error2_10" style="display:none; color:#FF0000; font-size: 10px;">Maximum File Size Limit is 1MB.</p>
		  </div>
		  <div class="col-12">
            <label class="form-label" for="upload_doc_11">Upload File Laporan 11</label>
            <div class="input-group">
			  <input class="form-control upload_file_docs" type="file" id="upload_doc_11" name="upload_doc_11" rowz="11" />
			  
			  <a href="" id="report_show_11" target="_blank"><button class="btn btn-outline-primary" type="button">Show</button></a>
            </div>
			<p id="error1_11" style="display:none; color:#FF0000; font-size: 10px;">Invalid File Format! File Format Must Be JPG, JPEG, PNG, & PDF.</p><p id="error2_11" style="display:none; color:#FF0000; font-size: 10px;">Maximum File Size Limit is 1MB.</p>
		  </div>
		  <div class="col-12">
            <label class="form-label" for="upload_doc_12">Upload File Laporan 12</label>
            <div class="input-group">
			  <input class="form-control upload_file_docs" type="file" id="upload_doc_12" name="upload_doc_12" rowz="12" />
			  
			  <a href="" id="report_show_12" target="_blank"><button class="btn btn-outline-primary" type="button">Show</button></a>
            </div>
			<p id="error1_12" style="display:none; color:#FF0000; font-size: 10px;">Invalid File Format! File Format Must Be JPG, JPEG, PNG, & PDF.</p><p id="error2_12" style="display:none; color:#FF0000; font-size: 10px;">Maximum File Size Limit is 1MB.</p>
		  </div>
		  <div class="col-sm-6">
            <label class="switch switch-square">
              <input type="checkbox" class="switch-input" value="1" id="sta_verifikasi" name="sta_verifikasi" />
              <span class="switch-toggle-slider">
                <span class="switch-on" style="top:20%"><i class="bx bx-check"></i></span>
                <span class="switch-off" style="top:20%"><i class="bx bx-x"></i></span>
              </span>
              <span class="switch-label">Verifikasi Laporan</span>
            </label>
		  </div>
		  <div class="col-12">
            <div class="alert displaynone" id="responseMsg"></div>
			<div class='alert alert-danger mt-2 d-none text-danger' id="err_file"></div>
		  </div>
          <div class="col-12">
            <button type="submit" id="submit_report" class="btn btn-primary me-sm-3 me-1">Submit</button>
            <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!--/ Modal Report 1 -->

<!-- Modal Chart-->
<div class="modal fade" id="modalChart" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-simple modal-enable-otp modal-dialog-centered">
    <div class="modal-content p-3 p-md-5">
      <div class="modal-body">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        <div class="text-center mb-4">
          <h3 class="mb-4">Activity Report</h3>
		  <input class="form-control" type="hidden" id="no_event_gr" name="no_event_gr" /> 
        </div>
        <!--<h6 id="no_event_p2">No. Event :</h6>-->
		<div class="col-12">
			<table>
				<tr>
				  <td class="" style="width: 100%;"><h5 class="" id="no_event_dt"></h5></td>
				  <td class="text-right"><h1 class="" id="grade_dt"></h1></td>
				</tr>
			</table>
			<div class="col-md-12">
				<table>
				  <tbody>
					<tr>
					  <td class="pe-3">Kategori</td>
					  <td>:<td/>
					  <td id="kategori_dt"></td>
					</tr>
					<tr>
					  <td class="pe-3">Tipe Kegiatan</td>
					  <td>:<td/>
					  <td id="tipe_dt"></td>
					</tr>
					<tr>
					  <td class="pe-3">Cabang</td>
					  <td>:<td/>
					  <td id="cabang_dt"></td>
					</tr>
					<tr>
					  <td class="pe-3">Nama Supervisor</td>
					  <td>:<td/>
					  <td id="spv_dt"></td>
					</tr>
					<tr>
					  <td class="pe-3">Tanggal Kegiatan</td>
					  <td>:<td/>
					  <td id="tanggal_dt"></td>
					</tr>
					<tr>
					  <td class="pe-3">Lokasi Kegiatan</td>
					  <td>:<td/>
					  <td id="lokasi_dt"></td>
					</tr>
					<tr>
					  <td class="pe-3">Tipe Kendaraan</td>
					  <td>:<td/>
					  <td id="kendaraan_dt"></td>
					</tr>
					<tr>
					  <td class="pe-3">Total Biaya</td>
					  <td>:<td/>
					  <td id="total_dt"></td>
					</tr>
				  </tbody>
				</table>
			</div>
		</div>
		<br />
		<div class="col-12">
			<div class="card">
				<h5 class="card-header" style="padding: 0.3rem 0.3rem !important;">Biaya Per Unit</h5>
				  <div class="table-responsive text-nowrap">
					<table class="table">
					  <thead>
						<tr>
						  <th>&nbsp;</th>
						  <th>Target</th>
						  <th>Pencapaian</th>
						</tr>
					  </thead>
					  <tbody class="table-border-bottom-0">
						<tr>
						  <td><strong>Database</strong></td>
						  <td><font size="2" id="db_tg"></font></td>
						  <td><font size="2" id="db_acv"></font></td>
						</tr>
						<tr>
						  <td><strong>Prospek</strong></td>
						  <td><font size="2" id="prospek_tg"></font></td>
						  <td><font size="2" id="prospek_acv"></font></td>
						</tr>
						<tr>
						  <td><strong>SPK</strong></td>
						  <td><font size="2" id="spk_tg"></font></td>
						  <td><font size="2" id="spk_acv"></font></td>
						</tr>
					  </tbody>
					</table>
				  </div>
			</div>
		</div>
		<br />
		<div class="col-12">
			<canvas id="grafik_capai" class="chartjs"></canvas>
		</div>
      </div>
    </div>
  </div>
</div>
<!--/ Modal Chart -->

<!-- Modal Cancel -->
<div class="modal fade" id="modalCancel" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-simple modal-enable-otp modal-dialog-centered">
    <div class="modal-content p-3 p-md-5">
      <div class="modal-body">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        <div class="text-center mb-4">
          <h3 class="mb-4">Cancel Event</h3>
        </div>
        <h6 id="no_event_c">No. Event :</h6>
        <form id="cancel_event_f" class="row g-3 mt-3" action="" enctype="multipart/form-data" method="POST" autocomplete="off">
          <div class="col-12">
            <label class="form-label" for="keterangan_cancel">Keterangan Cancel</label>
            <!--<div class="input-group">-->
			  <textarea class="form-control" id="keterangan_cancel" name="keterangan_cancel" rows="2"></textarea>
			  <input class="form-control" type="hidden" id="no_event_clc" name="no_event_clc" /> 
            <!--</div>-->
			<div class="alert displaynone" id="responseMsg_clc"></div>
			<div class='alert alert-danger mt-2 d-none text-danger' id="err_clc"></div>
		  </div>
          <div class="col-12">
            <button type="submit" id="sub_cacl" class="btn btn-primary me-sm-3 me-1">Submit</button>
            <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close">Close</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!--/ Modal Cancel -->

<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>

<script>
$(document).ready(function() {
	
	var cloc = '<?=$cloc;?>';
	$('#modalReport1').modal({ show: false});
	$('#responseMsg').hide();
	$('#err_file').hide();
	$('#report_show_1').hide();
	$('#report_show_2').hide();
	$('#report_show_3').hide();
	$('#report_show_4').hide();
	$('#report_show_5').hide();
	$('#report_show_6').hide();
	$('#report_show_7').hide();
	$('#report_show_8').hide();
	$('#report_show_9').hide();
	$('#report_show_10').hide();
	$('#report_show_11').hide();
	$('#report_show_12').hide();
	$('#modalChart').modal({ show: false});
	$('#modalCancel').modal({ show: false});
	
	$('#tgl_mulai').change(function() {
		
		var date_m = $(this).val();
		
		if(date_m != ''){
			//console.log(date_m);
			//$('#tgl_selesai').min = "2022-10-31";
			var x = document.getElementById("tgl_selesai").min = date_m;
			$('#tgl_selesai').val('');
		}

	});

});
</script>

<script>
	function model_report(nmr_event, file1, file2, file3, file4, file5, file6, file7, file8, file9, file10, file11, file12, sta_verifikasi, all_ver){
		
		
		$('#no_event_p').text('No. Event : '+nmr_event);
		
		$('#modalReport1').modal('show');
		
		$('#no_event').val(nmr_event);
		
		$('#responseMsg').hide();
		$('#err_file').hide();
		$('#report_show_1').hide();
		$('#report_show_2').hide();
		$('#report_show_3').hide();
		$('#report_show_4').hide();
		$('#report_show_5').hide();
		$('#report_show_6').hide();
		$('#report_show_7').hide();
		$('#report_show_8').hide();
		$('#report_show_9').hide();
		$('#report_show_10').hide();
		$('#report_show_11').hide();
		$('#report_show_12').hide();
		
		if(file1 != ""){
			$('#report_show_1').show();
			$('#report_show_1').attr('href',file1);
		}else{
			$('#report_show_1').hide();
			$('#report_show_1').attr('href','#');
		}
		
		if(file2 != ""){
			$('#report_show_2').show();
			$('#report_show_2').attr('href',file2);
		}else{
			$('#report_show_2').hide();
			$('#report_show_2').attr('href','#');
		}
		
		if(file3 != ""){
			$('#report_show_3').show();
			$('#report_show_3').attr('href',file3);
		}else{
			$('#report_show_3').hide();
			$('#report_show_3').attr('href','#');
		}
		
		if(file4 != ""){
			$('#report_show_4').show();
			$('#report_show_4').attr('href',file4);
		}else{
			$('#report_show_4').hide();
			$('#report_show_4').attr('href','#');
		}
		
		if(file5 != ""){
			$('#report_show_5').show();
			$('#report_show_5').attr('href',file5);
		}else{
			$('#report_show_5').hide();
			$('#report_show_5').attr('href','#');
		}
		
		if(file6 != ""){
			$('#report_show_6').show();
			$('#report_show_6').attr('href',file6);
		}else{
			$('#report_show_6').hide();
			$('#report_show_6').attr('href','#');
		}
		
		if(file7 != ""){
			$('#report_show_7').show();
			$('#report_show_7').attr('href',file7);
		}else{
			$('#report_show_7').hide();
			$('#report_show_7').attr('href','#');
		}
		
		if(file8 != ""){
			$('#report_show_8').show();
			$('#report_show_8').attr('href',file8);
		}else{
			$('#report_show_8').hide();
			$('#report_show_8').attr('href','#');
		}
		
		if(file9 != ""){
			$('#report_show_9').show();
			$('#report_show_9').attr('href',file9);
		}else{
			$('#report_show_9').hide();
			$('#report_show_9').attr('href','#');
		}
		
		if(file10 != ""){
			$('#report_show_10').show();
			$('#report_show_10').attr('href',file10);
		}else{
			$('#report_show_10').hide();
			$('#report_show_10').attr('href','#');
		}
		
		if(file11 != ""){
			$('#report_show_11').show();
			$('#report_show_11').attr('href',file11);
		}else{
			$('#report_show_11').hide();
			$('#report_show_11').attr('href','#');
		}
		
		if(file12 != ""){
			$('#report_show_12').show();
			$('#report_show_12').attr('href',file12);
		}else{
			$('#report_show_12').hide();
			$('#report_show_12').attr('href','#');
		}
		
		if(sta_verifikasi == '1'){
			$('#sta_verifikasi').prop('checked', true);
			if ($('#submit_report').attr('disabled',false)){
				$('#submit_report').attr('disabled',true);
			}
		}else{
			$('#sta_verifikasi').prop('checked', false);
			if ($('#submit_report').attr('disabled',true)){
				$('#submit_report').attr('disabled',false);
			}
		}
		
		if(all_ver != '1' || sta_verifikasi == '1'){
			if ($('#sta_verifikasi').attr('disabled',false)){
				$('#sta_verifikasi').attr('disabled',true);
			}
		}else{
			if ($('#sta_verifikasi').attr('disabled',true)){
				$('#sta_verifikasi').attr('disabled',false);
			}
		}
    }
</script>

<script>
  $(document).ready(function(){
	//binds to onchange event of your input field
	$(document).on('change', '.upload_file_docs', function(){
		var a=0;
		//var rowz = 'r';
		var rowz = $(this).attr('rowz');
		
		if ($('#submit_report').attr('disabled',false)){
			$('#submit_report').attr('disabled',true);
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
				
				var report_file = document.getElementsByClassName("upload_file_docs");
				var all = 0;
				for(i=1; i<=report_file.length; i++){
					//console.log('file '+i);
					if($('#upload_doc_'+i)[0].files.length > 0){
						//console.log('ada file');
						var ext_all = $('#upload_doc_'+i).val().split('.').pop().toLowerCase();
						if ($.inArray(ext, ['png','jpg','jpeg', 'pdf']) == -1){
							all++;
						}else{
							var picsize = ($('#upload_doc_'+i)[0].files[0].size);
							if (picsize > 1000000){
								all++;
							}
						}
					}
				}
				//console.log($('#sta_verifikasi').is(":checked"));
				if(all == 0 && !$('#sta_verifikasi').is(":checked")){
					$('#submit_report').attr('disabled',false);
				}
				
			}
		}
	});
  });
</script>

<script>
$(document).ready(function(){
  $("#upload_report").submit(function (event) {
	var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
	var files1 = $('#upload_doc_1')[0].files;
	var files2 = $('#upload_doc_2')[0].files;
	var files3 = $('#upload_doc_3')[0].files;
	var files4 = $('#upload_doc_4')[0].files;
	var files5 = $('#upload_doc_5')[0].files;
	var files6 = $('#upload_doc_6')[0].files;
	var files7 = $('#upload_doc_7')[0].files;
	var files8 = $('#upload_doc_8')[0].files;
	var files9 = $('#upload_doc_9')[0].files;
	var files10 = $('#upload_doc_10')[0].files;
	var files11 = $('#upload_doc_11')[0].files;
	var files12 = $('#upload_doc_12')[0].files;
	var sta_verifikasi = '';
	var no_event = $('#no_event').val();
	
	if($('#sta_verifikasi').is(":checked")){
		sta_verifikasi = '1';
	}
	
	//console.log(sta_verifikasi);
	
	if(files1.length > 0 || files2.length > 0 || files3.length > 0 || files4.length > 0 || files5.length > 0 || files6.length > 0 || files7.length > 0 || files8.length > 0 || files9.length > 0 || files10.length > 0 || files11.length > 0 || files12.length > 0 || sta_verifikasi > 0){
		
		var formData = new FormData();
		
		formData.append('file_report1',files1[0]);
		formData.append('file_report2',files2[0]);
		formData.append('file_report3',files3[0]);
		formData.append('file_report4',files4[0]);
		formData.append('file_report5',files5[0]);
		formData.append('file_report6',files6[0]);
		formData.append('file_report7',files7[0]);
		formData.append('file_report8',files8[0]);
		formData.append('file_report9',files9[0]);
		formData.append('file_report10',files10[0]);
		formData.append('file_report11',files11[0]);
		formData.append('file_report12',files12[0]);
        formData.append('_token',CSRF_TOKEN);
		formData.append('sta_verifikasi',sta_verifikasi);
		formData.append('no_event',no_event);
		
		$.ajax({
		  type: "POST",
		  url: "/proses_upload_report",//"/proses_upload_report",
		  data: formData,
		  dataType: "json",
		  contentType: false,
          processData: false,
		  success: function(response){
			  
			console.log(response);
			  
			if(response.status == 1){ // Uploaded successfully
				
				$('#responseMsg').removeClass("alert-danger");
				$('#responseMsg').addClass("alert-success");
				$('#responseMsg').html(response.msg_rsp);
				$('#responseMsg').show();
				
				if(response.nama_file1 != ''){
					$('#report_show_1').attr('href',response.nama_file1);
					$('#report_show_1').show();
				}
				
				if(response.nama_file2 != ''){
					$('#report_show_2').attr('href',response.nama_file2);
					$('#report_show_2').show();
				}
				
				if(response.nama_file3 != ''){
					$('#report_show_3').attr('href',response.nama_file3);
					$('#report_show_3').show();
				}
				
				if(response.nama_file4 != ''){
					$('#report_show_4').attr('href',response.nama_file4);
					$('#report_show_4').show();
				}
				
				if(response.nama_file5 != ''){
					$('#report_show_5').attr('href',response.nama_file5);
					$('#report_show_5').show();
				}
				
				if(response.nama_file6 != ''){
					$('#report_show_6').attr('href',response.nama_file6);
					$('#report_show_6').show();
				}
				
				if(response.nama_file7 != ''){
					$('#report_show_7').attr('href',response.nama_file7);
					$('#report_show_7').show();
				}
				
				if(response.nama_file8 != ''){
					$('#report_show_8').attr('href',response.nama_file8);
					$('#report_show_8').show();
				}
				
				if(response.nama_file9 != ''){
					$('#report_show_9').attr('href',response.nama_file9);
					$('#report_show_9').show();
				}
				
				if(response.nama_file10 != ''){
					$('#report_show_10').attr('href',response.nama_file10);
					$('#report_show_10').show();
				}
				
				if(response.nama_file11 != ''){
					$('#report_show_11').attr('href',response.nama_file11);
					$('#report_show_11').show();
				}
				
				if(response.nama_file12 != ''){
					$('#report_show_12').attr('href',response.nama_file12);
					$('#report_show_12').show();
				}
				
				if(response.sta_verifikasi == '1'){
					if ($('#submit_report').attr('disabled',false)){
						$('#submit_report').attr('disabled',true);
					}
					if ($('#sta_verifikasi').attr('disabled',false)){
						$('#sta_verifikasi').attr('disabled',true);
					}
				}
				$('.datatables-ajax').DataTable().ajax.reload();
				
			}else if(response.status == 2){ 
				$('#responseMsg').removeClass("alert-success");
				$('#responseMsg').addClass("alert-danger");
				$('#responseMsg').html(response.msg_rsp);
				$('#responseMsg').show();
			}

		  },
		  error: function(response){
              console.log("error : " + JSON.stringify(response) );
			  $('#err_file').text(response.error);
			  $('#err_file').show();
          }
		});
	
	}else{
         alert("Input salah satu file report / Verifikasi laporan");
    }

    event.preventDefault();
  });
});
</script>

<script>
	function model_show_chart(nmr_event){
		
		//$('#no_event_p2').text('No. Event : '+nmr_event);
		$('#modalChart').modal('show');
		$('#no_event_gr').val(nmr_event);

		$.getJSON("/get_grafik_ach_event?nmr_event="+nmr_event, function(data){
			
			//console.log(barChart);
			//barChart.options.plugins.title = 'No. Event : '+nmr_event;
			//barChart.data.datasets[0].data = data.target;
			//barChart.data.datasets[1].data = data.achiv;
			//barChart.update();
			
			$('#no_event_dt').text(nmr_event);
			$('#kategori_dt').text(data.kategori);
			$('#tipe_dt').text(data.tipe);
			$('#cabang_dt').text(data.cabang);
			$('#spv_dt').text(data.spv);
			$('#tanggal_dt').text(data.tanggal);
			$('#lokasi_dt').text(data.lokasi);
			$('#kendaraan_dt').text(data.kendaraan);
			$('#grade_dt').html(data.grade);
			$('#total_dt').html(data.total);
			$('#db_tg').text(data.per_database_tg);
			$('#db_acv').text(data.per_database_ac);
			$('#prospek_tg').text(data.per_prospek_tg);
			$('#prospek_acv').text(data.per_prospek_ac);
			$('#spk_tg').text(data.per_spk_tg);
			$('#spk_acv').text(data.per_spk_ac);
			
			renderChart(data.target, data.achiv, 'No. Event : '+nmr_event);
		});
		
    }
</script>

<script>
function renderChart(data_tar, data_ach, labels) {
	const purpleColor = '#836AF9',
		yellowColor = '#ffe800',
		cyanColor = '#28dac6',
		orangeColor = '#FF8132',
		orangeLightColor = '#FDAC34',
		oceanBlueColor = '#299AFF',
		greyColor = '#4F5D70',
		greyLightColor = '#EDF1F4',
		blueColor = '#2B9AFF',
		blueLightColor = '#84D0FF';

	  let borderColor, axisColor;

	  if (isDarkStyle) {
		borderColor = config.colors_dark.borderColor;
		axisColor = config.colors_dark.axisColor; // x & y axis tick color
	  } else {
		borderColor = config.colors.borderColor; // same as template border color
		axisColor = config.colors.axisColor; // x & y axis tick color\
	  }
	
	const barChart = document.getElementById('grafik_capai');
	
	let chartStatus = Chart.getChart("grafik_capai"); // <canvas> id	
	if(chartStatus != undefined) {
	  chartStatus.destroy();
	}
	
	var max_t = Math.max(...data_tar);
	var max_ach = Math.max(...data_ach);
	var max__ = 0;
	if(max_t >= max_ach){
		max__ = max_t+5;
	}else{
		max__ = max_ach+5;
	}
	
	if(barChart){
		
		const barChartVar = new Chart(barChart, {
		  type: 'bar',
		  data: {
			labels: [
			  'Database',
			  'Prospek',
			  /*'SPK OTS',
			  'SPK Follow UP'*/
			  'SPK'
			],
			datasets: [
			  /*{
				data: [275, 90, 190, 205, 125, 85, 55, 87],
				backgroundColor: cyanColor,
				borderColor: 'transparent',
				maxBarThickness: 15,
				borderRadius: {
				  topRight: 15,
				  topLeft: 15
				}
			  }*/
			  {
				label: 'Target',
				data: data_tar,
				borderColor: orangeColor,
				backgroundColor: orangeLightColor,
				borderWidth: 2,
				borderRadius: 5,
				borderSkipped: false
			  },
			  {
				label: 'Pencapaian',
				data: data_ach,
				borderColor: blueColor,
				backgroundColor: blueLightColor,
				borderWidth: 2,
				borderRadius: 5,
				borderSkipped: false
			  }
			]
		  },
		  plugins: [ChartDataLabels],
		  options: {
			responsive: true,
			maintainAspectRatio: false,
			animation: {
			  duration: 500
			},
			plugins: {
			  tooltip: {
				rtl: isRtl,
				backgroundColor: config.colors.white,
				titleColor: config.colors.black,
				bodyColor: config.colors.black,
				borderWidth: 1,
				borderColor: borderColor
			  },
			  legend: {
				 position: 'bottom',
				 labels: {
					 color: axisColor
				 }
			  },
			  title: {
				display: true,
				text: '',
				color: axisColor
			  },
			  datalabels: {
				color:'blue',
				anchor:'end',
				align:'top',
				offset: 0
			  }
			},
			scales: {
			  x: {
				grid: {
				  color: borderColor,
				  borderColor: borderColor
				},
				ticks: {
				  color: axisColor
				}
			  },
			  y: {
				min: 0,
				//max: max__,
				grid: {
				  color: borderColor,
				  borderColor: borderColor
				},
				ticks: {
				  //stepSize: 100,
				  tickColor: borderColor,
				  color: axisColor
				}
			  }
			}
		  }
		});
		
	}
}
</script>

<script>
	function model_cancel_event(nmr_event){
		
		$('#no_event_c').text('No. Event : '+nmr_event);
		
		$('#modalCancel').modal('show');

		$('#no_event_clc').val(nmr_event);
		
		$('#responseMsg_clc').hide();
		$('#err_clc').hide();
		
		$('#sub_cacl').attr('disabled',false);
    }
</script>

<script>
$(document).ready(function(){
  $("#cancel_event_f").submit(function (event) {
	var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
	var no_event_clc = $('#no_event_clc').val();
	var keterangan_cancel = $('#keterangan_cancel').val();
	
	//console.log(keterangan_cancel);
	
	if(keterangan_cancel != ""){
		
		var formData = new FormData();
		
        formData.append('_token',CSRF_TOKEN);
		formData.append('keterangan_cancel',keterangan_cancel);
		formData.append('no_event_clc',no_event_clc);
		
		$.ajax({
		  type: "POST",
		  url: "/proses_cancel_report",//"/proses_cancel_report",
		  data: formData,
		  dataType: "json",
		  contentType: false,
          processData: false,
		  success: function(response){
			  
			//console.log(response);
			  
			if(response.status == 1){ // Uploaded successfully
				
				$('#responseMsg_clc').removeClass("alert-danger");
				$('#responseMsg_clc').addClass("alert-success");
				$('#responseMsg_clc').html(response.msg_rsp);
				$('#responseMsg_clc').show();
				
				$('#sub_cacl').attr('disabled',true);
				$('.datatables-ajax').DataTable().ajax.reload();
				
			}else if(response.status == 2){ 
				$('#responseMsg_clc').removeClass("alert-success");
				$('#responseMsg_clc').addClass("alert-danger");
				$('#responseMsg_clc').html(response.msg_rsp);
				$('#responseMsg_clc').show();
			}
		  },
		  error: function(response){
              console.log("error : " + JSON.stringify(response) );
			  $('#err_clc').text(response.error);
			  $('#err_clc').show();
          }
		});
	
	}else{
         alert("Harap mengisi Alasan Cancel");
    }

    event.preventDefault();
  });
});
</script>

@endsection