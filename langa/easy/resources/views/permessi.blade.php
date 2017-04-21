@extends('adminHome')
@section('page')


@include('common.errors')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script type="text/javascript" src="{{asset('public/scripts/colors.js')}}"></script>
<script type="text/javascript" src="{{asset('public/scripts/jqColorPicker.min.js')}}"></script>
<script type="text/javascript">
     $('.color').colorPicker();
</script>

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


table, td, th {    
    border: 1px solid #ddd;
    text-align: left;
}

table {
    border-collapse: collapse;
    width: 100%;
}

th, td {
    padding: 15px;
}


</style>


@if(!empty(Session::get('msg')))

    <script>

    var msg = '<?php echo html_entity_decode(htmlentities(Session::get('msg'))); ?>';

    document.write(msg);

    </script>

@endif

@include('common.errors')

<h1>Permessi</h1><hr>
<h5>Profilazione Easy <b> LANGA </b></h5><hr>

<?php $ruolo = DB::table('ruolo_utente')->get(); ?>

<?php echo Form::open(array('url' => '/store-permessi')) ?>

<div class="col-md-4 pull-right">

    <label for="dipartimento">Profilazione <p style="color:#f37f0d;display:inline">(*)</p></label>

      <select id="nome_ruolo" class="form-control" name="nome_ruolo">

        @foreach($ruolo as $ruolo)
           <option value="{{ $ruolo->ruolo_id }}">{{ $ruolo->nome_ruolo }}</option>  
        @endforeach
         
      </select>

<br><br><br>
  </div>


<?php


  echo "<table>";
    echo "<tr>";
      echo "<th>";
        echo "Moduli";
      echo "</th> ";
      echo "<th>";
        echo "Lettura";
      echo "</th> ";
      echo "<th>";
        echo "Scrittura";
      echo "</th> ";
    echo "</tr>";

    $i=0;

    foreach ($module as $module) {

      $submodule = DB::table('modulo')
            ->where('modulo_sub', $module->id)
            ->get();
      
      if($submodule) {

         echo "<tr>";
            echo "<td><b>";
            echo $module->modulo;
            echo "</td></b> <td>"; ?>
            <input type="checkbox" class="reading" id="lettura<?php echo $i; ?>" name="lettura[]" 
        value="<?php $a = in_array($module->modulo, $permessi); 
                if($a) {
                echo $module->modulo; ?>" checked <?php  } ?>>
            <?php
            echo "</td><td>"; ?>
              <input type="checkbox" class="writing" id="scrittura<?php echo $i; ?>"  name="scrittura[]"  value="<?php $a = in_array($module->modulo, $permessi); 
                if($a) {
                echo $module->modulo; ?>" checked <?php  } ?>>
            <?php
        echo "</td></tr>";

        foreach ($submodule as $submodule) {

          echo "<tr>";

            echo "<td>";
            echo $submodule->modulo;
            echo "</td>";

            echo "<td>"; ?>
              <input type="checkbox" class="lettura<?php echo $i; ?>" id="lettura" name="lettura[]" value="{{ $module->modulo }} {{ '->' }} {{ $submodule->modulo }}">
              <?php
            echo "</td>";

            echo "<td>"; ?>
              <input type="checkbox" class="scrittura<?php echo $i; ?>" id="scrittura" name="scrittura[]" value="{{ $submodule->modulo }}">
              <input type="hidden" id="hidden" name="checkhidden" value="<?php echo $i; ?>">
            <?php
            echo "</td>";

          echo "</tr>";
         
        } $i++;
      } else {

         echo "<tr>";
            echo "<td><b>";
            echo $module->modulo;
         echo "</td></b> ";

          echo "<td>"; ?>
            <input type="checkbox" class="reading" id="lettura<?php echo $i; ?>" name="lettura[]" value="{{ $module->modulo }}">
            <?php
          echo "</td>";

          echo "<td>"; ?>
          
          <?php
          echo "</td>";

        echo "</tr>";
      }  
    }
  
  echo "</table>";

?>

<script type="text/javascript">
  
  $('.reading').click(function () {    
       // $('#sublettura').prop('checked', this.checked); 
        var $id = $(this).attr('id');
        $('.'+$id).prop('checked', this.checked);
   });

  $('.writing').click(function () {    
       var $id = $(this).attr('id');
        $('.'+$id).prop('checked', this.checked);
   });

</script>


<div class="col-md-12" style="padding-top:10px;padding-bottom:10px;">

		<button type="submit" class="btn btn-primary">Salva</button>

</div>

   <?php echo Form::close(); ?>  

<script type="text/javascript" src="{{asset('public/scripts/index.js')}}">
@endsection