@extends('layouts.app')

@section('content')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
		<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
<h1>Modifica optional</h1><hr>
<style>
table tr td {
	text-align:left;
	
}
.table-editable {
  position: relative;
}
.table-editable .glyphicon {
  font-size: 20px;
}

.table-remove {
  color: #700;
  cursor: pointer;
}
.table-remove:hover {
  color: #f00;
}

.table-up, .table-down {
  color: #007;
  cursor: pointer;
}
.table-up:hover, .table-down:hover {
  color: #00f;
}

.table-add {
  color: #070;
  cursor: pointer;
  position: absolute;
  top: 8px;
  right: 0;
}
.table-add:hover {
  color: #0b0;
}

      #map {
        height: 100%;
		height: 400px;
      }
      .controls {
        margin-top: 10px;
        border: 1px solid transparent;
        border-radius: 2px 0 0 2px;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        height: 32px;
        outline: none;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
      }

      #pac-input {
        background-color: #fff;
        font-family: Roboto;
        font-size: 15px;
        font-weight: 300;
        margin-left: 12px;
        padding: 0 11px 0 13px;
        text-overflow: ellipsis;
        width: 300px;
      }

      #pac-input:focus {
        border-color: #4d90fe;
      }

      .pac-container {
        font-family: Roboto;
      }

      #type-selector {
        color: #fff;
        background-color: #4d90fe;
        padding: 5px 11px 0px 11px;
      }

      #type-selector label {
        font-family: Roboto;
        font-size: 13px;
        font-weight: 300;
      }
</style>
@if(!empty(Session::get('msg')))
    <script>
    var msg = '<?php echo html_entity_decode(htmlentities(Session::get('msg'))); ?>';
    document.write(msg);
    </script>
@endif
@include('common.errors')
<div class="container-fluid col-md-12">
	<div style="display:inline">
	<img src="http://easy.langa.tv/storage/app/images/<?php echo $optional->icon; ?>" style="max-width:100px; max-height:100px;display:inline"></img><h1 style="display:inline">  Codice: {{$optional->id}}</h1><hr>
	</div>
</div>
<?php echo Form::open(array('url' => '/admin/tassonomie/update/optional/' . $optional->id, 'files' => true)) ?>
	{{ csrf_field() }}
	<!-- colonna a sinistra -->
	<div class="col-md-4">
		<label for="code">Nome breve <p style="color:#f37f0d;display:inline">(*)</p></label>
		<input value="{{ $optional->code }}" class="form-control" type="text" name="code" id="code" placeholder="Codice"><br>
		<label for="price">Prezzo <p style="color:#f37f0d;display:inline">(*)</p></label>
		<input value="{{ $optional->price }}" class="form-control" type="text" name="price" id="code" placeholder="Prezzo"><br>
	</div>
	<!-- colonna centrale -->
	<div class="col-md-4">
		<label for="label">Nome <p style="color:#f37f0d;display:inline">(*)</p></label>
		<input value="{{ $optional->label }}" class="form-control" type="text" name="label" id="label" placeholder="Nome"><br>
                <label for="frequenza">Frequenza <p style="color:#f37f0d;display:inline">(*)</p></label>
                <select name="frequenza" class="form-control">
                    @foreach($frequenze as $frequenza)
                        @if($frequenza->id == $optional->frequenza)
                        <option selected value="{{$frequenza->id}}">{{$frequenza->nome}}</option>
                        @else
                        <option value="{{$frequenza->id}}">{{$frequenza->nome}}</option>
                        @endif
                    @endforeach
                </select><br>
	</div>
	<!-- colonna a destra -->
	<div class="col-md-4">
		<label for="description">Descrizione <p style="color:#f37f0d;display:inline">(*)</p></label>
		<input value="{{ $optional->description }}" class="form-control" type="text" name="description" id="description" placeholder="Descrizione"><br>
                <label for="dipartimento">Dipartimento <p style="color:#f37f0d;display:inline">(*)</p></label>
                <select name="dipartimento" class="form-control">
                    @foreach($dipartimenti as $dipartimento)
                        @if($dipartimento->id == $optional->dipartimento)
                        <option selected value="{{$dipartimento->id}}">{{$dipartimento->nomedipartimento}}</option>
                        @else
                        <option value="{{$dipartimento->id}}">{{$dipartimento->nomedipartimento}}</option>
                        @endif
                    @endforeach
                </select><br>
                <label for="logo">Logo</label>
		<?php echo Form::file('logo', ['class' => 'form-control']); ?><br>
	</div>

	<div class="col-xs-6" style="padding-top:10px;padding-bottom:10px;">
		
		<button type="submit" class="btn btn-primary">Salva</button>
	</div>
    <?php echo Form::close(); ?>  

@endsection