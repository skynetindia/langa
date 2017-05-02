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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<h1>Quiz</h1>
<hr>

<div class="quiz-category">
<div class="row">
	<div class="col-md-4">
    	<div class="quiz-category-box-wrapper">
        	<div class="quiz-category-img">
            	<img src="public/images/web.jpg">
            </div>
            <div class="quiz-category-text">
            	<h3>Web</h3>
                <p>completa il quiz per scoprire i'offerta piu adatta a te!</p>
                
                <div class="quiz-category-actions">
                	<a href="#" id="myBtn" class="button btn-danger" data-toggle="modal><i class="fa fa-plus" aria-hidden="true"></i> info </a>
                    <a href="#" class="button btn-default">Inizia Quiz</a>
                </div>
            
            </div>
        </div>
    </div>
    
    
    <div class="col-md-4">
    	<div class="quiz-category-box-wrapper">
        	<div class="quiz-category-img">
            	<img src="public/images/print.jpg">
            </div>
            <div class="quiz-category-text">
            	<h3>Print</h3>
                <p>scegli gli optional piu adatti per far eseguire il tuo marketing cartaceo.</p>
                
                <div class="quiz-category-actions">
                	<a href="#" class="button btn-danger"><i class="fa fa-plus" aria-hidden="true"></i> info </a>
                    <a href="#" class="button btn-default">Inizia Quiz</a>
                </div>
            
            </div>
        </div>
    </div>
    
     <div class="col-md-4">
    	<div class="quiz-category-box-wrapper">
        	<div class="quiz-category-img">
            	<img src="public/images/video.jpg">
            </div>
            <div class="quiz-category-text">
            	<h3>Video</h3>
                <p>Utilizza i nostri tecnici e le nostre conoscenze video per il tuo business.</p>
                
                <div class="quiz-category-actions">
                	<a href="#" class="button btn-danger"><i class="fa fa-plus" aria-hidden="true"></i> info </a>
                    <a href="#" class="button btn-default">Inizia Quiz</a>
                </div>
            
            </div>
        </div>
    </div>
    
    <div class="col-md-12">
    	<hr>
    </div>
</div>
</div>


<div class="quiz-page-info-wrapper">
	<div class="row">
    	<div class="col-md-3">
        	<div class="quiz-page-info">
            	<h4>Chi?</h4>
                <p>Siamo un'azienda specializzata in web marketing e soluzioni digital che offre servizi a qualsisi tipologia di cliente.</p>
            </div>
        
        </div>
        
        <div class="col-md-3">
        	<div class="quiz-page-info">
            	<h4>Cosa?</h4>
                <p>Questo servizio da la possibilita a te che non puoi raggiungere i nostri studi e ma vuoi un servizio speciale e gradevole alla vista a prezzi modici.</p>
            </div>
        </div>
        
        
         <div class="col-md-3">
        	<div class="quiz-page-info">
            	<h4>Perche?</h4>
                <p>Non ce nessun legame cani azienda se non questo strumento. II Collequio. Nessun canfronto can il Team Faolish, presente tra i servizi LANGA Group.</p>
            </div>
        </div>
        
        
          <div class="col-md-3">
        	<div class="quiz-page-info">
            	<h4>Come?</h4>
                <p>Segui Il Colloquio e rendici partecipi dei tuoi interessi, dei tuci gusti estetici, del tuo lavoro e configura la tua forma.</p>
            </div>
        </div>
    
    </div>

