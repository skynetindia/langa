@extends('layouts.app')
@section('content')

<script src="{{ asset('public/scripts/jquery.min.js') }}"></script>

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.11.0/bootstrap-table.min.css">

<!-- Latest compiled and minified JavaScript -->
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.11.0/bootstrap-table.min.js"></script>

<!-- Latest compiled and minified Locales -->
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.11.0/locale/bootstrap-table-it-IT.min.js"></script>

<h1>Newsletter</h1><hr>

@if(!empty(Session::get('msg')))
    <script>
    var msg = '<?php echo html_entity_decode(htmlentities(Session::get('msg'))); ?>';
    document.write(msg);
    </script>
@endif

<div class="row">
  <div class="col-md-8">
    <form action="{{url('/newsletter/send')}}" method="post">
      {{ csrf_field() }}
      <label for="email">Seleziona Ente</label>
      <select name="email" class="form-control">
        @foreach($enti as $ente)
          <option value="{{$ente->email}}">{{$ente->nomereferente}}</option>
        @endforeach
      </select><br>
      <label for="oggetto">Seleziona template</label>
      <select class="form-control" id="template">
        <option selected></option>
        @foreach($newsletter as $n)
          <option value="{{$n->id}}">{{$n->name}}</option>
        @endforeach
      </select><br>
      <label for="contenuto">Contenuto</label>
      <textarea class="form-control" rows="15" id="contenuto" name="contenuto">

      </textarea><br>
      <input class="btn btn-warning" type="submit" value="Invia">
      <script>
      var newsletter = <?php echo json_encode($newsletter); ?>;
      $('#template').change(function() {
        for(var i = 0; i < newsletter.length; i++) {
          if(newsletter[i]["id"] == $('#template').val()) {
            $('#contenuto').val(newsletter[i]["contenuto"]);
            break;
          }
        }
      });
      </script>
    </form>
  </div>
</div>

@endsection