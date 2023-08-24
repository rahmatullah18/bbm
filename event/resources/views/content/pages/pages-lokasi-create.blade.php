@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Buat Lokasi Baru')

@section('vendor-style')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/tagify/tagify.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/bootstrap-select/bootstrap-select.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/typeahead-js/typeahead.css')}}" />
@endsection

@section('vendor-script')
<script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>
<script src="{{asset('assets/vendor/libs/tagify/tagify.js')}}"></script>
<script src="{{asset('assets/vendor/libs/bootstrap-select/bootstrap-select.js')}}"></script>
<script src="{{asset('assets/vendor/libs/typeahead-js/typeahead.js')}}"></script>
<script src="{{asset('assets/vendor/libs/bloodhound/bloodhound.js')}}"></script>
@endsection

@section('page-script')
<!--<script src="{{asset('assets/js/form-basic-inputs.js')}}"></script>-->
<script src="{{asset('assets/js/forms-selects.js')}}"></script>
<script src="{{asset('assets/js/forms-tagify.js')}}"></script>
<script src="{{asset('assets/js/forms-typeahead.js')}}"></script>
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
      <h5 class="card-header">Buat Lokasi Baru</h5>
      <div class="card-body">
		<form class="browser-default-validation" id="form_input_claim" action="{{url('/proses_create_lokasi')}}" enctype="multipart/form-data" method="POST" autocomplete="off">
		{{ csrf_field() }}
		<div class="col-md-12">
			<div class="row col-md-8">
				<div class="col-md p-4">
					<label class="form-label fw-bold">Nama Lokasi</label>
					<input type="text" class="form-control" id="nama_lokasi" name="nama_lokasi" placeholder="Nama Lokasi" aria-describedby="defaultFormControlHelp" value="" required/>
				</div>
				<div class="col-md p-4">
					<label for="kota" class="form-label fw-bold">Kota</label>
					<select class="select2 form-select form-select-lg" id="kota" name="kota" aria-label="Pilih Kota Lokasi" data-allow-clear="true" required>
						<option selected value="">Pilih Kota</option>
						<!--<option value="MKS">Makassar</option>
						<option value="MRS">Maros</option>
						<option value="PRT">KIma</option>-->
						
						<?php
							
							//var_dump($cabang)
							
							foreach ($kota as $row) {
								echo "<option value='".$row['CityCode']."'>".$row['CityName']."</option>";;
							}
							
						?>
						
					</select>
				</div>
			</div>
			<div class="row col-md-8">
				<div class="col-md-12 p-4">
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
	//console.log('jalanja');
	
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
			document.getElementById("jumlah1_"+element_id).value = jumlah;
		  
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
  var nomor = document.getElementsByClassName("nomor");
  for(i=1; i<=nomor.length; i++){
    var cek = document.getElementById("harga_"+i).value;
	
	var qty = document.getElementById("qty_"+i).value.split(',').join("");
    qtys = parseFloat(qty);
	
	if(cek != '' && qty != 0 && !isNaN(qty)){
	
		var jml = document.getElementById("harga1_"+i).value;
		total_semua = (total_semua + (parseFloat(jml) * qtys));
	}
  }  
	  var bilangan = addCommas(total_semua);
	  document.getElementById("total").value = bilangan; 
	  
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
	  
	  if(prospek > 0){
	  
		per_prospek = total_semua / prospek; 
		var per_prospek_ = addCommas(per_prospek);
		document.getElementById("per_prspk").value = per_prospek_;
	  }else{
		document.getElementById("per_prspk").value = 0;
	  }
	  
	  //console.log(spk_otss+spk_fus);
	  if((spk_otss+spk_fus) > 0){
		per_spk = total_semua / (spk_otss+spk_fus);
		var per_spk_ = addCommas(per_spk);
		document.getElementById("per_spk").value = per_spk_; 
	  }else{
		document.getElementById("per_spk").value = 0;
	  }
}
</script>

<script>
$("#form_input_claim").submit(function(e){
	// var table = document.getElementById('item_event');
	// var rowCount = table.rows.length;
	
	// //console.log(rowCount);
	// if(rowCount != 0){
		if(confirm('Apakah anda ingin menyimpan data ?')){
			$('#simpan').prop('disabled', true);
			return true;
		}else{
			return false;
		}
		
		//return confirm('Apakah anda ingin menyimpan data ?');
	// }else{
	// 	alert("Klik 'Tambah Baris' untuk menambah item biaya.");
	// 	e.preventDefault();
	// }
});
</script>

<script>
  $(document).ready(function(){
	//binds to onchange event of your input field
  });
</script>

<!--<script>
  $(document).ready(function(){
    $(document).on('change', '#status', function(){
      var status = $('#status').val();
	  //alert(status);
	  
	  if(status == "2"){
		$("#cancelq").show();
		 document.getElementById("ket_cancel").required = true;
	  }else{
		 document.getElementById("ket_cancel").required = false;
		$("#cancelq").hide();
	  }
		
    });  
  });
</script>-->

@endsection