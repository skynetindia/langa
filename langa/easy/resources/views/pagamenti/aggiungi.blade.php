@extends('layouts.app')

@section('content')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
		<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
<h1>Aggiungi disposizione per progetto</h1><hr>

@if(!empty(Session::get('msg')))
    <script>
    var msg = '<?php echo html_entity_decode(htmlentities(Session::get('msg'))); ?>';
    document.write(msg);
    </script>
@endif
@include('common.errors')

	{{ csrf_field() }}
	<!-- colonna a sinistra -->
	<div class="col-md-4">
		<label for="nomeazienda">Nome azienda <p style="color:#f37f0d;display:inline">(*)</p></label>
		<input value="{{ old('nomeazienda') }}" class="form-control" type="text" name="nomeazienda" id="nomeazienda" placeholder="Nome azienda"><br>

		<script>
			$.datepicker.setDefaults(
        		$.extend(
            		{'dateFormat':'dd/mm/yy'},
            		$.datepicker.regional['nl']
        		)
    		);
			$('#nomeazienda').datepicker();
		</script>
	</div>
	<!-- colonna centrale -->
	<div class="col-md-4">
		<label for="nomereferente">Nome referente <p style="color:#f37f0d;display:inline">(*)</p></label>
		<input value="{{ old('nomereferente') }}" class="form-control" type="text" name="nomereferente" id="nomereferente" placeholder="Nome referente"><br>

	</div>
	<!-- colonna a destra -->
	<div class="col-md-4">
		<label for="telefonoazienda">Telefono azienda <p style="color:#f37f0d;display:inline">(*)</p></label>
		<input value="{{ old('telefonoazienda') }}" class="form-control" type="text" name="telefonoazienda" id="telefonoazienda" placeholder="Telefono primario"><br>


	</div>
@endsection