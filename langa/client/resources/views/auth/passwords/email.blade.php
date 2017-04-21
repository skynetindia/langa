@extends('layouts.app')

<!-- Main Content -->
@section('content')
<div class="container">
    <div class="row">
    	@if(!empty(Session::get('msg')))

	    <script>
	
	    var msg = '<?php echo html_entity_decode(htmlentities(Session::get('msg'))); ?>';
	
	    document.write(msg);
	
	    </script>
	
	@endif
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Reset Password Easy LANGA Client</div>
                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/password/email') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">e-mail</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}">

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div><br>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                            <a class="btn btn-default" href="{{ url('/login') }}">Indietro</a>
                                <button type="submit" class="btn btn-warning">
                                    <i class="fa fa-btn fa-envelope"></i> Invia link di reset password
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
