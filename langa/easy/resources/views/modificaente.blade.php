@extends('layouts.app')

@section('content')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
		<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>

<!-- Include Date Range Picker -->
<script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />

<!--<link href="{{asset('build/js/jquery.datetimepicker.min.css')}}" rel="stylesheet">
<script src="{{asset('build/js/jquery.datetimepicker.full.js')}}"></script>-->

<h1><?php echo (isset($action) && $action=='add') ? 'Aggiungi ente' : 'Modifica ente'; ?></h1><hr>
<style>
table tr td {
	text-align:left;
	
}
.table-editable {
  position: relative;
}
.table-editable .glyphicon {
  font-size: 20px;
}

.table-remove {
  color: #700;
  cursor: pointer;
}
.table-remove:hover {
  color: #f00;
}

.table-up, .table-down {
  color: #007;
  cursor: pointer;
}
.table-up:hover, .table-down:hover {
  color: #00f;
}

.table-add {
  color: #070;
  cursor: pointer;
  position: absolute;
  top: 8px;
  right: 0;
}
.table-add:hover {
  color: #0b0;
}

      #map {
        height: 100%;
		height: 400px;
      }
      .controls {
        margin-top: 10px;
        border: 1px solid transparent;
        border-radius: 2px 0 0 2px;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        height: 32px;
        outline: none;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
      }

      #pac-input {
        background-color: #fff;
        font-family: Roboto;
        font-size: 15px;
        font-weight: 300;
        margin-left: 12px;
        padding: 0 11px 0 13px;
        text-overflow: ellipsis;
        width: 300px;
      }

      #pac-input:focus {
        border-color: #4d90fe;
      }

      .pac-container {
        font-family: Roboto;
      }

      #type-selector {
        color: #fff;
        background-color: #4d90fe;
        padding: 5px 11px 0px 11px;
      }

      #type-selector label {
        font-family: Roboto;
        font-size: 13px;
        font-weight: 300;
      }
</style>
@if(!empty(Session::get('msg')))
    <script>
    var msg = '<?php echo html_entity_decode(htmlentities(Session::get('msg'))); ?>';
    document.write(msg);
    </script>
@endif
@include('common.errors')
@if(isset($corp->logo))
<div class="container-fluid col-md-12">
	<div style="display:inline">
 	<img src="{{url('/storage/app/images/').'/'.$corp->logo}}" style="max-width:100px; max-height:100px;display:inline"></img><h4 style="display:inline">  Codice: {{$corp->id}}</h4>
    <hr>
	</div>
