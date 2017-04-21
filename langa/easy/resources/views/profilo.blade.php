@extends('layouts.app')
@section('content')

<div class="row">
  <div class="col-md-10 col-md-offset-1">
    <div class="panel panel-default">
      <div class="panel-heading">
        Profilo
      </div>
      <div class="panel-body">
      	<div style="display:inline">
      		<h4 style="display:inline"> <h3>{{$utente->name}}</h3>
					<img src="http://easy.langa.tv/storage/app/images/<?php echo $ente->logo; ?>" style="max-width:100px; max-height:100px;display:inline"></img><hr>
						<div class="col-md-12">
							<div class="col-md-4">
							<?php echo Form::open(array('url' => '/profilo/aggiornaimmagine' . "/$ente->id", 'files' => true)) ?>
								{{ csrf_field() }}
								<label for="logo">Carica immagine profilo</label>
								<input class="form-control" type="file" id="logo" name="logo"><br>
								<input class="form-control btn btn-warning" type="submit" value="Aggiorna immagine">
							</form>
						</div>
						<div class="col-md-6">
							<?php echo Form::open(array('url' => '/profilo/aggiungilink', 'files' => true)) ?>
								{{ csrf_field() }}
								<label for="name">Nome</label>
								<input type="text" placeholder="Nome" name="name" class="form-control"><br>
								<label for="url">URL Link</label>
								<input type="text" placeholder="Link" name="url" class="form-control"><br>
								<label for="img">Immagine</label>
								<input type="file" name="img" class="form-control"><br>
								<input type="submit" class="form-control btn btn-warning" value="Aggiungi Link Rapido">
							</form>
							<div class="table-responsive">
								<table class="table">
									@foreach($link as $l)
										<tr><td>{{ $l->name }} | {{ $l->url }} <a  href="{{url('/profilo/link/elimina') . '/' . $l->id}}" title="Elimina questo collegamento rapido" class="btn btn-danger"><span class="fa fa-eraser"></span></a></td></tr>
									@endforeach
								</table>
							</div>
						</div>
					</div>
				</div>
      </div>
    </div>
  </div>
</div>

@endsection