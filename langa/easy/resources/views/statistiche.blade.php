@extends('layouts.app')
@section('content')

<style>
tr:hover {
	background: #f39538;
}
.selected {
	font-weight: bold;
	font-size: 16px;
}
th {
	cursor: pointer;
}
</style>

<script src="{{ asset('public/scripts/jquery.min.js') }}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.6/Chart.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.6/Chart.min.js"></script>

<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.11.0/bootstrap-table.min.css">
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.11.0/bootstrap-table.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.11.0/locale/bootstrap-table-it-IT.min.js"></script>

<div class="col-md-12">
	<div class="col-md-8">
        <div class="btn-group">
            <h3 style="display:inline"><a href='{{url("/statistiche/economiche/$tipo") . '/' . ($anno - 1)}}'><i class="fa fa-arrow-left"></i>{{$anno - 1}}</a></h3>
            <h3 style="display:inline;color:#f37f0d"> {{$anno}} </h3><h3 style="display:inline"><a href='{{url("/statistiche/economiche/$tipo") . '/' . ($anno + 1)}}'>{{$anno + 1}}<i class="fa fa-arrow-right"></i></a></h3>
        </div>
    </div>
    <div class="col-md-4">
    	<select id="tipo" name="tipo" class="form-control">
        	@if($tipo == 1)
                <option selected value="1">Scadenza ricavo (Contabilità)</option>
                <option value="0">Inserimento ricavo (Contabilità)</option>
                <option value="3">Conferma commerciale (Preventivi)</option>
            @else
             	<option value="1">Scadenza ricavo (Contabilità)</option>
                <option selected value="0">Inserimento ricavo (Contabilità)</option>
                <option value="3">Conferma commerciale (Preventivi)</option>
            @endif
        </select>
        <script>
			var url = "<?php echo url('/statistiche/economiche'); ?>" + '/';
			var anno = "<?php echo $anno; ?>";
			$('#tipo').on("change", function() {
				url += $('#tipo').val() + '/' + anno;
				window.location.replace(url);
			});
		</script>
    </div>
</div>

<div class="canvas-holder">
	<canvas id="myChart" width="1080" height="540" style="display: block; width: 1080px; height: 540px;"></canvas>
</div>

<script>
var ctx = $("#myChart");
var data = {
    labels: ["Gennaio", "Febbraio", "Marzo", "Aprile", "Maggio", "Giugno", "Luglio", "Agosto", "Settembre", "Ottobre", "Novembre", "Dicembre"],
    datasets: [
        {
            label: "Guadagno",
            fill: false,
            lineTension: 0.1,
            backgroundColor: "#f37f0d",
            borderColor: "#f37f0d",
            borderCapStyle: 'butt',
            borderDash: [],
            borderDashOffset: 0.0,
            borderJoinStyle: 'miter',
            pointBorderColor: "#333",
            pointBackgroundColor: "#333",
            pointBorderWidth: 1,
            pointHoverRadius: 5,
            pointHoverBackgroundColor: "#333",
            pointHoverBorderColor: "#f37f0d",
            pointHoverBorderWidth: 2,
            pointRadius: 1,
            pointHitRadius: 10,
            data: <?php echo json_encode($guadagno); ?>,
            iGaps: false,
        },
		{
            label: "Ricavi",
            fill: false,
            lineTension: 0.1,
            backgroundColor: "#64C64B",
            borderColor: "#64C64B",
            borderCapStyle: 'butt',
            borderDash: [],
            borderDashOffset: 0.0,
            borderJoinStyle: 'miter',
            pointBorderColor: "#333",
            pointBackgroundColor: "#333",
            pointBorderWidth: 1,
            pointHoverRadius: 5,
            pointHoverBackgroundColor: "#333",
            pointHoverBorderColor: "#64C64B",
            pointHoverBorderWidth: 2,
            pointRadius: 1,
            pointHitRadius: 10,
            data: <?php echo json_encode($ricavi); ?>,
            iGaps: false,
        },
		{
            label: "Spese",
            fill: false,
            lineTension: 0.1,
            backgroundColor: "#E02424",
            borderColor: "#E02424",
            borderCapStyle: 'butt',
            borderDash: [],
            borderDashOffset: 0.0,
            borderJoinStyle: 'miter',
            pointBorderColor: "#333",
            pointBackgroundColor: "#333",
            pointBorderWidth: 1,
            pointHoverRadius: 5,
            pointHoverBackgroundColor: "#333",
            pointHoverBorderColor: "#E02424",
            pointHoverBorderWidth: 2,
            pointRadius: 1,
            pointHitRadius: 10,
            data: <?php echo json_encode($spese); ?>,
            iGaps: false,
        }
    ]
};
var myLineChart = new Chart(ctx, {
    type: 'line',
    data: data,
    options: {
		scales: {
            xAxes: [{
                display: true
            }]
        }
	}
});
</script>

