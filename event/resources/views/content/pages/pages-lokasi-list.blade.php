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
				  <!-- <tbody id="table_row">
				  </tbody> -->
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
	
	// $.ajax({
	// 	url: '/bbm/get-list-lokasi',
	// 	type: "get",
	// 	success: function (data) {
	// 		$("#table_row").html(data);
	// 	}
	// 	// error: function () {
	// 	// 	$("#loader"+id).hide();
	// 	// 	console.log("Error bosku");
	// 	// }
	// });

});
</script>

@endsection