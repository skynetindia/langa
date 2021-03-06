@extends('layouts.app')



@section('content')

@if(!empty(Session::get('msg')))

    <script>

    var msg = '<?php echo html_entity_decode(htmlentities(Session::get('msg'))); ?>';

    document.write(msg);

    </script>

@endif



@include('common.errors')

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
li label {
	padding-left: 10px;
}
.button {
    background-color: #4CAF50; /* Green */
    border: none;
    color: white;
    padding: 3px 15px;
    padding-bottom: 6px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    -webkit-transition-duration: 0.4s; /* Safari */
    transition-duration: 0.4s;
    cursor: pointer;
    border-radius: 4px;
}
.button2 { /* blue */
    background-color: white;
    color: black;
    border: 2px solid #337ab7;
}

.button2:hover {
    background-color: #337ab7;
    color: white;
}

.button3 { /* red */
    background-color: white;
    color: black;
    border: 2px solid #d9534f;
}

.button3:hover {
    background-color: #d9534f;
    color: white;
}
</style>

<script src="{{ asset('public/scripts/jquery.min.js') }}"></script>

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.11.0/bootstrap-table.min.css">

<!-- Latest compiled and minified JavaScript -->
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.11.0/bootstrap-table.min.js"></script>

<!-- Latest compiled and minified Locales -->
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.11.0/locale/bootstrap-table-it-IT.min.js"></script>


<h1>Preventivi</h1><hr>

<!-- Fine filtraggio miei/tutti -->
<div class="btn-group" style="display:inline">
<a onclick="multipleAction('modify');" id="modifica" style="display:inline;">

<button class="btn btn-primary" type="button" name="update" title="Chiedi di modificare l'ultimo preventivo selezionato"><span class="fa fa-pencil"></span></button>

</a>



<a id="pdf" onclick="multipleAction('pdf');" style="display:inline;">

<button class="btn" type="button" name="pdf" title="PDF - Generale il PDF dei preventivi selezionati"><span class="fa fa-file-pdf-o"></span></button>

</a>

</div>


    <table data-toggle="table" data-search="true" data-pagination="true" data-id-field="id" data-show-refresh="true" data-show-columns="true" data-url="preventivi/json" data-classes="table table-bordered" id="table">
        <thead>
            <th data-field="id" data-sortable="true">n° preventivo
            <th data-field="oggetto" data-sortable="true">Oggetto
            <th data-field="data" data-sortable="true">Data
            <th data-field="dipartimento" data-sortable="true">Dipartimento
            <th data-field="valenza" data-sortable="true">Valenza
            <th data-field="finelavori" data-sortable="true">Data fine lavori
            <th data-field="subtotale" data-sortable="true">Subtotale
            <th data-field="totale" data-sortable="true">Totale
            <th data-field="totaledapagare" data-sortable="true">Totale da pagare
            <th data-field="statoemotivo" data-sortable="true">Stato Emotivo
        </thead>
    </table>
<script>
var selezione = [];
var indici = [];
var n = 0;

$('#table').on('click-row.bs.table', function (row, tr, el) {
	var cod = /\d+/.exec($(el[0]).children()[0].innerHTML);
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

function check() { return confirm("Sei sicuro di voler eliminare: " + n + " preventivi?"); }
function multipleAction(act) {
	var error = false;
	var link = document.createElement("a");
	var clickEvent = new MouseEvent("click", {
	    "view": window,
	    "bubbles": true,
	    "cancelable": false
	});
	switch(act) {
			case 'modify':
                if(n!=0) {
					n--;
					link.href = "{{ url('/richiedimodifica/preventivo') }}" + '/' + indici[n];
					n = 0;
					selezione = undefined;
					link.dispatchEvent(clickEvent);
				}
			break;
			case 'pdf':
			    link.href = "{{ url('/preventivi/pdf/quote') }}" + '/';
			    for(var i = 0; i < n; i++) {
                    var url = link.href + indici[i];
                    var win = window.open(url, '_blank');
                    win.focus();
                }
                n = 0;
                selezione = undefined;
                setTimeout(function(){location.reload();},100*n);
			break;
		}
}
</script>

@endsection