<div class="col-md-12">
	<div class="col-md-6">
    	<h4>Costi</h4><hr>
        <div class="btn-group">
        	<a onclick="multipleAction('modify');" id="modifica" style="display:inline;">
            	<button class="btn btn-primary" type="button" name="update" title="Modifica - Modifica l'ultimo progetto selezionato"><i class="fa fa-pencil"></i></button>
            </a>
            <a id="delete" onclick="multipleAction('delete');" style="display:inline;">
            	<button class="btn btn-danger" type="button" name="remove" title="Elimina - Elimina i costi selezionati"><i class="fa fa-eraser"></i></button>
            </a>
        </div>
    	<table data-toggle="table" data-search="true" data-pagination="true" data-id-field="id" data-show-refresh="true" data-show-columns="true" data-url="<?php echo url('costi/json');?>" data-classes="table table-bordered" id="table">
            <thead>
                <th data-field="id" data-sortable="true">Codice
                <th data-field="ente" data-sortable="true">Ente
                <th data-field="oggetto" data-sortable="true">Oggetto
                <th data-field="costo" data-sortable="true">Costo
                <th data-field="datainserimento" data-sortable="true">Data inserimento
            </thead>
        </table>
        <!-- COSTI -->

<!-- change variable name for case 'delete' like n to n2 And indici to indici2-->

        <script>
			var selezione2 = [];
			var indici2 = [];
			var n2 = 0;
			
			$('#table').on('click-row.bs.table', function (row, tr, el) {
				var cod = /\d+/.exec($(el[0]).children()[0].innerHTML);
				if (!selezione2[cod]) {
					$(el[0]).addClass("selected");
					selezione2[cod] = cod;
					indici2[n2] = cod;
					n2++;

				} else {
					$(el[0]).removeClass("selected");
					selezione2[cod] = undefined;
					for(var i = 0; i < n; i++) {
						if(indici2[i] == cod) {
							for(var x = i; x < indici2.length - 1; x++)
								indici2[x] = indici2[x + 1];
							break;	
						}
					}
					n--;
				}
			});
			function check() { return confirm("Sei sicuro di voler eliminare: " + n2  + " costi?"); }
			function multipleAction(act) {
				var link = document.createElement("a");
				var clickEvent = new MouseEvent("click", {
					"view": window,
					"bubbles": true,
					"cancelable": false
				});
				var error = false;

					switch(act) {
						case 'delete':
							link.href = "{{ url('/costo/delete/') }}" + '/';
							if(check() && n2!=0) {

								for(var i = 0; i < n2; i++) {
                                
									$.ajax({

										type: "GET",
										url : link.href + indici2[i],

										error: function(url) {

											if(url.status==403) {
												link.href = "{{ url('/costo/delete') }}" + '/' + indici2[n];
												link.dispatchEvent(clickEvent);
											} 

										}

									});
								}
                                
								selezione2 = undefined;
								setTimeout(function(){location.reload();},100*n);
								n = 0;
							}
						break;
						case 'modify':
							if(n2 != 0) {
								n2--;
								link.target = "new";
								link.href = "{{ url('/costi/modify') }}" + '/' + indici2[n];
								n2 = 0;
								selezione2 = undefined;
								link.dispatchEvent(clickEvent);
							}
						break;
					}
			}
		</script>
        <!-- FINE COSTI -->
    </div>
    <div class="col-md-6">
    	<h4>Ricavi</h4><hr>
        <div class="btn-group">
