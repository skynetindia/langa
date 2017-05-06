@extends('adminHome')

@section('page')

<h1>Impostazioni globali</h1><hr>
{!! Form::open(array('url' => 'admin/globali/store', 'files' => true)) !!}
	<div class="form-group">
		<label for="logo">Logo</label>
		<?php echo Form::file('logo',['required']); ?><br>
		<div style="width:100px; height:100px">
			<img style="width:100px; height:100px;" src="data:image/png;base64,<?php echo $logo; ?>"></img>
		</div>
	</div><br>
	<input value="Salva" type="submit" class="btn btn-warning" >
{!! Form::close() !!}
<br>
<h4>Profilazione Easy <strong>LANGA</strong></h4>
<hr>
<div class="table-responsive admin-table">
    <table class="table table-striped table-bordered">
        <th>Profilazione
        <th>Lettura
        <th>Scrittura

    <?php $i = 1; ?>
    @foreach($profilazioni as $profilazione)
    <tr>
        <td>
           <a href="{{url('role-permessi/'.$profilazione->ruolo_id)}}"> {{$profilazione->nome_ruolo}}</a>
        </td>
        <td>
           <!--  <input type="radio"> -->

            <div class="cust-radio"><input name="admin_check[0]" checked="" id="admin_checkl<?php echo $i; ?>" value="l<?php echo $i; ?>" type="radio">
            <!-- <label for="admin_check1"> 3 M.</label> -->
            <div class="check"><div class="inside"></div></div></div>
        </td>
        <td>
           <!--  <input type="radio"> -->

           <div class="cust-radio"><input name="admin_check[0]" id="admin_checks<?php echo $i; ?>" value="s<?php echo $i; ?>" type="radio">
           <!-- <label for="admin_check2"> 1 M.</label> -->
           <div class="check"><div class="inside"></div></div></div>
        </td>
    </tr>
    <?php $i++; ?>
    @endforeach
    </table>
</div>

@endsection