</div>
@endif
<?php /*<div class="container-fluid col-md-12" style="background:#2a3f54;color:#ffffff"><br>
	<form action="http://maps.google.com/maps" onsubmit="punto()" method="get" target="new">
		<div>
			<div class="col-md-12">
				<h4 style="display:inline;color:#ffffff">Vuoi raggiungere l'ente?</h4>
	   			<br><br><input style="display:inline" class="form-control" style="color:#000000;max-width:250px;" type="text" name="saddr" placeholder="Inserisci la tua posizione">
	   			
<br>
	   			<input style="display:inline" type="hidden" id="prova" name="daddr">
	   			<br><input style="display:inline;background:#f37f0d; color:#ffffff;" class="form-control" type="submit" value="Vai dall'ente"><br><br><br>
	   		</div>
	   	    </div>
		</div>
	</form>
</div>*/?>
<?php 
if(isset($corp->id)){
	echo Form::open(array('url' => '/enti/update/corporation/' . $corp->id, 'files' => true,'id'=>'frmModificaente')); 
}
else {
	echo Form::open(array('url' => '/enti/store/', 'files' => true));
}
?>
	{{ csrf_field() }}
       
	<!-- inizio chiamata -->
  <div class="row">
	<div class="col-md-12" style="padding-top:10px;">
		<h4>Note (Conversazioni, costi, appunti,..)</h4>
		<a id="creaNuovaChiamata" class="btn btn-warning" name="create" title="Crea nuovo"><i class="fa fa-plus"></i></a>
		<a class="btn btn-danger" id="removeNote"  name="remove" title="Elimina"><i class="fa fa-eraser"></i></a>
		<div class="table-editable" style="padding-top:10px">
			<table class="table table-striped table-bordered">
			<thead>
				<th>#
				<th>Utente
                <th>Appunti
                <th>Date
                <th>Banca
                <th>Cassa
                <th>Frequenza
                <th>Notifiche                
				<?php /*<th>Ricontattare il giorno
				<th>Alle
				<th>Data inserimento*/?>
			</thead>
				<script>
				
				var ele;
				var k = 0;
				</script>
				<tbody id="tb"><script>$.datepicker.setDefaults(
                                        $.extend(
                                          {'dateFormat':'dd/mm/yy'},
                                          $.datepicker.regional['nl']
                                        )
                                      ); 
                    var $j = jQuery.noConflict();</script>
					@for($i = 0; $i < count($chiamate); $i++)
						<tr>
						<td>
							<input type="checkbox" class="selezione_note">
						</td>
                        <td><select class="form-control" id="utenti<?php echo $i; ?>"  name="utente[]"  class="form-control" >
                        @if(isset($action) && $action == 'add')
                         @foreach($utenti as $utente)
                            <option value="{{$utente->id}}" <?php if(isset($chiamate[$i]->id_utente) && $chiamate[$i]->id_utente == $utente->id ){ echo 'selected';}?>>{{$utente->name}}</option>
                         @endforeach
                        @else
                            @foreach($partecipanti as $partecipante)
                            <option value="{{$partecipante->id_user}}" <?php if(isset($chiamate[$i]->id_utente) && $chiamate[$i]->id_utente == $partecipante->id_user ){ echo 'selected';}?>>
                             @foreach($utenti as $utente)
                                            @if($utente->id == $partecipante->id_user)
                                                {{$utente->name}}
                                                @break
                                            @endif
                                        @endforeach
                            </option>
                            @endforeach
                        @endif
	        	        </select>
						</td>
						<td>
							<input type="text" id="editable<?php echo $i; ?>" name="ric[]" class="form-control" value="<?php echo isset($chiamate[$i]->appunti) ? $chiamate[$i]->appunti : ""; ?>">
						</td>
						<td>
							<input type="text" id="datepicker_to<?php echo $i; ?>" name="datepicker_to[]" class="form-control" value="<?php echo $chiamate[$i]->datainserimento; ?>">                            
						</td>
                        <td>
							<input type="text" name="banca[]" class="form-control" value="<?php echo isset($chiamate[$i]->banca) ? $chiamate[$i]->banca : ""; ?>">
						</td>
                        <td>
							<input type="text" name="cassa[]" class="form-control" value="<?php echo isset($chiamate[$i]->cassa) ? $chiamate[$i]->cassa : ""; ?>">
						</td>
                        <td><?php 
                        	$arrFrequen = array('1_M'=>'1 M.','2_M'=>'2 M.','3_M'=>'3 M.','6_M'=>'6 M.','1_A'=>'1 A.');
							foreach($arrFrequen as $key => $val){
                        		?><input type="radio" name="frequenza[<?php echo $i; ?>]" <?php if($key == $chiamate[$i]->frequenza){ echo 'checked';}?> id="frequenza_1M" value="{{ $key }}" /> <?php echo $val;
							}
						?></td>
						<td>
                        	<input type="checkbox" name="notifiche[<?php echo $i;?>]" value="1" <?php if(isset($chiamate[$i]->notifiche) && $chiamate[$i]->notifiche == '1') { echo 'checked';}?>/>
                        </td>
						<?php /*<td>
							<input type="text" id="impedisci<?php echo $i; ?>" name="datainserimento[]" class="form-control " value="<?php echo $chiamate[$i]->datainserimento; ?>">
						</td>*/?>	
						</tr>
						<script>                                             
						var impedisciModifica2 = function() {
							this.blur();
							this.value = "<?php echo $chiamate[$i]->datainserimento; ?>";
						}	
						//$j("#datepicker_to<?php echo $i; ?>").datepicker();
						//$(function() {
						$j("#datepicker_to<?php echo $i; ?>").daterangepicker({
						 	autoApply: true,
							timePicker: true,
							timePickerIncrement: 30,
							locale: {
								format: 'MM/DD/YYYY h:mm A'
							}
						});
						//});
						$j('.selezione').on("click", function() {
							ele = $j(this).parent().parent();
						});
						$j('#impedisci<?php echo $i; ?>').bind("click", impedisciModifica2);
						k++;
						</script>
					@endfor
				</tbody>
			</table>
		</div>
		<script>
		
		$j('#removeNote').on("click", function() {
			$j('.selezione_note:checked').parents("tr").remove();
			/*var inputs = $j(".selezione_note");
			for(var i = 0; i < inputs.length; i++){
				 if($j(inputs[i]).is(":checked")){
					 $j(inputs[i]).parents('tr').remove();
				}
			}*/			
		});
		var today = new Date();
			var dd = today.getDate();
			var mm = today.getMonth()+1; //January is 0!
			var yyyy = today.getFullYear();
			var tbody = document.createElement("tbody");
			if(dd<10) {
				dd='0'+dd;
			} 
			if(mm<10) {
				mm='0'+mm;
			}
		var vecchiaData = dd + "/" + mm + "/" + yyyy + " " + new Date().toTimeString().replace(/.*(\d{2}:\d{2}:\d{2}).*/, "$1");
		var test = vecchiaData.toString();
		$j('#creaNuovaChiamata').on("click", function() {
			/*lenght = $j('#tb').length();*/
			var count = $j('#tb').children('tr').length;
			var tr = '<tr>';
			var td = '<td><input type="checkbox" id="checkNu'+count+'" class="selezione_note"></td>';
				td +='<td><select class="form-control" id="utenti'+count+'" name="utente[]"  class="form-control">';
                td +='<?php 
				        if(isset($action) && $action == 'add'){
                         foreach($utenti as $utente){
                            ?><option value="{{$utente->id}}" <?php if(isset($chiamate[$i]->id_utente) && $chiamate[$i]->id_utente == $utente->id ){ echo 'selected';}?>>{{$utente->name}}</option><?php
						 }
						}
						else {
                            foreach($partecipanti as $partecipante) {
                            ?><option value="{{$partecipante->id_user}}" <?php if(isset($chiamate[$i]->id_utente) && $chiamate[$i]->id_utente == $partecipante->id_user ){ echo 'selected';}?>><?php
                             foreach($utenti as $utente){
                                 if($utente->id == $partecipante->id_user){
                                    echo $utente->name;
	                                 break;
								 }
							 }
                            ?></option><?php 
							}
					}
				
				/*foreach($utenti as $utente){
                	    ?><option value="<?php echo $utente->id;?>"><?php echo $utente->name;?></option><?php
					}*/
	        	    ?></select></td>';				
				td +='<td><input type="text" id="editable'+count+'" name="ric[]" class="form-control" value=""></td>';
				td +='<td><input type="text" id="datepicker_to'+count+'" name="datepicker_to[]" class="form-control" value=""></td>';
				td +='<td><input type="text" name="banca[]" class="form-control" value=""></td>';
                td +='<td><input type="text" name="cassa[]" class="form-control" value=""></td>';
                td +='<td><?php 
                        	$arrFrequen = array('1_M'=>'1 M.','2_M'=>'2 M.','3_M'=>'3 M.','6_M'=>'6 M.','1_A'=>'1 A.');
							foreach($arrFrequen as $key => $val){
                        		?><input type="radio" name="frequenza['+count+']" id="frequenza_1M" value="{{ $key }}" /> <?php echo $val;
							}
						?></td>';
				td +='<td><input type="checkbox" name="notifiche['+count+']" value="1" /></td>';
				tr += td+'</tr>'
			$j("#tb").append(tr);	
			$j("#datepicker_to"+ count).daterangepicker({
						 	autoApply: true,
							timePicker: true,
							timePickerIncrement: 30,
							locale: {
								format: 'MM/DD/YYYY h:mm A'
							}
						});
			//$j("#datepicker_to" + count).datepicker();
			/*$j("#datepicker_from" + count).datepicker();*/
			$j('.selezione').on("click", function() {
				ele = $j(this).parent().parent();
			});
			$j('#impedisci' + k).bind("click", impedisciModifica);
			k++;
			/*			
			var tabella = document.getElementById("tb");
			var tr = document.createElement("tr");
			var data = document.createElement("td");
			var ora = document.createElement("td");
			var check = document.createElement("input");
			check.type = "checkbox";
			check.className = "selezione";
			var checkbox = document.createElement("td");
			var select = document.createElement("select");
			for(var i = 0; i < 24; i++) {
				var opz = document.createElement("option");
				var opz2 = document.createElement("option");
				opz.appendChild(document.createTextNode(i + ":00"));
				opz2.appendChild(document.createTextNode(i + ":30"));
				select.appendChild(opz);
				select.appendChild(opz2);
			}
			var input = document.createElement("input");
			input.name = "datainserimento[]";
			input.id = "impedisci" + k;
			input.className = "form-control";
			input.value = vecchiaData;
			data.appendChild(input);
			var appunti = document.createElement("td");
			var input = document.createElement("input");
			input.placeholder = "Scrivi qui...";
			input.name = "ric[]";
			input.className = "form-control";
			appunti.appendChild(input);
			var ric = document.createElement("td");

			checkbox.appendChild(check);
			tr.appendChild(checkbox);
			tr.appendChild(appunti);
			tr.appendChild(ric);
			select.className = "form-control";
			ora.appendChild(select);
			tr.appendChild(ora);
			tr.appendChild(data);
			var input = document.createElement("input");
			input.className = "form-control";
			input.id = "datepicker" + k;
			input.placeholder = "__/__/____";
			input.name = "ricontattare[]";
			ric.appendChild(input);
			/*
				Appunti = appunti
				Ricontattare il giorno = ric
				Alle = select
				Data inserimento = data
			*
			select.name = "alle[]";
			tabella.appendChild(tr);
			$j("#datepicker" + k).datepicker();
			$j('.selezione').on("click", function() {
				ele = $j(this).parent().parent();
			});
			$j('#impedisci' + k).bind("click", impedisciModifica);
			k++;
		*/});	
		</script>
	</div></div>
	<!-- fine chiamata -->
	<!-- colonna a sinistra -->
  <div class="row">
	<div class="col-md-4">
		<br><label for="nomeazienda">Nome azienda <p style="color:#f37f0d;display:inline">(*)</p></label>
		<input value="{{ isset($corp->nomeazienda) ? $corp->nomeazienda : ""}}" class="form-control" type="text" name="nomeazienda" id="nomeazienda" placeholder="Nome azienda"><br>
		<label for="piva">Partita IVA / Codice fiscale</label>
		<input value="{{isset($corp->piva) ? $corp->piva : ""}}" class="form-control" type="text" name="piva" id="piva" placeholder="Partita iva"><br>
		<label for="cellulareazienda">Telefono Secondario </label>
		<input value="{{isset($corp->cellulareazienda) ? $corp->cellulareazienda : ""}}" class="form-control" type="text" name="cellulareazienda" id="cellulareazienda" placeholder="Telefono opzionale"><br>
		<label for="iban">IBAN</label>
		<input value="{{isset($corp->iban) ? $corp->iban : ""}}" class="form-control" type="text" name="iban" id="iban" placeholder="IBAN"><br>
        <label for="swift">Swift</label>
		<input value="{{isset($corp->swift) ? $corp->swift : ""}}" class="form-control" type="text" name="swift" id="swift" placeholder="swift"><br>
		<br>
		
	</div>
	<!-- colonna centrale -->
	<div class="col-md-4">
		<br><label for="nomereferente">Nome referente <p style="color:#f37f0d;display:inline">(*)</p></label>
		<input value="{{ isset($corp->nomereferente) ? $corp->nomereferente : ""}}" class="form-control" type="text" name="nomereferente" id="nomereferente" placeholder="Nome referente"><br>
		<label for="cf">Carta di Credito </label>
		<input value="{{isset($corp->cf) ? $corp->cf : ""}}" class="form-control" type="text" name="cf" id="cf" placeholder="Carta di Credito"><br>
		<label for="fax">Fax</label>
		<input value="{{isset($corp->fax) ? $corp->fax :""}}" class="form-control" type="text" name="fax" id="fax" placeholder="Fax"><br>
		<label for="statoemotivo">Stato emotivo</label>
		<select name="statoemotivo" class="form-control" id="statoemotivo" style="color:#ffffff">
			<!-- statoemotivoselezionato -->
			<option style="background-color:white"></option>
			@if($statoemotivoselezionato!=null)
				@foreach($statiemotivi as $statoemotivo)
					<option @if($statoemotivo->id == $statoemotivoselezionato->id_tipo) selected @endif style="background-color:{{$statoemotivo->color}};color:#ffffff" value="{{$statoemotivo->name}}">{{$statoemotivo->name}}</option>
				@endforeach
			@else
				@foreach($statiemotivi as $statoemotivo)
					<option style="background-color:{{$statoemotivo->color}};color:#ffffff" value="{{$statoemotivo->name}}">{{$statoemotivo->name}}</option>
				@endforeach
			@endif
		</select>
		<br>
		<script>
		var yourSelect = document.getElementById( "statoemotivo" );
			document.getElementById("statoemotivo").style.backgroundColor = yourSelect.options[yourSelect.selectedIndex].style.backgroundColor;
		$j('#statoemotivo').on("change", function() {
			var yourSelect = document.getElementById( "statoemotivo" );
			document.getElementById("statoemotivo").style.backgroundColor = yourSelect.options[yourSelect.selectedIndex].style.backgroundColor;
		});
		</script>
	</div>
	<!-- colonna a destra -->
	<div class="col-md-4">
		<br><datalist id="settori"></datalist>
		<label for="settore">Settore</label>
		<input value="{{isset($corp->settore) ? $corp->settore : old('settore')}}" list="settori" class="form-control" type="text" id="settore" name="settore" placeholder="Cerca un settore..."><br>
		<label for="telefonoazienda">Telefono Primario <p style="color:#f37f0d;display:inline">(*)</p></label>
		<input value="{{ isset($corp->telefonoazienda) ? $corp->telefonoazienda : old('telefonoazienda')}}" class="form-control" type="text" name="telefonoazienda" id="telefonoazienda" placeholder="Telefono primario"><br>
		<label for="email">Email primaria <p style="color:#f37f0d;display:inline">(*)</p></label>
		<input value="{{isset($corp->email) ? $corp->email : old('email')}}" class="form-control" type="email" name="email" id="email" placeholder="Email di notifica"><br>
		<label for="emailsecondaria">Email secondaria</label>
		<input value="{{isset($corp->emailsecondaria) ? $corp->emailsecondaria : old('emailsecondaria')}}" class="form-control" type="email" name="emailsecondaria" id="emailsecondaria" placeholder="Email opzionale"><br>

	</div></div>
  <div class="">
	<div class=""><strong>Indirizzo <p style="color:#f37f0d;display:inline">(*)</p></strong><br>
	 <input value="{{ isset($corp->indirizzo) ? $corp->indirizzo : old('indirizzo') }}" id="pac-input" name="indirizzo" class="controls" type="text"
        placeholder="Inserisci un indirizzo (*)">
    <div id="type-selector" class="controls">
      <input type="radio" name="type" id="changetype-all" checked="checked">
      <label for="changetype-all">Tutti</label>

      <input type="radio" name="type" id="changetype-establishment">
      <label for="changetype-establishment">Aziende</label>

      <input type="radio" name="type" id="changetype-address">
      <label for="changetype-address">Indirizzi</label>

      <input type="radio" name="type" id="changetype-geocode">
      <label for="changetype-geocode">CAP</label>
    </div>
	
    <div id="map"></div>
	</div></div>
  <div class="row">
   <?php /*<div class="col-md-4">
    	<!-- Note enti -->
        <br><label for="noteenti">Note private del commerciale</label><a onclick="mostra()" id="mostra"> <i class="fa fa-eye"></i></a>
        	<textarea style="background-color:#f39538;color:#ffffff" rows="9" title="Note nascoste, clicca l'occhio per mostrare" class="form-control nascondi" name="noteenti" id="noteenti" placeholder="Inserisci note per caratteristiche ente"></textarea>
        <!-- /note enti -->
    </div>*/?>
    <script>
	var testo = "<?php echo isset($corp->noteenti) ? $corp->noteenti : old('noteenti'); ?>";
	function mostra() {
		if($j('#noteenti').val()) {
			testo = $('#noteenti').val();
			$j('#noteenti').val("");
		} else {
			$j('#noteenti').val(testo);
			testo = "";
		}
	}
	function mostra2() {
		if(!$j('#noteenti').val())
			$j('#noteenti').val(testo);
	}
	</script>
    
    <div class="col-md-6">
    	<!-- sede legale -->
        <br><label for="sedelegale">Sede legale</label>
        	<textarea rows="9" title="Sede dell'ente che verrà riporata nel preventivo" class="form-control" name="sedelegale" id="sedelegale" placeholder="Sede legale">{{ isset($corp->sedelegale) ? $corp->sedelegale : old('sedelegale')  }}</textarea>
        <!-- /sede legale -->
    </div>
    <div class="col-md-6">
    	<!-- logo resp tel partecipanti -->

	<br><label for="logo">Logo</label>
	<?php echo Form::file('logo', ['class' => 'form-control']); ?><br>
    
    <label for="responsabilelanga">Responsabile LANGA <p style="color:#f37f0d;display:inline">(*)</p></label>
		<select title="Responsabile associato a questo ente" name="responsabilelanga" id="responsabilelanga" class="form-control"  onchange="trovaTelefono()">
			<option></option>
			@for($i = 1; $i < count($utenti); $i++)
				@if(isset($corp->responsabilelanga) && $corp->responsabilelanga == $utenti[$i]->name)
					<option selected>{{ $utenti[$i]->name }}</option>
				@else
					<option>{{ $utenti[$i]->name }}</option>
				@endif
			@endfor
		</select>
        <br><label for="telefonoresponsabile">Telefono responsabile Langa</label>
		<input class="form-control" type="text" name="telefonoresponsabile" readonly="readonly" id="telefonoresponsabile" placeholder="Telefono responsabile Langa"><br>

		<?php /*<div title="Se Sì, ente mostrato solamente all'utente che l'ha creato e all'admin" style="text-align:right">
			<label for="privato">Ente Privato?</label>
			No <input type="radio" @if(isset($corp->privato) && $corp->privato == '0') checked @endif value="0" name="privato">
			Sì <input type="radio" @if(isset($corp->privato) && $corp->privato == '1') checked @endif value="1" name="privato">
            <label for="cliente">         Login Attivo?</label>
			No <input type="radio" @if(isset($corp->id_cliente) && $corp->id_cliente == 0) checked @endif value="0" name="cliente">
			Sì <input type="radio" @if(isset($corp->id_cliente) && $corp->id_cliente != 0) checked @endif value="1" name="cliente">
		</div>*/?>
        
	    </div><!-- FINE 3 COLONNE (NOTE SEDE LOGO/RESP/TEL/PARTECIPANTI) -->
  </div>
