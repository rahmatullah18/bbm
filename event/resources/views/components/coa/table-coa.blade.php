<style>
    .pagination__table__coa {
        display: flex;
        justify-content: center;
        margin-top: 20px
    }

    .record__aksi__table__coa {
        color: #1e88e5;
        text-decoration: none;
        display: flex;
        align-items: center;
    }

</style>
<table class="table" id="coa-table">
    <thead class="table-dark">
        <tr>
            <th>No</th>
            <th>Nomor Akun</th>
            <th>Nama Akun</th>
            <th>Arus Kas</th>
            <th>Tipe</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody class="table-border-bottom-0">
        @foreach($dataAkun as $data)
        <tr>
            <td>{{$loop->iteration}}</td>
            <td>{{$data['cAkun']}}</td>
            <td>{{$data['cNama']}}</td>
            <td>{{$data['cAruskas']}}</td>
            <td>{{$data['cType']}}</td>
            <td>
                <a href="{{url('finance/edit-coa')}}/{{$data['id']}}" class="record__aksi__table__coa">
                    Edit <i class="menu-icon tf-icons bx bx-edit-alt"></i>
                </a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
