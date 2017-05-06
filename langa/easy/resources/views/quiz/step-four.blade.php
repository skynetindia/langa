@extends('layouts.app')

@section('content')


@if(!empty(Session::get('msg')))

    <script>

    var msg = '<?php echo html_entity_decode(htmlentities(Session::get('msg'))); ?>';

    document.write(msg);

    </script>

@endif

@include('common.errors')


<script src="{{ asset('public/scripts/jquery.min.js') }}"></script>

 <!-- CSS required for STEP Wizard  -->
 <style>
.wizard {
    margin: 20px auto;
    background: #fff;
}

    .wizard .nav-tabs {
        position: relative;
        margin: 40px auto;
        margin-bottom: 0;
        border-bottom-color: #e0e0e0;
    }

    .wizard > div.wizard-inner {
        position: relative;
    }

.connecting-line {
    height: 2px;
    background: #e0e0e0;
    position: absolute;
    width: 80%;
    margin: 0 auto;
    left: 0;
    right: 0;
    top: 50%;
    z-index: 1;
}

.wizard .nav-tabs > li.active > a, .wizard .nav-tabs > li.active > a:hover, .wizard .nav-tabs > li.active > a:focus {
    color: #555555;
    cursor: default;
    border: 0;
    border-bottom-color: transparent;
}

span.round-tab {
    width: 70px;
    height: 70px;
    line-height: 70px;
    display: inline-block;
    border-radius: 100px;
    background: #fff;
    border: 2px solid #e0e0e0;
    z-index: 2;
    position: absolute;
    left: 0;
    text-align: center;
    font-size: 25px;
}
span.round-tab i{
    color:#555555;
}
.wizard li.active span.round-tab {
    background: #fff;
    border: 2px solid #5bc0de;
    
}
.wizard li.active span.round-tab i{
    color: #5bc0de;
}

span.round-tab:hover {
    color: #333;
    border: 2px solid #333;
}

.wizard .nav-tabs > li {
    width: 25%;
}

.wizard li:after {
    content: " ";
    position: absolute;
    left: 46%;
    opacity: 0;
    margin: 0 auto;
    bottom: 0px;
    border: 5px solid transparent;
    border-bottom-color: #5bc0de;
    transition: 0.1s ease-in-out;
}

.wizard li.active:after {
    content: " ";
    position: absolute;
    left: 46%;
    opacity: 1;
    margin: 0 auto;
    bottom: 0px;
    border: 10px solid transparent;
    border-bottom-color: #5bc0de;
}

.wizard .nav-tabs > li a {
    width: 70px;
    height: 70px;
    margin: 20px auto;
    border-radius: 100%;
    padding: 0;
}

    .wizard .nav-tabs > li a:hover {
        background: transparent;
    }

.wizard .tab-pane {
    position: relative;
    padding-top: 50px;
}

.wizard h3 {
    margin-top: 0;
}

@media( max-width : 585px ) {

    .wizard {
        width: 90%;
        height: auto !important;
    }

    span.round-tab {
        font-size: 16px;
        width: 50px;
        height: 50px;
        line-height: 50px;
    }

    .wizard .nav-tabs > li a {
        width: 50px;
        height: 50px;
        line-height: 50px;
    }

    .wizard li.active:after {
        content: " ";
        position: absolute;
        left: 35%;
    }
}
</style>


