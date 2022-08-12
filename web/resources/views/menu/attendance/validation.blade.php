@if (session('warning'))
<div class="alert alert-warning">
    {{ session('warning') }}
</div>
@endif

@if (session('status'))
<div class="alert alert-info">
    {{ session('status') }}
</div>
@endif

@if ($errors->has('first_day'))
<div class="alert text-center alert-warning">
    {{ $errors->first('first_day') }}
</div>
@endif

@if ($errors->has('end_day'))
<div class="alert text-center alert-warning">
    {{ $errors->first('end_day') }}
</div>
@endif

@if ($errors->has('end_day'))
<div class="alert text-center alert-warning">
    {{ $errors->first('end_day') }}
</div>
@endif

