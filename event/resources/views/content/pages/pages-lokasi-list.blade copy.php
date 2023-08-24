@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Managemen Event')

@section('vendor-style')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/flatpickr/flatpickr.css')}}" />
@endsection

@section('vendor-script')
<script src="{{asset('assets/vendor/libs/datatables/jquery.dataTables.js')}}"></script>
<script src="{{asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js')}}"></script>
<script src="{{asset('assets/vendor/libs/datatables-responsive/datatables.responsive.js')}}"></script>
<script src="{{asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.js')}}"></script>
<!-- Flat Picker -->
<script src="{{asset('assets/vendor/libs/moment/moment.js')}}"></script>
<script src="{{asset('assets/vendor/libs/flatpickr/flatpickr.js')}}"></script>

@endsection

@section('page-script')
<script src="{{asset('assets/js/tables_list_lokasi.js')}}"></script>
@endsection

<style>
.input-error{
  outline: 1px solid red;
}
</style>

@section('content')
<h4 class="py-3 breadcrumb-wrapper mb-4">
  <span class="">Master Lokasi Event</span>
</h4>

<div class="row">
  <div class="col-md-12">
    <div class="card mb-4">
      <!--<h5 class="card-header">List Data Event</h5>-->
      <div class="card-body">
			<div class="card">
			  <h5 class="card-header">List Data Lokasi</h5>
			  <div class="card-datatable text-nowrap">
				<table class="datatables-ajax table table-bordered">
				  <thead>
					<tr>
					  <th>Kode Lokasi</th>
					  <th>Nama Lokasi</th>
					  <th>Provinsi</th>
					  <th>Kota</th>
					  <th>Status</th>
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

<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>

<script>
$(document).ready(function() {
	
	var cloc = '<?=$cloc;?>';
	$('#modalReport1').modal({ show: false})
	$('#responseMsg').hide();
	$('#err_file').hide();
	$('#report_show_').hide();
	
});
</script>

<script>
	function model_report(no, nmr_event, file){
		
		
		$('#no_event_p').text('No. Event : '+nmr_event);
		$('#header_report').text('Upload Dokumen Laporan '+no);
		
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
		  url: "/bbm/proses_upload_report",
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

@endsection