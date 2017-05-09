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
    .img-fluid{
        width: 40%;
    }
</style>
<div class="alert alert-success" style="display: none"><a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
    <h4>Fattura del progetto è stata aggiunta con successo al gruppo!</h4></div>
<script src="{{ asset('public/scripts/jquery.min.js') }}"></script>

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.11.0/bootstrap-table.min.css">

<!-- Latest compiled and minified JavaScript -->
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.11.0/bootstrap-table.min.js"></script>

<!-- Latest compiled and minified Locales -->
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.11.0/locale/bootstrap-table-it-IT.min.js"></script>


<script src="{{asset('public/scripts/select2.full.min.js')}}"></script>
<!--<h1>Disposione per progetto</h1><hr>-->
<h1>Gruppo di fatture</h1><hr>

<script>
    var urlmodifica = "";
    function aggiungiDisposizione() {
        $("#nuovaDisposizione").modal();
        $("#select2-idprogetto-container").text("");        
    }
</script>
<button class="btn btn-warning" type="button" name="update" title="Aggiungi - aggiungi una nuova disposizione" onclick="aggiungiDisposizione()"><i class="fa fa-plus"></i></button>

<br><br>
<div class="btn-group">
    <a id="mostra" onclick="multipleAction('mostra');" style="display:inline;">
        <button class="btn btn-primary" type="button" name="remove" title="Mostra - Mostra la disposizione selezionata"><i class="fa fa-pencil"></i></button>
    </a>
    <!--    <a onclick="multipleAction('modify');" id="modifica" style="display:inline;">
            <button class="btn btn-primary" type="button" name="update" title="Modifica - Modifica l'ultima disposizione selezionata"><i class="fa fa-pencil-square-o"></i></button>
        </a>-->
    <!--    <a id="duplicate" onclick="multipleAction('duplicate');" style="display:inline;">
            <button class="btn btn-info" type="button" name="duplicate" title="Duplica - Duplica le disposizioni selezionate"><i class="fa fa-files-o"></i></button>
        </a>    -->
    <a id="delete" onclick="multipleAction('delete');" style="display:inline;">
        <button class="btn btn-danger" type="button" name="remove" title="Elimina - Elimina le disposizioni selezionate"><i class="fa fa-trash"></i></button>
    </a>

</div>
<!--<br><br>
    <table data-toggle="table" data-search="true" data-pagination="true" data-id-field="id" data-show-refresh="true" data-show-columns="true" data-url="<?php echo url('/pagamenti/json'); ?>" data-classes="table table-bordered" id="table">
        <thead>
            <th data-field="id" data-sortable="true">n° quadro
            <th data-field="ente" data-sortable="true">Ente
            <th data-field="nomeprogetto" data-sortable="true">Nome quadro
            <th data-field="id_progetto" data-sortable="true">Nome progetto
            <th data-field="data" data-sortable="true">Data
        </thead>
    </table>-->
<br>
<br>
<br>
<?php
$grouped_types = array();
foreach ($quadri as $qua) {
    $grouped_types[$qua->nomegruppo][] = $qua;
}
?>

<div class="col-md-12 col-sm-12">

    <div class="row">
        @foreach($grouped_types as $key=>$val)

        <div class="col-md-4 col-sm-6 col-lg-3">
            <div class="innr-img">
                <a href="{{url("/pagamenti/listgroupinvoice/$key")}}">
                    <img src="{{asset('storage/app/images/folder.png')}}" alt="" class="img-fluid"></a>                <p> 
                    <a href="{{url("/pagamenti/listgroupinvoice/$key")}}">{{$key}}</a>
                </p>
            </div>
        </div>
        @endforeach


    </div>  
</div>
<!-- Aggiungi nuova disposizione MODALE -->
<div id="nuovaDisposizione" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Aggiungi raggruppamenti</h4>
            </div>
            <div class="modal-body">
                <!--                                <form action="{{url('/pagamenti/store')}}" method="post">-->

                {{ csrf_field() }}
                <label for="nomegruppo">Nome raggruppamenti</label>
                <input id="nomegruppo" name="nomegruppo" type="text" class="form-control" value="" placeholder="Nome raggruppamenti per progetto"><br>
                <!-- Seleziona progetto -->
                <label for="idprogetto">Legame a progetto</label>
                <select id="idprogetto" name="idprogetto" class="js-example-basic-single form-control" style="width:100%">
                    <option></option>
                    @foreach($progetti as $progetto)
                    <option value="{{$progetto->id}}">::{{$progetto->id}}<?php echo '/' . substr($progetto->datainizio, -2); ?> | {{$progetto->nomeprogetto}}</option>
                    @endforeach
                </select><br>
                <!-- fine progetto -->
                <br>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Chiudi</button>
                <input type="submit" class="btn btn-warning" value="Aggiung" id="salva">
                </form>
            </div>
        </div>

    </div>
