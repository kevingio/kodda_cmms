<div class="row mb-3">
    <div class="col-6 col-sm-4 col-lg-3 col-xl-2">
        <select class="form-control" name="month">
            @for($i = 1; $i < 13; $i++)
            <option value="{{ $i }}">{{ date('F', strtotime('2018-'.str_pad($i, 2, '0', STR_PAD_LEFT).'-01')) }}</option>
            @endfor
        </select>
    </div>
    <div class="col-6 col-sm-4 col-lg-3 col-xl-2">
        <select class="form-control" name="year"></select>
    </div>
</div>