<div class="row quiz-wizard">
  <div class="col-md-12">
    <h1>Quiz</h1>
    <div class="wizard">
      <div class="wizard-inner">
        <div class="connecting-line"></div>
        <ul class="nav nav-tabs">
          <li role="presentation" class="active"> <a href="#" title="Step 1"> <span class="round-tab"> <img src="{{ asset('images/folder.png') }}"> </span> <span class="tab-name">inserisci dati</span> </a> </li>
          <li role="presentation" class="active"> <a href="#" title="Step 2"> <span class="round-tab"> <img src="{{ asset('images/star.png') }}"> </span> <span class="tab-name">Valuta demo</span> </a> </li>
          <li role="presentation" class="active"> <a href="#" title="Step 3"> <span class="round-tab"> <img src="{{ asset('images/edit.png') }}"> </span> <span class="tab-name">Colori e layout</span> </a> </li>
          <li role="presentation" class="active"> <a href="#" title="Complete"> <span class="round-tab"> <img src="{{ asset('images/list.png') }}"> </span> <span class="tab-name">Optional</span> </a> </li>
          <li role="presentation" class="disabled"> <a href="#" title="Complete"> <span class="round-tab"> <img src="{{ asset('images/media.png') }}"> </span> <span class="tab-name">Media</span> </a> </li>
        </ul>
      </div>
      
      <div class="step-content step-four">
        <div class="step-pane">
          <div class="row">
              <div class="col-md-6">
                  <div class="left-side">
          <form action="">
            <div class="bootstrap-table">
              <div class="fixed-table-toolbar">
                <div class="columns columns-right btn-group pull-right">
                  <button class="btn btn-default" type="button" name="refresh" title="Aggiorna"><i class="glyphicon glyphicon-refresh icon-refresh"></i></button>
                  <div class="keep-open btn-group" title="Colonne">
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-th icon-th"></i> <span class="caret"></span></button>
                    <ul class="dropdown-menu" role="menu">
                      <li>
                        <label>
                          <input data-field="id" value="0" checked="checked" type="checkbox">
                          n° ente</label>
                      </li>
                      <li>
                        <label>
                          <input data-field="nomeazienda" value="1" checked="checked" type="checkbox">
                          Nome azienda</label>
                      </li>
                      <li>
                        <label>
                          <input data-field="nomereferente" value="2" checked="checked" type="checkbox">
                          Nome referente</label>
                      </li>
                      <li>
                        <label>
                          <input data-field="settore" value="3" checked="checked" type="checkbox">
                          Settore</label>
                      </li>
                      <li>
                        <label>
                          <input data-field="telefonoazienda" value="4" checked="checked" type="checkbox">
                          Telefono azienda</label>
                      </li>
                      <li>
                        <label>
                          <input data-field="email" value="5" checked="checked" type="checkbox">
                          Email</label>
                      </li>
                      <li>
                        <label>
                          <input data-field="indirizzo" value="6" checked="checked" type="checkbox">
                          Indirizzo</label>
                      </li>
                      <li>
                        <label>
                          <input data-field="responsabilelanga" value="7" checked="checked" type="checkbox">
                          Responsabile LANGA</label>
                      </li>
                      <li>
                        <label>
                          <input data-field="statoemotivo" value="8" checked="checked" type="checkbox">
                          Stato emotivo</label>
                      </li>
                      <li>
                        <label>
                          <input data-field="tipo" value="9" checked="checked" type="checkbox">
                          Tipo</label>
                      </li>
                    </ul>
                  </div>
                </div>
                <div class="pull-right search">
                  <input class="form-control" placeholder="Cerca" type="text">
                </div>
              </div>
            </div>
          </form>
          
          <br>

          <div class="row">

          <div class="col-md-12">
              <textarea cols="50" rows="2" id="get_lable"></textarea>
          </div>

          <?php $i=1; ?>
          @foreach($optional as $option)

          <div class="col-md-6 logo<?php echo $i;?>" onclick="setdiv(<?php echo $i ;?>)">
              <div class="item-wrapper">
                  <img src="{{ asset('storage/app/images/'.$option->icon) }}" height="50" width="50" class="logo_icon<?php echo $i;?>">
                  <div class="on-hover-text logo_label<?php echo $i;?>" id="">
                      {{ $option->label }}                     
                  </div>
                </div>
            </div>

            <div style="display: none;">
              <input type="hidden" name="optioan_id" class="optioan_id<?php echo $i;?>" value="{{ $option->id }}">
              <img src="{{ asset('storage/app/images/'.$option->immagine) }}" height="50" width="50" 
              class="logo_immagine<?php echo $i;?>">
              <div class="on-hover-text logo_description<?php echo $i;?>" id="">
                  {{ $option->description }}                 
              </div>
              <div class="on-hover-text logo_price<?php echo $i;?>" id="logo_price">
                  {{ $option->price }}
              </div>
            </div>

          <?php $i++; ?>
          @endforeach

         
          </div>
          
        </div>
                
                </div>
                
            <div class="col-md-6">
               <div class="right-side">
                <div class="right-header">
              <div class="right-heading">
                  <img src="" id="icon_logo" height="50" width="50">
                    <p id="icon_label"></p>
                </div>
                <div class="price">
                  € <span id="icon_price">50.00</span> cad
                </div>

                <input type="hidden" name="icon_id" id="icon_id">

            </div>
            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>" />
            <div class="right-side">
                  <button id="logo_add"> Aggiungi </button>
            </div>

            <div class="right-description">
              <div class="description-heading">
                  <span>Descrizione</span>
                 </div>
                 <div class="description">
                  <div class="desciption-img">
                      <img src="" alt="description" height="100" width="100" id="icon_immagine">
                    </div>
                    <div class="description-text">
                      <h4 id="icon_h4"></h4>
                        <p id="icon_description">Create web forms, surveys, quizzers and polls as easy as 1-2-3! With 123 Form Builder it takes just few clicks to create any custom form for Wiz. And no programming experience is requied.</p>
                    </div>
                 </div>
            </div>
        </div>
                
                </div>
            
            </div>
            
            <div class="step-footer">
              <div class="dots"> <span class="dot"> </span> <span class="dot"> </span> <span class="dot active"> </span> <span class="dot"> </span> <span class="dot"> </span> <span class="dot"> </span>
                <div class="page">3/7</div>
              </div>
              <ul class="list-inline">
                <li><a class="prev-step" id="prev_stepfour">Indietro</a></li>
                <li><a class="next-step" >Avanti</a></li>
              </ul>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>



<!-- JQeury code required for STEP wizard -->

  <script>

