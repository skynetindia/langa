@extends('adminHome')

@section('page')
<h1>Lavorazioni</h1><hr>
@if(!empty(Session::get('msg')))
    <script>
    var msg = '<?php echo html_entity_decode(htmlentities(Session::get('msg'))); ?>';
    document.write(msg);
    </script>
@endif
@include('common.errors')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script type="text/javascript" src="{{asset('public/scripts/colors.js')}}"></script>
<script type="text/javascript" src="{{asset('public/scripts/jqColorPicker.min.js')}}"></script>
<script type="text/javascript">	
         $('.color').colorPicker(); // that's it   
</script>
@foreach($departments as $departments)
	<?php $lavorazioni = DB::table('lavorazioni')->where('departments_id', $departments->id)->get(); ?>
<fieldset>
<form action="{{url('/admin/tassonomie/lavorazioninew')}}" method="post">
	<div class="col-md-12">
    <legend style="padding-left:10px;color:#fff;background-color: #999;" class="col-md-8">{{$departments->nomedipartimento}}</legend>
    <legend class="col-md-4 pull-right"><input class="form-control color no-alpha" value="#f37f0d" name="color" /></legend>
    </div>
    <br />
<h4>Aggiungi tipo</h4>
    {{ csrf_field() }}
    <input type="hidden" name="departments_id" id="departments_id" value="{{$departments->id}}" />
	<div class="col-md-4">
		<input type="text" class="form-control" required="required" name="name" placeholder="Nome"><br> 
	</div>
	<div class="col-md-8">
		<input type="text" class="form-control" name="description" placeholder="Descrizione"><br> 
	</div>	
	<div style="text-align:right">
		<input type="submit" class="btn btn-primary" value="Aggiungi">
	</div>
</form>
<h4>Modifica tipi</h4>
<div class="table-responsive">
		<table class="table table-striped table-bordered" style="text-align:right">
	@foreach($lavorazioni as $lavorazioni)		
		<tr>
		<form action="{{url('/admin/tassonomie/lavorazioniupdate')}}" method="post">        
		{{ csrf_field() }}
        <input type="hidden" name="departments_id" id="departments_id" value="{{$departments->id}}" />
		<input type="hidden" name="id" value="{{$lavorazioni->id}}">
		<div class="form-group">
			<div class="col-xs-6 col-sm-3">
				<td width="20%"><label class="pull-left">Nome lavorazione</label><input type="text" required="required" class="form-control" name="name" id="name" value="{{$lavorazioni->nome}}"> </td>
			</div>
			<div class="col-xs-6 col-sm-3">
				<td><label class="pull-left">Descizione</label><input type="text" class="form-control" name="description" value="{{$lavorazioni->description}}"></td>
			</div>
            <input type="hidden" name="color" value="{{$lavorazioni->color}}" />
            <?php 
			// ON ACTIVE THIS REMOVE HIDDEN COLOR INPUT TYPE
			/*<div class="col-xs-6 col-sm-3">
				<td><input type="text" class="form-control color no-alpha" name="color" value="{{$lavorazioni->color}}"></td>
			</div>*/?>		
			<div class="col-xs-6 col-sm-3">
				<td width="15%"><input type="submit" class="btn btn-primary" value="Salva">
				<a onclick="conferma(event);" type="submit" href="{{url('/admin/tassonomie/lavorazionidelete/id' . '/' . $lavorazioni->id)}}" class="btn danger"><button type="button" class="btn btn-danger">Cancella</button></a></td>
			</div>	
		</div>		
	</form>
	</tr>	
	@endforeach
	</table>
	</div>	
</form>
</fieldset>
	@endforeach
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