<a onclick="mAction('modify');" id="modifica" style="display:inline;">
<button class="btn btn-primary" type="button" name="update" title="Modifica - Modifica l'ultima disposizione selezionata"><i class="fa fa-pencil"></i></button>
</a>
<a id="duplicate" onclick="mAction('duplicate');" style="display:inline;">
<button class="btn btn-info" type="button" name="duplicate" title="Duplica - Duplica le disposizioni selezionate"><i class="fa fa-files-o"></i></button>
</a>    
<a id="delete" onclick="mAction('delete');" style="display:inline;">
<button class="btn btn-danger" type="button" name="remove" title="Elimina - Elimina le disposizioni selezionate"><i class="fa fa-eraser"></i></button>
</a>
<a id="pdf" onclick="mAction('pdf');" style="display:inline;">
<button class="btn" type="button" name="pdf" title="PDF - Genera il PDF delle disposizioni selezionate"><i class="fa fa-file-pdf-o"></i></button>
</a>
</div>
        <table data-toggle="table" data-search="true" data-pagination="true" data-id-field="id" data-show-refresh="true" data-show-columns="true" data-url="<?php echo url('/pagamenti/tranche/json');?>" data-classes="table table-bordered" id="tabella">
        <thead>
        	<th data-field="idfattura" data-sortable="true">n째 fattura 
            <th data-field="id" data-sortable="true">n째 disposizione
            <th data-field="nomequadro" data-sortable="true">Nome quadro
            <th data-field="tipo" data-sortable="true">Tipo
            <th data-field="datascadenza" data-sortable="true">Scadenza
            <th data-field="percentuale" data-sortable="true">%
            <th data-field="netto" data-sortable="true">Netto
            <th data-field="scontoaggiuntivo" data-sortable="true">Sconto aggiuntivo
            <th data-field="imponibile" data-sortable="true">Imponibile
            <th data-field="prezzoiva" data-sortable="true">Prezzo iva
            <th data-field="dapagare" data-sortable="true">Da pagare
            <th data-field="statoemotivo" data-sortable="true">Stato emotivo
        </thead>
    </table>
    <script>
var selezione = [];
var indici = [];
var n = 0;

$('#tabella').on('click-row.bs.table', function (row, tr, el) {
	var cod = /\d+/.exec($(el[0]).children()[1].innerHTML);
	if (!selezione[cod]) {
		$(el[0]).addClass("selected");
		selezione[cod] = cod;
		indici[n] = cod;
		n++;
	} else {
		$(el[0]).removeClass("selected");
		selezione[cod] = undefined;
		for(var i = 0; i < n; i++) {
			if(indici[i] == cod) {
				for(var x = i; x < indici.length - 1; x++)
					indici[x] = indici[x + 1];
				break;	
			}
		}
		n--;
	}
});



function check2() { return confirm("Sei sicuro di voler eliminare: " + n + " ricavi/disposizioni?"); }
function mAction(act) {
	var link = document.createElement("a");
	var clickEvent = new MouseEvent("click", {
	    "view": window,
	    "bubbles": true,
	    "cancelable": false
	});
	var error = false;
		switch(act) {
			case 'delete':
				link.href = "{{ url('/pagamenti/tranche/delete/') }}" + '/';
				if(check2() && n!=0) {
                                    for(var i = 0; i < n; i++) {
                                        $.ajax({
                                            type: "GET",
                                            url : link.href + indici[i],
                                            error: function(url) {
                                                if(url.status==403) {
                                                    link.href = "{{ url('/pagamenti/tranche/delete/') }}" + '/' + indici[n];
                                                    link.dispatchEvent(clickEvent);
                                                } 
                                            }
                                        });
                                    }
                                    selezione = undefined;
                                    setTimeout(function(){location.reload();},100*n);
                                    n = 0;
                                }
			break;
			case 'modify':
                if(n != 0) {
					n--;
					link.href = "{{ url('/pagamenti/tranche/modifica') }}" + '/' + indici[n];
					n = 0;
					selezione = undefined;
					link.dispatchEvent(clickEvent);
				}
			break;
			case 'pdf':
               link.href = "{{ url('/pagamenti/tranche/pdf') }}" + '/';
			    for(var i = 0; i < n; i++) {
                    var url = link.href + indici[i];
                    var win = window.open(url, '_blank');
                    win.focus();
                }
                n = 0;
                selezione = undefined;
                setTimeout(function(){location.reload();},100*n);
			break;
            case 'duplicate':
				link.href = "{{ url('/pagamenti/tranche/duplicate') }}" + '/';
                for(var i = 0; i < n; i++) {
                    $.ajax({
                        type: "GET",
                        url : link.href + indici[i],
                        error: function(url) {
                            if(url.status==403) {
                                link.href = "{{ url('/pagamenti/tranche/duplicate') }}" + '/' + indici[n];
                                link.dispatchEvent(clickEvent);
                                error = true;
                            } 
                        }
                    });
                }
                selezione = undefined;
                if(error === false)
                    setTimeout(function(){location.reload();},100*n);
                n = 0;
			break;
		}
}    

</script>
    <!-- fine RICAVI -->
    </div>
</div>

@endsection