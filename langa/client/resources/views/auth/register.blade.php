@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Registrati</div>
                <div class="panel-body">
                
                    <form id="signupForm" name="signupForm" class="form-horizontal" role="form" method="POST" action="{{ url('/register') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('nomeazienda') ? ' has-error' : '' }}">
                            <label for="nomeazienda" class="col-md-4 control-label">Nome Azienda</label>

                            <div class="col-md-6">
                                <input id="nomeazienda" type="text" class="form-control" name="nomeazienda" value="{{ old('nomeazienda') }}" placeholder="entrare nomeazienda">

                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('nomereferente') ? ' has-error' : '' }}">
                            <label for="nomereferente" class="col-md-4 control-label">Nome Referente</label>

                            <div class="col-md-6">
                                <input id="nomereferente" type="text" class="form-control" name="nomereferente" value="{{ old('nomereferente') }}" placeholder="entrare nomereferente">
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('telefonoprimario') ? ' has-error' : '' }}">
                            <label for="telefonoprimario" class="col-md-4 control-label">Telefono Primario</label>

                            <div class="col-md-6">
                                <input id="telefonoprimario" type="text" class="form-control" name="telefonoprimario" value="{{ old('telefonoprimario') }}" placeholder="entrare telefonoprimario">
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('emailprimaria') ? ' has-error' : '' }}">
                            <label for="emailprimaria" class="col-md-4 control-label">Email Primaria</label>

                            <div class="col-md-6">
                                <input id="emailprimaria" type="text" class="form-control" name="emailprimaria" value="{{ old('emailprimaria') }}" placeholder="entrare emailprimaria">
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('settore') ? ' has-error' : '' }}">

                            <datalist id="settori"></datalist>

                            <label for="settore" class="col-md-4 control-label">Settore</label>

                            <div class="col-md-6">

                                <input value="{{ old('settore') }}" list="settori" class="form-control" type="text" id="settore" name="settore" placeholder="Cerca un settore...">

                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('telefonosecondario') ? ' has-error' : '' }}">
                            <label for="telefonosecondario" class="col-md-4 control-label">Telefono Secondario</label>

                            <div class="col-md-6">
                                <input id="telefonosecondario" type="text" class="form-control" name="telefonosecondario" value="{{ old('telefonosecondario') }}" placeholder="entrare telefonosecondario">

                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('emailsecondaria') ? ' has-error' : '' }}">
                            <label for="emailsecondaria" class="col-md-4 control-label">Email Secondario</label>

                            <div class="col-md-6">
                                <input id="emailsecondaria" type="text" class="form-control" name="emailsecondaria" value="{{ old('emailsecondaria') }}" placeholder="entrare emailsecondaria">

                            </div>
                        </div>


                        <div class="form-group{{ $errors->has('fax') ? ' has-error' : '' }}">
                            <label for="fax" class="col-md-4 control-label">Fax</label>

                            <div class="col-md-6">
                                <input id="fax" type="fax" class="form-control" name="fax" value="{{ old('fax') }}" placeholder="entrare fax">

                            </div>
                        </div>

                       
                        <div class="form-group{{ $errors->has('statoemotivo') ? ' has-error' : '' }}">
                            <label for="statoemotivo" class="col-md-4 control-label">Stato Emotivo</label>

                            <div class="col-md-6">
                                <input id="statoemotivo" type="statoemotivo" class="form-control" name="statoemotivo" placeholder="entrare statoemotivo">

                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('cf') ? ' has-error' : '' }}">
                            <label for="cf" class="col-md-4 control-label">partita IVA/ Codice Fiscale</label>

                            <div class="col-md-6">
                                <input id="cf" type="cf" class="form-control" name="cf" value="{{ old('cf') }}" placeholder="entrare cf">

                            </div>
                        </div>


                        <div class="form-group{{ $errors->has('cartadicredito') ? ' has-error' : '' }}">
                            <label for="cartadicredito" class="col-md-4 control-label">Carta di Credito</label>

                            <div class="col-md-6">
                                <input id="cartadicredito" type="cartadicredito" class="form-control" name="cartadicredito" placeholder="entrare cartadicredito">
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('iban') ? ' has-error' : '' }}">
                            <label for="iban" class="col-md-4 control-label">IBAN</label>

                            <div class="col-md-6">
                                <input id="iban" type="iban" class="form-control" name="iban" placeholder="entrare iban">
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('swift') ? ' has-error' : '' }}">
                            <label for="swift" class="col-md-4 control-label">Swift</label>

                            <div class="col-md-6">
                                <input id="swift" type="swift" class="form-control" name="swift"  placeholder="entrare swift">
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('sedelegale') ? ' has-error' : '' }}">
                            <label for="sedelegale" class="col-md-4 control-label">Sede Legale</label>

                            <div class="col-md-6">
                            <textarea rows="4" cols="50" id="sedelegale" class="form-control" name="sedelegale" placeholder="entrare sedelegale"></textarea>
                            
                            </div>
                        </div>


                        <div class="form-group{{ $errors->has('indirizzospedizione') ? ' has-error' : '' }}">
                            <label for="indirizzospedizione" class="col-md-4 control-label">Indirizzo Spedizione</label>

                            <div class="col-md-6">
                            <textarea rows="4" cols="50" id="indirizzospedizione" class="form-control" name="indirizzospedizione" placeholder="entrare indirizzospedizione"></textarea>
                                
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('logo') ? ' has-error' : '' }}">
                            <label for="logo" class="col-md-4 control-label">Logo</label>

                            <div class="col-md-6">
                                <input id="logo" type="file"  name="logo" placeholder="selezionare logo">
                              
                            </div>
                        </div>
                        
                        <br>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-warning">
                                    <i class="fa fa-btn fa-user"></i> Register
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


<!-- <script >
    // Carica i settori nel datalist dal file.json
var datalist = document.getElementById("settori");

var xhr = new XMLHttpRequest();
xhr.onreadystatechange = function(response) {

    if (xhr.readyState === 4 && xhr.status === 200) {
        var json = JSON.parse(xhr.responseText);
        json.forEach(function(item) {
            var option = document.createElement('option');
            option.value = item;
            datalist.appendChild(option);
        });
    }
}
xhr.open('GET', "{{ asset('public/json/settori.json') }}", true);
xhr.send();

</script> -->