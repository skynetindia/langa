<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
		<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>

<link href="http://easy.langa.tv/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="{{asset('public/css/select2.min.css')}}"> 
<script src="{{asset('public/scripts/select2.full.min.js')}}"></script>

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
<style>
	body {
		background: #f37f0d;
	}

</style>
</head>
<body>
<!-- Modify event modal -->
<!-- Start edit event modal -->
<div class="modal fade" id="editEvent" role="dialog" aria-labelledby="modalTitle">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button> -->
                 <button type="button" class="close" data-dismiss="modal">&times;</button>
             
        		<h3 class="modal-title" id="modalTitle">Modifica evento</h3>
			</div>
			<div class="modal-body">
				
        		<!-- Start form to modify an event -->
        		@include('common.errors')
        		<form action="{{ url('/calendario/update/event/' . $event->id) }}" method="post">
        			<!-- Start form to add a new event -->
        			{{ csrf_field() }}
                                @include('common.errors')
                                <div class="form-group">
        				<label for="ente" class="control-label">Ente</label>
						<select name="ente" id="ente" class="js-example-basic-single form-control" style="width:100%">
                                                    <option selected></option>
						@foreach($enti as $ente)
                            @if($ente->id == $event->id_ente)
                                <option selected value="{{$ente->id}}">{{$ente->nomeazienda}} | {{$ente->nomereferente}}</option>
                            @else
								<option value="{{$ente->id}}">{{$ente->nomeazienda}} | {{$ente->nomereferente}}</option>
                                                @endif
						@endforeach
						</select><script type="text/javascript">

    $(".js-example-basic-single").select2();

</script>
        			</div>
					<div class="form-group">
        				<label for="titolo" class="control-label">Oggetto</label>
        				<input value="{{ $event->titolo }}" type="text" name="titolo" id="titolo" class="form-control" placeholder="Appuntamento per discutere...">
        			</div>
                    <div class="form-group">
        				<label for="dove" class="control-label">Dove?</label>
        				<input value="{{ $event->dove }}" type="text" name="dove" id="dove" class="form-control" placeholder="Indirizzo appuntamento (Città, via, numero civico...)">
        			</div>
        			<div class="form-group">
        				<label for="dettagli" class="control-label">Dettagli</label>
        				<textarea rows="4" name="dettagli" id="dettagli" class="form-control" placeholder="Informazioni generali">{{ $event->dettagli }}</textarea>
        			</div>
        			<fieldset>
        			<legend>Orario</legend>
					<div class="col-md-12">
                    	<div class="col-md-4">
						<h4>Ora</h4>

                                                <label for="sh" class="control-label">Dalle</label><br>
        				<input type="text" class="form-control" name="sh" value="{{ $event->sh }}">

                                                <br><label for="eh" class="control-label">Alle</label><br>
        				<input type="text" class="form-control" name="eh" value="{{ $event->eh }}">

                                        </div>
                                <div class="col-md-4">
                                    <h4>Giorno</h4>

        				<label for="giorno" class="control-label">Dal</label> 
        				<?php
        				if($event->giorno < 10)
        					$event->giorno = '0' . $event->giorno;
        					
        				if($event->mese < 10)
        					$event->mese = '0' . $event->mese;
        					
        				if($event->giornoFine < 10)
        					$event->giornoFine = '0' . $event->giornoFine;
        					
        				if($event->meseFine < 10)
        					$event->meseFine = '0' . $event->meseFine;
        				?>
        				<input value="{{ $event->giorno . '/' . $event->mese . '/' . $event->anno}}" type="text" name="giorno" id="giorno" class="form-control">
     
        				<br><label for="giornoFine" class="control-label">Al</label> 
        				<input value="{{$event->giornoFine . '/' . $event->meseFine . '/' . $event->annoFine }}" type="text" name="giornoFine" id="giornoFine" class="form-control">
                                        <br>
            
                                    <script>
                                        $.datepicker.setDefaults(
                                        $.extend(
                                          {'dateFormat':'dd/mm/yy'},
                                          $.datepicker.regional['nl']
                                        )
                                      );
                                    $('#giorno').datepicker();
                                    $('#giornoFine').datepicker();
                                    </script>    
                                </div>
                                <div class="col-md-4">
                                <h4>Notifica</h4>
                                <label for="notifica">Inviare notifica?</label>
                                <select class="form-control" name="notifica" id="notifica">
                                        <option selected value="0">No</option>
                                        <option value="1">Si</option>
                                </select><br>
                                <label for="privato">Privato?</label>
                                <select class="form-control" name="privato" id="privato">
                                	@if($event->privato == 1)
                                        <option value="0">No</option>
                                        <option selected value="1">Si</option>
                                    @else
                                    	<option selected value="0">No</option>
                                        <option value="1">Si</option>
                                    @endif
                                </select><br>
                                </div></div>
        			</fieldset>
        			<div class="modal-footer">
        				<input type="submit" class="btn btn-primary" value="Salva ed esci">
      				</div>
        		</form>
      		</div>
      		
		</div>
	</div>
</div>

<script>
function conferma(e) {
	var confirmation = confirm("Sei sicuro?") ;
    if (!confirmation)
        e.preventDefault();
	return confirmation ;
}
setTimeout(function(){
	$('#editEvent').modal('show');
}, 100);

$('body').bind('click', function() {
	setTimeout(function(){
	$('#editEvent').modal('show');
}, 1000);
});

</script>

</body>
</html>