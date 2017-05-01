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

<script type="text/javascript">
 
 $(document).ready(function() {

  $("#dipartimento").change(function(){

    if( $(this).val() == 1) {

        $("#sconto_section").hide();       
        $("#rendita").hide();
        $("#rendita_reseller").hide();
        $("#zone").hide();

    } else if( $(this).val() == 3) {

        $("#sconto_section").hide();    
        $("#rendita").hide();
        $("#rendita_reseller").hide();
        $("#zone").hide();

    } else if( $(this).val() == 4) {

        $("#sconto_section").show();      
        $("#rendita").show();
        $("#rendita_reseller").hide();
        $("#zone").show();

    } else {

      $("#sconto_section").show(); 
      $("#rendita").show();
      $("#rendita_reseller").show();
      $("#zone").show();

    }

  });

});

</script>

@if(!empty(Session::get('msg')))

    <script>

    var msg = '<?php echo html_entity_decode(htmlentities(Session::get('msg'))); ?>';

    document.write(msg);

    </script>

@endif

    <script type="text/javascript">

        $(document).on("click", "#profilazioneinterna", function () {
            
            if ($(this).is(":unchecked")) {
                $("#rendita").show();
            } else {
                $("#rendita").hide();
            }
        });

    </script>


@include('common.errors')

@if(isset($utente))

  <h1>Modifica utente</h1><hr>

  <?php echo Form::open(array('url' => '/admin/update/utente' . "/$utente->id", 'files' => true, 'id' => 'user_modification'));

   ?>

    {{ csrf_field() }}


    <!-- colonna a sinistra -->

  <div id="profilazione" class="pull-right">

    <label for="profilazione" >
        <input type="checkbox" id="profilazioneinterna" <?php if($utente->dipartimento == 1 || $utente->dipartimento == 3) { ?> checked="checked" <?php } ?> />
        Profilazione interna?
    </label>

  </div>

   <div class="col-md-4">

    <label for="name">Nome <p style="color:#f37f0d;display:inline">(*)</p></label>

    <input type="hidden" name="user_id" value="{{ $utente->id }}">

    <input value="{{ $utente->name }}" class="form-control" type="text" name="name" id="name" placeholder="inserisci il nome"><br>