// $("#step_twonext").click(function(e){
//       document.location = '{{ url('/quiz/stepthree') }}';
//   });

  $('#prev_stepfour').click(function() {
    history.back();
  });

   function setdiv(i) {

      var icon = $('.logo_icon'+i).attr("src");
      var image = $('.logo_immagine'+i).attr("src");
      var label = $(".logo_label"+i).text();
      var price = $(".logo_price"+i).text();
      var description = $(".logo_description"+i).text();     
      var id = $(".optioan_id"+i).val();      

      label = label.replace(/(^\s*)|(\s*$)/gi,"");
      label = label.replace(/[ ]{2,}/gi," ");
      label = label.replace(/\n /,"\n");
      price = price.replace(/(^\s*)|(\s*$)/gi,"");
      price = price.replace(/[ ]{2,}/gi," ");
      price = price.replace(/\n /,"\n");

      $('#icon_logo').attr('src',icon);
      $('#icon_immagine').attr('src',image);
      $('#icon_label').text(label);
      $('#icon_price').text(price);
      $('#icon_h4').text(label);
      $('#icon_description').text(description);
      $('#icon_id').val(id);

      }

      $("#logo_add").click(function(e){

          var label = $('#icon_label').text()
          $('#get_lable').append($("#icon_label").text());
         
          e.preventDefault();

          var icon_label = $("#icon_label").text(); 
          var price = $("#icon_price").text();
          var optioan_id = $('#icon_id').val();
          var _token = $('input[name="_token"]').val();
         
          $.ajax({

              type:'POST',
              data: {
                      'icon_label': icon_label,
                      'price':price,
                      'optioan_id':optioan_id,
                      '_token' : _token
                    },

              url: '{{ url('storeStepfour') }}',

              success:function(data) {               
                  console.log(data);
                  // location.reload();
              }
          });

      });
    $(document).ready(function () {

        // var icon = document.getElementsByClassName('logo_icon');
        // var image = document.getElementsByClassName('logo_immagine');
        // var label = $(".logo_label").text();
        // var price = $(".logo_price").text();
        // var description = $(".logo_description").text();        

        // $('#icon_logo').attr('src',icon.src);
        // $('#icon_immagine').attr('src',image.src);
        // $('#icon_label').text(label);
        // $('#icon_price').text("€ " + price + ".00 cad");
        // $('#icon_h4').text(label);
        // $('#icon_description').text(description);
        
      // });      

     $("#step_1A").click(function(e){
        
        var nome_azienda = document.getElementById("nome_azienda");
        var ref_name = document.getElementById("ref_name");
        var settore_merceologico = document.getElementById("settore_merceologico");
        var indirizzo = document.getElementById("indirizzo");
        var telefono = document.getElementById("telefono");
        var email = document.getElementById("email");

            if (nome_azienda.value == '') {
                document.getElementById("span_azienda").style.display = "block";
                return false;
            } 

            if (ref_name.value == '') {
                document.getElementById("span_referente").style.display = "block";
                return false;
            } 

            if (settore_merceologico.value == '') {
                console.log("if");
                document.getElementById("span_settore").style.display = "block";
                return false;
            } 

            if (indirizzo.value == '') {
                document.getElementById("span_indirizzo").style.display = "block";
                return false;
            } 

            if (telefono.value == '') {
                document.getElementById("span_telefono").style.display = "block";
                return false;
            } 

            if (email.value == '') {
                document.getElementById("span_email").style.display = "block";
                return false;
            } 

          e.preventDefault();

          var nome_azienda = $("#nome_azienda").val(); 
          var ref_name = $("#ref_name").val();
          var settore_merceologico = $("#settore_merceologico").val();
          var indirizzo = $("#indirizzo").val(); 
          var telefono = $("#telefono").val(); 
          var email = $("#email").val();
          var _token = $('input[name="_token"]').val();

          $.ajax({
            type:'POST',
            data: {
                    'nome_azienda': nome_azienda,
                    'ref_name':ref_name,
                    'settore_merceologico': settore_merceologico,
                    'indirizzo': indirizzo,
                    'telefono':telefono,
                    'email': email,
                    '_token' : _token
                  },
            url: '{{ url('storeStep_1') }}',
            success:function(data) {
                  // location.reload();
                  console.log(data);
            }

        });

     });



    //Initialize tooltips
    $('.nav-tabs > li a[title]').tooltip();
    
    //Wizard
    $('a[data-toggle="tab"]').on('show.bs.tab', function (e) {

        var $target = $(e.target);
    
        if ($target.parent().hasClass('disabled')) {
            return false;
        }
    });

    $(".next-step").click(function (e) {

        var $active = $('.wizard .nav-tabs li.active');
        $active.next().removeClass('disabled');
        nextTab($active);

    });
    $(".prev-step").click(function (e) {

        var $active = $('.wizard .nav-tabs li.active');
        prevTab($active);

    });
});

function nextTab(elem) {
    $(elem).next().find('a[data-toggle="tab"]').click();
}
function prevTab(elem) {
    $(elem).prev().find('a[data-toggle="tab"]').click();
}
  
  </script>




@endsection