<div class="row">
	<div class="col-md-12">
    <div class="row">
    	<?php /*?><div class="col-md-4">
	<br><label for="tipi[]">Tipo</label><br>
		<!-- tipiselezionati -->
		<div class="table table-responsive">
		<table class="table-bordered">
		<tr>
		<?php $check = false; ?>
		@for($i = 0; $i < count($tipi); $i++)
			@if($i%4==0)
				</tr><tr>
			@endif
			@for($k = 0; $k < count($tipiselezionati); $k++)
				@if($tipiselezionati[$k]->id_tipo == $tipi[$i]->id)
					<td class="ciao"><input type="checkbox" checked name="tipi[]" id="tipi[]" value="<?php echo $tipi[$i]->name; ?>"><?php echo " " . $tipi[$i]->name; ?></td>
					<?php $check = true; ?>
				@endif
			@endfor
			@if($check==false)
				<td class="ciao"><input type="checkbox" name="tipi[]" id="tipi[]" value="<?php echo $tipi[$i]->name; ?>"><?php echo " " . $tipi[$i]->name; ?></td>
			@endif
			<?php $check = false; ?>
		@endfor
		</tr>
		</table>
	</div></div><?php */?>
    <div class="col-md-6">
        	<br><label for="indirizzospedizione">Indirizzo spedizione</label>
        	<textarea rows="9" title="Sede dell'ente che verrà riporata nel preventivo" class="form-control" name="indirizzospedizione" id="indirizzospedizione" placeholder="Indirizzo spedizione">{{ isset($corp->indirizzospedizione) ? $corp->indirizzospedizione :  old('sedelegale') }}</textarea>
        </div>
        

	
		
	<div class="col-md-6">
     		<br><label for="partecipanti">Partecipanti</label><br>
	        <div class="col-md-12">
	            <div class="col-xs-6">
	                <select class="form-control" id="utenti">
                	    @foreach($utenti as $utente)
                	    <option value="{{$utente->id}}">{{$utente->name}}</option>
                	    @endforeach
        	        </select>
	            </div>
	            <div class="col-xs-6">
	                <br><a class="btn btn-warning" style="text-decoration: none; color:#fff" id="aggiungiPartecipante"><i class="fa fa-plus"></i></a>
	                <a class="btn btn-danger" style="text-decoration: none; color:#fff" id="elimina"><i class="fa fa-eraser"></i></a>
	            </div>
	        </div><br>
	        <div class="col-md-12">
	            <table class="table table-striped table-bordered">
	                <thead>
	                    <th>#</th>
	                    <th>Id</th>
	                    <th>Utente</th>
                        <th>Notifiche</th>
	                </thead>
	                <tbody id="partecipanti">
						@foreach($partecipanti as $partecipante)
	                        <tr>
	                            <td>
	                                <input type="checkbox" class="selezione">
	                            </td>
	                            <td>
	                                <input type="text" name="partecipanti[]" readonly="readonly" value="<?php echo $partecipante->id_user; ?>" class="form-control">
	                            </td>
	                            <td>
	                                @foreach($utenti as $utente)
	                                	@if($utente->id == $partecipante->id_user)
	                                		{{$utente->name}}
	                                		@break
	                                	@endif
	                                @endforeach
	                            </td>
                                <td>
                                <input type="checkbox" name="partecipantiNotifiche[<?php echo $partecipante->id_user;?>]" <?php if($partecipante->notifiche=='1'){ echo 'checked';}?> value="1" />	
                                
                                </td>
	                            <script>
	                                $j('.selezione').on("click", function() {
				                selezione[n] = $j(this).parent().parent();
				                n++;
		                	});
	                            </script>
	                        </tr>
	                    @endforeach
	                </tbody>

	                <script>
	                    var selezione = [];
	                    var n = 0;
	                    var k = 0;
	                    $j('#aggiungiPartecipante').on("click", function() {
	                        var tab = document.getElementById("partecipanti");
	                        var tr = document.createElement("tr");
	                        var check = document.createElement("td");
	                        var checkbox = document.createElement("input");
	                        checkbox.type = "checkbox";
	                        checkbox.className = "selezione";
	                        check.appendChild(checkbox);
	                        k++;
	                        var td = document.createElement("td");
	                        var td1 = document.createElement("td");
							var td2 = document.createElement("td");
	                        var nomeUtente = document.createTextNode($j("#utenti option:selected").text());
	                        var idNotifiche = document.createElement("input");
	                        idNotifiche.type = "checkbox";	                        
	                        idNotifiche.value = '1';
	                        idNotifiche.name = "partecipantiNotifiche["+$j("#utenti option:selected").val()+"]";
					 		/*var idNotificheHidden = document.createElement("input");
	                        idNotificheHidden.type = "hidden";	                        
	                        idNotificheHidden.value = '0';
	                        idNotificheHidden.name = "partecipantiNotifiche[]";*/
							
							var idUtente = document.createElement("input");
	                        idUtente.type = "text";
	                        idUtente.className = "form-control";
	                        idUtente.value = $j("#utenti option:selected").val();
	                        idUtente.name = "partecipanti[]";
							/*idUtente.readonly = true;*/
							idUtente.setAttribute('readonly','true')
	                        td.appendChild(nomeUtente);
	                        td1.appendChild(idUtente);
							td2.appendChild(idNotifiche);
							/*td2.appendChild(idNotificheHidden);*/							
	                        tr.appendChild(check);
	                        tr.appendChild(td1);							
	                        tr.appendChild(td);
							tr.appendChild(td2);
	                        tab.appendChild(tr);
	                        $j('.selezione').on("click", function() {
				                selezione[n] = $j(this).parent().parent();
				                n++;
		                	});
	                    });
	                    $j('#elimina').on("click", function() {
	                       for(var i = 0; i < n; i++) {
	                           selezione[i].remove();
	                       }
	                       n = 0;
	                    });
	                </script>
	            </table>
	        </div>
            </div></div></div>
        </div>
      <!-- /partecipanti -->