<!--    <label for="cellulare">Cellulare</label>

                <input value="{{$utente->cellulare}}" class="form-control" type="text" name="cellulare" id="cellulare" placeholder="Cellulare"><br> -->
                
    <label for="colore">Colore</label>

    <input value="{{$utente->color}}" class="form-control color no-alpha" type="text" name="colore" id="colore" placeholder="Scegli un colore"><br>

    <div id="sconto_section"  <?php if($utente->dipartimento == 1 || $utente->dipartimento == 3) { ?> style="display: none" <?php } ?>>

    <div id="sconto">


    <label for="sconto">Sconto <p style="color:#f37f0d;display:inline">(*)</p></label>

    <input value="{{ $utente->sconto }}" class="form-control" type="text" name="sconto" id="sconto" placeholder="inserisci sconto"><br>

    </div>

    <div id="sconto_bonus">

    <label for="sconto_bonus">Sconto bonus<p style="color:#f37f0d;display:inline">(*)</p></label>

    <input value="{{ $utente->sconto_bonus }}" class="form-control" type="text" name="sconto_bonus" id="sconto_bonus" placeholder="inserire il bonus di sconto"><br>

    </div></div>  

    </div>

    <!-- colonna centrale -->

    <div class="col-md-4">

    <label for="id_ente">Associa a ente <p style="color:#f37f0d;display:inline">(*)</p></label>

      <div class="col-xs-6">

      <br>

      <a class="btn btn-warning" style="text-decoration: none; color:#fff" id="aggiungiente"><i class="fa fa-plus"></i></a>

      <a class="btn btn-danger" style="text-decoration: none; color:#fff" id="eliminaente"><i class="fa fa-eraser"></i></a>
              
      </div>

    <div class="col-md-12">

      <table class="table table-striped table-bordered">
                  
      <tbody id="ente">
      <?php 

          $ente = explode(",", $utente->id_ente);
          
          $i=0;
          
      foreach ($ente as $ente_value) { ?>
          
      <tr>
                      
      <label class="checkente<?php echo $i;?>">
      <select name="idente[]" class="form-control" id="id_ente" style="width: 200px">

      <option style="background-color:white" selected disabled>-- select --</option>  
      <?php  
        foreach ($enti as $enti_value) { ?> 

         <option <?php if($enti_value->id == $ente_value){ echo 'selected'; } ?> value="<?php echo $enti_value->id ?>"><?php echo $enti_value->nomereferente ?> </option> 

      <?php  }  ?>
    
    </select>
      
    <input id="checkente<?php echo $i;?>" type="checkbox" class="checkente">  

    </label>

    <?php $i++; ?>
    </tr>
    <?php  } 

    ?>
    <input type="hidden" id="hidden" name="check" value="<?php echo $i; ?>">
    
    </tbody>

    <script>
                    
    $('#aggiungiente').on("click", function() {
    var i = $("#hidden").val();
      
      $('#ente').append("<label class='checkente"+i+"'><select name='idente[]' class='form-control' id='id_ente'> <?php $check = false; ?> <option selected style='background-color:white'></option><?php for($i = 0; $i < count((array)$enti); $i++){if($enti[$i]->id == $utente->id_ente){ ?><option selected value='<?php echo $enti[$i]->id ?>'><?php echo $enti[$i]->nomereferente ?></option><?php $check = true; } if($check==false){ ?> <option value='<?php echo $enti[$i]->id ?>'><?php echo $enti[$i]->nomereferente ?> </option>+<?php } $check = false; }?></select><input id='checkente"+i+"' type='checkbox' class='checkente'></label>" );
        i++;
        $('#hidden').val(i);

            });

              $('#eliminaente').on("click", function() {

                  if($('#checkente0').prop('checked') == true) {

                      alert("Can not remove default ente");
                      $('input:checkbox').removeAttr('checked');

                  } else {

                     $(".checkente").each(function(){

                      var i = $("#hidden").val();

                        if($(this).prop('checked') ==true) {

                          var newclass = $(this).prop('id');
                          $("."+newclass).remove(); 
                          
                            i--;
                            $('#hidden').val(i);
                      }

                    });

                  }                 
              });

                  </script>
              </table>
        </div>  
      <br>

      <label for="email">e-mail </label><p style="color:#f37f0d;display:inline"> (*) </p></label>

      <input value="{{$utente->email}}" class="form-control" type="email" name="email" id="email" placeholder="inserisci l'email"><br>

      <div id="rendita" <?php if($utente->dipartimento == 1 || $utente->dipartimento == 3) { ?> style="display: none" <?php } ?>>

      <label for="rendita">Rendita <p style="color:#f37f0d;display:inline"> (*) </p></label>

      <input value="{{ $utente->rendita }}" class="form-control" type="text" name="rendita" id="rendita" placeholder="inserire l'annuità"><br>
    
      </div>


      <div id="rendita_reseller" <?php if($utente->dipartimento == 1 || $utente->dipartimento == 3 || $utente->dipartimento == 4) { ?> style="display: none" <?php } ?>>

     <label for="rendita_reseller">Rendita su reseller<p style="color:#f37f0d;display:inline"> (*) </p></label>

      <input value="{{ $utente->rendita_reseller }}" class="form-control" type="text" name="rendita_reseller" id="rendita_reseller" placeholder="inserire l'annuità del rivenditore"><br>

      </div>

      </div>

    <!-- colonna a destra -->

    <?php $ruolo = DB::table('ruolo_utente')
            ->where('is_delete', '=', 0)
            ->get();

    ?>

    <div class="col-md-4">

    <label for="dipartimento">Profilazione <p style="color:#f37f0d;display:inline">(*)</p></label>

    <select id="dipartimento" class="form-control" name="dipartimento">
         

         @foreach($ruolo as $ruolo)
           <option  value="{{ $ruolo->ruolo_id }}" <?php echo ($utente->dipartimento == $ruolo->ruolo_id) ? 'selected="selected"':'';?>>{{ $ruolo->nome_ruolo }}</option>  
        @endforeach 
      </select><br>

      <label for="password">Password</label>

      <input class="form-control" type="password" name="password" id="password" placeholder="inserire la password"> <br>

      <div id="zone" <?php if($utente->dipartimento == 1 || $utente->dipartimento == 3) { ?> style="display: none" <?php } ?>>

      <label for="zone">Zone <p style="color:#f37f0d;display:inline">(*)</p></label>

      <div class="col-xs-6">
      <br><a class="btn btn-warning" style="text-decoration: none; color:#fff" id="aggiungizone"><i class="fa fa-plus"></i></a>

      <a class="btn btn-danger" style="text-decoration: none; color:#fff" id="eliminazone"><i class="fa fa-eraser"></i></a>

    </div>

    <div class="col-md-12">
    
    <table class="table table-striped table-bordered">
                  
    <tbody id="zone">

    <?php 
      $city = explode(",", $utente->id_citta);

      $i=0;

    foreach ($city as $city_value) { ?>

    <tr>

    <label class="checkzone<?php echo $i;?>">                    

    <select name="zone[]" class="form-control" id="zone" style="width: 200px">
          <option style="background-color:white" selected disabled>-- select --</option>  
    <?php  

    foreach ($citta as $citta_value) { ?> 

     <option <?php if($citta_value->id_citta == $city_value){ echo 'selected'; } ?> value="<?php echo $citta_value->id_citta ?>"><?php echo $citta_value->nome_citta ?> </option> 
    <?php    }
    ?>

    </select>

    <input id="checkzone<?php echo $i;?>" type="checkbox" class="checkzone"> 
    </label>
    <?php $i++; ?>
        </tr>
    <?php  } ?>

    <input type="hidden" id="hiddenzone" name="checkhidden" value="<?php echo $i; ?>">
    
    </tbody>


    <script>
                  
      $('#aggiungizone').on("click", function() {

      var i = $("#hiddenzone").val();

      $('#zone').append("<label class='checkzone"+i+"'><select name='zone[]' class='form-control' id='zone' style='width: 250px'> <?php $check = false; ?> <option selected style='background-color:white'></option><?php for($i = 0; $i < count((array)$citta); $i++){if($citta[$i]->id_citta == $utente->id_citta){ ?><option selected value='<?php echo $citta[$i]->id_citta ?>'><?php echo $citta[$i]->nome_citta ?></option><?php $check = true; } if($check==false){ ?> <option value='<?php echo $citta[$i]->id_citta ?>'><?php echo $citta[$i]->nome_citta ?> </option>+<?php } $check = false; }?></select><input id='checkzone"+i+"' type='checkbox' class='checkzone'></label>");

          i++;
          $('#hiddenzone').val(i);

          });

        $('#eliminazone').on("click", function() {

            if($('#checkzone0').prop('checked') == true) {

              alert("Can not remove default zone");
              $('input:checkbox').removeAttr('checked');

          } else {

              $(".checkzone").each(function(){

              var i = $("#hiddenzone").val();

                if($(this).prop('checked') ==true) {

                  var newclass = $(this).prop('id');
                  $("."+newclass).remove(); 
                  
                    i--;
                    $('#hiddenzone').val(i);
              }

            });

          }                 
      });

      </script>

      <!-- if($('input[name=defaultcitta]:checked')){
              alert("Can not remove default zone");
          } else {
            $(".zonecheckbox input:checked").parent().remove();  
          }   -->
              
      </table>

      </div>
      
     </div>    

  </div> 



