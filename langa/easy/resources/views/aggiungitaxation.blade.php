@extends('adminHome')
@section('page')

@if(!empty(Session::get('msg')))

    <script>

    var msg = '<?php echo html_entity_decode(htmlentities(Session::get('msg'))); ?>';

    document.write(msg);

    </script>

@endif
@include('common.errors')



<div class="row">
  <div class="col-md-8">

    <form action="{{url('/taxation/store')}}" id="taxation_form" method="post">
      {{ csrf_field() }}

      @if(isset($taxation))
          <h1>Update template per Tassazione</h1><hr>
          <label>Tassazione Nome <p style="color:#f37f0d;display:inline">(*)</p></label>
          <input class="form-control" name="tassazione_nome" value="{{ $taxation->tassazione_nome }}">
          <br>
          <label>Tassazione Percentuale <p style="color:#f37f0d;display:inline">(*)</p></label>
          <input class="form-control" name="tassazione_percentuale" value="{{ $taxation->tassazione_percentuale }}">
          <br>
          <input type="hidden" name="tassazione_id" value="{{ $taxation->tassazione_id }}">
          <input class="btn btn-warning" type="submit" value="Modify">
      @else
          <h1>Aggiungi template per Tassazione</h1><hr>
          <label>Tassazione Nome <p style="color:#f37f0d;display:inline">(*)</p></label>
          <input class="form-control" name="tassazione_nome" value="">
          <br>
          <label>Tassazione Percentuale <p style="color:#f37f0d;display:inline">(*)</p></label>
          <input class="form-control" name="tassazione_percentuale" value="">
          <br>
          <input class="btn btn-warning" type="submit" value="Aggiungi">
      @endif

    </form>
  </div>
</div>

@endsection