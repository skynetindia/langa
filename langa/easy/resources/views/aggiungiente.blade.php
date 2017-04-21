@extends('layouts.app')

@section('content')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
		<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
<h1>Aggiungi ente</h1><hr>

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
<?php echo Form::open(array('url' => '/enti/store/', 'files' => true)) ?>
	{{ csrf_field() }}
	<!-- colonna a sinistra -->
  <div class="row">
  	<div class="col-md-4">
  		<label for="nomeazienda">Nome azienda <p style="color:#f37f0d;display:inline">(*)</p></label>
  		<input value="{{ old('nomeazienda') }}" class="form-control" type="text" name="nomeazienda" id="nomeazienda" placeholder="Nome azienda"><br>
  		<label for="piva">Partita iva</label>
  		<input value="{{ old('piva') }}" class="form-control" type="text" name="piva" id="piva" placeholder="Partita iva"><br>
  		<label for="cellulareazienda">Cellulare azienda</label>
  		<input value="{{ old('cellulareazienda') }}" class="form-control" type="text" name="cellulareazienda" id="cellulareazienda" placeholder="Telefono opzionale"><br>
  		<label for="iban">IBAN</label>
  		<input value="{{ old('iban') }}" class="form-control" type="text" name="iban" id="iban" placeholder="IBAN azienda"><br>
  		<br>
  		
  	</div>
	<!-- colonna centrale -->
	<div class="col-md-4">
		<label for="nomereferente">Nome referente <p style="color:#f37f0d;display:inline">(*)</p></label>
		<input value="{{ old('nomereferente') }}" class="form-control" type="text" name="nomereferente" id="nomereferente" placeholder="Nome referente"><br>
		<label for="cf">Codice fiscale</label>
		<input value="{{ old('cf') }}" class="form-control" type="text" name="cf" id="cf" placeholder="Codice fiscale"><br>
		<label for="fax">Fax</label>
		<input value="{{ old('fax') }}" class="form-control" type="text" name="fax" id="fax" placeholder="Fax"><br>
		<label for="statoemotivo">Stato emotivo</label>
		<!-- statiemotivi -->
		<select name="statoemotivo" class="form-control" id="statoemotivo" style="color:#ffffff">
			<option style="background-color:white"></option>
			@foreach($statiemotivi as $statoemotivo)
				<option style="background-color:{{$statoemotivo->color}};color:#ffffff">{{$statoemotivo->name}}</option>
			@endforeach
		</select>
		<br>
		<script>
		$('#statoemotivo').on("change", function() {
			var yourSelect = document.getElementById( "statoemotivo" );
			document.getElementById("statoemotivo").style.backgroundColor = yourSelect.options[yourSelect.selectedIndex].style.backgroundColor;
		});
		</script>
	</div>
	<!-- colonna a destra -->
	<div class="col-md-4">
		<datalist id="settori"></datalist>
		<label for="settore">Settore</label>
		<input   class="form-control" type="text" id="settore" name="settore" placeholder="Cerca un settore..."><br>
		<label for="telefonoazienda">Telefono azienda <p style="color:#f37f0d;display:inline">(*)</p></label>
		<input value="{{ old('telefonoazienda') }}" class="form-control" type="text" name="telefonoazienda" id="telefonoazienda" placeholder="Telefono primario"><br>
		<label for="email">Email primaria <p style="color:#f37f0d;display:inline">(*)</p></label>
		<input value="{{ old('email') }}" class="form-control" type="email" name="email" id="email" placeholder="Email di notifica"><br>
		<label for="emailsecondaria">Email secondaria</label>
		<input value="{{ old('emailsecondaria') }}" class="form-control" type="email" name="emailsecondaria" id="emailsecondaria" placeholder="Email opzionale"><br>

	</div>
</div>
<div class="">
	<div class=""><strong>Indirizzo <p style="color:#f37f0d;display:inline">(*)</p></strong><br>
	 <input value="{{ old('indirizzo') }}" id="pac-input" name="indirizzo" class="controls" type="text"
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
	</div>
