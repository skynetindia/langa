@extends('adminHome')
@section('page')

<h1>Modifica template per newsletter</h1><hr>
@if(!empty(Session::get('msg')))

    <script>

    var msg = '<?php echo html_entity_decode(htmlentities(Session::get('msg'))); ?>';

    document.write(msg);

    </script>

@endif
@include('common.errors')


<div class="row">
  <div class="col-md-12">
    <form action="{{url('/newsletter/update') . '/' . $newsletter->id}}" method="post">
      {{ csrf_field() }}
      <label>Oggetto</label>
      <input class="form-control" name="name" value="{{$newsletter->name}}"><br>
      <label>Dipartimento</label>
      <select class="form-control" name="dipartimento">
        <option <?php if($newsletter->dipartimento == "AMMINISTRAZIONE") echo 'selected'; ?> value="AMMINISTRAZIONE">AMMINISTRAZIONE</option>
        <option <?php if($newsletter->dipartimento == "COMMERCIALE") echo 'selected'; ?> value="COMMERCIALE">COMMERCIALE</option>
        <option <?php if($newsletter->dipartimento == "TECNICO") echo 'selected'; ?> value="TECNICO">TECNICO</option>
      </select><br>
      <label>Contenuto Template</label>
      <textarea name="contenuto" class="form-control" rows="15">{{$newsletter->contenuto}}
      </textarea><br>
      <input class="btn btn-warning" type="submit" value="Aggiungi">
    </form>
  </div>
</div>


@endsection