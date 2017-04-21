@extends('adminHome')
@section('page')

<h1>Aggiungi template per newsletter</h1><hr>
@if(!empty(Session::get('msg')))

    <script>

    var msg = '<?php echo html_entity_decode(htmlentities(Session::get('msg'))); ?>';

    document.write(msg);

    </script>

@endif
@include('common.errors')


<div class="row">
  <div class="col-md-12">
    <form action="{{url('/newsletter/store')}}" method="post">
      {{ csrf_field() }}
      <label>Oggetto</label>
      <input class="form-control" name="name" value="{{old('name')}}"><br>
      <label>Dipartimento</label>
      <select class="form-control" name="dipartimento">
        <option value="AMMINISTRAZIONE">AMMINISTRAZIONE</option>
        <option value="COMMERCIALE">COMMERCIALE</option>
        <option value="TECNICO">TECNICO</option>
      </select><br>
      <label>Contenuto Template</label>
      <textarea name="contenuto" class="form-control" rows="15">{{old('contenuto')}}
      </textarea><br>
      <input class="btn btn-warning" type="submit" value="Aggiungi">
    </form>
  </div>
</div>


@endsection