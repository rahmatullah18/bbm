<div x-cloak class="d-flex justify-content-between mt-4 paginationPo" x-data="{
  pageFirst(){
    // clearSearch()
    pagePricelist = 1
    limit = limit
    getDataPricelist()
  },
  pageBack(){
    // clearSearch()
    pagePricelist = pagePricelist < 1 ? 1 : pagePricelist - 1
    limit = limit
    getDataPricelist()
  },
  pageNext(){
    // clearSearch()
    pagePricelist = pagePricelist < 1 ? 1 : pagePricelist + 1
    limit = limit
    getDataPricelist()
  },
}">
  <div class="btn btn-sm border px-2 cursor-pointer bg-white rounded-pill shadow-sm" @click="pageFirst()">
    <small class="text-gray-700">First</small>
  </div>

  <div class="d-flex gap-4 align-items-center">
    <span>
      <small>Total <span class="fw-bold" x-text="totalDataPricelist"></span> Data</small>
    </span>
    <span>
      <small>Page</small>
      <small class="fw-bold" x-text="pagePricelist"></small>
      <small>From</small>
      <small class="fw-bold" x-text="pageLastPricelist"></small>
    </span>
  </div>

  <div class=" d-flex justify-content-end gap-2">
    {{-- back --}}
    <template x-if="pagePricelist > 1">
      <div class=" btn btn-sm border px-2 cursor-pointer bg-white rounded-pill shadow-sm" @click="pageBack()">
        <small class="text-gray-700">Previous</small>
      </div>
    </template>
    <template x-if="pagePricelist <= 1">
      <div class="btn btn-sm border px-2 bg-light rounded-pill shadow-sm">
        <small class="">Previous</small>
      </div>
    </template>

    {{-- next --}}
    <template x-if="pagePricelist >= 1">
      <div class="btn btn-sm border px-2 cursor-pointer bg-white rounded-pill shadow-sm" @click="pageNext()">
        <small class="text-secondary">Next</small>
      </div>
    </template>
    <template x-if="pagePricelist < 1">
      <div class="btn btn-sm border px-2 bg-light rounded-pill shadow-sm">
        <small class="">Next</small>
      </div>
    </template>
  </div>
</div>
{{-- </template> --}}
