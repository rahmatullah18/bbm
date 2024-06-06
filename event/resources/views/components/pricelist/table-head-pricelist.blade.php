<thead class="table-dark">
  <tr>
    <th class="first-col sticky-col text-center">
      <div class="">
        <span>
          <i class='bx bx-select-multiple'></i>
        </span>
      </div>
    </th>
    <th class="second-col sticky-col">
      <div class="d-flex align-items-center gap-2 justify-content-start">
        <span>
          Kode
        </span>
        <span class="d-flex flex-column">
          <svg @click="sort('cKode', 'asc')" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="4" viewBox="0 0 24 24" stroke="currentColor" class="svgIcon cursor-pointer text-secondary fill-current w-2 h-2" x-bind:class="{'text-primary': sorted.field === 'cKode' && sorted.rule === 'asc'}">
            <path d="M5 15l7-7 7 7"></path>
          </svg>
          <svg @click="sort('cKode', 'desc')" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="4" viewBox="0 0 24 24" stroke="currentColor" class="svgIcon cursor-pointer text-secondary fill-current" x-bind:class="{'text-primary': sorted.field === 'cKode' && sorted.rule === 'desc'}">
            <path d="M19 4l-7 7-7-7"></path>
          </svg>
        </span>
      </div>
    </th>
    <th>
      <div class="d-flex align-items-center gap-2 justify-content-start">
        <span>
          Cabang
        </span>
        <span class="d-flex flex-column">
          <svg @click="sort('cnama', 'asc')" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="4" viewBox="0 0 24 24" stroke="currentColor" class="svgIcon cursor-pointer text-secondary fill-current w-2 h-2" x-bind:class="{'text-primary': sorted.field === 'cnama' && sorted.rule === 'asc'}">
            <path d="M5 15l7-7 7 7"></path>
          </svg>
          <svg @click="sort('cnama', 'desc')" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="4" viewBox="0 0 24 24" stroke="currentColor" class="svgIcon cursor-pointer text-secondary fill-current" x-bind:class="{'text-primary': sorted.field === 'cnama' && sorted.rule === 'desc'}">
            <path d="M19 4l-7 7-7-7"></path>
          </svg>
        </span>
      </div>
    </th>
    <th>
      <div class="d-flex align-items-center gap-2 justify-content-start">
        <span>
          Merek
        </span>
        <span class="d-flex flex-column">
          <svg @click="sort('cmerk', 'asc')" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="4" viewBox="0 0 24 24" stroke="currentColor" class="svgIcon cursor-pointer text-secondary fill-current w-2 h-2" x-bind:class="{'text-primary': sorted.field === 'cmerk' && sorted.rule === 'asc'}">
            <path d="M5 15l7-7 7 7"></path>
          </svg>
          <svg @click="sort('cmerk', 'desc')" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="4" viewBox="0 0 24 24" stroke="currentColor" class="svgIcon cursor-pointer text-secondary fill-current" x-bind:class="{'text-primary': sorted.field === 'cmerk' && sorted.rule === 'desc'}">
            <path d="M19 4l-7 7-7-7"></path>
          </svg>
        </span>
      </div>
    </th>
    <th>
      <div class="d-flex align-items-center gap-2 justify-content-start">
        <span>
          Tipe
        </span>
        <span class="d-flex flex-column">
          <svg @click="sort('ctipe', 'asc')" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="4" viewBox="0 0 24 24" stroke="currentColor" class="svgIcon cursor-pointer text-secondary fill-current w-2 h-2" x-bind:class="{'text-primary': sorted.field === 'ctipe' && sorted.rule === 'asc'}">
            <path d="M5 15l7-7 7 7"></path>
          </svg>
          <svg @click="sort('ctipe', 'desc')" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="4" viewBox="0 0 24 24" stroke="currentColor" class="svgIcon cursor-pointer text-secondary fill-current" x-bind:class="{'text-primary': sorted.field === 'ctipe' && sorted.rule === 'desc'}">
            <path d="M19 4l-7 7-7-7"></path>
          </svg>
        </span>
      </div>
    </th>
    <th>
      <div class="d-flex align-items-center gap-2 justify-content-start">
        <span>
          HPP ON
        </span>
        <span class="d-flex flex-column">
          <svg @click="sort('nhpp_on', 'asc')" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="4" viewBox="0 0 24 24" stroke="currentColor" class="svgIcon cursor-pointer text-secondary fill-current w-2 h-2" x-bind:class="{'text-primary': sorted.field === 'nhpp_on' && sorted.rule === 'asc'}">
            <path d="M5 15l7-7 7 7"></path>
          </svg>
          <svg @click="sort('nhpp_on', 'desc')" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="4" viewBox="0 0 24 24" stroke="currentColor" class="svgIcon cursor-pointer text-secondary fill-current" x-bind:class="{'text-primary': sorted.field === 'nhpp_on' && sorted.rule === 'desc'}">
            <path d="M19 4l-7 7-7-7"></path>
          </svg>
        </span>
      </div>
    </th>
    <th>
      <div class="d-flex align-items-center gap-2 justify-content-start">
        <span>
          HPP OFF
        </span>
        <span class="d-flex flex-column">
          <svg @click="sort('nhpp_off', 'asc')" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="4" viewBox="0 0 24 24" stroke="currentColor" class="svgIcon cursor-pointer text-secondary fill-current w-2 h-2" x-bind:class="{'text-primary': sorted.field === 'nhpp_off' && sorted.rule === 'asc'}">
            <path d="M5 15l7-7 7 7"></path>
          </svg>
          <svg @click="sort('nhpp_off', 'desc')" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="4" viewBox="0 0 24 24" stroke="currentColor" class="svgIcon cursor-pointer text-secondary fill-current" x-bind:class="{'text-primary': sorted.field === 'nhpp_off' && sorted.rule === 'desc'}">
            <path d="M19 4l-7 7-7-7"></path>
          </svg>
        </span>
      </div>
    </th>
    <th>
      <div class="d-flex align-items-center gap-2 justify-content-start">
        <span>
          HRG ON
        </span>
        <span class="d-flex flex-column">
          <svg @click="sort('nhrg_on', 'asc')" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="4" viewBox="0 0 24 24" stroke="currentColor" class="svgIcon cursor-pointer text-secondary fill-current w-2 h-2" x-bind:class="{'text-primary': sorted.field === 'nhrg_on' && sorted.rule === 'asc'}">
            <path d="M5 15l7-7 7 7"></path>
          </svg>
          <svg @click="sort('nhrg_on', 'desc')" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="4" viewBox="0 0 24 24" stroke="currentColor" class="svgIcon cursor-pointer text-secondary fill-current" x-bind:class="{'text-primary': sorted.field === 'nhrg_on' && sorted.rule === 'desc'}">
            <path d="M19 4l-7 7-7-7"></path>
          </svg>
        </span>
      </div>
    </th>
    <th>
      <div class="d-flex align-items-center gap-2 justify-content-start">
        <span>
          HRG OFF
        </span>
        <span class="d-flex flex-column">
          <svg @click="sort('nhrg_off', 'asc')" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="4" viewBox="0 0 24 24" stroke="currentColor" class="svgIcon cursor-pointer text-secondary fill-current w-2 h-2" x-bind:class="{'text-primary': sorted.field === 'nhrg_off' && sorted.rule === 'asc'}">
            <path d="M5 15l7-7 7 7"></path>
          </svg>
          <svg @click="sort('nhrg_off', 'desc')" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="4" viewBox="0 0 24 24" stroke="currentColor" class="svgIcon cursor-pointer text-secondary fill-current" x-bind:class="{'text-primary': sorted.field === 'nhrg_off' && sorted.rule === 'desc'}">
            <path d="M19 4l-7 7-7-7"></path>
          </svg>
        </span>
      </div>
    </th>
    <th>
      <div class="d-flex align-items-center gap-2 justify-content-start">
        <span>
          HRG Tebus
        </span>
        <span class="d-flex flex-column">
          <svg @click="sort('ntebus', 'asc')" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="4" viewBox="0 0 24 24" stroke="currentColor" class="svgIcon cursor-pointer text-secondary fill-current w-2 h-2" x-bind:class="{'text-primary': sorted.field === 'ntebus' && sorted.rule === 'asc'}">
            <path d="M5 15l7-7 7 7"></path>
          </svg>
          <svg @click="sort('ntebus', 'desc')" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="4" viewBox="0 0 24 24" stroke="currentColor" class="svgIcon cursor-pointer text-secondary fill-current" x-bind:class="{'text-primary': sorted.field === 'ntebus' && sorted.rule === 'desc'}">
            <path d="M19 4l-7 7-7-7"></path>
          </svg>
        </span>
      </div>
    </th>
    <th>
      <div class="d-flex align-items-center gap-2 justify-content-start">
        <span>
          Cashback
        </span>
        <span class="d-flex flex-column">
          <svg @click="sort('ncash_back', 'asc')" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="4" viewBox="0 0 24 24" stroke="currentColor" class="svgIcon cursor-pointer text-secondary fill-current w-2 h-2" x-bind:class="{'text-primary': sorted.field === 'ncash_back' && sorted.rule === 'asc'}">
            <path d="M5 15l7-7 7 7"></path>
          </svg>
          <svg @click="sort('ncash_back', 'desc')" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="4" viewBox="0 0 24 24" stroke="currentColor" class="svgIcon cursor-pointer text-secondary fill-current" x-bind:class="{'text-primary': sorted.field === 'ncash_back' && sorted.rule === 'desc'}">
            <path d="M19 4l-7 7-7-7"></path>
          </svg>
        </span>
      </div>
    </th>
    <th>
      <div class="d-flex align-items-center gap-2 justify-content-start">
        <span>
          Expedisi
        </span>
        <span class="d-flex flex-column">
          <svg @click="sort('nexpedisi', 'asc')" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="4" viewBox="0 0 24 24" stroke="currentColor" class="svgIcon cursor-pointer text-secondary fill-current w-2 h-2" x-bind:class="{'text-primary': sorted.field === 'nexpedisi' && sorted.rule === 'asc'}">
            <path d="M5 15l7-7 7 7"></path>
          </svg>
          <svg @click="sort('nexpedisi', 'desc')" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="4" viewBox="0 0 24 24" stroke="currentColor" class="svgIcon cursor-pointer text-secondary fill-current" x-bind:class="{'text-primary': sorted.field === 'nexpedisi' && sorted.rule === 'desc'}">
            <path d="M19 4l-7 7-7-7"></path>
          </svg>
        </span>
      </div>
    </th>
    <th>
      <div class="d-flex align-items-center gap-2 justify-content-start">
        <span>
          Asuransi
        </span>
        <span class="d-flex flex-column">
          <svg @click="sort('nasuransi', 'asc')" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="4" viewBox="0 0 24 24" stroke="currentColor" class="svgIcon cursor-pointer text-secondary fill-current w-2 h-2" x-bind:class="{'text-primary': sorted.field === 'nasuransi' && sorted.rule === 'asc'}">
            <path d="M5 15l7-7 7 7"></path>
          </svg>
          <svg @click="sort('nasuransi', 'desc')" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="4" viewBox="0 0 24 24" stroke="currentColor" class="svgIcon cursor-pointer text-secondary fill-current" x-bind:class="{'text-primary': sorted.field === 'nasuransi' && sorted.rule === 'desc'}">
            <path d="M19 4l-7 7-7-7"></path>
          </svg>
        </span>
      </div>
    </th>
    <th>
      <div class="d-flex align-items-center gap-2 justify-content-start">
        <span>
          karoseri
        </span>
        <span class="d-flex flex-column">
          <svg @click="sort('nkaroseri', 'asc')" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="4" viewBox="0 0 24 24" stroke="currentColor" class="svgIcon cursor-pointer text-secondary fill-current w-2 h-2" x-bind:class="{'text-primary': sorted.field === 'nkaroseri' && sorted.rule === 'asc'}">
            <path d="M5 15l7-7 7 7"></path>
          </svg>
          <svg @click="sort('nkaroseri', 'desc')" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="4" viewBox="0 0 24 24" stroke="currentColor" class="svgIcon cursor-pointer text-secondary fill-current" x-bind:class="{'text-primary': sorted.field === 'nkaroseri' && sorted.rule === 'desc'}">
            <path d="M19 4l-7 7-7-7"></path>
          </svg>
        </span>
      </div>
    </th>
    <th>
      <div class="d-flex align-items-center gap-2 justify-content-start">
        <span>
          Delivery
        </span>
        <span class="d-flex flex-column">
          <svg @click="sort('ndelivery', 'asc')" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="4" viewBox="0 0 24 24" stroke="currentColor" class="svgIcon cursor-pointer text-secondary fill-current w-2 h-2" x-bind:class="{'text-primary': sorted.field === 'ndelivery' && sorted.rule === 'asc'}">
            <path d="M5 15l7-7 7 7"></path>
          </svg>
          <svg @click="sort('ndelivery', 'desc')" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="4" viewBox="0 0 24 24" stroke="currentColor" class="svgIcon cursor-pointer text-secondary fill-current" x-bind:class="{'text-primary': sorted.field === 'ndelivery' && sorted.rule === 'desc'}">
            <path d="M19 4l-7 7-7-7"></path>
          </svg>
        </span>
      </div>
    </th>
    <th>
      <div class="d-flex align-items-center gap-2 justify-content-start">
        <span>
          Aksesoris
        </span>
        <span class="d-flex flex-column">
          <svg @click="sort('naksesoris', 'asc')" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="4" viewBox="0 0 24 24" stroke="currentColor" class="svgIcon cursor-pointer text-secondary fill-current w-2 h-2" x-bind:class="{'text-primary': sorted.field === 'naksesoris' && sorted.rule === 'asc'}">
            <path d="M5 15l7-7 7 7"></path>
          </svg>
          <svg @click="sort('naksesoris', 'desc')" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="4" viewBox="0 0 24 24" stroke="currentColor" class="svgIcon cursor-pointer text-secondary fill-current" x-bind:class="{'text-primary': sorted.field === 'naksesoris' && sorted.rule === 'desc'}">
            <path d="M19 4l-7 7-7-7"></path>
          </svg>
        </span>
      </div>
    </th>
    <th>
      <div class="d-flex align-items-center gap-2 justify-content-start">
        <span>
          Bunga Inventory
        </span>
        <span class="d-flex flex-column">
          <svg @click="sort('nbunga_inventory', 'asc')" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="4" viewBox="0 0 24 24" stroke="currentColor" class="svgIcon cursor-pointer text-secondary fill-current w-2 h-2" x-bind:class="{'text-primary': sorted.field === 'nbunga_inventory' && sorted.rule === 'asc'}">
            <path d="M5 15l7-7 7 7"></path>
          </svg>
          <svg @click="sort('nbunga_inventory', 'desc')" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="4" viewBox="0 0 24 24" stroke="currentColor" class="svgIcon cursor-pointer text-secondary fill-current" x-bind:class="{'text-primary': sorted.field === 'nbunga_inventory' && sorted.rule === 'desc'}">
            <path d="M19 4l-7 7-7-7"></path>
          </svg>
        </span>
      </div>
    </th>
    <th>
      <div class="d-flex align-items-center gap-2 justify-content-start">
        <span>
          Pemeliharaan PDI
        </span>
        <span class="d-flex flex-column">
          <svg @click="sort('npemeliharaan_pdi', 'asc')" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="4" viewBox="0 0 24 24" stroke="currentColor" class="svgIcon cursor-pointer text-secondary fill-current w-2 h-2" x-bind:class="{'text-primary': sorted.field === 'npemeliharaan_pdi' && sorted.rule === 'asc'}">
            <path d="M5 15l7-7 7 7"></path>
          </svg>
          <svg @click="sort('npemeliharaan_pdi', 'desc')" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="4" viewBox="0 0 24 24" stroke="currentColor" class="svgIcon cursor-pointer text-secondary fill-current" x-bind:class="{'text-primary': sorted.field === 'npemeliharaan_pdi' && sorted.rule === 'desc'}">
            <path d="M19 4l-7 7-7-7"></path>
          </svg>
        </span>
      </div>
    </th>
    <th>
      <div class="d-flex align-items-center gap-2 justify-content-start">
        <span>
          BBN
        </span>
        <span class="d-flex flex-column">
          <svg @click="sort('nbbn', 'asc')" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="4" viewBox="0 0 24 24" stroke="currentColor" class="svgIcon cursor-pointer text-secondary fill-current w-2 h-2" x-bind:class="{'text-primary': sorted.field === 'nbbn' && sorted.rule === 'asc'}">
            <path d="M5 15l7-7 7 7"></path>
          </svg>
          <svg @click="sort('nbbn', 'desc')" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="4" viewBox="0 0 24 24" stroke="currentColor" class="svgIcon cursor-pointer text-secondary fill-current" x-bind:class="{'text-primary': sorted.field === 'nbbn' && sorted.rule === 'desc'}">
            <path d="M19 4l-7 7-7-7"></path>
          </svg>
        </span>
      </div>
    </th>
    <th>
      <div class="d-flex align-items-center gap-2 justify-content-start">
        <span>
          Insentif
        </span>
        <span class="d-flex flex-column">
          <svg @click="sort('ninsentif', 'asc')" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="4" viewBox="0 0 24 24" stroke="currentColor" class="svgIcon cursor-pointer text-secondary fill-current w-2 h-2" x-bind:class="{'text-primary': sorted.field === 'ninsentif' && sorted.rule === 'asc'}">
            <path d="M5 15l7-7 7 7"></path>
          </svg>
          <svg @click="sort('ninsentif', 'desc')" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="4" viewBox="0 0 24 24" stroke="currentColor" class="svgIcon cursor-pointer text-secondary fill-current" x-bind:class="{'text-primary': sorted.field === 'ninsentif' && sorted.rule === 'desc'}">
            <path d="M19 4l-7 7-7-7"></path>
          </svg>
        </span>
      </div>
    </th>
    <th>
      <div class="d-flex align-items-center gap-2 justify-content-start">
        <span>
          Biaya Tambahan
        </span>
        <span class="d-flex flex-column">
          <svg @click="sort('nby_tambahan', 'asc')" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="4" viewBox="0 0 24 24" stroke="currentColor" class="svgIcon cursor-pointer text-secondary fill-current w-2 h-2" x-bind:class="{'text-primary': sorted.field === 'nby_tambahan' && sorted.rule === 'asc'}">
            <path d="M5 15l7-7 7 7"></path>
          </svg>
          <svg @click="sort('nby_tambahan', 'desc')" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="4" viewBox="0 0 24 24" stroke="currentColor" class="svgIcon cursor-pointer text-secondary fill-current" x-bind:class="{'text-primary': sorted.field === 'nby_tambahan' && sorted.rule === 'desc'}">
            <path d="M19 4l-7 7-7-7"></path>
          </svg>
        </span>
      </div>
    </th>
    <th>
      <div class="d-flex align-items-center gap-2 justify-content-start">
        <span>
          Keterangan
        </span>
        <span class="d-flex flex-column">
          <svg @click="sort('cket', 'asc')" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="4" viewBox="0 0 24 24" stroke="currentColor" class="svgIcon cursor-pointer text-secondary fill-current w-2 h-2" x-bind:class="{'text-primary': sorted.field === 'cket' && sorted.rule === 'asc'}">
            <path d="M5 15l7-7 7 7"></path>
          </svg>
          <svg @click="sort('cket', 'desc')" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="4" viewBox="0 0 24 24" stroke="currentColor" class="svgIcon cursor-pointer text-secondary fill-current" x-bind:class="{'text-primary': sorted.field === 'cket' && sorted.rule === 'desc'}">
            <path d="M19 4l-7 7-7-7"></path>
          </svg>
        </span>
      </div>
    </th>
    <th>
      <div class="d-flex align-items-center gap-2 justify-content-start">
        <span>
          Tahun
        </span>
        <span class="d-flex flex-column">
          <svg @click="sort('ctahun', 'asc')" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="4" viewBox="0 0 24 24" stroke="currentColor" class="svgIcon cursor-pointer text-secondary fill-current w-2 h-2" x-bind:class="{'text-primary': sorted.field === 'ctahun' && sorted.rule === 'asc'}">
            <path d="M5 15l7-7 7 7"></path>
          </svg>
          <svg @click="sort('ctahun', 'desc')" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="4" viewBox="0 0 24 24" stroke="currentColor" class="svgIcon cursor-pointer text-secondary fill-current" x-bind:class="{'text-primary': sorted.field === 'ctahun' && sorted.rule === 'desc'}">
            <path d="M19 4l-7 7-7-7"></path>
          </svg>
        </span>
      </div>
    </th>
  </tr>
</thead>
