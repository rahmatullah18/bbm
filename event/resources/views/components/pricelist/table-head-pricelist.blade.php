<thead class="table-dark">
  <tr>
    <th class="first-col sticky-col text-center">
      <div class="">
        <span>
          <i class='bx bx-select-multiple'></i>
        </span>
      </div>
    </th>
    <template x-for="(thead, index) in dataThead">
      <th x-bind:class="thead.key === 'cKode' ? 'second-col sticky-col bg-dark' : ''">
        <template x-if="!thead.active">
          <div class="d-flex align-items-center gap-2 justify-content-start ">
            <span x-text="thead.name" x-on:click="selectedActiveSearchThead(thead.key,index)">
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
          <input type="text" class="w-100 rounded">
        </template>
      </th>
    </template>
  </tr>
</thead>
