{{-- table aktivitas lainnya --}}
@php
$totalAktivitasLainnya = 0;
@endphp
<div>
    <div class="py-2 px-3 header_table_aruskas">Aktivitas Lainnya</div>
    <div class="table-responsive text-nowrap">
        <table class="table" id="arus-kas-table-lainnya">
            <thead class="">
                <tr>
                    <th>No</th>
                    <th>Nomor Akun</th>
                    <th>Nama Akun</th>
                    <th>Arus Kas</th>
                    <th>Tipe</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0" x-data="dataLainnya">
                @if(count($dummyData) > 0)
                @foreach ($dummyData as $index => $data)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$data[0]['cAkun']}}</td>
                    <td>{{$data[0]['NamaAkun']}}</td>
                    <td>-</td>
                    <td>{{$data[0]['cPos_3']}}</td>
                    <td class="data__total__aktivitas__operasional" @click="toggle({{$index}})"><u>{{formatRupiah($data[0]['total'])}}</u></td>
                </tr>
                @foreach ($data as $i => $item)
                <tr x-show="lists[{{ $index }}].isOpen" x-transition class="detail__aktivitas__operasional">
                    <td>
                    </td>
                    <td></td>
                    <td></td>
                    <td>-</td>
                    <td>{{$item['cPos_3']}}</td>
                    <td>{{formatRupiah($item['sum_namount'])}}</td>
                </tr>
                @endforeach
                @php
                $totalAktivitasLainnya += $data[0]['total'];
                @endphp
                @endforeach
                @else
                <tr>
                    <td colspan="6" class="text-center">Tidak ada data</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
    <div class="d-flex py-2 px-4 justify-content-between border-top">
        <div class="text-bold text-uppercase">Total Arus Kas Aktivitas Lainnya</div>
        <div class="text-bold">{{formatRupiah($totalAktivitasLainnya)}}</div>
    </div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('dataLainnya', () => ({
            lists: [],

            toggle(index) {
                if (typeof this.lists[index] === 'undefined') {
                    this.lists[index] = {
                        isOpen: false
                    };
                }
                this.lists[index].isOpen = !this.lists[index].isOpen;
            }
        }))
    })

</script>