@else
  
  <?php $role = DB::table('ruolo_utente')
        ->where('is_delete', '=', 0)
        ->get();
    ?>
  
   @foreach ($role as $value) 

    <?php 
    if($value->ruolo_id == 1) { 
      ?>

      <script type="text/javascript">
        
        $(document).ready(function() {
          
            $("#sconto_section").hide();       
            $("#rendita").hide();
            $("#rendita_reseller").hide();
            $("#zone").hide();

          });

      </script>

    <?php } ?>

  @endforeach

  <h1>Add utente</h1><hr>

  <?php echo Form::open(array('url' => '/admin/update/utente', 'files' => true, 'id' => 'user_modification')) ?>
    
    {{ csrf_field() }}

    <div id="profilazione" class="pull-right">

    <label for="profilazione" >
        <input type="checkbox" id="profilazioneinterna" />
        Profilazione interna?
    </label>

  </div>

   <div class="col-md-4">

    <label for="name">Nome <p style="color:#f37f0d;display:inline">(*)</p></label>

    <input value="" class="form-control" type="text" name="name" id="name" placeholder="inserisci il nome"><br>

<!--    <label for="cellulare">Cellulare</label>

                <input value="" class="form-control" type="text" name="cellulare" id="cellulare" placeholder="Cellulare"><br> -->
                
    <label for="colore">Colore</label>

    <input value="" class="form-control color no-alpha" type="text" name="colore" id="colore" placeholder="Scegli un colore"><br>

    <div id="sconto_section" >

    <div id="sconto">

    <label for="sconto">Sconto <p style="color:#f37f0d;display:inline">(*)</p></label>

    <input value="" class="form-control" type="text" name="sconto" id="sconto" placeholder="inserisci sconto"><br>

    </div>

    <div id="sconto_bonus">

    <label for="sconto_bonus">Sconto bonus<p style="color:#f37f0d;display:inline">(*)</p></label>

    <input value="" class="form-control" type="text" name="sconto_bonus" id="sconto_bonus" placeholder="inserire il bonus di sconto"><br>

    </div></div>  

    </div>

    <!-- colonna centrale -->

    <div class="col-md-4">

    <label for="id_ente">Associa a ente <p style="color:#f37f0d;display:inline">(*)</p></label>

     <div class="col-xs-6">

      <br>

      <a class="btn btn-warning" style="text-decoration: none; color:#fff" id="aggiungiente"><i class="fa fa-plus"></i></a>

      <a class="btn btn-danger" style="text-decoration: none; color:#fff" id="eliminaente"><i class="fa fa-eraser"></i></a>
              
      </div>


      <div class="col-md-12">

      <table class="table table-striped table-bordered">
                  
      <tbody id="ente">
      <?php 

       
          
          $i=0;
          
    ?>
          
      <tr>
                      
      <label class="checkente<?php echo $i;?>">
      <select name="idente[]" class="form-control" id="id_ente" style="width: 200px">

      <option style="background-color:white" selected disabled>-- select --</option> 
      <?php  
        foreach ($enti as $enti_value) { ?> 

         <option value="<?php echo $enti_value->id ?>"><?php echo $enti_value->nomereferente ?> </option> 

      <?php  }  ?>
    
    </select>
      
    <input id="checkente<?php echo $i;?>" type="checkbox" class="checkente">  

    </label>

    <?php $i++; ?>
    </tr>
   
    <input type="hidden" id="hidden" name="check" value="<?php echo $i; ?>">
    
    </tbody>

    <script>
                    
    $('#aggiungiente').on("click", function() {
    var i = $("#hidden").val();
      
      $('#ente').append("<label class='checkente"+i+"'><select name='idente[]' class='form-control' id='id_ente'> <?php $check = false; ?> <option selected style='background-color:white'></option><?php for($i = 0; $i < count((array)$enti); $i++){ ?><option selected value='<?php echo $enti[$i]->id ?>'><?php echo $enti[$i]->nomereferente ?></option><?php $check = true; if($check==false){ ?> <option value='<?php echo $enti[$i]->id ?>'><?php echo $enti[$i]->nomereferente ?> </option>+<?php } $check = false; }?></select><input id='checkente"+i+"' type='checkbox' class='checkente'></label>" );
        i++;
        $('#hidden').val(i);

            });

              $('#eliminaente').on("click", function() {

                  if($('#checkente0').prop('checked') == true) {

                      alert("Can not remove default ente");
                      $('input:checkbox').removeAttr('checked');

                  } else {

                     $(".checkente").each(function(){

                      var i = $("#hidden").val();

                        if($(this).prop('checked') ==true) {

                          var newclass = $(this).prop('id');
                          $("."+newclass).remove(); 
                          
                            i--;
                            $('#hidden').val(i);
                      }

                    });

                  }                 
              });

                  </script>
              </table>
        </div>  
      <br>

      <label for="email">e-mail </label><p style="color:#f37f0d;display:inline"> (*) </p></label>

      <input value="" class="form-control" type="email" name="email" id="email" placeholder="inserisci l'email"><br>

      <div id="rendita_reseller">

     <label for="rendita_reseller">Rendita su reseller<p style="color:#f37f0d;display:inline"> (*) </p></label>

      <input value="" class="form-control" type="text" name="rendita_reseller" id="rendita_reseller" placeholder="inserire l'annuità del rivenditore"><br>

      </div>


      <div id="rendita">

      <label for="rendita">Rendita <p style="color:#f37f0d;display:inline"> (*) </p></label>

      <input value="" class="form-control" type="text" name="rendita" id="rendita" placeholder="inserire l'annuità"><br>
    
      </div>
      </div>

        <!-- colonna a destra -->
 <?php $role = DB::table('ruolo_utente')
        ->where('is_delete', '=', 0)
        ->get();
        ?>
    <div class="col-md-4">

    <label for="dipartimento">Profilazione <p style="color:#f37f0d;display:inline">(*)</p></label>

      <select id="dipartimento" class="form-control" 
      name="dipartimento">

           @foreach ($role as $value) 

            <option value="{{ $value->ruolo_id }}">{{ $value->nome_ruolo }} </option>

          @endforeach

      </select><br>

      <label for="password">Password <p style="color:#f37f0d;display:inline">(*)</p></label></label>

      <input class="form-control" type="password" name="add_password" id="password" placeholder="inserire la password"><br>

      <div id="zone">

      <label for="zone">Zone <p style="color:#f37f0d;display:inline">(*)</p></label>

      <div class="col-xs-6">
      <br><a class="btn btn-warning" style="text-decoration: none; color:#fff" id="aggiungizone"><i class="fa fa-plus"></i></a>

      <a class="btn btn-danger" style="text-decoration: none; color:#fff" id="eliminazone"><i class="fa fa-eraser"></i></a>

    </div>


    <div class="col-md-12">
    
    <table class="table table-striped table-bordered">
                  
    <tbody id="zone">

    <?php 
     
      $i=0;

    ?>
    <tr>

    <label class="checkzone<?php echo $i;?>">                    

    <select name="zone[]" class="form-control" id="zone" style="width: 200px">
          <option style="background-color:white" selected disabled>-- select --</option> 
    <?php  

    foreach ($citta as $citta_value) { ?> 

     <option value=""><?php echo $citta_value->nome_citta ?> </option> 

    <?php    }
    ?>

    </select>

    <input id="checkzone<?php echo $i;?>" type="checkbox" class="checkzone"> 
    </label>

    <?php $i++; ?>
        </tr>

    <input type="hidden" id="hiddenzone" name="checkhidden" value="<?php echo $i; ?>">
    
    </tbody>

    <script>
                  
      $('#aggiungizone').on("click", function() {

      var i = $("#hiddenzone").val();

      $('#zone').append("<label class='checkzone"+i+"'><select name='zone[]' class='form-control' id='zone' style='width: 250px'> <?php $check = false; ?> <option selected style='background-color:white'></option><?php for($i = 0; $i < count((array)$citta); $i++){ ?><option value='<?php echo $citta[$i]->id_citta ?>'><?php echo $citta[$i]->nome_citta ?></option><?php $check = true; if($check==false){ ?> <option value='<?php echo $citta[$i]->id_citta ?>'><?php echo $citta[$i]->nome_citta ?> </option>+<?php } $check = false; }?></select><input id='checkzone"+i+"' type='checkbox' class='checkzone'></label>");

          i++;
          $('#hiddenzone').val(i);

          });

        $('#eliminazone').on("click", function() {

            if($('#checkzone0').prop('checked') == true) {

              alert("Can not remove default zone");
              $('input:checkbox').removeAttr('checked');

          } else {

              $(".checkzone").each(function(){

              var i = $("#hiddenzone").val();

                if($(this).prop('checked') ==true) {

                  var newclass = $(this).prop('id');
                  $("."+newclass).remove(); 
                  
                    i--;
                    $('#hiddenzone').val(i);
              }

            });

          }                 
      });

      </script>

      <!-- if($('input[name=defaultcitta]:checked')){
              alert("Can not remove default zone");
          } else {
            $(".zonecheckbox input:checked").parent().remove();  
          }   -->
              
      </table>

      </div>
      
     </div>    

  </div> 

@endif



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

    {!! link_to(URL::previous(), 'Cancel', ['class' => 'btn btn-danger']) !!}

	</div>

    <?php echo Form::close(); ?>  

<script>

$('.ciao').on("click", function() {

    $(this).children()[0].click();

});

</script>

<script type="text/javascript" src="{{asset('public/scripts/index.js')}}">
@endsection