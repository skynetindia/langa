@extends('adminHome')

@section('page')
<h1>Tassonomie enti</h1><hr>
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
<form action="{{url('/admin/tassonomie/new')}}" method="post">
    {{ csrf_field() }}
	<div class="col-md-4">
		<input type="text" class="form-control" name="name" placeholder="Nome"><br> 
	</div>
	<div class="col-md-4">
		<input type="text" class="form-control" name="description" placeholder="Descrizione"><br> 
	</div>
	<div class="col-md-4">
		<input class="form-control color no-alpha" value="#f37f0d" name="color" /><br>
	</div>
	<div style="text-align:right">
		<input type="submit" class="btn btn-primary" value="Aggiungi">
	</div>
</form>
<h4>Modifica tipi</h4>
<div class="table-responsive">
		<table class="table table-striped table-bordered" style="text-align:right">
	@foreach($tipi as $tipo)
		
		<tr>
		<form action="{{url('/admin/tassonomie/update')}}" method="post">
		{{ csrf_field() }}
		<input type="hidden" name="id" value="{{$tipo->id}}">
		<div class="form-group">
			<div class="col-xs-6 col-sm-3">
				<td><input type="text" class="form-control" name="name" id="name" value="{{$tipo->name}}"> </td>
			</div>
			<div class="col-xs-6 col-sm-3">
				<td><input type="text" class="form-control" name="description" value="{{$tipo->description}}"></td>
			</div>
			<div class="col-xs-6 col-sm-3">
				<td><input type="text" class="form-control color no-alpha" name="color" value="{{$tipo->color}}"></td>
			</div>
			<div class="col-xs-6 col-sm-3">
				<td><input type="submit" class="btn btn-primary" value="Salva">
				<a  onclick="conferma(event);" type="submit" href="{{url('/admin/tassonomie/delete/id' . '/' . $tipo->id)}}" class="btn danger"><button type="button" class="btn btn-danger">Cancella</button></a></td>
			</div>	
		</div>
		
	</form>
	</tr>
	
	@endforeach
	</table>
	</div>
	
</form>
</fieldset>

<fieldset>
<legend style="padding-left:10px;color:#fff;background-color: #999">Stato emotivo</legend>
<form action="{{url('/admin/tassonomie/nuovostatoemotivo')}}" method="post">
    {{ csrf_field() }}
	<div class="col-md-4">
		<input type="text" class="form-control" name="name" placeholder="Nome"><br> 
	</div>
	<div class="col-md-4">
		<input type="text" class="form-control" name="description" placeholder="Descrizione"><br> 
	</div>
	<div class="col-md-4">
		<input class="form-control color no-alpha" value="#f37f0d" name="color" /><br>
	</div>
	<div style="text-align:right">
		<input type="submit" class="btn btn-primary" value="Aggiungi">
	</div>
</form>
<h4>Modifica stato emotivo</h4>
<div class="table-responsive">
		<table class="table table-striped table-bordered" style="text-align:right">
	@foreach($statiemotivitipi as $statoemotivotipo)
		
		<tr>
		<form action="{{url('/admin/tassonomie/aggiornastatiemotivi')}}" method="post">
		{{ csrf_field() }}
		<input type="hidden" name="id" value="{{$statoemotivotipo->id}}">
		<div class="form-group">
			<div class="col-xs-6 col-sm-3">
				<td><input type="text" class="form-control" name="name" id="name" value="{{$statoemotivotipo->name}}"> </td>
			</div>
			<div class="col-xs-6 col-sm-3">
				<td><input type="text" class="form-control" name="description" value="{{$statoemotivotipo->description}}"></td>
			</div>
			<div class="col-xs-6 col-sm-3">
				<td><input type="text" class="form-control color no-alpha" name="color" value="{{$statoemotivotipo->color}}"></td>
			</div>
			<div class="col-xs-6 col-sm-3">
				<td><input type="submit" class="btn btn-primary" value="Salva">
				<a  onclick="conferma(event);" type="submit" href="{{url('/admin/tassonomie/statiemotivi/delete/id' . '/' . $statoemotivotipo->id)}}" class="btn danger"><button type="button" class="btn btn-danger">Cancella</button></a></td>
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