@extends('adminHome')



@section('page')

<h1>Pacchetti</h1><hr>

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



<form action="{{ url('/admin/tassonomie/pacchetti/add') }}" method="post" style="display:inline;">

{{ csrf_field() }}

<button class="btn btn-warning" type="submit" name="create" title="Crea nuovo - Aggiungi un nuovo pacchetto"><i class="fa fa-plus"></i></button>

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

<th>Titolo</th>

<th>Icona</th>

<th>Optional</th>

</tr>

</thead>

<tbody>

    <!--

Elenco in cui ogni optional è legato ad un id di un pacchetto

optional_id => id dell'optional

pack_id => id del pacchetto

'optionalpack'

    

Elenco di tutti i pacchetti, che saranno popolati tramite id

dall' optional pack

'pack'

    

'optional'

Elenco di tutti gli optional, contiene l'id che devo trovare nel optionalpack

per formare i pacchetti

-->

<?php $count = 0; ?>

@foreach ($pack as $pacchetto)

	<tr>

		<td><input class="selectable" type="checkbox"></td>

		<td>{{$pacchetto->id}}</td>

                <td>{{$pacchetto->label}}</td>

                <td><img src="http://easy.langa.tv/storage/app/images/<?php echo $pacchetto->icon; ?>" style="max-width:75px; max-height:75px"></img></td>

                <td>



                    @foreach($optionalpack as $opt)



                        @if($pacchetto->id == $opt->pack_id)



                            @foreach($optional as $opzionale)



                                @if($opzionale->id == $opt->optional_id)

                                    {{$opzionale->label}}

                                    @break

                                @endif

                            @endforeach

                        @endif

                    @endforeach     

                </td>

	</tr>

        <?php $count++; ?>

@endforeach		

</tbody>

</table>

<?php if($count==0) {

	echo "<h3 style='text-align:center;'>Nessun pacchetto trovato</h3>";

} ?>

</div>

<div class="pull-right">

{{ $pack->links() }}

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

	return confirm("Sei sicuro di voler eliminare: " + n + " pacchetti?");

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

				link.href = "{{ url('/admin/tassonomie/delete/pacchetto') }}" + '/';

				if(check()) {

                                    for(var i = 0; i < n; i++) {

                                        $.ajax({

                                            type: "GET",

                                            url : link.href + selezione[i],

                                            error: function(url) {

                                                if(url.status==403) {

                                                    link.href = "{{ url('/admin/tassonomie/delete/pacchetto') }}" + '/' + selezione[n];

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
					link.href = "{{ url('/admin/tassonomie/modify/pacchetto') }}" + '/' + selezione[n];
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