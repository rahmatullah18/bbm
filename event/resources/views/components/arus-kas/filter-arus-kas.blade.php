<div class="container__filter__aruskas">
    <form action="{{url('finance/arus-kas')}}" method="post">
        @csrf
        @method('post')
        <div class="date__filter__aruskas">
            <div class=" mb-4">
                <label for="flatpickr-date" class="form-label">Date Picker</label>
                <input type="date" name="start_postdate" class="@error('start_postdate') border border-danger @enderror form-control flatpickr-input active" placeholder="YYYY-MM-DD" id="flatpickr-date">
            </div>
            <div class=" mb-4">
                <label for="flatpickr-date" class="form-label">Date Picker</label>
                <input type="date" name="end_postdate" class="@error('start_postdate') border border-danger @enderror form-control flatpickr-input active" placeholder="YYYY-MM-DD" id="flatpickr-date">
            </div>
            <div class="">
                <button class="btn btn-primary">Tampilkan</button>
            </div>
        </div>
    </form>
    <a href="{{route('finance-arus-kas-export')}}" class="btn btn-success">Excel</a>
</div>
