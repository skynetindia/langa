@extends('layouts.app')
@section('content')

<h1>Modifica costo: <strong>{{$costo->oggetto}}</strong></h1>

@if(!empty(Session::get('msg')))
    <script>
    var msg = '<?php echo html_entity_decode(htmlentities(Session::get('msg'))); ?>';
    document.write(msg);
    </script>
@endif

<button class="btn btn-info btn-lg" onclick="window.close();">Torna alle statistiche</button>
<br>
<div class="col-md-12">
    <form action="{{url('/costo/aggiorna') . '/' . $costo->id}}" method="post">
        {{ csrf_field() }}
             Oggetto: <input type="text" name="oggetto" value="{{$costo->oggetto}}" class="form-control">
             Costo: <input type="text" name="costo" value="{{$costo->costo}}" class="form-control">
             Data inserimento: <input type="text" name="datainserimento" value="{{$costo->datainserimento}}" class="form-control">
             Ente: <select class="form-control" name="ente">
                  @foreach($enti as $ente)
                  	@if($costo->id_ente == $ente->id)
                  		<option selected value="{{$ente->id}}">{{$ente->id}} | {{$ente->nomeazienda}}</option>
                  	@else
                    	<option value="{{$ente->id}}">{{$ente->id}} | {{$ente->nomeazienda}}</option>
                    @endif
                  @endforeach
             </select>
             <input type="submit" value="Salva">
    </form>
</div>

@endsection