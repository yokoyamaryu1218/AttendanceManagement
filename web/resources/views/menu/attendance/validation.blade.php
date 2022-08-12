@if (session('warning'))
<div class="alert alert-warning">
    <small>{{ session('warning') }}</small>
</div>
@endif

@if (session('status'))
<div class="alert alert-info">
    <small> {{ session('status') }}</small>
</div>
@endif

@if ($errors->has('first_day'))
<div class="alert text-center alert-warning">
    <small>{{ $errors->first('first_day') }}</small>
</div>
@endif

@if ($errors->has('end_day'))
<div class="alert text-center alert-warning">
    <small>{{ $errors->first('end_day') }}</small>
</div>
@endif
