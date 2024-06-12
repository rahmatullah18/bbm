<div x-data="{
  detailPricelist: [],
  filteredPricelists: [],
  isLoadingDetailPricelist: false,
  loadingSubmit: false,


  // state for edit pricelist
  selectedPricelists: [],
  kode:'',
  nama:'',
  tahun:'',
  cabang:'',
  hpp_on:'',
  hpp_off:'',
  harga_on:'',
  harga_off:'',
  bbn:'',
  cash_back:'',
  keterangan:'',
  tebus:'',
  expedisi:'',
  delivery:'',
  asuransi:'',
  karoseri:'',
  bunga_inventory:'',
  pemeliharaan_pdi:'',
  aksesoris:'',
  insentif:'',
  by_tambahan:'',

  handleChangeInput(state, event){
    this[state] = removeThousandsSeparator(event.target.value)
  },

  selectedActiveKode(kode, index){
    let active = this.selectedPricelists.find(item => item == kode) ? true : false
    if(active){
      items[index] = {
        ...items[index],
        active: true
      }
    }else{
      items[index] = {
        ...items[index],
        active:false
      }
    }
  },

  selectedActiveSearchThead(key, index, ){
    let active = dataThead.find(item => item.key == key)
    console.log({active})
    if(active.hasOwnProperty('active')){
      if(active){
        this.dataThead[index] = {
          ...this.dataThead[index],
          active:true
        }
      }else{
        this.dataThead[index] = {
          ...this.dataThead[index],
          active:false
        }
      }
    }
  },

  filterSelectedPricelists(){
    const newItems = items.slice();
    const filteredItems = newItems.slice().filter(item => this.selectedPricelists.includes(item.cKode))
    this.filteredPricelists = filteredItems
  },
  clearSelectedPricelists(){
    this.filteredPricelists = []
    this.selectedPricelists = [];
  },

  submitFormEditMultiple() {
    this.isLoadingTable = true
    const payload = this.filteredPricelists.slice().map(item => {
      return {
        kode: item.cKode,
        nama: item.cnama,
        tahun: item.ctahun,
        cabang: globalCabang,
        hpp_on: item.nhpp_on,
        hpp_off: item.nhpp_off,
        harga_on: item.nhrg_on,
        harga_off: item.nhrg_off,
        bbn: item.nbbn,
        cash_back: item.ncash_back,
        keterangan: item.cket ?? '',
        tebus: item.ntebus,
        expedisi: item.nexpedisi,
        delivery: item.ndelivery,
        asuransi: item.nasuransi,
        karoseri: item.nkaroseri,
        bunga_inventory: item.nbunga_inventory,
        pemeliharaan_pdi: item.npemeliharaan_pdi,
        aksesoris: item.naksesoris,
        insentif: item.ninsentif,
        by_tambahan: item.nby_tambahan,
      }
    })
    fetch(getBaseUrlApi('master/pl-unit/update'), {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Authorization': 'Bearer ' + globalToken,
      },
      body: JSON.stringify(payload)
    }).then(res => res.json()).then(data => {
      Swal.fire({
        icon: 'success',
        title: 'Data tersimpan',
        showConfirmButton: false,
        timer: 2000
      })
    }).catch(err => {
      Swal.fire({
        icon:'error',
        title:'Data gagal disimpan',
        text: err,
      })
    }).finally(() => {
      getDataPricelist()
      this.filteredPricelists = [];
      this.selectedPricelists = [];
      this.isLoadingTable = false
    })
  },

  testing(){
    console.log('masuk')
  },

}" x-effect="
  console.log({selectedPricelists, filteredPricelists})
