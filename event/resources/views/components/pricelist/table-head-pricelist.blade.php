<thead class="table-light">
  <tr>
    <th class="first-col sticky-col text-center">
      <div class="">
        <span>
          <i class='bx bx-select-multiple'></i>
        </span>
      </div>
    </th>
    <template x-for="(thead, index) in dataThead">
      <th x-bind:class="thead.key === 'cKode' ? 'second-col sticky-col bg-light' : ''">
        <template x-if="!thead.active">
          <div class="d-flex align-items-center gap-2 justify-content-start ">
            <span x-text="thead.name" x-bind:role="thead.hasOwnProperty('active') && 'button' " x-bind:class="thead.hasOwnProperty('active') && 'border-bottom border-dark '" x-on:click="selectedActiveSearchThead(thead.key,index)">
            </span>
            <span class="d-flex flex-column">
              <svg @click="sort(thead.key, 'asc')" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="4" viewBox="0 0 24 24" stroke="currentColor" class="svgIcon cursor-pointer text-secondary fill-current w-2 h-2" x-bind:class="{'text-primary': sorted.field === thead.key && sorted.rule === 'asc'}">
                <path d="M5 15l7-7 7 7"></path>
              </svg>
              <svg @click="sort(thead.key, 'desc')" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="4" viewBox="0 0 24 24" stroke="currentColor" class="svgIcon cursor-pointer text-secondary fill-current" x-bind:class="{'text-primary': sorted.field === thead.key && sorted.rule === 'desc'}">
                <path d="M19 4l-7 7-7-7"></path>
              </svg>
            </span>
          </div>
        </template>
        <template x-if="thead.active">
          <div style="min-width: 40px; " class="d-flex gap-1 align-items-center">
            {{-- input --}}
            <template x-if="thead.type === 'input'">
              <input x-bind:placeholder="thead.name" type="text" class="w-100 form-control form-control-sm  my-0 rounded-lg" x-on:input.debounce.2000ms="searchThead($event.target.value, thead.key)" autofocus style="font-size: 10px" />
            </template>
            {{-- select --}}
            <template x-if="thead.type === 'select'">
              <div style="min-width: 100px; ">
                <select class=" w-100 h-100 form-select form-select-sm rounded-lg" x-on:change.debounce.2000ms="searchThead($event.target.value, thead.key)" style="font-size: 11px">
                  <option value="">Semua</option>
                  <template x-for="(data, idx) in
                  thead.key === 'ctipe' ? dataTipe : thead.key === 'cnama' ? dataCabang : dataTahun">
                    <option x-bind:value="
                    thead.key === 'ctipe' ? data.ctipe : thead.key === 'cnama' ? data.cloc : data" x-text="thead.key === 'ctipe' ? data.ctipe : thead.key === 'cnama' ? data.cnama : data" :key="idx"></option>
                  </template>
                </select>
              </div>
            </template>
            <span class="d-flex flex-column">
              <svg @click="sort(thead.key, 'asc')" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="4" viewBox="0 0 24 24" stroke="currentColor" class="svgIcon cursor-pointer text-secondary fill-current w-2 h-2" x-bind:class="{'text-primary': sorted.field === thead.key && sorted.rule === 'asc'}">
                <path d="M5 15l7-7 7 7"></path>
              </svg>
              <svg @click="sort(thead.key, 'desc')" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="4" viewBox="0 0 24 24" stroke="currentColor" class="svgIcon cursor-pointer text-secondary fill-current" x-bind:class="{'text-primary': sorted.field === thead.key && sorted.rule === 'desc'}">
                <path d="M19 4l-7 7-7-7"></path>
              </svg>
            </span>
          </div>
        </template>
      </th>
    </template>
  </tr>
</thead>