</div>
<!-- FINE MODALE AGGIUNGI DISPOSIZIONE -->
<script>
    var quadri = <?php echo json_encode($quadri); ?>;
</script>
<!-- Modifica disposizione MODALE -->
<div id="modificaDisposizione" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Modifica quadro disposizioni</h4>
            </div>
            <div class="modal-body">
                <form method="post" id="modificaform">
                    <script>
                        function impostaUrl() {
					$('#modificaform').attr('action', urlmodifica);
					for(var i = 0; i < quadri.length; i++) {
						if(quadri[i]["id"] == indici[tmp]) {
							$(".modal-body #nomeprogetto").val(quadri[i]["nomeprogetto"]);
							$(".modal-body #idprogetto").val(quadri[i]["id_progetto"]);
							break;		
						}	
					}
				}
			</script>
        	{{ csrf_field() }}
        	<label for="nomeprogetto">Nome quadro</label>
        	<input id="nomeprogetto" name="nomeprogetto" type="text" class="form-control" value="{{old('nomeprogetto')}}" placeholder="Nome quadro disposizioni per progetto"><br>
            <!-- Seleziona progetto -->
            <label for="idprogetto">Legame a progetto</label>
            <select id="idprogetto" name="idprogetto" class="js-example-basic-single form-control" style="width:100%">
            <option></option>
            @foreach($progetti as $progetto)
            	<option value="{{$progetto->id}}">::{{$progetto->id}}<?php echo '/' . substr($progetto->datainizio, -2);?> | {{$progetto->nomeprogetto}}</option>
            @endforeach
            </select><script type="text/javascript">

    $(".js-example-basic-single").select2();

</script><br>
            <!-- fine progetto -->
            <br>
      </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Chiudi</button>
                        <input type="submit" class="btn btn-warning" value="Salva" >
                        <!--                            </form>-->
                    </div>
            </div>

        </div>
    </div>
  
        <!-- FINE MODALE MODIFICA DISPOSIZIONE -->
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

        var tmp;

        function check() {
            return confirm("Sei sicuro di voler eliminare: " + n + " disposizioni?");
        }
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
				link.href = "{{ url('/pagamenti/delete/accounting') }}" + '/';
				if(check() && n!=0) {
                                    for(var i = 0; i < n; i++) {
                                        $.ajax({
                                            type: "GET",
                                            url : link.href + indici[i],
                                            error: function(url) {
                                                if(url.status==403) {
                                                    link.href = "{{ url('/pagamenti/delete/accounting') }}" + '/' + indici[n];
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
					tmp = n;
					tmp--;
					urlmodifica = "{{ url('/pagamenti/modifica/accounting') }}" + '/' + indici[tmp];
					$("#modificaDisposizione").modal();
					impostaUrl();
				}
			break;
            case 'duplicate':
				link.href = "{{ url('/pagamenti/duplicate/accounting') }}" + '/';
                for(var i = 0; i < n; i++) {
                    $.ajax({
                        type: "GET",
                        url : link.href + indici[i],
                        error: function(url) {
                            if(url.status==403) {
                                link.href = "{{ url('/pagamenti/duplicate/accounting') }}" + '/' + indici[n];
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
			case 'mostra':
				if(n != 0) {
					n--;
					link.href = "{{ url('/pagamenti/mostra/accounting') }}" + '/' + indici[n];
					n = 0;
					selezione = undefined;
					link.dispatchEvent(clickEvent);
				}
			break;
		}
}    

        $(document).ready(function () {

            $('#salva').on("click", function () {
                if ($("#nomegruppo").val() == "") {
                    alert("The nomegruppo field is required.");
                    return false;
                }
                if ($("#idprogetto").val() == "") {
                    alert("The progetto field is required.");
                    return false;
                }
                urlD = "{{url('pagamenti/store')}}";
                $.ajax({
                    url: urlD,
                    data: "nomegruppo=" + $("#nomegruppo").val() + "&idprogetto=" + $("#idprogetto").val(),
                    success: function (result) {
                        $('#nuovaDisposizione').modal('toggle');
                        $('.alert-success').show();
                        if (result !== "false") {
                            url = "{{ url('/preventivi/delete/quote') }}" + '/' + result;
                            var group = "<div class='col-md-4 col-sm-6 col-lg-3'><div class='innr-img'><a href='" + url + "'><img src='{{asset('storage/app/images/folder.png')}}' alt='' class='img-fluid'></a><p><a href='" + url + "'>" + result + "</a></p></div></div>";
                            $(".col-md-12 .row").append(group);
                            $("#nomegruppo").val("");                            
                        }
                    }});
            });
        });
</script>



@endsection