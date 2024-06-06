  <!-- Modal import -->
  <div class="modal fade" data-bs-backdrop='static' id="modalExportPricelist" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
      <div class="modal-content position-relative">
        <div class="modal-header d-flex align-items-center">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Export Daftar Harga</h1>
          <button type="button" class=" btn btn-danger btn-sm position-absolute" style="padding: 0.5px 1px; right:10px; top:10px;" data-bs-dismiss="modal" aria-label="Close">
            <i class='bx bx-x'></i>
          </button>
        </div>
        <div class="modal-body">
          <form action="{{url('/export-pricelist')}}" method="POST">
            @csrf
            <div class="">
              <label class="" for="tahun">Tahun : </label>
              <select name="tahun" class="form-select form-select-sm">
                <option value="">Semua</option>
                <template x-for="(tahun, idx) in dataTahun">
                  <option x-bind:value="tahun" x-text="tahun" :key="idx"></option>
                </template>
              </select>
            </div>
            <div class="d-flex justify-content-end mt-4">
              <button type="submit" class="btn btn-primary btn-sm " style="padding: 4px 10px" data-bs-dismiss="modal">Export</button>
            </div>
          </form>
        </div>

      </div>
    </div>
  </div>
  {{-- end modal import --}}
