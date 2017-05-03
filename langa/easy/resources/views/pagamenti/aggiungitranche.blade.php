@extends('layouts.app')
@section('content')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
		<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
<style>tr:hover td {
    background: #f2ba81;
}</style>
<script src="{{asset('public/scripts/select2.full.min.js')}}"></script>
<h1>Aggiungi Fattura</h1><hr>

@if(!empty(Session::get('msg')))
    <script>
    var msg = '<?php echo html_entity_decode(htmlentities(Session::get('msg'))); ?>';
    document.write(msg);
    </script>
@endif

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
		<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>

 <link href="{{asset('public/css/dropzone.css')}}" rel="stylesheet" />
<script type="text/javascript" src="{{asset('public/scripts/dropzone.js')}}"></script>

@include('common.errors')
<form action="{{url('/pagamenti/tranche/store')}}" method="post" name="add_fattura" id="add_fattura">
	{{ csrf_field() }}
<div class="row">
	<div class="col-md-8">
    	    <script>
			"use strict";
			$.datepicker.setDefaults(
                                        $.extend(
                                          {'dateFormat':'dd/mm/yy'},
                                          $.datepicker.regional['nl']
                                        )
                                      );
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
    	    			</script></label>
    	<div class="col-md-4">
		 	<label for="id">n° fattura</label>
	        <input value="{{old('idfattura')}}" type="text" id="idfattura" name="idfattura" placeholder="n° fattura" class="form-control">
        </div>

        <div class="col-md-8">
			
		    <label for="legameprogetto">Legame a progetto</label>
		    <select name="legameprogetto" id="legameprogetto" class="js-example-basic-single form-control">
		       <option></option>
            @foreach($progetti as $progetto)
            	<option value="{{$progetto->id}}">::{{$progetto->id}}<?php echo '/' . substr($progetto->datainizio, -2);?> | {{$progetto->nomeprogetto}}</option>
            @endforeach
		        
		    </select>
<br><br><br>
		</div>
	
	<div class="row">
	
	<div class="col-md-4">
		<h4> Intestazione fattura</h4>
	    <label for="sedelegaleente">Sede legale ente (DA)</label>
	    <select name="DA" id="sedelegaleente" class="js-example-basic-single form-control">
	        <option></option>
	        @foreach($enti as $ente)
	        <option value="{{$ente->id}}">{{$ente->id}} | {{$ente->nomeazienda}}</option>
	        @endforeach
	    </select><br>
	    <br>
	    <label for="note"> Note </label>
		<input value="" type="text" class="form-control" id="note" name="note" placeholder="note">

	    <br><label for="modalita">Modalità di pagamento</label>
		<input value="{{old('modalita')}}" type="text" class="form-control" id="modalita" name="modalita" placeholder="Modalità di pagamento"><br>
	</div>
	<div class="col-md-4">
	<input type="hidden" name="id_disposizione" value="{{$idfattura}}"> 
		<br><br>
	   <label for="sedelegaleentea">Sede legale ente (A) </label>
	    <select id="sedelegaleentea" name="A" class="js-example-basic-single form-control">
	        <option></option>
	        @foreach($enti as $ente)
	        <option value="{{$ente->id}}">{{$ente->id}} | {{$ente->nomeazienda}}</option>
	        @endforeach
	    </select><br><br>

	 	<label for="emissione">Emissione del</label>
	    <input value="{{old('emissione')}}" type="text" name="emissione" id="emissione" class="form-control"><br>

		<label for="iban">IBAN Societario</label>
	     <select name="iban" id="iban" class="js-example-basic-single form-control">
	        <option></option>
	        @foreach($enti as $ente)
	        <option value="{{$ente->iban}}">{{$ente->id}} | {{$ente->nomeazienda}}</option>
	        @endforeach
	    </select><script type="text/javascript">

    $(".js-example-basic-single").select2();

