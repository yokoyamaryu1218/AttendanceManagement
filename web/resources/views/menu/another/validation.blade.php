@if ($errors->has('name'))
<div class="alert text-center alert-warning">
    {{ $errors->first('name') }}
</div>
@endif
@if ($errors->has('password'))
<div class="alert text-center alert-warning">
    {{ $errors->first('password') }}
</div>
@endif
@if ($errors->has('management_emplo_id'))
<div class="alert text-center alert-warning">
    {{ $errors->first('management_emplo_id') }}
</div>
@endif
