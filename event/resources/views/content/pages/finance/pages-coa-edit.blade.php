@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Edit Coa')
@section('content')
<div class="col-md-6">
    <div class="card mb-4">
        <h5 class="card-header">Edit Coa</h5>
        <div class="card-body">
            <form action="{{url('finance/update-coa')}}/{{$akun['id']}}" method="post">
                @csrf
                @method('put')
                <div>
                    <div>
                        <label for="defaultFormControlInput" class="form-label">Nomor Akun</label>
                        <input type="text" name="cAkun" value="{{$akun['cAkun']}}" class="form-control" id="defaultFormControlInput" placeholder="11112901..." aria-describedby="defaultFormControlHelp" />
                        {{-- error --}}
                        @error('cAkun')
                        <div class="form-text text-danger">
                            {{$message}}
                        </div>
                        @enderror
                    </div>

                    <div>
                        <label for="defaultFormControlInput" class="form-label">Nama Akun</label>
                        <input value="{{$akun['cNama']}}" type="text" class="form-control" id="defaultFormControlInput" placeholder="Kas BLK Unit..." aria-describedby="defaultFormControlHelp" name="cNama" />
                        @error('cNama')
                        <div class="form-text text-danger">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                    <div class="">
                        <label for="exampleFormControlSelect1" class="form-label">Arus Kas</label>
                        <select class="form-select" name="cAruskas" id="exampleFormControlSelect1" aria-label="Default select example">
                            @foreach ($akun['aruskas'] as $item)
                            <option value="{{$item}}" {{$item == $akun['cAruskas'] ? 'selected' : ''}}>{{$item}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="">
                        <label for="exampleFormControlSelect1" class="form-label">Tipe</label>
                        <select class="form-select" name="cType" id="exampleFormControlSelect1" aria-label="Default select example">
                            @foreach ($akun['type'] as $item)
                            <option value="{{$item}}" {{$item == trim($akun['cType']) ? 'selected' : ''}}>{{$item}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mt-3">
                        <button type="submit" name="submit" class="btn btn-primary">Update</button>
                    </div>
            </form>
        </div>
    </div>
</div>
@endsection
