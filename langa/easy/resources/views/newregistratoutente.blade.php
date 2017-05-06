@extends('adminHome')



@section('page')

<h1>New Utenti Easy <strong>LANGA</strong></h1><hr>

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

@if (\Session::has('success'))
    <div class="alert alert-success">
        <ul>
            <li style="list-style-type:none; width: 1000px; text-align: center; font-size: 20px">{!! \Session::get('success') !!}</li>
        </ul>
    </div>
@endif



</div>

<br><br>

<div class="table-responsive table-custom-design">

<table data-toggle="table" data-search="true" data-pagination="true" data-id-field="id" data-show-refresh="true" data-show-columns="true" data-url="newutente/json" data-classes="table table-bordered" id="table">
    <thead>
        <th data-field="id" data-sortable="true">n° id </th>
        <th data-field="name" data-sortable="true">Nome </th>
        <th data-field="email" data-sortable="true">Email </th>
        <th data-field="azione" data-sortable="true">Azione </th>
    </thead>

</table>

</div>

<!-- <div class="table-responsive"> -->

<!-- <table class="selectable table table-hover table-bordered" id="table" cellspacing="0" cellpadding="0">

<thead>

<tr style="background: #999; color:#ffffff"> -->

<!-- Intestazione tabella dipartimenti -->

<!-- <th>#</th>

<th>Codice</th>

<th>Nome</th>

<th>Email</th>

<th colspan="2" > Azione  </th>

</tr>

</thead> -->

<!-- <tbody> -->

<?php //$count = 0; ?>

    <!--

'sconti'

'entisconti' = legame tra l'id_sconto e l'id_tipo ente,

'tipienti' = Elenco dei tipi enti (POTENZIALE, CLIENTE, ... con ->color)

-->

<!-- @foreach ($utenti as $utente) -->
<!-- 
    <tr>

        <td><input class="selectable" type="checkbox"></td>

        <td>{{$utente->id}}</td>

                <td>{{$utente->name}}</td>

                <td>{{$utente->email}}</td>

                <td> -->

<!--  <a class="btn btn-default" id="approvare" href="{{ url('/approvare/'.$utente->id) }}" onclick="return confirm('Are you sure you want to Approvare this item?');"> Approvare </a>

 <a class="btn btn-default" id="rifiutare" class="btn btn-default" href="{{ url('/rifiutare/'.$utente->id) }}" onclick="return confirm('Are you sure you want to Rifiutare this item?');"> RifiutareK </a>

    </tr>
 -->
    <?php //$count++; ?>

<!-- @endforeach      -->

<!-- </tbody> -->

<!-- </table> -->

<?php //if($count==0) {

    //echo "<h3 style='text-align:center;'>Nessuno sconto trovato</h3>";

//} ?>

<!-- </div> -->

<!-- <div class="pull-right"> -->

<!-- {{ $utenti->links() }} -->

<!-- </div> -->

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

    return confirm("Sei sicuro di voler eliminare: " + n + " utenti?");

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

                link.href = "{{ url('/admin/destroy/utente') }}" + '/';

                if(check()) {

                                    for(var i = 0; i < n; i++) {

                                        $.ajax({

                                            type: "GET",

                                            url : link.href + selezione[i],

                                            error: function(url) {

                                                if(url.status==403) {

                                                    link.href = "{{ url('/admin/destroy/utente') }}" + '/' + selezione[--n];

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
                    
                    link.href = "{{ url('/admin/modify/utente') }}" + '/' + selezione[n];
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