<script>
	setTimeout(function() {
		var cellulari = ["<?php
			for($i=1;$i<count($utenti);$i++) {
				if($i == count($utenti) - 1)
					echo $utenti[$i]->cellulare . "\"";
				else
					echo $utenti[$i]->cellulare . "\",\"";
			}
		?>];
		var nomi = ["<?php
			for($i=1;$i<count($utenti);$i++) {
				if($i == count($utenti) - 1)
					echo $utenti[$i]->name . "\"";
				else
					echo $utenti[$i]->name . "\",\"";
			}
		?>];
			var k;
			var nome = $j("#responsabilelanga option:selected" ).text();
			for(var i = 0; i < <?php echo count($utenti)-1;?>;i++) {
				if(nomi[i] == nome) {
					k = i;
					break;
				}
			}
			$j('#telefonoresponsabile').val(cellulari[k]);
	}, 100);
	function trovaTelefono() {
		var cellulari = ["<?php
			for($i=1;$i<count($utenti);$i++) {
				if($i == count($utenti) - 1)
					echo $utenti[$i]->cellulare . "\"";
				else
					echo $utenti[$i]->cellulare . "\",\"";
			}
		?>];
		var nomi = ["<?php
			for($i=1;$i<count($utenti);$i++) {
				if($i == count($utenti) - 1)
					echo $utenti[$i]->name . "\"";
				else
					echo $utenti[$i]->name . "\",\"";
			}
		?>];
			var k;
			var nome = $j("#responsabilelanga option:selected" ).text();
			for(var i = 0; i < <?php echo count($utenti)-1;?>;i++) {
				if(nomi[i] == nome) {
					k = i;
					break;
				}
			}
			$j('#telefonoresponsabile').val(cellulari[k]);
	}
