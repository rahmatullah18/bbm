@php
$cloc = session()->get('cloc');
@endphp
<div>
  <div class="modal fade" data-bs-backdrop='static' id="modalEditPricelist" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content position-relative editModalPricelist">
        <button type="button" class=" btn btn-danger btn-sm position-absolute" style="padding: 0.5px 1px; right:10px; top:10px;" data-bs-dismiss="modal" aria-label="Close" id="closeModalEditPricelist">
          <i class='bx bx-x'></i>
        </button>
        <div class="modal-header">
          <h1 class="modal-title fs-5">Edit Daftar Harga
            {{-- <span x-text="detailPricelist.cKode"></span> --}}
          </h1>
        </div>
        <div class="modal-body">
          <div class="d-grid gap-2">
            <div class="d-flex justify-content-between gap-2">
              {{-- kode --}}
              <div class="form-group w-100">
                <label class="form-label fw-bold" for="kode">Kode </label>
                <x-red-star />
                <input x-model="kode" type="text" class="form-control form-control-sm" name="kode" id="kode" aria-describedby="" readonly>
              </div>
              {{-- nama --}}
              <div class="form-group ">
                <label class="form-label fw-bold" for="nama">Nama Cabang</label>
                <x-red-star />
                <input x-model="nama" type="text" class="form-control form-control-sm" name="nama" id="nama" aria-describedby="" readonly>
              </div>
            </div>
            <div class="d-flex gap-2">
              {{-- hpp on --}}
              <div class="form-group w-100">
                <label class="form-label fw-bold" for="hpp_on">HPP ON</label>
                <x-red-star />
                <input type="text" class="form-control form-control-sm" name="hpp_on" id="hpp_on" aria-describedby="" x-bind:value="formatRupiah(hpp_on ?? 0)" x-mask:dynamic="$money($input, ',')" x-on:input="handleChangeInput('hpp_on',$event)">
              </div>
              {{-- hpp off --}}
              <div class="form-group w-100">
                <label class="form-label fw-bold" for="hpp_off">HPP OFF</label>
                <x-red-star />
                <input type="text" class="form-control form-control-sm" name="hpp_off" id="hpp_off" aria-describedby="" x-bind:value="formatRupiah(hpp_off ?? 0)" x-mask:dynamic="$money($input, ',')" x-on:input="handleChangeInput('hpp_off',$event)">
              </div>
            </div>
            <div class="d-flex gap-2">
              {{-- hrg_on --}}
              <div class="form-group w-100">
                <label class="form-label fw-bold" for="harga_on">Harga ON</label>
                <x-red-star />
                <input type="text" class="form-control form-control-sm" name="harga_on" id="harga_on" aria-describedby="" x-bind:value="formatRupiah(harga_on ?? 0)" x-mask:dynamic="$money($input, ',')" x-on:input="handleChangeInput('harga_on',$event)">
              </div>
              {{-- hrg_on --}}
              <div class="form-group w-100">
                <label class="form-label fw-bold" for="harga_off">Harga OFF</label>
                <x-red-star />
                <input type="text" class="form-control form-control-sm" name="harga_off" id="harga_off" aria-describedby="" x-bind:value="formatRupiah(harga_off ?? 0)" x-mask:dynamic="$money($input, ',')" x-on:input="handleChangeInput('harga_off',$event)">
              </div>
            </div>
            <div class="d-flex gap-2">
              {{-- expedisi --}}
              <div class="form-group w-100">
                <label class="form-label fw-bold" for="expedisi">Expedisi</label>
                <x-red-star />
                <input type="text" class="form-control form-control-sm" name="expedisi" id="expedisi" aria-describedby="" x-bind:value="formatRupiah(expedisi ?? 0)" x-mask:dynamic="$money($input, ',')" x-on:input="handleChangeInput('expedisi',$event)">
              </div>
              {{-- asuransi --}}
              <div class="form-group w-100">
                <label class="form-label fw-bold" for="asuransi">Asuransi</label>
                <x-red-star />
                <input type="text" class="form-control form-control-sm" name="asuransi" id="asuransi" aria-describedby="" x-bind:value="formatRupiah(asuransi ?? 0)" x-mask:dynamic="$money($input, ',')" x-on:input="handleChangeInput('asuransi',$event)">
              </div>
            </div>
            <div class="d-flex gap-2">
              {{-- karoseri --}}
              <div class="form-group w-100">
                <label class="form-label fw-bold" for="karoseri">Karoseri</label>
                <x-red-star />
                <input type="text" class="form-control form-control-sm" name="karoseri" id="karoseri" aria-describedby="" x-bind:value="formatRupiah(karoseri ?? 0)" x-mask:dynamic="$money($input, ',')" x-on:input="handleChangeInput('karoseri',$event)">
              </div>
              {{-- delivery --}}
              <div class="form-group w-100">
                <label class="form-label fw-bold" for="delivery">Delivery</label>
                <x-red-star />
                <input type="text" class="form-control form-control-sm" name="delivery" id="delivery" aria-describedby="" x-bind:value="formatRupiah(delivery ?? 0)" x-mask:dynamic="$money($input, ',')" x-on:input="handleChangeInput('delivery',$event)">
              </div>
              {{-- aksesoris --}}
              <div class="form-group w-100">
                <label class="form-label fw-bold" for="aksesoris">Aksesoris</label>
                <x-red-star />
                <input type="text" class="form-control form-control-sm" name="aksesoris" id="aksesoris" aria-describedby="" x-bind:value="formatRupiah(aksesoris ?? 0)" x-mask:dynamic="$money($input, ',')" x-on:input="handleChangeInput('aksesoris',$event)">
              </div>
            </div>
            <div class="d-flex gap-2">
              {{-- tebus --}}
              <div class="form-group w-100">
                <label class="form-label fw-bold" for="tebus">Harga Tebus</label>
                <x-red-star />
                <input type="text" class="form-control form-control-sm" name="tebus" id="tebus" aria-describedby="" x-bind:value="formatRupiah(tebus ?? 0)" x-mask:dynamic="$money($input, ',')" x-on:input="handleChangeInput('tebus',$event)">
              </div>
              {{-- cahsback --}}
              <div class="form-group w-100">
                <label class="form-label fw-bold" for="cash_back">Cashback</label>
                <x-red-star />
                <input type="text" class="form-control form-control-sm" name="cash_back" id="cash_back" aria-describedby="" x-bind:value="formatRupiah(cash_back ?? 0)" x-mask:dynamic="$money($input, ',')" x-on:input="handleChangeInput('cash_back',$event)">
              </div>
              {{-- bunga_inventory --}}
              <div class="form-group w-100">
                <label class="form-label fw-bold" for="bunga_inventory">Bunga Inventory</label>
                <x-red-star />
                <input type="text" class="form-control form-control-sm" name="bunga_inventory" id="bunga_inventory" aria-describedby="" x-bind:value="formatRupiah(bunga_inventory ?? 0)" x-mask:dynamic="$money($input, ',')" x-on:input="handleChangeInput('bunga_inventory',$event)">
              </div>
              {{-- pemeliharaan_pdi --}}
              <div class="form-group w-100">
                <label class="form-label fw-bold" for="pemeliharaan_pdi">Pemeliharaan PDI</label>
                <x-red-star />
                <input type="text" class="form-control form-control-sm" name="pemeliharaan_pdi" id="pemeliharaan_pdi" aria-describedby="" x-bind:value="formatRupiah(pemeliharaan_pdi ?? 0)" x-mask:dynamic="$money($input, ',')" x-on:input="handleChangeInput('pemeliharaan_pdi',$event)">
              </div>
            </div>
            <div class="d-flex gap-2">
              {{-- bbn --}}
              <div class="form-group w-100">
                <label class="form-label fw-bold" for="bbn">BBN</label>
                <x-red-star />
                <input type="text" class="form-control form-control-sm" name="bbn" id="bbn" aria-describedby="" x-bind:value="formatRupiah(bbn ?? 0)" x-mask:dynamic="$money($input, ',')" x-on:input="handleChangeInput('bbn',$event)">
              </div>
              {{-- Insentif --}}
              <div class="form-group w-100">
                <label class="form-label fw-bold" for="insentif">Insentif</label>
                <x-red-star />
                <input type="text" class="form-control form-control-sm" name="insentif" id="insentif" aria-describedby="" x-bind:value="formatRupiah(insentif ?? 0)" x-mask:dynamic="$money($input, ',')" x-on:input="handleChangeInput('insentif',$event)">
              </div>
            </div>
            {{-- by_tambahan --}}
            <div class="form-group w-100">
              <label class="form-label fw-bold" for="by_tambahan">Biaya Tambahan</label>
              <x-red-star />
              <input type="text" class="form-control form-control-sm" name="by_tambahan" id="by_tambahan" aria-describedby="" x-bind:value="formatRupiah(by_tambahan ?? 0)" x-mask:dynamic="$money($input, ',')" x-on:input="handleChangeInput('by_tambahan',$event)">
            </div>
            {{-- keterangan --}}
            <div class="form-group w-100">
              <label class="form-label fw-bold" for="keterangan">Keterangan</label>
              <x-red-star />
              <input type="text" class="form-control form-control-sm" name="keterangan" id="keterangan" aria-describedby="" x-model="keterangan">
            </div>
            <div class="d-flex justify-content-end">
              <button {{-- x-show="!loadingSubmit"  --}} x-on:click="submitFormEdit()" style="padding: 4px 10px" type="button" class="btn btn-sm btn-primary" class="btnSubmit" data-bs-dismiss="modal" aria-label="Close">Simpan</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
