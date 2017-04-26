@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Registrati</div>
                <div class="panel-body">
                    <form id="signupForm" class="form-horizontal" role="form" method="POST" action="{{ url('/register') }}" >
                    
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Nome <p style="color:#f37f0d;display:inline">(*)</p> </label>

                            <div class="col-md-6">

                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="inserisci il nome">

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="cellulare" class="col-md-4 control-label">Cellulare <p style="color:#f37f0d;display:inline">(*)</p> </label>

                            <div class="col-md-6">

                                <input id="cellulare" type="text" class="form-control" name="cellulare" value="{{ old('cellulare') }}" placeholder="inserisci il cellulare">

                                @if ($errors->has('cellulare'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('cellulare') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail <p style="color:#f37f0d;display:inline">(*)</p> </label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="inserisci l'email">

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Password <p style="color:#f37f0d;display:inline">(*)</p> </label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" placeholder="inserire la password">

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            <label for="password-confirm" class="col-md-4 control-label">Conferma Password <p style="color:#f37f0d;display:inline">(*)</p> </label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="inserire la conferma password">

                                @if ($errors->has('password_confirmation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                    <?php

                        // get stato list
                        $stato = DB::table('stato')
                            ->select('id_stato', 'nome_stato')
                            ->get();

                        // // get citta list
                        // $citta = DB::table('citta')
                        //     ->select('id_citta', 'nome_citta')
                        //     ->get();

                        // get all commercial users
                        $commerciale = DB::table('users')
                             ->select('id', 'name', 'email')
                             ->where('dipartimento', '=', "COMMERCIALE")
                             ->get();

                    ?>

                        <div class="form-group{{ $errors->has('stato') ? ' has-error' : '' }}">
                            <label for="stato" class="col-md-4 control-label">stato               </label>

                            <div class="col-md-6">

                            <select id="state" class="form-control" name="state") >

                            <option>seleziona stato</option>
                                @foreach ($stato as $stato)
                                    <option value="{{$stato->id_stato}}">{{ $stato->nome_stato }}</option>
                                @endforeach

                            </select>

                                @if ($errors->has('stato'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('stato') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                       
                        <div class="form-group{{ $errors->has('citta') ? ' has-error' : '' }}">
                            <label for="citta" class="col-md-4 control-label">Citta <p style="color:#f37f0d;display:inline">(*)</p>      </label>

                            <div class="col-md-6">

                        <select id="city" class="form-control input-sm" name="city">
                                <option value="">seleziona citta </option>
                            </select>

                                @if ($errors->has('citta'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('citta') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        

                         <div class="form-group{{ $errors->has('commerciale') ? ' has-error' : '' }}">
                            <label for="commerciale" class="col-md-4 control-label"> Commerciale </label>

                            <div class="col-md-6">

                            <select id="commerciale" class="form-control" name="commerciale">

                            <option>seleziona commerciale</option>
                                @foreach ($commerciale as $commerciale)
                                    <option value="{{$commerciale->id}}">{{ $commerciale->name }} ({{ $commerciale->email }})</option>
                                @endforeach

                            </select>

                                @if ($errors->has('commerciale'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('commerciale') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-warning">
                            <i class="fa fa-btn fa-user"></i> Register
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<script src="{{ url('public/scripts/jquery.min.js')}}"></script>

<script type="text/javascript">

    // select dependency in state-city selection
    $(document).ready(function() {

        $('select[name="state"]').on('change', function() {

            var stateID = $(this).val();

            if(stateID) {

                $.ajax({

                    url: '{{ url('/cities/') }}'+ '/' + stateID,

                    type: "GET",

                    dataType: "json",

                    success:function(data) {

                        $('select[name="city"]').empty();

                         $('select[name="city"]').append('<option value=""></option>');

                        $.each(data, function(key, value) {

                            $('select[name="city"]').append('<option value="'+ key +'">'+ value +'</option>');

                        });

                    }

                });

            }else{

                $('select[name="city"]').empty();

            }

        });
        
    });

</script>