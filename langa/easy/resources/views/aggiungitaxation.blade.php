@extends('adminHome')
@section('page')

<h1>Aggiungi template per Tassazione</h1><hr>
@if(!empty(Session::get('msg')))

    <script>

    var msg = '<?php echo html_entity_decode(htmlentities(Session::get('msg'))); ?>';

    document.write(msg);

    </script>

@endif
@include('common.errors')

<div class="row">
  <div class="col-md-6">
    <form action="{{url('/taxation/store')}}" method="post">
      {{ csrf_field() }}
      
      <label>Tassazione Nome</label>
      <input class="form-control" name="tassazione_nome" value="">
      <br>
      <label>Tassazione Percentuale</label>
      <input class="form-control" name="tassazione_percentuale" value="">
      <br>
      <input class="btn btn-warning" type="submit" value="Aggiungi">
    </form>
  </div>
</div>

@endsection