">
  <div class="d-flex justify-content-between align-items-center mb-2">
    {{-- button update --}}
    <div class=" d-flex gap-2">
      <button class="btn p-0 " x-on:click="clearSearch()">
        <i class='bx bx-reset'></i>
      </button>
      <template x-if="selectedPricelists.length > 0">
        {{-- edit --}}
        <button class="btn btn-sm btn-primary d-flex align-items-center rounded-pill" style="padding: 4px 16px" data-bs-toggle="modal" data-bs-target="#modalEditMultiplePricelist" x-on:click="filterSelectedPricelists()"><i class='bx bx-edit-alt'></i>
          <span>Edit</span>
        </button>
      </template>
      <template x-if="selectedPricelists.length > 0">
        {{-- clear --}}
        <button class="btn btn-sm btn-success d-flex align-items-center rounded-pill" style="padding: 4px 16px" x-on:click="clearSelectedPricelists()"><i class='bx bx-checkbox-minus'></i>
          <span>Clear</span>
        </button>
      </template>
    </div>
    {{-- buttons --}}
    <div class="d-flex justify-content-end align-items-center gap-2 ">
      <button class="btn btn-sm btn-info rounded-pill d-flex align-items-center gap-1" style="padding: 4px 16px" data-bs-toggle="modal" data-bs-target="#modalImportPricelist">
        <i class='bx bxs-file-import'></i>
        <span>Import</span>
      </button>
      <button class="btn btn-sm btn-primary d-flex rounded-pill align-items-center gap-1" style="padding: 4px 16px" data-bs-toggle="modal" data-bs-target="#modalExportPricelist">
        <i class='bx bxs-file-export'></i>
        <span>Export</span>
      </button>
    </div>
  </div>
  {{-- loading skeleton --}}
  <x-animasi.skeleton-data-table :number="16" />
  <div class="view">
    <div class="wrapper rounded-sm">
      <table x-show="!isLoadingTable" class="table   table-hover caption-top bg-white table-striped table-responsive-lg">
        {{-- table head --}}
        <x-pricelist.table-head-pricelist />
        <tbody class="table-border-bottom-0 placeholder-glow">
          <template x-if="totalDataPricelist === 0">
            <tr>
              <td colspan="16" class="text-center"> Data tidak ditemukan</td>
            </tr>
          </template>
          <template x-for="(item, index) in items" :key="index">
            <tr class="animation__opacity thead">
              <td class="text-center first-col sticky-col bg-white">
                <input type="checkbox" x-bind:value="item.cKode" class="form-check-input rounded-pill" x-model="selectedPricelists" x-on:change="selectedActiveKode(item.cKode, index)" id="checkbox-pricelist">
              </td>
              <td x-text="item.cKode" class="second-col sticky-col bg-white"></td>
              <td x-text="item.cnama"></td>
              <td x-text="item.cmerk"></td>
              <td x-text="item.ctipe"></td>
              <td x-text="item.ctahun"></td>
              <td x-text="formatRupiah(item.nhpp_on)" class="text-end"></td>
              <td x-text="formatRupiah(item.nhpp_off)" class="text-end"></td>
              <td x-text="formatRupiah(item.nhrg_on)" class="text-end"></td>
              <td x-text="formatRupiah(item.nhrg_off)" class="text-end"></td>
              <td x-text="formatRupiah(item.ntebus)" class="text-end"></td>
              <td x-text="formatRupiah(item.ncash_back)" class="text-end"></td>
              <td x-text="formatRupiah(item.nexpedisi)" class="text-end"></td>
              <td x-text="formatRupiah(item.nasuransi)" class="text-end"></td>
              <td x-text="formatRupiah(item.nkaroseri)" class="text-end"></td>
              <td x-text="formatRupiah(item.ndelivery)" class="text-end"></td>
              <td x-text="formatRupiah(item.naksesoris)" class="text-end"></td>
              <td x-text="formatRupiah(item.nbunga_inventory)" class="text-end"></td>
              <td x-text="formatRupiah(item.npemeliharaan_pdi)" class="text-end"></td>
              <td x-text="formatRupiah(item.nbbn)" class="text-end"></td>
              <td x-text="formatRupiah(item.ninsentif)" class="text-end"></td>
              <td x-text="formatRupiah(item.nby_tambahan)" class="text-end"></td>
              <td x-text="item.cket"></td>

            </tr>
          </template>
        </tbody>
      </table>
    </div>
  </div>

  {{-- edit modal pricelist --}}
  <x-pricelist.modal.edit-modal-pricelist />
  {{-- multiple edit modal pricelist --}}
  <x-pricelist.modal.edit-modal-multiple-pricelist />

</div>
