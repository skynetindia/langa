@extends('adminHome')

@section('page')
<h1> Alert Tipo </h1><hr>
@include('common.errors')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script type="text/javascript" src="{{asset('public/scripts/colors.js')}}"></script>
<script type="text/javascript" src="{{asset('public/scripts/jqColorPicker.min.js')}}"></script>
<script type="text/javascript">
	
         $('.color').colorPicker(); // that's it
   
</script>


<fieldset>
<legend style="padding-left:10px;color:#fff;background-color: #999">Tipi</legend>
<h4>Aggiungi tipo</h4>
<form action="{{url('/alert/add/tipo')}}" method="post" name="alerttipo" id="alerttipo">
    {{ csrf_field() }}
	<div class="col-md-4"> 
		<p style="color:#f37f0d;display:inline">(*)</p>
		<input type="text" class="form-control" id="nome_tipo" name="nome_tipo" placeholder="Nome"><br> 
	</div>
	<div class="col-md-4">
	
	<br>
		<input type="text" class="form-control" id="desc_tipo" name="desc_tipo" placeholder="Descrizione"><br> 
	</div>
	<div class="col-md-4">
	<br>
		<input class="form-control color no-alpha" value="#f37f0d" name="color" id="color" /><br>
	</div>
	<div style="text-align:right">
		<input type="submit" class="btn btn-primary" value="Aggiungi">
	</div>
</form>
<h4>Modifica tipi</h4>
<div class="table-responsive">
		<table class="table table-striped table-bordered" style="text-align:right">
	@foreach($alert_tipo as $type)
		
		<tr>
		<form action="{{url('/admin/update/tipo')}}" method="post" id="modifyalerttipo" name="modifyalerttipo">
		{{ csrf_field() }}
		<input type="hidden" name="id_tipo" value="{{$type->id_tipo}}">
		<div class="form-group">
			<div class="col-xs-6 col-sm-3">
			<td>
				<input type="text" class="form-control" name="nome_tipo" id="nome_tipo" value="{{$type->nome_tipo}}"> 
				</td>
			</div>
			<div class="col-xs-6 col-sm-3">
				<td><input type="text" class="form-control" name="desc_tipo" value="{{$type->desc_tipo}}"></td>
			</div>
			<div class="col-xs-6 col-sm-3">
				<td><input type="text" class="form-control color no-alpha" name="color" value="{{$type->color}}"></td>
			</div>
			<div class="col-xs-6 col-sm-3">
				<td><input type="submit" class="btn btn-primary" value="Salva">
				<a  onclick="conferma(event);" type="submit" href="{{url('/admin/delete/tipo' . '/' . $type->id_tipo)}}" class="btn danger"><button type="button" class="btn btn-danger">Cancella</button></a></td>
			</div>	
		</div>
		
	</form>
	</tr>
	
	@endforeach
	</table>
	</div>
	
</form>
</fieldset>

<script>
	function conferma(e) {
	var confirmation = confirm("Sei sicuro?") ;
    if (!confirmation)
        e.preventDefault();
	return confirmation ;
}
</script>

<script type="text/javascript" src="{{asset('public/scripts/index.js')}}">

@endsection