</script><br>
		
	</div>
	<div class="col-md-4">
	<br><br>
	<label for="Tipo">Tipo di fattura</label>
        <select id="Tipo" name="tipofattura" class="form-control">
        	<option value="0" selected>Fattura di vendita</option>
            <option value="1">Nota di credito</option>
        </select><br>
        
	    
	    <label for="base">Su base</label>
	    <input value="{{old('base')}}" class="form-control" type="text" name="base" id="base" placeholder="Su base">
	    <br>

        <label for="indirizzospedizione">Indirizzo di spedizione</label>
        <select name="indirizzospedizione" name="indirizzospedizione" id="indirizzospedizione" class="js-example-basic-single form-control">
	        <option></option>
	        @foreach($enti as $ente)
	        <option value="{{$ente->indirizzospedizione}}">{{$ente->id}} | {{$ente->nomeazienda}}</option>
	        @endforeach
	    </select>

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
    		var vecchiaData = dd + "/" + mm + "/" + yyyy + " " + new Date().toTimeString().replace(/.*(\d{2}:\d{2}:\d{2}).*/, "$1");
    		var dataInserimento = vecchiaData.toString();
    		var impedisciModifica = function(e) {
    			this.blur();
    			this.value = dataInserimento;
		    }
	</script>
		
	</div>
	</div>
			<h4>Corpo fattura</h4>
	        <div class="col-md-12">
	                <a class="btn btn-warning" style="text-decoration: none; color:#fff" id="aggiungiCorpo"><span class="fa fa-plus"></span></a>
	                <a class="btn btn-danger" style="text-decoration: none; color:#fff" id="eliminaCorpo"><span class="fa fa-eraser"></span></a>
	        </div><br>
	        <div class="">
	    	<table class="table table-striped">
	    		<thead>
	    			<th>#</th>
	    			<th>riferimenti</th>
	    			<th>descrizione</th>
	    			<th>Q.tà</th>
	    			<th>Unitario</th>
	    			<th>Subtotale</th>

	    		</thead>
	    		<tbody id="corpofattura">
                <script>
				
	                   
	                    var kCorpo = 0;
				 var selezioneCorpo = [];
	                    var nCorpo = 0;
				</script>
                <?php $totale = 0; ?>
                	@if($corpofattura != null)
                	@foreach($corpofattura as $ele)
                    	<tr>
                        	<td><input type="checkbox" class="selezione"></td>
                            <td><input class="form-control" type="text" name="ordine[]" value="<?php echo ':' . $ordine . '/' . $anno; ?>"></td>
                            <td><input class="form-control" type="text" name="desc[]" value="<?php echo $ele->descrizione; ?>"></td>
                            <td><input class="form-control" type="text" name="qt[]" value="<?php echo $ele->qta; ?>"></td>
                            <td><input class="form-control" type="text" name="subtotale[]" value="<?php echo $ele->prezzounitario; ?>"></td>
                            <td><input class="form-control" type="text" name="scontoagente[]" value="<?php echo $sconto; ?>"></td>
                            <td><input class="form-control" type="text" name="scontobonus[]" value="<?php echo $scontobonus; ?>"></td>
                            <td><input class="form-control" type="text" name="prezzonetto[]" value="<?php echo $ele->totale; ?>"></td>
                            <td><input class="form-control" type="text" name="iva[]" value=""></td>
                            <?php $totale += $ele->totale; ?>
                            <script>
								$j('.selezione').on("click", function() {
									selezioneCorpo[nCorpo] = $j(this).parent().parent();
									nCorpo++;
		                		});
							</script>
                        </tr>
                    @endforeach
                    @endif
	    		</tbody>
	    		 <script>
	                    $j('#aggiungiCorpo').on("click", function() {
	                        var tab = document.getElementById("corpofattura");

	                        var tr = document.createElement("tr");
	                        var check = document.createElement("td");
	                        var checkbox = document.createElement("input");
	                        checkbox.type = "checkbox";
	                        checkbox.className = "selezione";
	                        check.appendChild(checkbox);
	                        var ord = document.createElement("td");

	                        var ordine = document.createElement("input");
	                        ordine.type = "text";
	                        ordine.placeholder = ":preventivo";
	                        ordine.className = "form-control";
	                        ordine.name = "ordine[]";
							// ordine.value = ":";
	                        ord.appendChild(ordine);

	                        var progetto = document.createElement("input");
	                        progetto.type = "text";
	                        progetto.placeholder = ":progetto";
	                        progetto.className = "form-control";
	                        progetto.name = "ordine[]";
							// progetto.value = ":";
	                        ord.appendChild(progetto);

	                        var td = document.createElement("td");
	                        var descrizione = document.createElement("textarea");
	                        descrizione.className = "form-control";
	                        descrizione.name = "desc[]";
	                        descrizione.rows = "3";
	                        descrizione.cols = "80";
	                        td.appendChild(descrizione);

	                        var qt = document.createElement("td");
	                        var quantita = document.createElement("input");
	                        quantita.type = "text";
	                        quantita.className = "form-control";
	                        quantita.name = "qt[]";
	                        qt.appendChild(quantita);

	                        var unitario = document.createElement("td");
	                        var unitary = document.createElement("input");
	                        unitary.type = "text";
	                        unitary.className = "form-control";
	                        unitary.name = "unitario";
							unitario.appendChild(unitary);


	                        var pr = document.createElement("td");
	                        var prezzo = document.createElement("input");
	                        prezzo.type = "text";
	                        prezzo.className = "form-control";
	                        prezzo.name = "subtotale[]";
	                        pr.appendChild(prezzo);

	                        var perc = document.createElement("td");
	                        var percentualesconto = document.createElement("input");
	                        percentualesconto.type = "text";
	                        percentualesconto.className = "form-control";
	                        percentualesconto.name = "scontoagente[]";
							perc.appendChild(percentualesconto);

							var per = document.createElement("td");
	                        var percentual = document.createElement("input");
	                        percentual.type = "text";
	                        percentual.className = "form-control";
	                        percentual.name = "scontobonus[]";
	                        per.appendChild(percentual);

	                        var netto = document.createElement("td");
	                        var prezzonetto = document.createElement("input");
	                        prezzonetto.type = "text";
	                        prezzonetto.className = "form-control";
	                        prezzonetto.name = "prezzonetto[]";
	                        netto.appendChild(prezzonetto);

	                        var perciva = document.createElement("td");
	                        var iva = document.createElement("input");
	                        iva.type = "text";
	                        iva.className = "form-control";
	                        iva.name = "iva[]";

	                        perciva.appendChild(iva);
	                        tr.appendChild(check);
	                        tr.appendChild(ord);
	                        tr.appendChild(td);
	                        tr.appendChild(qt);
	                        tr.appendChild(unitario);
	                        tr.appendChild(pr);
	      //                   tr.appendChild(perc);
							// tr.appendChild(per);
	      //                   tr.appendChild(netto);
	      //                   tr.appendChild(perciva);
	                        kCorpo++;

	                        tab.appendChild(tr);

	                        $j('.selezione').on("click", function() {
				                selezioneCorpo[nCorpo] = $j(this).parent().parent();
				                nCorpo++;
		                	});
	                    });

	                    $j('#eliminaCorpo').on("click", function() {
	                       for(var i = 0; i < nCorpo; i++) {
	                           selezioneCorpo[i].remove();
	                       }
	                       nCorpo = 0;
	                    });
	                </script>
	    	</table>
	    	</div>
			<h4>Base fattura</h4><a onclick="calcola()" style="text-decoration:none" class="" title="Compilazione assistita"><br>Clicca <span class="fa fa-info"></span> per compilazione</span></a>
			<div class="table-responsive">
	   	<br><table class="table table-bordered">
	   		<thead>
	   			
	   			<th>Netto lavorazioni</th>
	   			<th>Sconto aggiuntivo</th>
	   			<th>Netto totale</th>
	   			<th>Imponibile fattura</th>
	   			<th>Prezzo IVA</th>
	   			<th>% IVA</th>
	   			<th><b> Totale Da pagare </b></th>
	   		</thead>
	   		<tbody>
	   			
	   			<td><input id="netto" class="form-control" type="text" name="netto" value="{{old('netto')}}"></td>
	   			<td><input id="sconto" class="form-control" type="text" name="scontoaggiuntivo" value="{{old('scontoaggiuntivo')}}"></td>
	   			<td><input id="nettototale" class="form-control" type="text" name="nettototale" value="{{old('nettototale')}}"></td>
	   			<td><input id="imponibile" class="form-control" type="text" name="imponibile" value="{{old('imponibile')}}"></td>
	   			<td><input id="prezzoiva" class="form-control" type="text" name="prezzoiva" value="{{old('prezzoiva')}}"></td>
	   			<td><input id="percentualeiva" class="form-control" type="text" name="percentualeiva" value="{{old('percentualeiva')}}"></td>
	   			<td><input id="dapagare" class="form-control" type="text" name="dapagare" value="{{old('dapagare')}}"></td>
                <script>
					function approssima(x) {
						
					}
					function calcola() {
						var percentuale = $j('#percentuale').val() || 0;
						var netto = $j('#netto').val() || 0;
						var sconto = $j('#sconto').val() || 0;
						var imponibile = $j('#imponibile').val() || 0;
						var prezzoiva = $j('#prezzoiva').val() || 0;
						var percentualeiva = $j('#percentualeiva').val() || 0;
						var dapagare = $j('#dapagare').val() || 0;
						
						var importototale = eval(prompt("Inserisci l'importo equivalente al 100%", <?php echo $totale; ?> || netto));
						sconto = eval(prompt("Inserisci lo sconto aggiuntivo (€)", sconto));
						percentuale = eval(prompt("Inserisci la percentuale (%)", percentuale));
						netto = eval(prompt("Inserisci il prezzo netto (€)", (importototale - sconto) * percentuale / 100));
						imponibile = eval(prompt("Inserisci l'imponibile (€)", netto));
						percentualeiva = eval(prompt("Inserisci la l'iva (%)", 22));
						prezzoiva = eval(prompt("Inserisci il prezzo con iva (€)", imponibile * percentualeiva / 100));
						dapagare = eval(prompt("Inserisci il totale da pagare (€)", imponibile + prezzoiva));
						
						approssima(netto);
						approssima(imponibile);
						approssima(prezzoiva);
						approssima(dapagare);
						
						
						$j('#percentuale').val(percentuale);
						$j('#netto').val(importototale);
						$j('#sconto').val(sconto);
						$j('#imponibile').val(imponibile);
						$j('#prezzoiva').val(prezzoiva);
						$j('#percentualeiva').val(percentualeiva);
						$j('#dapagare').val(dapagare);
					}
					
				</script>
	   		</tbody>
	   	</table>
	   	</div>

	   	<div class="col-md-2" style="padding-top:20px;padding-bottom:10px;">
		<input onclick="mostra2()" type="submit" class="btn btn-warning" value="Salva">
	</div>

	</div>
	<div class="col-md-4">
		<label for="statoemotivo">Stato emotivo</label>
		<!-- statiemotivi -->
		<select name="statoemotivo" class="form-control" id="statoemotivo" style="color:#ffffff">
			@for($i = 0; $i < count($statiemotivi); $i++)
            	@if($i == 0)
					<option selected style="background-color:{{$statiemotivi[$i]->color}};color:#ffffff">{{$statiemotivi[$i]->name}}</option>
                @else
                	<option style="background-color:{{$statiemotivi[$i]->color}};color:#ffffff">{{$statiemotivi[$i]->name}}</option>
                @endif
			@endfor
		</select>
		<script>
		var yourSelect = document.getElementById( "statoemotivo" );
			document.getElementById("statoemotivo").style.backgroundColor = yourSelect.options[yourSelect.selectedIndex].style.backgroundColor;
		$j('#statoemotivo').on("change", function() {
			var yourSelect = document.getElementById( "statoemotivo" );
			document.getElementById("statoemotivo").style.backgroundColor = yourSelect.options[yourSelect.selectedIndex].style.backgroundColor;
		});
		</script>
		<br>
		  <label for="privato">Nascondi statistiche <span class="fa fa-eye-slash" title="Se sì, questa disposizione non influenzerà le statistiche economiche"></span>
            <select class="form-control" name="privato">
            	<option value="0" selected>No</option>
                <option value="1">Si</option>
            </select>
		<!-- <label for="datainserimento">Data inserimento disposizione <p style="color:#f37f0d;display:inline">(*)</p></label><br>
    		<input value="{{old('datainserimento')}}" class="form-control" name="datainserimento" id="datainserimento"></input><br>
            <label for="nomereferente">Note private per l'amministrazione</label><a onclick="mostra()" id="mostra"> <span class="fa fa-eye"></span></a>
		<textarea class="form-control" placeholder="Note amministrative accordate verbalmente/scritte a mano sul preventivo" title="Note nascoste, clicca l'occhio per mostrare"></textarea>
		<br><label for="nomereferente">Note private dell'amministrazione</label><a onclick="mostra()" id="mostra"> <span class="fa fa-eye"></span></a>
		    <textarea class="form-control" name="dettagli" id="dettagli" placeholder="Inserisci note amministrative relative alla disposizione" title="Note nascoste, clicca l'occhio per mostrare" style="background:#f39538;color:#ffffff"></textarea>  -->
           <script>
			// var testo = "<?php echo old('dettagli'); ?>";
			// function mostra() {
			// 	if($j('#dettagli').val()) {
			// 		testo = $j('#dettagli').val();
			// 		$j('#dettagli').val("");
			// 	} else {
			// 		$j('#dettagli').val(testo);
			// 		testo = "";
			// 	}
			// }
			// function mostra2() {
			// 	if(!$j('#dettagli').val())
			// 		$j('#dettagli').val(testo);
			// }
			</script> 
			<br><label for="tipo">Tipo</label>
		    <select name="tipo" id="tipo" class="form-control">
    		    <option value="0">Pagamento</option>
    		    <option value="1">Rinnovo</option>
		    </select>
			<div id="frequenza">
		    <br><label for="frequ">Frequenza in giorni</label>
		    <input id="frequ" name="frequenza" class="form-control" placeholder="Frequenza" value="{{old('frequenza')}}">
		</div>
        
			<br><label for="percentuale">% importo totale (Inserisci 0 per importo non %) <p style="color:#f37f0d;display:inline">(*)</p></label>
			<input id="percentuale" name="percentuale" class="form-control" value="{{old('percentuale')}}" placeholder="% disposizione">
            <div id="percentualediv">
		    <br><label for="frequ">Importo</label>
		    <input id="frequ" name="importo_nopercentuale" class="form-control" placeholder="Importo" value="{{old('importo_nopercentuale')}}">
		</div>
            <script>
			$j('#percentuale').on("change", function() {
				if($j('#percentuale').val() == 0) {
					// Nascondo l'importo
					$j('#percentualediv').show();
					
				} else {
					// Mostro l'importo
					$j('#percentualediv').hide();
				}
			});
			</script>
			<br><label for="datascadenza">Data scadenza disposizione <p style="color:#f37f0d;display:inline">(*)</p></label><br>
		    <input value="{{old('datascadenza')}}" class="form-control" name="datascadenza" id="datascadenza"></input><br>
		    <script>
		    $j('#frequenza').hide();
			$j('#percentualediv').hide();
		    $j('#datainserimento').datepicker();
		    $j('#datascadenza').datepicker();
		    $j('#emissione').datepicker();
        $j('#tipo').on("change", function() {
			if($j('#tipo').val() == 0) {
			    // Nascondo la frequenza
			    $j('#frequenza').hide();
			} else {
			    // Mostro la frequenza
			    $j('#frequenza').show();
			}
		});
		</script>

