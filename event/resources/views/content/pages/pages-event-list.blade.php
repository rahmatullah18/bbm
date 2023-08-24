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
          <h3 class="mb-4" id="header_report">Upload Dokumen Laporan 1</h3>
        </div>
        <h6 id="no_event_p">No. Event :</h6>
        <!--<p>Enter your mobile phone number with country code and we will send you a verification code.</p>-->
        <form id="upload_report" class="row g-3 mt-3" action="" enctype="multipart/form-data" method="POST" autocomplete="off">
          <div class="col-12">
            <label class="form-label" for="upload_doc_report">Upload File Laporan</label>
            <div class="input-group">
			  <input class="form-control upload_file_docs" type="file" id="upload_doc_report" name="upload_doc_report" />
			  
			  <a href="" id="report_show_" target="blank"><button class="btn btn-outline-primary" type="button" id="report_show">Show</button></a>
			  <input class="form-control" type="hidden" id="no_report" name="no_report" />
			  <input class="form-control" type="hidden" id="no_event" name="no_event" /> 
            </div>
			<p id="error1_r" style="display:none; color:#FF0000; font-size: 10px;">Invalid File Format! File Format Must Be JPG, JPEG, PNG, & PDF.</p><p id="error2_r" style="display:none; color:#FF0000; font-size: 10px;">Maximum File Size Limit is 1MB.</p>
			<div class="alert displaynone" id="responseMsg"></div>
			<div class='alert alert-danger mt-2 d-none text-danger' id="err_file"></div>
		  </div>
          <div class="col-12">
            <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
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

<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>

<script>
$(document).ready(function() {
	
	var cloc = '<?=$cloc;?>';
	$('#modalReport1').modal({ show: false});
	$('#responseMsg').hide();
	$('#err_file').hide();
	$('#report_show_').hide();
	$('#modalChart').modal({ show: false});
	
});
</script>

<script>
	function model_report(no, nmr_event, file){
		
		
		$('#no_event_p').text('No. Event : '+nmr_event);
		//$('#header_report').text('Upload Dokumen Laporan '+no);
		$('#header_report').text('Upload Dokumen Laporan');
		
		$('#modalReport1').modal('show');
		
		$('#no_report').val(no);
		$('#no_event').val(nmr_event);
		
		$('#responseMsg').hide();
		$('#err_file').hide();
		$('#report_show_').hide();
		
		if(file != ""){
			$('#report_show_').show();
			$('#report_show_').attr('href',file);
		}else{
			$('#report_show_').hide();
			$('#report_show_').attr('href','#');
		}
    }
</script>

<script>
  $(document).ready(function(){
	//binds to onchange event of your input field
	$(document).on('change', '.upload_file_docs', function(){
		var a=0;
		var rowz = 'r';

		if ($('button:submit').attr('disabled',false)){
			$('button:submit').attr('disabled',true);
		}
		
		var ext = $('#upload_doc_report').val().split('.').pop().toLowerCase();
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
  $("#upload_report").submit(function (event) {
	var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
	var files = $('#upload_doc_report')[0].files;
	var no_report = $('#no_report').val();
	var no_event = $('#no_event').val();
	
	if(files.length > 0){
		
		var formData = new FormData();
		
		formData.append('file_report',files[0]);
        formData.append('_token',CSRF_TOKEN);
		formData.append('no_report',no_report);
		formData.append('no_event',no_event);
		
		$.ajax({
		  type: "POST",
		  url: "/proses_upload_report",
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
				
				$('#report_show_').attr('href',response.nama_file);
				$('#report_show_').show();
				
			}else if(response.status == 2){ 
				$('#responseMsg').removeClass("alert-success");
				$('#responseMsg').addClass("alert-danger");
				$('#responseMsg').html(response.message);
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
         alert("Please select a file.");
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

@endsection