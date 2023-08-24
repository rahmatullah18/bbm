{{-- aktivitas investasi --}}
<div>
    <div class="py-2 px-3 header_table_aruskas">Aktivitas Investasi</div>
    <div class="table-responsive text-nowrap px-2">
        <table class="table" id="arus-kas-table-investasi">
            <thead class="">
                <tr>
                    <th>No</th>
                    <th>Nomor Akun</th>
                    <th>Nama Akun</th>
                    <th>Arus Kas</th>
                    <th>Tipe</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0" x-data="{dataInvestasi}">
                @if(count($dummyData) > 0)
                @foreach ($dummyData as $index => $data)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$data[0]['cAkun']}}</td>
                    <td>{{$data[0]['NamaAkun']}}</td>
                    <td>{{$data[0]['cAkun']}}</td>
                    <td @click="toggle({{$index}})"><u>{{$data[0]['cPos_3']}}</u></td>
                </tr>
                @foreach ($data as $i => $item)
                <tr x-show="lists[{{ $index }}]?.isOpen" x-transition class="detail__aktivitas__operasional">
                    <td>
                    </td>
                    <td></td>
                    <td></td>
                    <td>-</td>
                    <td>{{$item['cPos_3']}}</td>
                </tr>
                @endforeach
                @endforeach
                @else
                <tr>
                    <td colspan="6" class="text-center">Tidak ada data</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
{{-- end aktivitas investasi --}}

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('dataInvestasi', () => ({
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