</form>          	
          	<?php $mediaCode = date('dmyhis');?>

          	<div class="col-md-12">
	        <label for="scansione">Allega file amministrativo (Scansione preventivo, contratto, ...)</label><br>
	        <br>
	        <div class="col-md-12">
            	<div class="image_upload_div">
                <?php echo Form::open(array('url' => '/add/fatture/uploadfiles/'. $mediaCode, 'files' => true,'class'=>'dropzone')) ?>
{{ csrf_field() }}
    			</form>				
				</div><script>
				var url = '<?php echo url('/add/fatture/getfiles/'.$mediaCode); ?>';
				Dropzone.autoDiscover = false;
				$j(".dropzone").each(function() {
				  $j(this).dropzone({
					complete: function(file) {
					  if (file.status == "success") {
					  	 $j.ajax({url: url, success: function(result){
        					$j("#files").html(result);
							$j(".dz-preview").remove();
							$j(".dz-message").show();
					    }});
					  }
					}
				  });
				});
				function deleteQuoteFile(id){
					var urlD = '<?php echo url('/add/fatture/deletefiles/'); ?>/'+id;
						$j.ajax({url: urlD, success: function(result){
							$j(".quoteFile_"+id).remove();
					    }});
				}
				function updateType(typeid,fileid){
					var urlD = '<?php echo url('/add/fatture/updatefiletype/'); ?>/'+typeid+'/'+fileid;
						$j.ajax({url: urlD, success: function(result){
							//$j(".quoteFile_"+id).remove();
					    }});
				}				
			
                </script>
	            <table class="table table-striped table-bordered">	                
	                <tbody><?php
					if(isset($preventivo->id) && isset($quotefiles)){
					foreach($quotefiles as $prev) {
				$imagPath = url('/storage/app/images/quote/'.$prev->name);
				$html = '<tr class="quoteFile_'.$prev->id.'"><td><img src="'.$imagPath.'" height="100" width="100"><a class="btn btn-danger pull-right" style="text-decoration: none; color:#fff" onclick="deleteQuoteFile('.$prev->id.')"><i class="fa fa-eraser"></i></a></td></tr>';
				$html .='<tr class="quoteFile_'.$prev->id.'"><td>';
				$utente_file = DB::table('ruolo_utente')->select('*')->where('is_delete', '=', 0)->get();							
				foreach($utente_file as $key => $val){
					$check = '';
					if($val->ruolo_id == $prev->type){
						$check = 'checked';
					}
					$html .=' <input type="radio" name="rdUtente_'.$prev->id.'"  '.$check.' id="rdUtente_'.$val->ruolo_id.'" onchange="updateType('.$val->ruolo_id.','.$prev->id.');"  value="'.$val->ruolo_id.'" /> '.$val->nome_ruolo;
				}
				echo $html .='</td></tr>';
			}
					}
                    ?></tbody>
                    <tbody id="files">
	                </tbody>
                    
	                <script>
	                var $j = jQuery.noConflict();
	                    var selezione = [];
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
	                        fileInput.name = "filee[]";
	                        td.appendChild(fileInput);
	                        tr.appendChild(check);
	                        tr.appendChild(td);
	                        tab.appendChild(tr);
	                        $j('.selezione').on("click", function() {
				                selezione[nFile] = $j(this).parent().parent();
				                nFile++;
		                	});
	                    });
	                    $j('#eliminaFile').on("click", function() {
	                       for(var i = 0; i < nFile; i++) {
	                           selezione[i].remove();
	                       }
	                       nFile = 0;
	                    });
	                </script>
	            </table><hr>
	            </div>

            </div>
		
	</div>
</div>



@endsection