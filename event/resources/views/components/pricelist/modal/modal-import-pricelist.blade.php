@php
$cloc = session()->get('cloc');
@endphp
<div x-data="{
  isActiveTable : false,
  isLoadingSubmit: false,
  dataImport: [],
  nameFile:'',
  date:today,

  handleInputChange(){
    this.excelFile = $refs.excelInput.files[0]
    this.nameFile = excelFile.name
  },

  clearExcel(){
    excelFile = null;
    $refs.excelInput.value = '';
    this.nameFile = ''
  },

  filterPayloadImport(data){
    return data.map((item, idx) => {
      return {
        ...item,
        tgl_berlaku:this.date,
        kode_tipe: item.kode,
        persen_pph22: item.pph22,
        pph22: item.pph22_margin,
        catatan: item.disini,
      }
    })
  },

  async uploadFile(){
    isLoadingUploadFile = true
    let formData = new FormData();
    // jika kosong
    if(!excelFile || excelFile.length < 1){
      Swal.fire({
        icon: 'error',
        text: 'File tidak boleh kosong!',
        showConfirmButton: false,
        timer: 1500
      })
      isLoadingUploadFile = false
      return
    }
    formData.append('excel', excelFile);

    fetch(`${baseUrl}api/pricelist/import-pricelist`, {
      method: 'POST',
      body: formData
    }).then(res => res.json()).then(data => {
      // jika error == true
      if(data['error'] == true){
        Swal.fire({
          icon: 'error',
          title: 'Perhitungan gagal',
          text: 'Contact Tim IT',
          showConfirmButton: false,
          timer: 4000
        })
      return;
      } else if(!data[0].kode_tipe && !data[0].cabang && !data[0].tahun && !data[0].tebus && !data[0].deposit){
        throw 'gagal'
      }
      const filtered = this.filterPayloadImport(data)
      this.dataImport = filtered
      this.isActiveTable = true
    }).catch(err => {
      Swal.fire({
        icon: 'error',
        title: 'Format excel tidak cocok',
        text: 'Format excel tidak sesuai, silahkan download template untuk menyesuaian format excel',
        showConfirmButton: false,
        timer: 6000
      })
      this.clearExcel()
    }).finally(() => {
      // getDataDaftarHarga()
      isLoadingUploadFile = false
    })
  },
  submitForm(){
    Swal.fire({
      icon: 'question',
      title: 'Import Pricelist sekarang?',
      showConfirmButton: true,
      showCancelButton:true
      // timer: 6000
    }).then(async (result) => {
      if(result.isConfirmed){
        this.isLoadingSubmit = true
        const payload = this.dataImport
        const res = await fetchApi({
          url: 'master/price_unit/insert',
          method: 'POST',
          data: payload
        })

        if(!res.error){
          Swal.fire({
            icon: 'success',
            title: 'Data berhasil ditambahkan',
            showConfirmButton: false,
            timer: 2000
          })
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Data gagal ditambahkan',
            showConfirmButton: false,
            timer: 2000
          })
        }

        getDataPricelist()
        this.clearExcel()
        this.dataImport= []
        this.isActiveTable= false
        this.isLoadingSubmit = false
      }
    })
  },
  handleDrop(event) {
    console.log({event});
    const files = event.dataTransfer.files;
    if (files.length > 0) {
      $refs.excelInput.files = files;
      this.handleInputChange();
    }
  }
}">
  <div class="modal fade" data-bs-backdrop='static' id="modalImportPricelist" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
      <div class="modal-content position-relative editModalPricelist">
        <button type="button" class=" btn btn-danger btn-sm position-absolute" style="padding: 0.5px 1px; right:10px; top:10px;" data-bs-dismiss="modal" aria-label="Close" id="closeModalImportPricelist">
          <i class='bx bx-x'></i>
        </button>
        <div class="modal-header">
          <h1 class="modal-title fs-5">Import Daftar Harga</h1>
        </div>
        <div class="modal-body">
          {{-- table non active --}}
          <div x-show="!isActiveTable">
            <div class=" mb-2 d-flex justify-content-between  align-items-center " for="inputGroupFile02">
              <form action="{{url('/import-template')}}" method="POST">
                @csrf
                <button type="submit" class="btn btn-sm shadow-sm btn-success rounded-pill">
                  Template
                  <i class='bx bxs-download bx-xs'></i>
                </button>
              </form>

              <button class="btn p-0" x-on:click="clearExcel()">
                <i class='bx bx-reset'></i>
              </button>
            </div>

            <label for="fileExcel" class="labelFile" x-on:drop.prevent="handleDrop($event)" x-on:dragover.prevent>
              <div x-show="!excelFile || excelFile.length === 0">
                <div>
                  <x-icon.awan />
                  <p>Klik atau seret file ke sini</p>
                </div>
              </div>
              <div x-show="excelFile.lastModified">
                <div>
                  <x-icon.centang />
                  <p x-text="nameFile"></p>
                </div>
              </div>
            </label>

            <input id="fileExcel" type="file" x-ref="excelInput" x-on:change="handleInputChange()" class="inputFile" placeholder="pilih file" style="display:none" accept=".xls,.xlsx">

            <div class="d-flex justify-content-end mt-2">
              <button x-show="!isLoadingUploadFile" x-on:click="uploadFile()" type="button" class="btn btn-primary btn-sm rounded-pill shadow-sm " style="padding: 6px 16px">Tambah</button>
              <span x-show="isLoadingUploadFile">
                <x-loading-submit />
              </span>
            </div>
          </div>
          {{-- table active --}}
          <div x-show="isActiveTable">
            <div class="d-flex justify-content-between align-items-center">
              <span x-on:click="isActiveTable = ! isActiveTable" class="text-primary">
                <span class="d-flex align-items-center cursor-pointer ">
                  <i class='bx bx-arrow-back'></i>
                  <span>Kembali</span>
                </span>
              </span>
              <div class="section-filter" style="width: 20%;">
                <label for="" class="label-filter">Tanggal : </label>
                <input x-model="date" type="date" class="form-control form-control-sm rounded-pill shadow-sm">
              </div>
            </div>
            <div class="table-responsive text-nowrap mt-2" style="max-height: 30rem;">
              <table class="table table-bordered">
                <thead class="table-secondary">
                  <tr>
                    <th>Kode</th>
                    <th>Model</th>
                    <th>Cabang</th>
                    <th>Kategori</th>
                    <th>Tahun</th>
                    <th>Harga Tebus</th>
                    <th>Deposit</th>
                    <th>Tebus Deposit</th>
                    <th>Harga Tebus Net</th>
                    <th>Biaya Karoseri</th>
                    <th>Biaya Aksesoris</th>
                    <th>Biaya Expedisi</th>
                    <th>Persen Asuransi</th>
                    <th>Biaya Asuransi</th>
                    <th>Biaya Pemeliharaan PDI</th>
                    <th>Insentif</th>
                    <th>Persen Bunga Inventory</th>
                    <th>Bunga Inventory</th>
                    <th>BBN</th>
                    <th>Persen Margin</th>
                    <th>Margin</th>
                    <th>Hpp OFF</th>
                    <th>Hpp ON</th>
                    <th>Harga OFF</th>
                    <th>Harga ON</th>
                    <th>Biaya PPN</th>
                    <th>PPH 22</th>
                    <th>PPH 22 Margin</th>
                    <th>PPN Des</th>
                    <th>PPN Per</th>
                    <th>Tambahan Harga</th>
                  </tr>
                </thead>
                <tbody>
                  <template x-for="(item, idx) in dataImport">
                    <tr>
                      <td x-text="item.kode"></td>
                      <td x-text="item.model"></td>
                      <td x-text="item.cabang"></td>
                      <td x-text="item.kategori"></td>
                      <td x-text="item.tahun"></td>
                      <td x-text="formatRupiah(item.harga_tebus ?? 0)"></td>
                      <td x-text="formatRupiah(item.deposit ?? 0)"></td>
                      <td x-text="formatRupiah(item.tebus_deposit ?? 0)"></td>
                      <td x-text="formatRupiah(item.harga_tebus_net ?? 0)"></td>
                      <td x-text="formatRupiah(item.karoseri ?? 0)"></td>
                      <td x-text="formatRupiah(item.aksesoris ?? 0)"></td>
                      <td x-text="formatRupiah(item.expedisi ?? 0)"></td>
                      <td x-text="item.persen_asuransi ?? ''"></td>
                      <td x-text="formatRupiah(item.asuransi ?? 0)"></td>
                      <td x-text="formatRupiah(item.pemeliharaan_pdi ?? 0)"></td>
                      <td x-text="formatRupiah(item.insentif ?? 0)"></td>
                      <td x-text="item.persen_bunga_inventory ?? ''"></td>
                      <td x-text="formatRupiah(item.bunga_inventory ?? 0)"></td>
                      <td x-text="formatRupiah(item.bbn ?? 0)"></td>
                      <td x-text="item.persen_margin ?? ''"></td>
                      <td x-text="formatRupiah(item.margin ?? 0)"></td>
                      <td x-text="formatRupiah(item.hpp_off ?? 0)"></td>
                      <td x-text="formatRupiah(item.hpp_on ?? 0)"></td>
                      <td x-text="formatRupiah(item.harga_off_bulat ?? 0)"></td>
                      <td x-text="formatRupiah(item.harga_on_bulat ?? 0)"></td>
                      <td x-text="formatRupiah(item.biaya_ppn ?? 0)"></td>
                      <td x-text="item.pph22 ?? ''"></td>
                      <td x-text="formatRupiah(item.pph22_margin ?? 0)"></td>
                      <td x-text="item.ppn_des ?? ''"></td>
                      <td x-text="item.ppn_per ?? ''"></td>
                      <td x-text="formatRupiah(item.tambahan_harga ?? 0)"></td>
                    </tr>
                  </template>
                </tbody>
              </table>
            </div>
            <div class="d-flex justify-content-end mt-4">
              <button x-show="!isLoadingSubmit" x-on:click="submitForm()" type="button" class="btn btn-primary btn-sm rounded-pill shadow-sm" style="padding: 6px 16px">Import</button>
              <span x-show="isLoadingSubmit">
                <x-loading-submit />
              </span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
