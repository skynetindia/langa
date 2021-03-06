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

<?php $ruolo = DB::table('ruolo_utente')->where('is_delete', '=', 0)->get(); ?>

<?php echo Form::open(array('url' => '/store-permessi')) ?>

<div class="col-md-4 pull-right">

    <label for="dipartimento">Profilazione <p style="color:#f37f0d;display:inline">(*)</p></label>

@if(isset($ruolo_id))

      <select id="nome_ruolo" class="form-control" name="nome_ruolo">

        @foreach($ruolo as $ruolo)
           <option  value="{{ $ruolo->ruolo_id }}" <?php echo ($ruolo_id==$ruolo->ruolo_id) ? 'selected="selected"':'';?>>{{ $ruolo->nome_ruolo }}</option>  
        @endforeach
         
      </select>

@else

    <input type="text" name="new_ruolo">

@endif

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
?>

@if(isset($permessi))

<?php

    foreach ($module as $module) {

      $submodule = DB::table('modulo')
            ->where('modulo_sub', $module->id)
            ->get();
      if($submodule) {

         echo "<tr>";
            echo "<td><b>";
            echo $module->modulo;
            echo "</td></b> <td>";
       ?><input type="checkbox" class="reading" id="lettura<?php echo $i; ?>" name="lettura[]" value="<?php echo $module->id.'|0|lettura';?>" <?php echo (in_array($module->id.'|0|lettura', $permessi)) ? 'checked' :''; ?>>        <?php
            echo "</td><td>"; ?>
              <input type="checkbox" class="writing" id="scrittura<?php echo $i; ?>"  name="scrittura[]"  value="<?php echo $module->id.'|0|scrittura';?>"<?php echo (in_array($module->id.'|0|scrittura', $permessi)) ? 'checked' :''; ?>>
            <?php
        echo "</td></tr>";

        foreach ($submodule as $submodule) {

          echo "<tr>";

            echo "<td>";
            echo $submodule->modulo;
            echo "</td>";

            echo "<td>"; ?>
              <input type="checkbox" class="lettura<?php echo $i; ?>" id="lettura" name="lettura[]" value="<?php echo $module->id.'|'.$submodule->id.'|lettura';?>"<?php echo (in_array($module->id.'|'.$submodule->id.'|lettura', $permessi)) ? 'checked' :''; ?> >
              <?php
            echo "</td>";

            echo "<td>"; ?>
              <input type="checkbox" class="scrittura<?php echo $i; ?>" id="scrittura" name="scrittura[]" value="<?php echo $module->id.'|'.$submodule->id.'|scrittura';?>" <?php echo (in_array($module->id.'|'.$submodule->id.'|scrittura', $permessi)) ? 'checked' :''; ?> >
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
            <input type="checkbox" class="reading" id="lettura<?php echo $i; ?>" name="lettura[]" value="<?php echo $module->id.'|0|lettura';?>" <?php echo (in_array($module->id.'|0|lettura', $permessi)) ? 'checked' :''; ?>>
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

@else
 <?php  
    foreach ($module as $module) {

      $submodule = DB::table('modulo')
            ->where('modulo_sub', $module->id)
            ->get();

      if($submodule) {

         echo "<tr>";
            echo "<td><b>";
            echo $module->modulo;
            echo "</td></b> <td>";
       ?><input type="checkbox" class="reading" id="lettura<?php echo $i; ?>" name="lettura[]" value="<?php echo $module->id.'|0|lettura';?>">        <?php
            echo "</td><td>"; ?>
              <input type="checkbox" class="writing" id="scrittura<?php echo $i; ?>"  name="scrittura[]"  value="<?php echo $module->id.'|0|scrittura';?>">
            <?php
        echo "</td></tr>";

        foreach ($submodule as $submodule) {

            echo "<tr>";

            echo "<td>";
            echo $submodule->modulo;
            echo "</td>";

            echo "<td>"; ?>
              <input type="checkbox" class="lettura<?php echo $i; ?>" id="lettura" name="lettura[]" value="<?php echo $module->id.'|'.$submodule->id.'|lettura';?>">
              <?php
            echo "</td>";

            echo "<td>"; ?>
              <input type="checkbox" class="scrittura<?php echo $i; ?>" id="scrittura" name="scrittura[]" value="<?php echo $module->id.'|'.$submodule->id.'|scrittura';?>">
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
            <input type="checkbox" class="reading" id="lettura<?php echo $i; ?>" name="lettura[]" value="<?php echo $module->id.'|0|lettura';?>">
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
@endif


<script type="text/javascript">

    //bhavika uncheck write permissoin when user uncheck read permissoin
    //code start
    $("input[type='checkbox']").on("click", function () {
        if (!$(this).prop('checked') && $(this).attr("id") == "lettura") {
            var str = $(this).attr("value");
            arr = str.split('|'),
                    output = arr.pop();
            str = arr.join('|') + '|scrittura';
            if ($(":checkbox[value='" + str + "']").prop("checked")) {
                $(":checkbox[value='" + str + "']").prop("checked", false)
            }
        }
    });
    //bhavika check read permissoin when user check write permissoin
    //code start
    $("input[type='checkbox']").on("click", function () {
        if ($(this).prop('checked') && $(this).attr("id") == "scrittura") {
            var str = $(this).attr("value");
            arr = str.split('|'),
                    output = arr.pop();
            str = arr.join('|') + '|lettura';
            if (!$(":checkbox[value='" + str + "']").prop("checked")) {
                $(":checkbox[value='" + str + "']").prop("checked", true)
            }
        }
    });
    //code ends   
    $('.reading').click(function () {
        // $('#sublettura').prop('checked', this.checked); 
        //bhavika uncheck write permissoin when user uncheck ready permissoin
        //code start
        var $id = $(this).attr('id');
        var write = "scrittura" + $id.replace(/[^\d.]/g, '');
        if (!$(this).prop('checked')) {
            $('#' + write).prop('checked', false);
            $('.' + write).prop('checked', false);
        }
        //code ends
        $('.' + $id).prop('checked', this.checked);

    });
    $('.writing').click(function () {
        var $id = $(this).attr('id');
        $('.' + $id).prop('checked', this.checked);
        
        var $id = $(this).attr('id');
        var read = "lettura" + $id.replace(/[^\d.]/g, '');
        if ($(this).prop('checked')) {
            $('#' + read).prop('checked', true);
            $('.' + read).prop('checked', true);
        }
        
    });</script>


<div class="col-md-12" style="padding-top:10px;padding-bottom:10px;">

    <button type="submit" class="btn btn-primary">Salva</button>

</div>

   <?php echo Form::close(); ?>  
<script>
    $('#nome_ruolo').change(function () {
        var url = '<?php echo url('/role-permessi'); ?>';
        window.location = url + '/' + $(this).val();
    });</script>
<script type="text/javascript" src="{{asset('public/scripts/index.js')}}">

@endsection