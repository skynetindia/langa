@extends('layouts.app')
@section('content')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
		<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
<style>tr:hover td {
    background: #f2ba81;
}</style>

<h1>Modifica corpo fattura</h1><hr>
<button class="btn btn-info" onclick="window.close();" title="Torna alla disposizione"><span class="fa fa-arrow-left"></span></button><br>

@if(!empty(Session::get('msg')))
    <script>
    var msg = '<?php echo html_entity_decode(htmlentities(Session::get('msg'))); ?>';
    document.write(msg);
    </script>
@endif

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
		<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>

@include('common.errors')

<form action="{{url('/pagamenti/tranche/corpofattura/update') . '/' . $tranche}}" method="post">
    {{ csrf_field() }}
    <div class="row">
        <div class="col-md-12">
            <input type="submit" class="btn btn-warning btn-sm" value="Salva">
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered">
        	<th>Ordinamento numerico</th>
        	<th>Ordine Preventivo</th>
            <th>Descrizione                                                                                                              </th>
            <th>Q.tà</th>
            <th>Subtotale</th>
            <th>Sconto agente</th>
            <th>Sconto bonus</th>
            <th>Prezzo netto</th>
            <th>Percentuale iva</th>
    	   @foreach($corpofattura as $fattura)
                <tr>
                	<td><input type="number" class="form-control" name="ordine_numerico[]" value="{{$fattura->ordine_numerico}}"></td>
                    <td><input type="text" class="form-control" name="ord[]" value="{{$fattura->ordine}}"></td>
                    <td><textarea class="form-control" name="desc[]">{{$fattura->descrizione}}</textarea></td>
                    <td><input type="text" class="form-control" name="qt[]" value="{{$fattura->qta}}"></td>
                    <td><input type="text" class="form-control" name="sub[]" value="{{$fattura->subtotale}}"></td>
                    <td><input type="text" class="form-control" name="scontoagente[]" value="{{$fattura->scontoagente}}"></td>
                    <td><input type="text" class="form-control" name="scontobonus[]" value="{{$fattura->scontobonus}}"></td>
                    <td><input type="text" class="form-control" name="netto[]" value="{{$fattura->netto}}"></td>
                    <td><input type="text" class="form-control" name="iva[]" value="{{$fattura->percentualeiva}}"></td>
                    <td><a href="{{url('pagamenti/tranche/corpofattura/delete') . '/' . $fattura->id}}" class="btn btn-danger" style="text-decoration:none">Cancella</a></td>
                </tr>
            @endforeach
        </table>
        <div class="row">
            <div class="col-md-12">
                <input type="submit" class="btn btn-warning btn-sm" value="Salva">
            </div>
        </div>
    </div>
</form>

@endsection