</div>
<div class="row">
	<div class="col-md-4">
    	<!-- Note enti -->
        <br><label for="noteenti">Note private del commerciale</label><a onclick="mostra()" id="mostra"> <i class="fa fa-eye"></i></a>
        	<textarea style="background-color:#f39538;color:#ffffff" rows="9" title="Note nascoste, clicca l'occhio per mostrare" class="form-control nascondi" name="noteenti" id="noteenti" placeholder="Inserisci note per caratteristiche ente"></textarea>
        <!-- /note enti -->
    </div>
    <script>
	var testo = "<?php echo old('noteenti'); ?>";
	function mostra() {
		if($('#noteenti').val()) {
			testo = $('#noteenti').val();
			$('#noteenti').val("");
		} else {
			$('#noteenti').val(testo);
		}
	}
	</script>
    <div class="col-md-4">
    	<!-- sede legale -->
        <br><label for="sedelegale">Sede legale</label>
        	<textarea rows="9" title="Sede dell'ente che verrà riporata nel preventivo" class="form-control" name="sedelegale" id="sedelegale" placeholder="Sede legale">{{ old('sedelegale') }}</textarea>
        <!-- /sede legale -->
    </div>
    <div class="col-md-4">
    	<!-- logo resp tel partecipanti -->

	<br><label for="logo">Logo</label>
	<?php echo Form::file('logo', ['class' => 'form-control']); ?><br>
    
    <label for="responsabilelanga">Responsabile LANGA <p style="color:#f37f0d;display:inline">(*)</p></label>
		<select title="Responsabile associato a questo ente" name="responsabilelanga" id="responsabilelanga" class="form-control"  onchange="trovaTelefono()">
			<option></option>
			@for($i = 1; $i < count($utenti); $i++)
					<option>{{ $utenti[$i]->name }}</option>
			@endfor
		</select>
        <br><label for="telefonoresponsabile">Telefono responsabile Langa</label>
		<input class="form-control" type="text" name="telefonoresponsabile" id="telefonoresponsabile" placeholder="Telefono responsabile Langa"><br>

<div title="Se Sì, ente mostrato solamente all'utente che l'ha creato e all'admin" style="text-align:right">
			<label for="privato">Privato?</label>
			No <input type="radio" checked value="0" name="privato">
			Sì <input type="radio" value="1" name="privato">
		</div>
	    </div><!-- FINE 3 COLONNE (NOTE SEDE LOGO/RESP/TEL/PARTECIPANTI) -->
