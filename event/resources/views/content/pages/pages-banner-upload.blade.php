@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Managemen Event')

@section('vendor-style')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/dropzone/dropzone.css')}}" />
@endsection

@section('vendor-script')
<script src="{{asset('assets/vendor/libs/dropzone/dropzone.js')}}"></script>
@endsection

@section('page-script')
<script src="{{asset('assets/js/forms-file-upload-banner.js')}}"></script>
@endsection

@section('content')
<h4 class="py-3 breadcrumb-wrapper mb-4">
  <span class="text-muted fw-light">Banner Event /</span> Upload Banner Baru
</h4>

<div class="row">
  <!-- Basic  -->
  <div class="col-12">
    <div class="card mb-4">
      <h5 class="card-header">Pilih Gambar</h5>
      <div class="card-body">
        <form  action="{{url('/proses-upload-banner')}}" enctype="multipart/form-data" method="POST" autocomplete="off"  id="dropzone-basic">
		{{ csrf_field() }}
          <div class="col-md-12">
          <div class="row">
            <div class="col-md p-3">
              <label class="form-label fw-bold">Nama / Keterangan Banner</label>
              <input type="text" class="form-control" id="cnama_gambar" name="cnama_gambar" placeholder="Nama / Keterangan" aria-describedby="defaultFormControlHelp" value="" required/>
            </div>
          </div>
          <div class="row">
            <div class="col-md p-3">
              <label for="kota" class="form-label fw-bold">URL Link Banner</label>
              <input type="text" class="form-control" id="curl_link" name="curl_link" placeholder="URL Link Banner" aria-describedby="defaultFormControlHelp" value="" required/>
            </div>
          </div>
          <div class="row">
            <div class="col-md p-3">
              <label for="formFile" class="form-label"><Strong>File Gambar</strong> (Gambar harus berukuran 1000 x 500 px)</label>
              <input class="form-control" type="file" id="formFile" name="file_image" required>
            </div>
          </div>
          <div class="row" id="row_preview" hidden>
            <div class="col-md p-3">
              <label id="label_preview" for="img_output" class="form-label fw-bold">Preview</label>
              <img id="img_output"  style="width:100%" src=""/>
            </div>
          </div>
          <br/>
          <div class="row justify-content-center">
            <!-- <div class="col-4"> -->
              <button style="width:100px;" type="submit" class="btn btn-primary">Upload</button>
            <!-- </div> -->
          </div>
        </form>
		</div>
      </div>
    </div>
  </div>
  <!-- /Basic  -->
</div>

<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>

<script>
$("#formFile").change(function(e) {
	var _URL = window.URL || window.webkitURL;

    var file, img;
    var allowedExtensions = /(\.jpg|\.JPG|\.jpeg|\.JPEG|\.png|\.PNG|\.webp)$/i;
    var output = document.getElementById('img_output');

    if ((file = this.files[0])) {
        img = new Image();
        img.onload = function() {
            // alert(this.width + " " + this.height);
            var fileInput =
            document.getElementById('formFile');
              
            var filePath = fileInput.value;
          
            // Allowing file type
            var allowedExtensions = /(\.jpg|\.JPG|\.jpeg|\.JPEG|\.png|\.PNG|\.webp)$/i;
              
            if (!allowedExtensions.exec(filePath)) {
                alert('File yang dipilih harus berformat gambar.');
                $("#formFile").val(null);
                output.src = "";
                document.getElementById('row_preview').hidden = true;
            }else{
              if(!(this.width == 1000 && this.height == 500)){
                alert("Gambar harus berukuran 1000 x 500 px!");
                $("#formFile").val(null);
                output.src = "";
                document.getElementById('row_preview').hidden = true;
              }else{
                output.src = _URL.createObjectURL(file);
                document.getElementById('row_preview').hidden = false;
              }
            }
            
        };
        img.onerror = function() {
            alert( "File yang dipilih harus berformat gambar.");
            $("#formFile").val(null);
            output.src = "";
            document.getElementById('row_preview').hidden = true;
        };
        img.src = _URL.createObjectURL(file);


    }

});
// function fileValidation() {
//     var fileInput =
//         document.getElementById('formFile');
      
//     var filePath = fileInput.value;
  
//     // Allowing file type
//     var allowedExtensions = /(\.jpg|\.JPG|\.jpeg|\.JPEG|\.png|\.PNG|\.webp)$/i;
      
//     if (!allowedExtensions.exec(filePath)) {
//         alert('File yang dipilih harus berformat gambar.');
//         fileInput.value = '';
//         return false;
//     }else{
//       alert($("#formFile").files[0].width + " " + $("#formFile").files[0].height);
//     }
// }
function updateNamaLink(){
	var t = document.getElementById("ket").value;
	document.getElementById("cnama_gambar").value = t;
	var t1 = document.getElementById("url_link").value;
	document.getElementById("curl_link").value = t1;
}

function submitForm(){
	document.getElementById("dropzone-basic").submit();
}
</script>
@endsection
