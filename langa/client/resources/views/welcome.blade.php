@extends('layouts.app')

@section('content')

<style>
div.img {
    border: 1px solid #ccc;
}

div.img:hover {
    border: 1px solid #f37f0d;
}

div.img img {
    width: 300px;
    height: 200px;
}


div.desc {
    padding: 10px;
    text-align: center;
}

* {
    box-sizing: border-box;
}

.clearfix:after {
    content: "";
    display: table;
    clear: both;
}
</style>

@if(!empty(Session::get('nuovaregistrazione')))
    <h1 style="text-align:center;color:#ffffff">Tutto sotto controllo, manca soltanto la conferma dell'admin
    <img class="img-responsive" src="http://easy.langa.tv/storage/app/images/ok.jpg"></img>
    {{Session::forget('nuovaregistrazione')}}               
@elseif(!empty(Session::get('confermaregistrazione')))
    <h1 style="text-align:center;color:#ffffff">Account attivato con successo, una email è già stata inviata al nuovo cliente
    <img class="img-responsive" src="http://easy.langa.tv/storage/app/images/ok.jpg"></img>
    {{Session::forget('confermaregistrazione')}}
@elseif (Auth::guest())  
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Benvenuto
                </div>

                <div class="panel-body">
				    <div class="col-md-4">
                        <br>
                        <div style="text-align: center">
                            <a href="{{url('/')}}">
                                <img style="width:200px;height:200px" src="{{url('images/logo.png')}}" ></img>
                            </a>
                        </div>
					</div>
                    <br><br>
					<div class="col-md-8">
                        <br><h4>Benvenuto su Easy <strong>LANGA</strong>!</h4>
                        Un semplice, veloce e sicuro metodo per organizzare la tua azienda. Accedendo potrai gestire
					    i tuoi eventi, visualizzare gli enti già contattati da altri utenti, gestire i progetti, 
                        eseguire i preventivi per i clienti, gestire i pagamenti e le relative fatture.<br></br>
                        <small><small>* ruoli e capacità della vostra utenza sono decisi a monte dall'admin del gestionale Easy <strong>LANGA</strong></small></small>
					</div>                     
                </div><br>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading" style="text-align: right">
                    <a class="btn btn-warning" href="{{ url('/login') }}">Entra</a>
                    <a class="btn btn-warning" href="{{ url('/register') }}">Registrati</a>
                </div>
            </div>
        </div>
    </div>
@else

    <div class="row">

        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Dati dei Clienti
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table"><tr>
                            
                        </tr></table>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

@endsection