</script>
<?php /*?><div class="col-md-12">
<!-- SEZIONE COSTI ENTI -->
            	<h4>Costi</h4>
            <a id="creaNuovoCosto" class="btn btn-warning" name="create" title="Crea nuovo"><i class="fa fa-plus"></i></a>
            <a class="btn btn-danger" onclick="eliminaCosto()" name="remove" title="Elimina"><i class="fa fa-eraser"></i></a>
            <div class="table-responsive table-editable" style="padding-top:10px">
                <table class="table table-striped table-bordered">
                <thead>
                    <th>#
                    <th>Oggetto
                    <th>Costo (€)
                    <th>Data inserimento
                </thead>
                    <script>
					
                     
                    function eliminaCosto() {
                        eleme.remove();
                    }
                    var impedisciModifica = function(e) {
                        this.blur();
                        this.value = test;
                    }
                    var eleme;
                    var kCosti = 0;
                    </script>
                    <tbody id="tab">

                        @for($i = 0; $i < count($costi); $i++)
                            <tr>
                            <td>
                                <input type="checkbox" class="selezione">
                            </td>
                            <td>
                                <input type="text" name="oggettocosto[]" class="form-control" value="<?php echo $costi[$i]->oggetto; ?>">
                            </td>
                            <td>
                                <input type="text" name="costi[]" class="form-control" value="<?php echo $costi[$i]->costo; ?>">
                            </td>
                            <td>
                                <input type="text" id="datepicker<?php echo $i; ?>" name="datainserimentocosto[]" class="form-control " value="<?php echo $costi[$i]->datainserimento; ?>">
                            </td>
                            <td>
                            	<a href="{{url('/costo/delete/') . '/' . $costi[$i]->id}}" onclick="return confirm('Sei sicuro di voler cancellare questo costo?');" class="btn btn-danger" style="text-decoration:none">Cancella</a>
                            </td>
                            </tr>
                            <script>
                                                 
                            var impedisciModifica2 = function() {
                                this.blur();
                                this.value = "<?php echo $costi[$i]->datainserimento; ?>";
                            }
                            $j("#datepicker<?php echo $i; ?>").datepicker();
                            $j('.selezione').on("click", function() {
                                eleme = $j(this).parent().parent();
                            });
                            kCosti++;
                            </script>
                        @endfor
                    </tbody>
                </table>
                
            </div>

<!-- hide buttons Crea nuovo and Elimina  -->

         <!--   <a id="creaNuovoCosto2" class="btn btn-warning" name="create" title="Crea nuovo"><i class="fa fa-plus"></i></a>
            	<a class="btn btn-danger" onclick="eliminaCosto()" name="remove" title="Elimina"><i class="fa fa-eraser"></i></a> -->
            	
		<script>
			var today = new Date();
			var dd = today.getDate();
			var mm = today.getMonth()+1; //January is 0!
			var yyyy = today.getFullYear();
			var tbody = document.createElement("tbody");
			if(dd<10) {
				dd='0'+dd;
			} 
			if(mm<10) {
				mm='0'+mm;
			}
			var vecchiaData = dd + "/" + mm + "/" + yyyy + " " + new Date().toTimeString().replace(/.*(\d{2}:\d{2}:\d{2}).*, "$1");
			var test = vecchiaData.toString();
			function aggiungi() {
				var tabella = document.getElementById("tab");
				var tr = document.createElement("tr");
				
				var data = document.createElement("td"); // oggetto
				var costo = document.createElement("td"); // Costo
				var ora = document.createElement("td"); // data inserimento
				var check = document.createElement("input");
				
				check.type = "checkbox";
				check.className = "selezione";
				var checkbox = document.createElement("td");

				var input = document.createElement("input");
				input.name = "datainserimentocosto[]";
				input.id = "datepicker" + kCosti;
				input.className = "form-control";
				data.appendChild(input);
				
				var appunti = document.createElement("td");
				var input = document.createElement("input");
				input.placeholder = "Scrivi qui...";
				input.name = "oggettocosto[]";
				input.className = "form-control";
				appunti.appendChild(input);
				var ric = document.createElement("td");
				checkbox.appendChild(check);
				tr.appendChild(checkbox);
				tr.appendChild(appunti);
				
				var costoInput = document.createElement("input");
				costoInput.name = "costi[]";
				costoInput.className = "form-control";

				costo.appendChild(costoInput);
				tr.appendChild(costo);
				tr.appendChild(data);
				/*
					Appunti = appunti
					Ricontattare il giorno = ric
					Alle = select
					Data inserimento = data
				*

				tabella.appendChild(tr);
				$j("#datepicker" + kCosti).datepicker();
				$j('.selezione').on("click", function() {
					eleme = $j(this).parent().parent();
				});
				kCosti++;	
			}
			$j('#creaNuovoCosto').on("click", aggiungi);
			$j('#creaNuovoCosto2').on("click", aggiungi);	
			</script>
            <!-- FINE COSTI -->
 </div><?php */?>
