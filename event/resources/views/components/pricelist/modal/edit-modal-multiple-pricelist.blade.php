<style>
  .input-pricelist {
    font-size: 12px;
  }

</style>

<div x-data="{
  handleChangeInputPriceAndText(key, event, index, isText = false){
    const newFilteredArr = filteredPricelists.slice()
    if(isText){
      newFilteredArr[index][key] = event.target.value
    }else{
      newFilteredArr[index][key] = removeThousandsSeparator(event.target.value)
    }
    filteredPricelists = newFilteredArr.slice()
  },

  handleRemoveItem(cKode){
    const results = filteredPricelists.filter(item => item.cKode != cKode)
    filteredPricelists = results.slice()
  },
}">
  <div class="modal fade" data-bs-backdrop='static' id="modalEditMultiplePricelist" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
      <div class="modal-content position-relative editModalMultiplePricelist">
        <button type="button" class=" btn btn-danger btn-sm position-absolute" style="padding: 0.5px 1px; right:10px; top:10px;" data-bs-dismiss="modal" aria-label="Close" id="closeModalEditPricelist">
          <i class='bx bx-x'></i>
        </button>
        <div class="modal-header">
          <h1 class="modal-title fs-5">Edit Daftar Harga</h1>
        </div>
        <div class="modal-body">
          <div class=" table-responsive text-nowrap mt-2 ">
            <table class="table table-hover bg-white">
              <thead class="table-dark">
                <tr>
                  <th class="first-col sticky-col">
                    <div class="d-flex align-items-center gap-2 justify-content-start">
                      <span>
                        Kode
                      </span>
                    </div>
                  </th>
                  <th>
                    <div class="d-flex align-items-center gap-2 justify-content-start">
                      <span>
                        Nama
                      </span>
                    </div>
                  </th>
                  <th>
                    <div class="d-flex align-items-center gap-2 justify-content-start">
                      <span>
                        Merek
                      </span>
                    </div>
                  </th>
                  <th>
                    <div class="d-flex align-items-center gap-2 justify-content-start">
                      <span>
                        Tipe
                      </span>
                    </div>
                  </th>
                  <th>
                    <div class="d-flex align-items-center gap-2 justify-content-start" style="width: 110px">
                      <span>
                        HPP ON
                      </span>
                    </div>
                  </th>
                  <th>
                    <div class="d-flex align-items-center gap-2 justify-content-start" style="width: 110px">
                      <span>
                        HPP OFF
                      </span>
                    </div>
                  </th>
                  <th>
                    <div class="d-flex align-items-center gap-2 justify-content-start" style="width: 110px">
                      <span>
                        HRG ON
                      </span>
                    </div>
                  </th>
                  <th>
                    <div class="d-flex align-items-center gap-2 justify-content-start" style="width: 110px">
                      <span>
                        HRG OFF
                      </span>
                    </div>
                  </th>
                  <th>
                    <div class="d-flex align-items-center gap-2 justify-content-start" style="width: 110px">
                      <span>
                        Hrg Tebus
                      </span>
                    </div>
                  </th>
                  <th>
                    <div class="d-flex align-items-center gap-2 justify-content-start" style="width: 110px">
                      <span>
                        Cashback
                      </span>
                    </div>
                  </th>
                  <th>
                    <div class="d-flex align-items-center gap-2 justify-content-start" style="width: 110px">
                      <span>
                        Expedisi
                      </span>
                    </div>
                  </th>
                  <th>
                    <div class="d-flex align-items-center gap-2 justify-content-start" style="width: 110px">
                      <span>
                        Asuransi
                      </span>
                    </div>
                  </th>
                  <th>
                    <div class="d-flex align-items-center gap-2 justify-content-start" style="width: 110px">
                      <span>
                        Karoseri
                      </span>
                    </div>
                  </th>
                  <th>
                    <div class="d-flex align-items-center gap-2 justify-content-start" style="width: 110px">
                      <span>
                        Delivery
                      </span>
                    </div>
                  </th>
                  <th>
                    <div class="d-flex align-items-center gap-2 justify-content-start" style="width: 110px">
                      <span>
                        AKsesoris
                      </span>
                    </div>
                  </th>
                  <th>
                    <div class="d-flex align-items-center gap-2 justify-content-start" style="width: 110px">
                      <span>
                        Bunga Inventory
                      </span>
                    </div>
                  </th>
                  <th>
                    <div class="d-flex align-items-center gap-2 justify-content-start" style="width: 110px">
                      <span>
                        Pemeliharaan PDI
                      </span>
                    </div>
                  </th>
                  <th>
                    <div class="d-flex align-items-center gap-2 justify-content-start" style="width: 110px">
                      <span>
                        BBN
                      </span>
                    </div>
                  </th>
                  <th>
                    <div class="d-flex align-items-center gap-2 justify-content-start" style="width: 110px">
                      <span>
                        Insentif
                      </span>
                    </div>
                  </th>
                  <th>
                    <div class="d-flex align-items-center gap-2 justify-content-start" style="width: 110px">
                      <span>
                        Biaya Tambahan
                      </span>
                    </div>
                  </th>
                  <th>
                    <div class="d-flex align-items-center gap-2 justify-content-start" style="width: 200px">
                      <span>
                        Keterangan
                      </span>
                    </div>
                  </th>
                  <th>
                    <div class="d-flex align-items-center gap-2 justify-content-start" style="width: 70px">
                      <span>
                        Tahun
                      </span>
                    </div>
                  </th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody class="table-border-bottom-0 placeholder-glow">
                <template x-if="filteredPricelists === 0">
                  <tr>
                    <td colspan="16" class="text-center">Data tidak ditemukan</td>
                  </tr>
                </template>
                <template x-for="(item, index) in filteredPricelists" :key="index">
                  <tr class="animation__opacity modal-edit-pricelist">
                    <td x-text="item.cKode" class="first-col sticky-col bg-white"></td>
                    <td x-text="item.cnama"></td>
                    <td x-text="item.cmerk"></td>
                    <td x-text="item.ctipe"></td>
                    <td>
                      <input type="text" class="form-control form-control-sm input-pricelist" name="nhpp_on" id="nhpp_on" aria-describedby="" x-bind:value="formatRupiah(item.nhpp_on ?? 0)" x-mask:dynamic="$money($input, ',')" x-on:input="handleChangeInputPriceAndText('nhpp_on', $event, index)
                      ">
                    </td>
                    <td>
                      <input type="text" class="form-control form-control-sm input-pricelist" name="nhpp_off" id="nhpp_off" aria-describedby="" x-bind:value="formatRupiah(item.nhpp_off ?? 0)" x-mask:dynamic="$money($input, ',')" x-on:input="handleChangeInputPriceAndText('nhpp_off', $event, index)">
                    </td>
                    <td>
                      <input type="text" class="form-control form-control-sm input-pricelist" name="nhrg_on" id="nhrg_on" aria-describedby="" x-bind:value="formatRupiah(item.nhrg_on ?? 0)" x-mask:dynamic="$money($input, ',')" x-on:input="handleChangeInputPriceAndText('nhrg_on', $event, index)">
                    </td>
                    <td>
                      <input type="text" class="form-control form-control-sm input-pricelist" name="nhrg_off" id="nhrg_off" aria-describedby="" x-bind:value="formatRupiah(item.nhrg_off ?? 0)" x-mask:dynamic="$money($input, ',')" x-on:input="handleChangeInputPriceAndText('nhrg_off', $event, index)">
                    </td>
                    <td>
                      <input type="text" class="form-control form-control-sm input-pricelist" name="ntebus" id="ntebus" aria-describedby="" x-bind:value="formatRupiah(item.ntebus ?? 0)" x-mask:dynamic="$money($input, ',')" x-on:input="handleChangeInputPriceAndText('ntebus', $event, index)">
                    </td>
                    <td>
                      <input type="text" class="form-control form-control-sm input-pricelist" name="ncash_back" id="ncash_back" aria-describedby="" x-bind:value="formatRupiah(item.ncash_back ?? 0)" x-mask:dynamic="$money($input, ',')" x-on:input="handleChangeInputPriceAndText('ncash_back', $event, index)">
                    </td>
                    <td>
                      <input type="text" class="form-control form-control-sm input-pricelist" name="nexpedisi" id="nexpedisi" aria-describedby="" x-bind:value="formatRupiah(item.nexpedisi ?? 0)" x-mask:dynamic="$money($input, ',')" x-on:input="handleChangeInputPriceAndText('nexpedisi', $event, index)">
                    </td>
                    <td>
                      <input type="text" class="form-control form-control-sm input-pricelist" name="nasuransi" id="nasuransi" aria-describedby="" x-bind:value="formatRupiah(item.nasuransi ?? 0)" x-mask:dynamic="$money($input, ',')" x-on:input="handleChangeInputPriceAndText('nasuransi', $event, index)">
                    </td>
                    <td>
                      <input type="text" class="form-control form-control-sm input-pricelist" name="nkaroseri" id="nkaroseri" aria-describedby="" x-bind:value="formatRupiah(item.nkaroseri ?? 0)" x-mask:dynamic="$money($input, ',')" x-on:input="handleChangeInputPriceAndText('nkaroseri', $event, index)">
                    </td>
                    <td>
                      <input type="text" class="form-control form-control-sm input-pricelist" name="ndelivery" id="ndelivery" aria-describedby="" x-bind:value="formatRupiah(item.ndelivery ?? 0)" x-mask:dynamic="$money($input, ',')" x-on:input="handleChangeInputPriceAndText('ndelivery', $event, index)">
                    </td>
                    <td>
                      <input type="text" class="form-control form-control-sm input-pricelist" name="naksesoris" id="naksesoris" aria-describedby="" x-bind:value="formatRupiah(item.naksesoris ?? 0)" x-mask:dynamic="$money($input, ',')" x-on:input="handleChangeInputPriceAndText('naksesoris', $event, index)">
                    </td>
                    <td>
                      <input type="text" class="form-control form-control-sm input-pricelist" name="nbunga_inventory" id="nbunga_inventory" aria-describedby="" x-bind:value="formatRupiah(item.nbunga_inventory ?? 0)" x-mask:dynamic="$money($input, ',')" x-on:input="handleChangeInputPriceAndText('nbunga_inventory', $event, index)">
                    </td>
                    <td>
                      <input type="text" class="form-control form-control-sm input-pricelist" name="npemeliharaan_pdi" id="npemeliharaan_pdi" aria-describedby="" x-bind:value="formatRupiah(item.npemeliharaan_pdi ?? 0)" x-mask:dynamic="$money($input, ',')" x-on:input="handleChangeInputPriceAndText('npemeliharaan_pdi', $event, index)">
                    </td>
                    <td>
                      <input type="text" class="form-control form-control-sm input-pricelist" name="nbbn" id="nbbn" aria-describedby="" x-bind:value="formatRupiah(item.nbbn ?? 0)" x-mask:dynamic="$money($input, ',')" x-on:input="handleChangeInputPriceAndText('nbbn', $event, index)">
                    </td>
                    <td>
                      <input type="text" class="form-control form-control-sm input-pricelist" name="ninsentif" id="ninsentif" aria-describedby="" x-bind:value="formatRupiah(item.ninsentif ?? 0)" x-mask:dynamic="$money($input, ',')" x-on:input="handleChangeInputPriceAndText('ninsentif', $event, index)">
                    </td>
                    <td>
                      <input type="text" class="form-control form-control-sm input-pricelist" name="nby_tambahan" id="nby_tambahan" aria-describedby="" x-bind:value="formatRupiah(item.nby_tambahan ?? 0)" x-mask:dynamic="$money($input, ',')" x-on:input="handleChangeInputPriceAndText('nby_tambahan', $event, index)">
                    </td>
                    <td>
                      <input type="text" class="form-control form-control-sm input-pricelist" name="cket" id="cket" aria-describedby="" x-bind:value="item.cket ?? ''" x-on:input="handleChangeInputPriceAndText('cket', $event, index, true)">
                    </td>
                    <td>
                      <input type="text" class="form-control form-control-sm input-pricelist" name="ctahun" id="ctahun" aria-describedby="" x-bind:value="item.ctahun ?? ''" x-on:input="handleChangeInputPriceAndText('ctahun', $event, index, true)">
                    </td>
                    <td class="">
                      <span class="text-danger" style="cursor: pointer" x-on:click="handleRemoveItem(item.cKode)"><i class='bx bx-trash'></i></span>
                    </td>
                  </tr>
                </template>
              </tbody>
            </table>
          </div>
          <div class="mt-2 d-flex justify-content-end">
            <template x-if="filteredPricelists.length > 0">
              <button x-on:click="submitFormEditMultiple()" style="padding: 4px 10px" type="button" class="btn btn-sm btn-primary" class="btnSubmit" data-bs-dismiss="modal" aria-label="Close">Simpan</button>
            </template>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
