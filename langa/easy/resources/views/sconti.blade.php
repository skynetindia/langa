@extends('adminHome')



@section('page')

<h1>Sconti</h1><hr>

@include('common.errors')



<style>

tr:hover td {

	background:#f2ba81

}

.selected {

	background: #f37f0d;
color: #ffffff;
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

<script>

  $(function(){

        $("table").stupidtable();

    });

    

    

@if(!empty(Session::get('msg')))





    var msg = '<?php echo html_entity_decode(htmlentities(Session::get('msg'))); ?>';

    document.write(msg);



@endif

</script>



<div class="btn-group">



<form action="{{ url('/admin/tassonomie/sconti/add') }}" method="post" style="display:inline;">

{{ csrf_field() }}

<button class="btn btn-warning" type="submit" name="create" title="Crea nuovo - Aggiungi un nuovo sconto"><i class="fa fa-plus"></i></button>

</form><br>



<a onclick="multipleAction('modify');" id="modifica" style="display:inline;">

<button class="btn btn-primary" type="button" name="update" title="Modifica - Modifica l'ultimo ente selezionato"><i class="glyphicon glyphicon-pencil"></i></button>

</a>



<a id="delete" onclick="multipleAction('delete');" style="display:inline;">

<button class="btn btn-danger" type="button" name="remove" title="Elimina - Elimina gli enti selezionati"><i class="glyphicon glyphicon-erase"></i></button>

</a>

</div>

<br><br>

<div class="table-responsive">

<table class="selectable table table-hover table-bordered" id="table" cellspacing="0" cellpadding="0">

<thead>

<tr style="background: #999; color:#ffffff">

<!-- Intestazione tabella dipartimenti -->

<th>#</th>

<th>Codice</th>

<th>Nome</th>

<th>Descrizione</th>

<th>Tipi</th>

<th>Sconto %</th>

</tr>

</thead>

<tbody>

<?php $count = 0; ?>

    <!--

'sconti'

'entisconti' = legame tra l'id_sconto e l'id_tipo ente,

'tipienti' = Elenco dei tipi enti (POTENZIALE, CLIENTE, ... con ->color)

-->

@foreach ($sconti as $sconto)

	<tr>

		<td><input class="selectable" type="checkbox"></td>

		<td>{{$sconto->id}}</td>

                <td>{{$sconto->name}}</td>

                <td>{{$sconto->descrizione}}</td>

                @foreach($entisconti as $entesconto)

                    @if($entesconto->id_sconto == $sconto->id)

                        @foreach($tipienti as $tipoente)

                            @if($tipoente->id == $entesconto->id_tipo)

                                <td><p style="padding-left:5px;color:#ffffff;background-color: <?php echo $tipoente->color; ?>;">{{$tipoente->name}}</p></td> 

                            @endif

                        @endforeach

                    @endif

                @endforeach

                <td>{{$sconto->sconto}}%</td>

	</tr>

        <?php $count++; ?>

@endforeach		

</tbody>

</table>

<?php if($count==0) {

	echo "<h3 style='text-align:center;'>Nessuno sconto trovato</h3>";

} ?>

</div>

<div class="pull-right">

{{ $sconti->links() }}

</div>

<script>

var selezione = [];

var n = 0;

$(".selectable tbody tr input[type=checkbox]").change(function(e){
	var stato = e.target.checked;
  if (stato) {
	 
	  $(this).closest("tr").addClass("selected");
	  selezione[n] = $(this).closest("tr").children()[1].innerHTML;
	   n++;
  } else {
	  selezione[n] = undefined;
	  n--;
	  $(this).closest("tr").removeClass("selected");
  }
});

$(".selectable tbody tr").click(function(e){
    var cb = $(this).find("input[type=checkbox]");
    cb.trigger('click');
});





function check() {

	return confirm("Sei sicuro di voler eliminare: " + n + " sconti?");

}



function multipleAction(act) {

	var link = document.createElement("a");

	var clickEvent = new MouseEvent("click", {

	    "view": window,

	    "bubbles": true,

	    "cancelable": false

	});

	if(selezione!==undefined) {

		switch(act) {

			case 'delete':

				link.href = "{{ url('/admin/tassonomie/delete/sconto') }}" + '/';

				if(check()) {

                                    for(var i = 0; i < n; i++) {

                                        $.ajax({

                                            type: "GET",

                                            url : link.href + selezione[i],

                                            error: function(url) {

                                                if(url.status==403) {

                                                    link.href = "{{ url('/admin/tassonomie/delete/sconto') }}" + '/' + selezione[n];

                                                    link.dispatchEvent(clickEvent);

                                                } 

                                            }

                                        });

                                    }

                                    setTimeout(function(){location.reload();},100*n);

                                }

					

			break;

			case 'modify':
				

				n--;
                if(selezione[n]!=undefined) {
					link.href = "{{ url('/admin/tassonomie/modify/sconto') }}" + '/' + selezione[n];
					n = 0;
					selezione = undefined;
					link.dispatchEvent(clickEvent);
				}
				n = 0;
			break;

		}

	}

}



</script>



@endsection