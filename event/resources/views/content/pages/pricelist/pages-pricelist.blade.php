@php
$configData = Helper::appClasses();
$cloc = session()->get('cloc');
$date1 = date('Y-m-01');
$date2 = date('Y-m-t');
// $token = getToken();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Pricelist')

@section('vendor-style')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/sweetalert2/sweetalert2.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/flatpickr/flatpickr.css')}}" />
@endsection

@section('page-style')
<link rel="stylesheet" href="{{asset('assets/css/pricelist.css')}}">
@endsection

@section('vendor-script')
<script src="{{asset('assets/vendor/libs/sweetalert2/sweetalert2.js')}}"></script>
@endsection

@section('content')

<div x-data="{
  items: [],
  limit: 25,
  pricelistInfo:false,
  isLoadingTable: false,
  isLoadingDetailPricelist: false,
  pagePricelist: 1,
  pageLastPricelist: 0,
  totalDataPricelist: '',
  dateStart: '{{$date1}}',
  dateLast: '{{$date2}}',
  keys:['ctahun','cKode','cmerk','ctipe','cnama','nhpp_on','nhpp_off','nhrg_on','nhrg_off','ncash_back','ckat','cket','ntebus','nexpedisi','ndelivery','nasuransi','nkaroseri','naksesoris','nbunga_inventory','npemeliharaan_pdi','nbbn','ninsentif','nby_tambahan'],

  dataThead : [
    {name: 'kode', key:'cKode', type:'input', active:false, model:'searchInputKode'},
    {name: 'Cabang', key:'cnama', type:'select', active:false, model:'searchInputCabang',},
    {name: 'Merek', key:'cmerek', type:'input', active:false, model:'searchInputMerk'},
    {name: 'Tipe', key:'ctipe', type:'select', active:false, model:'searchInputTipe', },
    {name: 'Tahun', key:'ctahun', type:'select', active:false, model:'searchInputTahun', },
    {name: 'HRG Tebus (RP)', key:'ntebus', },
    {name: 'Karoseri (RP)', key:'nkaroseri', },
    {name: 'Expedisi (RP)', key:'nexpedisi', },
    {name: 'Asuransi (RP)', key:'nasuransi', },
    {name: 'Aksesoris (RP)', key:'naksesoris', },
    {name: 'Delivery (RP)', key:'ndelivery', },
    {name: 'Pemeliharaan PDI (RP)', key:'npemeliharaan_pdi', },
    {name: 'Insentif (RP)', key:'ninsentif', },
    {name: 'Bunga Inventory (RP)', key:'nbunga_inventory', },
    {name: 'BBN (RP)', key:'nbbn', },
    {name: 'HPP ON (RP)', key:'nhpp_on', },
    {name: 'HPP OFF (RP)', key:'nhpp_off', },
    {name: 'HRG ON (RP)', key:'nhrg_on', },
    {name: 'HRG OFF (RP)', key:'nhrg_off', },
    {name: 'Cashback (RP)', key:'ncash_back', },
    {name: 'Biaya Tambahan (RP)', key:'nby_tambahan', },
    {name: 'Keterangan (RP)', key:'cket', },
  ],
  pages: [],
  offset: 25,
  currentPage: 1,
  sorted: {
    field: '',
    rule: '',
  },

  // search
  selectedSearch: 'kode',
  dataTahun: [],
  dataTipe:[],
  dataCabang: [],
  searchInputKode:'',
  searchInputMerk:'',
  searchInputTipe:'',
  searchInputModel:'',
  searchInputCabang:'',
  searchInputTahun:'',

  // state import excel
  isLoadingUploadFile:false,
  excelFile: [],

  getDataPricelist(){
    this.isLoadingTable = true
      fetch(getBaseUrlApi('master/pl-unit/list'), {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Authorization': 'Bearer ' + globalToken,
        },
        body: JSON.stringify({
          'kode' : this.searchInputKode,
          'merk' : this.searchInputMerk,
          'tipe' : this.searchInputTipe,
          'model' : this.searchInputModel,
          'cabang' : this.searchInputCabang ?? '',
          'tahun' : this.searchInputTahun,
          'detail' : 0,
          'page' : this.pagePricelist,
          'limit' : Number(this.limit),
        })
      }).then(res => res.json()).then(data => {
        this.items = data.result.data
        this.pageLastPricelist = data['result']['last_page']
        this.totalDataPricelist = data.result.total
      }).catch(err => {
        this.items = []
        this.totalDataPricelist = 0
      }).finally(() => {
        this.isLoadingTable = false
      })
  },

  searchDataPricelist(value){
    this.limit = this.limit
    this.pagePricelist = 1
    this.getDataPricelist()

    // remove focus checkbox
    // document.getElementById('checkbox-pricelist').checked = false
  },
  searchThead(value, key){
    this.limit = this.limit
    this.pagePricelist = 1
    if(key === 'cKode'){
      this.searchInputKode = value
    }
    else if(key === 'cmerek'){
      this.searchInputMerk = value
    }
    else if(key === 'ctipe'){
      this.searchInputTipe = value
    } else if(key === 'cnama'){
      this.searchInputCabang = value
    } else if(key === 'ctahun'){
      this.searchInputTahun = value
    }
    this.getDataPricelist()
  },
  changeListTable(){
    this.pagePricelist = 1
    this.getDataPricelist()
  },
  initTahun(){
    var currentYear = new Date().getFullYear()
    for(let year = currentYear; year >= currentYear - 10; year--){
      this.dataTahun.push(year)
    }
  },
  async initTipeKendaraan(){
    await initialFetchApiOrLocal({
      name: 'dataTipeKendaraan',
      url: 'master/tipe-model/list',
      loading: this.isLoadingTable,
      body: {
        'status' : '1',
        'grup' : 'ctipe',
      }
    }).then((data) => {
      this.dataTipe = data
    })
  },
  async initCabang(){
    await initialFetchApiOrLocal({
      name: 'dataCabang',
      url: 'general/list-cabang',
      loading: this.isLoadingTable,
      // results: this.dataCabang
    }).then((data) => {
      this.dataCabang = data
    })
  },
  sort(field, rule) {
    // function compareOnKey berasal dari global function
    this.items = this.items.sort(compareOnKey(field, rule, this.keys))
    this.sorted.field = field
    this.sorted.rule = rule
  },
  clearSearch(){
    this.searchInputKode = '';
    this.searchInputModel = '';
    this.searchInputTipe = '';
    this.searchInputModel = '';
    this.searchInputCabang = '';
    this.searchInputTahun = '';
    this.clearTheadSearch();
    // getDataPricelist()
  },
  clearTheadSearch(){
    const mappingThead = this.dataThead.slice().map((item,index) => {
      if(item.hasOwnProperty('active')){
        return {
          ...item,
          active : false
        }
      }else {
        return {
          ...item
        }
      }
    })
    this.dataThead = mappingThead
  },
}" x-init="
  getDataPricelist()
  initTahun()
  initTipeKendaraan()
  initCabang()
  " x-effect="console.log({
  // items: items,
  dataTipe,
  dataCabang,
})">

  <x-title-page title="DAFTAR HARGA" />
  <div class="d-flex justify-content-between gap-2  flex-wrap" x-cloak>
    <div class="d-flex gap-2  align-items-center mt-4 pagingPo">
      <span>Tampilkan : </span>
      <select x-model="limit" x-on:change="changeListTable()" class="form-select form-select-sm rounded-pill shadow-sm" style="width: 70px;">
        <option value="5">5</option>
        <option value="10">10</option>
        <option value="25">25</option>
        <option value="50">50</option>
        <option value="100">100</option>
      </select>
      <span>Data</span>
    </div>
    <div class="d-flex align-items-center gap-4 page4" x-cloak>
      <div class="d-flex gap-1 align-items-center mt-4">
        {{-- kode --}}
        <div class="section-filter">
          <label for="" class="label-filter">Kode : </label>
          <input x-model="searchInputKode" type="text" class="form-control form-control-sm rounded-pill shadow-sm" placeholder="Cari kode ..." aria-label="Recipient's username">
        </div>
        {{-- model --}}
        <div class="section-filter">
          <label for="" class="label-filter">Model : </label>
          <input x-model="searchInputModel" type="text" class="form-control rounded-pill shadow-sm form-control-sm " placeholder="Cari model ..." aria-label="Recipient's username">
        </div>
        {{-- tipe --}}
        <div class="section-filter">
          <label for="" class="label-filter">Tipe : </label>
          <select x-model="searchInputTipe" class="form-select form-select-sm rounded-pill shadow-sm">
            <option value="">Semua</option>
            <template x-for="(tipe, idx) in dataTipe">
              <option x-bind:value="tipe.ctipe" x-text="tipe.ctipe" :key="idx"></option>
            </template>
          </select>
        </div>
        {{-- cabang --}}
        <div class="section-filter">
          <label for="" class="label-filter">Cabang : </label>
          <select x-model="searchInputCabang" class="form-select form-select-sm rounded-pill shadow-sm">
            <option value="">Semua</option>
            <template x-for="(cabang, idx) in dataCabang">
              <option x-bind:value="cabang.cloc" x-text="cabang.cnama" :key="idx"></option>
            </template>
          </select>
        </div>
        {{-- tahun --}}
        <div class="section-filter">
          <label for="" class="label-filter">Tahun : </label>
          <select x-model="searchInputTahun" class="form-select form-select-sm rounded-pill shadow-sm">
            <option value="">Semua</option>
            <template x-for="(tahun, idx) in dataTahun">
              <option x-bind:value="tahun" x-text="tahun" :key="idx"></option>
            </template>
          </select>
        </div>

        <button class="btn  rounded-pill  btn-sm border shadow-sm" style="padding: 4px 16px;" x-on:click="searchDataPricelist()">
          <i class='bx bx-search'></i>
        </button>
        <button class="btn  btn-sm rounded-pill  border shadow-sm" style="padding: 4px 16px;" x-on:click="clearSearch()">
          <i class='bx bx-reset'></i>
        </button>
      </div>
    </div>
  </div>

  <div class="table-responsive text-nowrap mt-2 " x-cloak>
    <x-pricelist.table-pricelist />
  </div>

  {{-- pagination --}}
  <div x-cloak>
    <x-pricelist.pagination-pricelists />
  </div>


  {{-- modal import pricelist --}}
  <x-pricelist.modal.modal-import-pricelist />

  {{-- modal export pricelist --}}
  <x-pricelist.modal.modal-export-pricelist />
</div>
@endsection
