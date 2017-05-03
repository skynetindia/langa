@extends('adminHome')

@section('page')
<h1>Quiz Ratings </h1><hr>
@include('common.errors')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script type="text/javascript" src="{{asset('public/scripts/colors.js')}}"></script>
<script type="text/javascript" src="{{asset('public/scripts/jqColorPicker.min.js')}}"></script>
<script type="text/javascript">
	
         $('.color').colorPicker(); // that's it
   
</script>



<fieldset>
<legend style="padding-left:10px;color:#fff;background-color: #999">Ratings</legend>
<h4>Aggiungi Type</h4>
<form action="{{url('/admin/rating/new')}}" method="post" name="add_rating" id="add_rating">
    {{ csrf_field() }}
	<div class="col-md-4">
		<label> Title <p style="color:#f37f0d;display:inline">(*)</p> </label>
		<input type="text" class="form-control" id="descrizione" name="titolo" placeholder="titolo"><br> 
	</div>
	<div class="col-md-4">
	<label> Description  </label>
		<input type="text" class="form-control" id="descrizione" name="descrizione" placeholder="descrizione"><br> 
	</div>
	
	<div style="text-align:right">
		<input type="submit" class="btn btn-primary" value="Aggiungi">
	</div>
</form>

<h4>Modifica Type</h4>
<div class="table-responsive">
		<table class="table table-striped table-bordered" style="text-align:right">
	@foreach($ratings as $rating)
		
		<tr>
		<form action="{{url('/admin/rating/update')}}" method="post" name="edit_rating" id="edit_rating">
		{{ csrf_field() }}
		<input type="hidden" name="rating_id" value="{{$rating->rating_id}}">
		<div class="form-group">

			<div class="col-xs-6 col-sm-3">
				<td><input type="text" class="form-control" name="titolo" id="titolo" value="{{$rating->titolo}}" placeholder="titolo (*)"> </td>
			</div>
			<div class="col-xs-6 col-sm-3">
				<td><input type="text" id="descrizione" class="form-control" name="descrizione" value="{{$rating->descrizione}}" placeholder="descrizione"></td>
			</div>
		
			<div class="col-xs-6 col-sm-3">
				<td><input type="submit" class="btn btn-primary" value="Salva">
				<a  onclick="conferma(event);" type="submit" href="{{url('/admin/rating/delete/id' . '/' . $rating->rating_id)}}" class="btn danger"><button type="button" class="btn btn-danger">Cancella</button></a></td>
			</div>	
		</div>
		
	</form>
	</tr>
	
	@endforeach
	</table>
	</div>
	
</form>
</fieldset>

<script>
	function conferma(e) {
	var confirmation = confirm("Sei sicuro?") ;
    if (!confirmation)
        e.preventDefault();
	return confirmation ;
}
</script>

<script type="text/javascript" src="{{asset('public/scripts/index.js')}}">

@endsection