</div>
<div class="modal fade quiz-popup" id="myModal" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Consulta gli optional <b>LANGA WEB</b></h4>
      </div>
      
      <div class="modal-body">
        <div class="left-side">
          <form action="">
            <div class="bootstrap-table">
              <div class="fixed-table-toolbar">
                <div class="columns columns-right btn-group pull-right">
                  <button class="btn btn-default" type="button" name="refresh" title="Aggiorna"><i class="glyphicon glyphicon-refresh icon-refresh"></i></button>
                  <div class="keep-open btn-group" title="Colonne">
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-th icon-th"></i> <span class="caret"></span></button>
                    <ul class="dropdown-menu" role="menu">
                      <li>
                        <label>
                          <input data-field="id" value="0" checked="checked" type="checkbox">
                          n° ente</label>
                      </li>
                      <li>
                        <label>
                          <input data-field="nomeazienda" value="1" checked="checked" type="checkbox">
                          Nome azienda</label>
                      </li>
                      <li>
                        <label>
                          <input data-field="nomereferente" value="2" checked="checked" type="checkbox">
                          Nome referente</label>
                      </li>
                      <li>
                        <label>
                          <input data-field="settore" value="3" checked="checked" type="checkbox">
                          Settore</label>
                      </li>
                      <li>
                        <label>
                          <input data-field="telefonoazienda" value="4" checked="checked" type="checkbox">
                          Telefono azienda</label>
                      </li>
                      <li>
                        <label>
                          <input data-field="email" value="5" checked="checked" type="checkbox">
                          Email</label>
                      </li>
                      <li>
                        <label>
                          <input data-field="indirizzo" value="6" checked="checked" type="checkbox">
                          Indirizzo</label>
                      </li>
                      <li>
                        <label>
                          <input data-field="responsabilelanga" value="7" checked="checked" type="checkbox">
                          Responsabile LANGA</label>
                      </li>
                      <li>
                        <label>
                          <input data-field="statoemotivo" value="8" checked="checked" type="checkbox">
                          Stato emotivo</label>
                      </li>
                      <li>
                        <label>
                          <input data-field="tipo" value="9" checked="checked" type="checkbox">
                          Tipo</label>
                      </li>
                    </ul>
                  </div>
                </div>
                <div class="pull-right search">
                  <input class="form-control" placeholder="Cerca" type="text">
                </div>
              </div>
            </div>
          </form>
          
          <div class="row">
          	<div class="col-md-6">
          		<div class="item-wrapper">
                	<img src="public/images/3d.jpg">
                	<div class="on-hover-text">
                    	Sezione<br>
                        %blog
                    </div>
                </div>
            </div>
            
            
            <div class="col-md-6">
          		<div class="item-wrapper">
                	<img src="public/images/video-editing.jpg">
                	<div class="on-hover-text">
                    	Sezione<br>
                        %blog
                    </div>
                </div>
            </div>
            
            
             <div class="col-md-6">
          		<div class="item-wrapper">
                	<img src="public/images/video-editing.jpg">
                	<div class="on-hover-text">
                    	Sezione<br>
                        %blog
                    </div>
                </div>
            </div>
            
            
              <div class="col-md-6">
          		<div class="item-wrapper">
                	<img src="public/images/mobile-touch.jpg">
                	<div class="on-hover-text">
                    	Sezione<br>
                        %blog
                    </div>
                </div>
            </div>
            
             <div class="col-md-6">
          		<div class="item-wrapper">
                	<img src="public/images/3d.jpg">
                	<div class="on-hover-text">
                    	Sezione<br>
                        %blog
                    </div>
                </div>
            </div>
            
             <div class="col-md-6">
          		<div class="item-wrapper">
                	<img src="public/images/video-editing.jpg">
                	<div class="on-hover-text">
                    	Sezione<br>
                        %blog
                    </div>
                </div>
            </div>
            
          </div>
          
        </div>
        
        <div class="right-side">
        	<div class="right-header">
            	<div class="right-heading">
                	<img src="public/images/news.jpg">
                    <p>Sezione %blog</p>
                </div>
                <div class="price">
                	€ 50.00 cad
                </div>
            </div>
            <div class="right-description">
            	<div class="description-heading">
	                <span>Descrizione</span>
                 </div>
                 <div class="description">
                 	<div class="desciption-img">
                    	<img src="public/images/description-img.jpg" alt="description">
                    </div>
                    <div class="description-text">
                    	<h4>Sezione %blog</h4>
                        <p>Create web forms, surveys, quizzers and polls as easy as 1-2-3! With 123 Form Builder it takes just few clicks to create any custom form for Wiz. And no programming experience is requied.</p>
                    </div>
                 </div>
            </div>
        </div>
        
      </div>
    </div>
  </div>
</div>
<script>
$(document).ready(function(){

    $("#myBtn").click(function(){
        $("#myModal").modal();
    });
});

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