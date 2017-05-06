@extends('adminHome')



@section('page')

<h1>Pacchetti</h1><hr>

@include('common.errors')



<style>

tr:hover td {

	background:#f2ba81

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

</style>



<script src="{{ asset('public/scripts/jquery.min.js') }}"></script>

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.11.0/bootstrap-table.min.css">

<!-- Latest compiled and minified JavaScript -->
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.11.0/bootstrap-table.min.js"></script>

<!-- Latest compiled and minified Locales -->
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.11.0/locale/bootstrap-table-it-IT.min.js"></script>

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

<div class="table-responsive table-custom-design">

    <table data-toggle="table" data-search="true" data-pagination="true" data-id-field="id" data-show-refresh="true" data-show-columns="true" data-url="{{ url('/admin/tassonomie/pacchetti/json') }}" data-classes="table table-bordered" id="table">
    <thead>
      <th data-field="id" data-sortable="true">Codice </th>
      <th data-field="label" data-sortable="true">Titolo </th>
      <th data-field="icon" data-sortable="true">Icona </th>
      <th data-field="optional" data-sortable="true">Optional </th>
    </thead>
    </table>
</div>

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

function check() { return confirm("Sei sicuro di voler eliminare: " + n + " tassazione?"); }
function multipleAction(act) {
  var error = false;
  var link = document.createElement("a");
  var clickEvent = new MouseEvent("click", {
      "view": window,
      "bubbles": true,
      "cancelable": false
  });
  switch(act) {
    case 'delete':
      link.href = "{{ url('/admin/tassonomie/delete/pacchetto') }}" + '/';
      if(check() && n!=0) {
        for(var i = 0; i < n; i++) {
          $.ajax({
            type: "GET",
            url : link.href + indici[i],
            error: function(url) {
              if(url.status==403) {
                link.href = "{{ url('/admin/tassonomie/delete/pacchetto') }}" + '/' + indici[n];
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
                if(n!=0) {
          n--;
          link.href = "{{ url('/admin/tassonomie/modify/pacchetto') }}" + '/' + indici[n];
          n = 0;
          selezione = undefined;
          link.dispatchEvent(clickEvent);
        }
      break;
   
    }
}
</script>


@endsection