<div class="col-md-6" style="padding-top:10px;padding-bottom:10px;">
		
		<button onclick="mostra2()" type="submit" class="btn btn-warning">Salva</button>
	</div>
<?php echo Form::close(); ?>
<script>
function punto() {
	$j('#prova').val($('#pac-input').val());
}
$j('.ciao').on("click", function() {
	$(this).children()[0].click();
});
// Carica i settori nel datalist dal file.json
var datalist = document.getElementById("settori");
var xhr = new XMLHttpRequest();
xhr.onreadystatechange = function(response) {
	if (xhr.readyState === 4 && xhr.status === 200) {
		var json = JSON.parse(xhr.responseText);
		json.forEach(function(item) {
			var option = document.createElement('option');
			option.value = item;
			datalist.appendChild(option);
		});
    }
}
xhr.open('GET', "{{ asset('public/json/settori.json') }}", true);
xhr.send();
</script>
<script>
      // This example requires the Places library. Include the libraries=places
      // parameter when you first load the API. For example:
      // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

      function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: 44.8688, lng: 8.2195},
          zoom: 13
        });
        var input = /** @type {!HTMLInputElement} */(
            document.getElementById('pac-input'));

        var types = document.getElementById('type-selector');
        map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
        map.controls[google.maps.ControlPosition.TOP_LEFT].push(types);

        var autocomplete = new google.maps.places.Autocomplete(input);
        autocomplete.bindTo('bounds', map);
		var image = "{{asset('public/marker.png')}}";
        var infowindow = new google.maps.InfoWindow();
        var marker = new google.maps.Marker({
		  icon: image,
          map: map,
		  draggable: true,
		  animation: google.maps.Animation.DROP,
          anchorPoint: new google.maps.Point(0, -29)
        });

        autocomplete.addListener('place_changed', function() {
          infowindow.close();
          marker.setVisible(false);
          var place = autocomplete.getPlace();
          if (!place.geometry) {
            window.alert("Autocomplete's returned place contains no geometry");
            return;
          }

          // If the place has a geometry, then present it on a map.
          if (place.geometry.viewport) {
            map.fitBounds(place.geometry.viewport);
          } else {
            map.setCenter(place.geometry.location);
            map.setZoom(17);  // Why 17? Because it looks good.
          }
          marker.setIcon(/** @type {google.maps.Icon} */({
            
            size: new google.maps.Size(71, 71),
            origin: new google.maps.Point(0, 0),
            anchor: new google.maps.Point(17, 34),
            scaledSize: new google.maps.Size(35, 35)
          }));
          marker.setPosition(place.geometry.location);
          marker.setVisible(true);

          var address = '';
          if (place.address_components) {
            address = [
              (place.address_components[0] && place.address_components[0].short_name || ''),
              (place.address_components[1] && place.address_components[1].short_name || ''),
              (place.address_components[2] && place.address_components[2].short_name || '')
            ].join(' ');
          }

          infowindow.setContent('<div><strong>' + place.name + '</strong><br>' + address);
          infowindow.open(map, marker);
        });

        // Sets a listener on a radio button to change the filter type on Places
        // Autocomplete.
        function setupClickListener(id, types) {
          var radioButton = document.getElementById(id);
          radioButton.addEventListener('click', function() {
            autocomplete.setTypes(types);
          });
        }

        setupClickListener('changetype-all', []);
        setupClickListener('changetype-address', ['address']);
        setupClickListener('changetype-establishment', ['establishment']);
        setupClickListener('changetype-geocode', ['geocode']);
      }
	  
	  $j(document).ready(function() {
        // validate signup form on keyup and submit
        $("#frmModificaente").validate({

            rules: {
                nomeazienda: {
                    required: true,
                    maxlength: 35
                },
                nomereferente: {
					required: true,
                    maxlength: 35
                },
                telefonoazienda: {
                    required: true,                    
                    maxlength: 15,
                },
                email: {
                    required: true,   
                    email: true                 
                },
                emailsecondaria: {
                    email: true
                },
                responsabilelanga: {   
                    required: true                
                }
            },
            messages: {
                nomeazienda: {
                    required: "Please enter Nome azienda",
                    maxlength: "Nome azienda must be less than 35 characters"
                },
                nomereferente: {
					required: "Please enter Nome referente",
                    maxlength: "Nome referente must be less than 35 characters"
                },
                telefonoazienda: {
                    required: "Please enter Telefono Primario",                    
                    maxlength: "Telefono Primario must be less than 15",
                },
                email: {
                    required: "Please enter Email primaria",   
                    email: "Please enter valid Email primaria"                 
                },
                emailsecondaria: {
                    email: "Please enter valid Email secondaria"
                },
                responsabilelanga: {   
                    required: "Please select a Responsabile LANGA"                
                }
            }

        });
	  });
    </script>
	<!--<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBPyPHd-CTp9Nh_Jqe1NwJiX6WKQYpVEtI&sensor=false&libraries=places&callback=initMap"
        async defer></script>-->
	<!--AIzaSyBPyPHd-CTp9Nh_Jqe1NwJiX6WKQYpVEtI -->
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCjhyTxmz9i9mGwzB1xy6mvVYH46PD2ylE&libraries=places&callback=initMap" async defer></script>

@endsection