</div>
<div class="row">
	<div class="col-md-12">
    <div class="row">
    	<div class="col-md-4">
	       <br><label for="tipi[]">Tipo</label><br>
  		    <!-- tipiselezionati -->
  		    <div class="table table-responsive">
		        <table class="table-bordered">
          		<tr>
          		@for($i = 0; $i < count($tipi); $i++)
          			@if($i%4==0)
          				</tr><tr>
          			@endif
          			<td class="ciao"><input type="checkbox" name="tipi[]" id="tipi[]" value="<?php echo $tipi[$i]->name; ?>"><?php echo " " . $tipi[$i]->name; ?></td>
          		@endfor
          		</tr>
        		</table>
	       </div>
      </div>
      <div class="col-md-4">
        	<br><label for="indirizzospedizione">Indirizzo spedizione</label>
        	<textarea rows="9" title="Sede dell'ente che verrà riporata nel preventivo" class="form-control" name="indirizzospedizione" id="indirizzospedizione" placeholder="Indirizzo spedizione">{{ old('sedelegale') }}</textarea>
      </div>

	   <div class="col-md-4">
        <label for="partecipanti">Partecipanti</label><br>
        <div class="row">
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
	        </div></div><br>
	        <div class="col-md-12">
	            <table class="table table-striped table-bordered">
	                <thead>
	                    <th>#</th>
	                    <th>Id</th>
	                    <th>Utente</th>
	                </thead>
	                <tbody id="partecipanti">
	                </tbody>


	                <script>
	                    var selezione = [];
	                    var n = 0;
	                    var k = 0;

	                    $('#aggiungiPartecipante').on("click", function() {

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

	                        var nomeUtente = document.createTextNode($j("#utenti option:selected").text());

	                        var idUtente = document.createElement("input");

	                        idUtente.type = "text";

	                        idUtente.className = "form-control";

	                        idUtente.value = $j("#utenti option:selected").val();

	                        idUtente.name = "partecipanti[]";

	                        td.appendChild(nomeUtente);

	                        td1.appendChild(idUtente);

	                        tr.appendChild(check);

	                        tr.appendChild(td1);

	                        tr.appendChild(td);

	                        tab.appendChild(tr);

	                        $('.selezione').on("click", function() {

				                selezione[n] = $j(this).parent().parent();

				                n++;

		                	});

	                    });

	                    $('#elimina').on("click", function() {

	                       for(var i = 0; i < n; i++) {

	                           selezione[i].remove();

	                       }

	                       n = 0;

	                    });

	                </script>

	            </table>

	        </div>

          </div>
        </div></div></div>
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
			var nome = $("#responsabilelanga option:selected" ).text();
			for(var i = 0; i < <?php echo count($utenti)-1;?>;i++) {
				if(nomi[i] == nome) {
					k = i;
					break;
				}
			}
			$('#telefonoresponsabile').val(cellulari[k]);
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
			var nome = $("#responsabilelanga option:selected" ).text();
			console.log(nome);
			for(var i = 0; i < <?php echo count($utenti)-1;?>;i++) {
				if(nomi[i] == nome) {
					k = i;
					break;
				}
			}
			$('#telefonoresponsabile').val(cellulari[k]);
	}
</script>
	<!-- inizio chiamata -->
  <div class="row">
	<div class="col-md-12" style="padding-top:10px;">
		<h4>Conversazioni private</h4>
		<a id="creaNuovaChiamata" class="btn btn-warning" name="create" title="Crea nuovo"><i class="fa fa-plus"></i></a>
		<a class="btn btn-danger" onclick="elimina()" name="remove" title="Elimina"><i class="fa fa-eraser"></i></a>
		<div class="table-editable" style="padding-top:10px">
			<table class="table table-striped table-bordered">
			<thead>
				<th>#
				<th>Appunti
				<th>Ricontattare il giorno
				<th>Alle
				<th>Data inserimento
			</thead>
				<tbody id="tb">
				
				</tbody>
			</table>
		</div>
		<script>
                            $.datepicker.setDefaults(
                                        $.extend(
                                          {'dateFormat':'dd/mm/yy'},
                                          $.datepicker.regional['nl']
                                        )
                                      );
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
		function elimina() {
			ele.remove();
		}
		var impedisciModifica = function(e) {
			this.blur();
			this.value = test;
		}
		var $j = jQuery.noConflict();
		var ele;
		var k = 0;
		$j('#creaNuovaChiamata').on("click", function() {
			var tabella = document.getElementById("tb");
			var tr = document.createElement("tr");
			var data = document.createElement("td");
			var ora = document.createElement("td");
			var check = document.createElement("input");
			var checkbox = document.createElement("td");
			check.type = "checkbox";
			check.className = "selezione";
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
			input.id = "editable" + k;
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
			*/
			select.name = "alle[]";
			tabella.appendChild(tr);
			$j("#datepicker" + k).datepicker();
			$j('.selezione').on("click", function() {
				ele = $j(this).parent().parent();
			});
			$j('#impedisci' + k).bind("click", impedisciModifica);
			k++;
		});	
		</script>
	</div></div>
	<!-- fine chiamata -->
	<div class="col-xs-6" style="padding-top:10px;padding-bottom:10px;">
		
		<button type="submit" class="btn btn-warning">Salva</button>
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
console.log(datalist);
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
    </script>

	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAL_rtMv03GNmWgYfQkcGPPOsQ43LGun-0&libraries=places&callback=initMap"
        async defer></script>
        
<script>

</script>
@endsection