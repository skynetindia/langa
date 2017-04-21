@extends('layouts.app')



@section('content')





<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

		<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">

<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>

<style>tr:hover td {

    background: #f2ba81;

}</style>





<h1>Aggiungi progetto</h1><hr>



@if(!empty(Session::get('msg')))

    <script>

    var msg = '<?php echo html_entity_decode(htmlentities(Session::get('msg'))); ?>';

    document.write(msg);

    </script>

@endif



@include('common.errors')

<?php echo Form::open(array('url' => '/progetti/store/', 'files' => true)) ?>

	{{ csrf_field() }}
<div class="row">
		<div class="col-md-8">
			<label for="prev">Legare?</label>
    	    	<select class="form-control" id="prev">
    	    		<option></option>
    	    		@foreach($preventiviconfermati as $prev)
    	    			<option value="{{$prev->id}}">{{$prev->oggetto}}</option>
    	    		@endforeach
    	    	</select>
    	    	<script>
				var $j = jQuery.noConflict();
    	    		var clickEvent = new MouseEvent("click", {
					    "view": window,
					    "bubbles": true,
					    "cancelable": false
					});
    	    		$j('#prev').on("change", function() {
    	    			var id = $j("#prev").val();
    	    			var link = document.createElement("a");
    	    			link.href = "{{ url('/progetti/add') }}" + '/' + id;
						link.dispatchEvent(clickEvent);
    	    		});
    	    	</script>
          <label for="preventivo">Preventivo</label>
				<input type="text" disabled value=":cod/anno" class="form-control"><br>
			
			<div class="btn-group">
        		    <a href="" title="Preventivo originale" class="btn btn-warning" style="display:inline"><i class="fa fa-circle-o"></i></a>
        		    <a href="" title="Preventivo no prezzi" class="btn btn-danger" style="display:inline"><i class="fa fa-ban"></i></a>
        		</div>
				<br><label for="nomeprogetto">Nome progetto/oggetto preventivo<p style="color:#f37f0d;display:inline">(*)</p></label>
        		<input value="{{ old('nomeprogetto') }}" class="form-control" type="text" name="nomeprogetto" id="nomeprogetto" placeholder="Nome progetto"><br>
				<label for="lavorazioni">Lavorazioni</label><br>
	            <a class="btn btn-warning" style="text-decoration: none; color:#fff" id="aggiungiLavorazione"><span class="fa fa-plus"></span></a>
	            <a class="btn btn-danger" style="text-decoration: none; color:#fff" id="eliminaLavorazione"><span class="fa fa-eraser"></span></a>
              <div class="table-responsive">
	            <table class="table table-bordered">
	                <thead>
	                    <th>#</th>
	                    <th>Lavorazioni                                                                                                                                       </th>
	                    <th>Da fare il</th>
	                    <th>Alle</th>
	                    <th>Programmato il</th>
	                    <th>Completato</th>
	                </thead>
	                <tbody id="lavorazioni">
	                </tbody>
	                <script>
	                    var selezioneLavorazioni = [];
	                    var nLav = 0;
	                    var kLav = 0;
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
                		var impedisciModifica = function(e) {
                			this.blur();
                			this.value = test;
                		}
	                    $j('#aggiungiLavorazione').on("click", function() {
	                        var tabella = document.getElementById("lavorazioni");
                			var tr = document.createElement("tr");
                			var data = document.createElement("td");
                			var ora = document.createElement("td");
                			var check = document.createElement("input");
                			var checkbox = document.createElement("td");
                			check.type = "checkbox";
                			check.className = "selezione";
                			var select1 = document.createElement("select");
                			var compl = document.createElement("td");
                			select1.name = "completato[]";
                			select1.className = "form-control";
                			var array = ["No", "Si"];
                			compl.appendChild(select1);
                			
                			for(var i = 0; i < array.length; i++) {
                				var option = document.createElement("option");
                				option.value = i;
                				option.text = array[i];
                				select1.appendChild(option);
                			}
                			
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
                			input.id = "impedisci" + kLav;
                			input.className = "form-control";
                			input.value = vecchiaData;
                			data.appendChild(input);
                			var appunti = document.createElement("td");
                			var input = document.createElement("input");
                			input.placeholder = "Scrivi qui...";
                			input.name = "ric[]";
                			input.className = "form-control";
                			input.id = "editable" + kLav;
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
                			tr.appendChild(compl);
                			var input = document.createElement("input");
                			input.className = "form-control";
                			input.id = "datepicker" + kLav;
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
                			$j("#datepicker" + kLav).datepicker();
                			$j('.selezione').on("click", function() {
                				selezioneLavorazioni[nLav] = $j(this).parent().parent();
				                nLav++;
                			});
                			$j('#impedisci' + kLav).bind("click", impedisciModifica);
                			kLav++;
	                    });
	                    $j('#eliminaLavorazione').on("click", function() {
	                       for(var i = 0; i < nLav; i++) {
	                           selezioneLavorazioni[i].remove();
	                       }
	                       nLav = 0;
	                    });
	                </script>
	            </table>
		</div>
    </div>
		<div class="col-md-4">
        <label for="noteprivate">Servizi applicati</label><br>

        		<!-- Servizi applicati -->



	                <a class="btn btn-warning" style="text-decoration: none; color:#fff" id="aggiungiNote"><span class="fa fa-plus"></span></a>

	                <a class="btn btn-danger" style="text-decoration: none; color:#fff" id="eliminaNote"><span class="fa fa-eraser"></span></a>

	        	<br>

		            <table class="table table-striped table-bordered">

		                <thead>

		                    <th>#</th>
		                    <th>URL</th>
		                    <th>User</th>
                            <th>Passw</th>
                            <th>Scadenza</th>

		                </thead>

		                <tbody id="noteprivate">

		                </tbody>

		                <script>

		                

		                    var selezioneServizi = [];

		                    var nServ = 0;

		                    var kServ = 0;

		                    $j('#aggiungiNote').on("click", function() {

		                        var tab = document.getElementById("noteprivate");

		                        var tr = document.createElement("tr");

		                        var check = document.createElement("td");

		                        var checkbox = document.createElement("input");

		                        checkbox.type = "checkbox";

		                        checkbox.className = "selezione";

		                        check.appendChild(checkbox);

		                        kServ++;

		                        var td = document.createElement("td");

		                        var td1 = document.createElement("td");
								
								var td2 = document.createElement("td");
								var td3 = document.createElement("td");

		                        var fileInput = document.createElement("input");

		                        fileInput.type = "text";

		                        fileInput.className = "form-control";

		                        fileInput.name = "nome[]";

		                        var dettagli = document.createElement("input");

		                        dettagli.type = "text";

		                        dettagli.className = "form-control";

		                        dettagli.name = "dett[]";
								
								var password = document.createElement("input");
		                        password.type = "text";
		                        password.className = "form-control";
		                        password.name = "pass[]";
								
								var scadenza = document.createElement("input");
		                        scadenza.type = "text";
		                        scadenza.className = "form-control";
		                        scadenza.name = "scad[]";
								scadenza.id = "datepicker" + kServ;

		                        td.appendChild(fileInput);
		                        td1.appendChild(dettagli);
								td2.appendChild(scadenza);
								td3.appendChild(password);

		                        tr.appendChild(check);

		                        tr.appendChild(td);

		                        tr.appendChild(td1);//username
								tr.appendChild(td3);//password
								tr.appendChild(td2);//scadenza
								

		                        tab.appendChild(tr);

		                        $j('.selezione').on("click", function() {

					                selezioneServizi[nServ] = $j(this).parent().parent();

					                nServ++;

			                	});
								
								$j("#datepicker" + kServ).datepicker();

		                    });

		                    $j('#eliminaNote').on("click", function() {

		                       for(var i = 0; i < nServ; i++) {

		                           selezioneServizi[i].remove();

		                       }

		                       nServ = 0;

		                    });

		                </script>

		            </table>
                    <p>

  						<label for="progresso">Progresso del progetto </label>

  						<input type="text" id="amount" name="progresso" style="border:0; color:#f6931f; font-weight:bold; width:25px;">%

					</p>

					<div id="slider-range-max"></div><br>
			<label for="statoemotivo">Stato emotivo</label>
                <select name="statoemotivo" class="form-control" id="statoemotivo" style="color:#ffffff">
                    <option style="background-color:white"></option>
                    @foreach($statiemotivi as $statoemotivo)
                        <option style="background-color:{{$statoemotivo->color}};color:#ffffff">{{$statoemotivo->name}}</option>
                    @endforeach
                </select>
                <br>
                <script>
                $j('#statoemotivo').on("change", function() {
                    var yourSelect = document.getElementById( "statoemotivo" );
                    document.getElementById("statoemotivo").style.backgroundColor = yourSelect.options[yourSelect.selectedIndex].style.backgroundColor;
                });
                </script>
				<label for="notetecniche">Note private per il tecnico</label><a onclick="mostraPrivate()" id="mostra"> <span class="fa fa-eye"></span></a>

        		<textarea rows="2" class="form-control" type="text" name="notetecniche" id="notetecniche" title="Note nascoste, clicca l'occhio per mostrare" placeholder="Note tecniche accordate verbalmente/scritte a mano sul preventivo"></textarea><br>
	
        		<label for="noteprivate">Note private del tecnico</p></label><a onclick="mostra()" id="mostra"> <span class="fa fa-eye"></span></a>

        		<textarea id="noteenti" style="background-color:#f39538;color:#ffffff" rows="2" class="form-control" type="text" name="noteprivate" title="Note nascoste, clicca l'occhio per mostrare" placeholder="Inserisci note tecniche relative al progetto"></textarea>
				<script>
				$j('#notetecniche').on("click", function() {
					this.blur();
				});
				
				var testo = "<?php echo old('noteprivate'); ?>";
				var testoPrivato = "<?php echo old('notetecniche'); ?>";
				function mostra() {
					if($j('#noteenti').val()) {
						testo = $j('#noteenti').val();
						$j('#noteenti').val("");
					} else {
						$j('#noteenti').val(testo);
					}
				}
				function mostraPrivate() {
					if(j$('#notetecniche').val()) {
						testoPrivato = $('#notetecniche').val();
						$j('#notetecniche').val("");
					} else {
						$j('#notetecniche').val(testoPrivato);
					}
				}
				function mostra2() {
					if(!$j('#noteenti').val()) {
						$j('#noteenti').val(testo);
						$j('#notetecniche').val(testoPrivato);
					}
				}
				</script>
				<br>
				<label for="preventivo">Tempo</label><br>

        		<div>

        		    <input value="{{ old('datainizio') }}" class="form-control" type="text" name="datainizio" id="datainizio" placeholder="Data inizio"><br>

        		    <input value="{{ old('datafine') }}" class="form-control" type="text" name="datafine" id="datafine" placeholder="Data fine"><br>

        		    <script>

        		    

					  $j( function() {

					    $j( "#slider-range-max" ).slider({

					      range: "max",

					      min: 0,

					      max: 100,

					      value: 10,

					      slide: function( event, ui ) {

					        $j( "#amount" ).val( ui.value );

					      }

					    });

					    $j( "#amount" ).val( $j( "#slider-range-max" ).slider( "value" ) );

					  } );

  					</script>

        		    

        		    <script>

        		    $j.datepicker.setDefaults(

                        $j.extend(

                            {'dateFormat':'dd/mm/yy'},

                            $j.datepicker.regional['nl']

                        )

                    );

        		    $j('#datainizio').datepicker();

        		    $j('#datafine').datepicker();

        		    </script>

        		</div>
				<br>
				<label for="datisensibili">Dati sensibili</label><br>



	                <a class="btn btn-warning" style="text-decoration: none; color:#fff" id="aggiungiDati"><span class="fa fa-plus"></span></a>

	                <a class="btn btn-danger" style="text-decoration: none; color:#fff" id="eliminaDati"><span class="fa fa-eraser"></span></a>

	       <br>



	            <table class="table table-striped table-bordered">

	                <thead>

	                    <th>#</th>

	                    <th>Dati sensibili</th>

	                </thead>

	                <tbody id="datisensibili">

	                </tbody>

	                <script>

	                    var selezioneFile2 = [];

	                    var nDati = 0;

	                    var kDati = 0;

	                    $j('#aggiungiDati').on("click", function() {

	                        var tab = document.getElementById("datisensibili");

	                        var tr = document.createElement("tr");

	                        var check = document.createElement("td");

	                        var checkbox = document.createElement("input");


	                        checkbox.type = "checkbox";

	                        checkbox.className = "selezione";

	                        check.appendChild(checkbox);

	                        kDati++;

	                        var td = document.createElement("td");

	                        var fileInput = document.createElement("textarea");

	                		fileInput.rows = "7";

	                        fileInput.className = "form-control";

	                        fileInput.name = "dati[]";

	                        td.appendChild(fileInput);

	                        tr.appendChild(check);

	                        tr.appendChild(td);

	                        tab.appendChild(tr);

	                        $j('.selezione').on("click", function() {

				                selezioneFile2[nDati] = $j(this).parent().parent();

				                nDati++;

		                	});

	                    });

	                    $j('#eliminaDati').on("click", function() {

	                       for(var i = 0; i < nDati; i++) {

	                           selezioneFile2[i].remove();

	                       }

	                       nDati = 0;

	                    });

	                </script>

	            </table>
			<label for="files">Files</label><br>



	                <a class="btn btn-warning" style="text-decoration: none; color:#fff" id="aggiungiFile"><span class="fa fa-plus"></span></a>

	                <a class="btn btn-danger" style="text-decoration: none; color:#fff" id="eliminaFile"><span class="fa fa-eraser"></span></a>

	        <br>



	            <table class="table table-striped table-bordered">

	                <thead>

	                    <th>#</th>

	                    <th>Sfoglia</th>

	                </thead>

	                <tbody id="files">

	                </tbody>

	                <script>

	                    var selezioneFile = [];

	                    var nFile = 0;

	                    var kFile = 0;

	                    $j('#aggiungiFile').on("click", function() {

	                        var tab = document.getElementById("files");

	                        var tr = document.createElement("tr");

	                        var check = document.createElement("td");

	                        var checkbox = document.createElement("input");

	                        checkbox.type = "checkbox";

	                        checkbox.className = "selezione";

	                        check.appendChild(checkbox);

	                        kFile++;

	                        var td = document.createElement("td");

	                        var fileInput = document.createElement("input");

	                        fileInput.type = "file";

	                        fileInput.className = "form-control";

	                        fileInput.name = "file[]";

	                        td.appendChild(fileInput);

	                        tr.appendChild(check);

	                        tr.appendChild(td);

	                        tab.appendChild(tr);

	                        $j('.selezione').on("click", function() {

				                selezioneFile[nFile] = $j(this).parent().parent();

				                nFile++;

		                	});

	                    });

	                    $j('#eliminaFile').on("click", function() {

	                       for(var i = 0; i < nFile; i++) {

	                           selezioneFile[i].remove();

	                       }

	                       nFile = 0;

	                    });

	                </script>

	            </table>
			<label for="partecipanti">Partecipanti</label><br>
	                <select class="form-control" id="utenti">

                	    @foreach($utenti as $utente)

                	    <option value="{{$utente->id}}">{{$utente->name}}</option>

                	    @endforeach

        	        </select><br>



	                <a class="btn btn-warning" style="text-decoration: none; color:#fff" id="aggiungiPartecipante"><span class="fa fa-plus"></span></a>

	                <a class="btn btn-danger" style="text-decoration: none; color:#fff" id="elimina"><span class="fa fa-eraser"></span></a>


	        <br>



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
	</div>
<div class="col-md-2" style="padding-top:10px;padding-bottom:10px;">

		

		<button onclick="mostra2()" type="submit" class="btn btn-warning">Salva</button>

	</div>

<?php echo Form::close(); ?> 
</div><!-- /row -->
@endsection