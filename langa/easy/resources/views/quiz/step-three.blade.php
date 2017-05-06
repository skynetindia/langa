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

<script type="text/javascript" src="{{asset('public/scripts/colors.js')}}"></script>
<script type="text/javascript" src="{{asset('public/scripts/jqColorPicker.min.js')}}"></script>



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

<!-- tagging textarea -->
<link href="{{asset('public/css/jquery.tag-editor.css')}}" rel="stylesheet">

  <!-- HTML Structure -->

<div class="row quiz-wizard">
  <div class="col-md-12">
    <h1>Quiz</h1>
    <div class="wizard">
      <div class="wizard-inner">
        <div class="connecting-line"></div>
        <ul class="nav nav-tabs">
          <li role="presentation" class="active"> <a href="#" title="Step 1"> <span class="round-tab"> <img src="{{ asset('images/folder.png') }}"> </span> <span class="tab-name">inserisci dati</span> </a> </li>
          <li role="presentation" class="disabled"> <a href="#" title="Step 2"> <span class="round-tab"> <img src="{{ asset('images/star.png') }}"> </span> <span class="tab-name">Valuta demo</span> </a> </li>
          <li role="presentation" class="disabled"> <a href="#" title="Step 3"> <span class="round-tab"> <img src="{{ asset('images/edit.png') }}"> </span> <span class="tab-name">Colori e layout</span> </a> </li>
          <li role="presentation" class="disabled"> <a href="#" title="Complete"> <span class="round-tab"> <img src="{{ asset('images/list.png') }}"> </span> <span class="tab-name">Optional</span> </a> </li>
          <li role="presentation" class="disabled"> <a href="#" title="Complete"> <span class="round-tab"> <img src="{{ asset('images/media.png') }}"> </span> <span class="tab-name">Media</span> </a> </li>
        </ul>
      </div>
      
      <div class="step-content step-three">
        <div class="step-pane">
          <form role="form" name="step_three" class="text-center register-for-quiz-form" method="post">
            <ol>
              <li><label> Quali pagine desidereresti? <p style="color:#f37f0d;display:inline">(*)</p> </label>
                   <div class="form-group">
            <!-- <textarea class="form-control" rows="5" ></textarea> 
            -->
            {{ csrf_field() }}

             <textarea name="pages" id="pages" cols="100"></textarea>
                     </div>
                </li>
                <span id="span_pages" style="display: none;">pages field is required </span>
                
                
                <li><label>Quali colori ti piacerebbero? <p style="color:#f37f0d;display:inline">(*)</p></label>
                <div class="form-group">
                     <div class="input-group">
                      <input type="text" class="form-control color no-alpha" value="" id="colore_primario"
                      name="colore_primario" placeholder="colore primario">
                      <span class="input-group-addon">Color picker goes here </span> 
                       </div>
                </div>
                 <span id="span_primario" style="display: none;">colore primario field is required </span>

                 <div class="form-group">
                     <div class="input-group">
                      <input type="text" class="form-control color " value="" name="colore_secondario" placeholder="Colore secondario" id="colore_secondario">
                      <span class="input-group-addon">Color picker goes here</span> 
                       </div>
                </div>
                
                <div class="form-group">
                     <div class="input-group">
                      <input type="text" class="form-control color" value="" name="colore_alternativo" placeholder="Colore alternativo" id="colore_alternativo">
                      <span class="input-group-addon">Color picker goes here</span> 
                       </div>
                </div>
                 </li>
                  
                 <li><label>Quali caratteri vorresti utilizzare?</label>
                  <div class="row">
                    <div class="col-md-6">
                           <div class="form-group">
                              <select class="form-control" id="fontsize" name="fontsize">
                                <option>12</option>
                                <option>18</option>
                                <option>24</option>
                                <option>28</option>
                                <option>32</option>
                                <option>36</option>
                                <option>40</option>
                                <option>48</option>
                              </select>
                            </div>
                            
                             <div class="form-group">
                                  <textarea class="form-control" rows="5" id="font_preview" name="font_preview">
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus lacinia dictum varius. Aenean fermentum est a nisl luctus, eu consequat dolor auctor. Aliquam dignissim sed felis a cursus. Aliquam ac vulputate metus. Proin sit amet felis auctor, elementum orci nec, hendrerit massa.
                                  </textarea>
                                </div>
                        </div>                        
                        
                      <div class="col-md-6">
                         <div class="form-group">
                            <select class="form-control" id="fontfamily" name="fontfamily">
                              <option>Arial</option>
                              <option>Verdana </option>
                              <option>Impact </option>
                              <option>Comic Sans MS</option>
                            </select>
                          </div>
                      </div>

                    </div>
                 </li>
            
            </ol>
            
          <div class="step-footer">
              <div class="dots"> <span class="dot"> </span> <span class="dot"> </span> <span class="dot active"> </span> <span class="dot"> </span> <span class="dot"> </span> <span class="dot"> </span>
                <div class="page">3/7</div>
              </div>
              <ul class="list-inline">
              <li><a class="prev-step" id="prev_stepthree">Indietro</a></li>
              <li><a class="next-step" id="step-three">Avanti</a></li>
              </ul>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

  
<!-- tagging textarea -->

<script src="https://code.jquery.com/ui/1.10.2/jquery-ui.min.js"></script>

<script src="{{asset('/public/scripts/jquery.tag-editor.js')}}">
</script>

<script src="{{asset('/public/scripts/jquery.caret.min.js')}}">
</script>


<script type="text/javascript">

    $('.color').colorPicker();

    $("#fontfamily").change(function() {
      $('#font_preview').css("font-family", $(this).val());
    });

    $("#fontsize").change(function() {
        $('#font_preview').css("font-size", $(this).val() + "px");
    });

    $('#prev_stepthree').click(function() {
      history.back();
    });


    $("#step-three").click(function(e){
        
        var pages = document.getElementById("pages");
        var colore_primario = document.getElementById("colore_primario");

        if (pages.value == '') {
            document.getElementById("span_pages").style.display = "block";
            return false;
        } 

        if (colore_primario.value == '') {
            document.getElementById("span_primario").style.display = "block";
            return false;
        } 


          e.preventDefault();

          var pages = $("#pages").val(); 
          var colore_primario = $("#colore_primario").val();
          var colore_secondario = $("#colore_secondario").val();
          var colore_alternativo = $("#colore_alternativo").val(); 
          var fontsize = $("#fontsize").val(); 
          var fontfamily = $("#fontfamily").val();
          var font_preview = $("#font_preview").val();
          var _token = $('input[name="_token"]').val();

          $.ajax({
            type:'POST',
            data: {
                    'pages': pages,
                    'colore_primario':colore_primario,
                    'colore_secondario': colore_secondario,
                    'colore_alternativo': colore_alternativo,
                    'fontsize':fontsize,
                    'fontfamily':fontfamily,
                    'font_preview': font_preview,
                    '_token' : _token
                  },
            url: '{{ url('storeStepthree') }}',
            success:function(data) {
                document.location = '{{ url('/quiz/stepfour') }}';
                  // location.reload();
                  // console.log(data);
            }

        });

     });

</script>

 <script>

  ;(function($){

        // jQuery UI autocomplete extension - suggest labels may contain HTML tags
        // github.com/scottgonzalez/jquery-ui-extensions/blob/master/src/autocomplete/jquery.ui.autocomplete.html.js
        (function($){var proto=$.ui.autocomplete.prototype,initSource=proto._initSource;function filter(array,term){var matcher=new RegExp($.ui.autocomplete.escapeRegex(term),"i");return $.grep(array,function(value){return matcher.test($("<div>").html(value.label||value.value||value).text());});}$.extend(proto,{_initSource:function(){if(this.options.html&&$.isArray(this.options.source)){this.source=function(request,response){response(filter(this.options.source,request.term));};}else{initSource.call(this);}},_renderItem:function(ul,item){return $("<li></li>").data("item.autocomplete",item).append($("<a></a>")[this.options.html?"html":"text"](item.label)).appendTo(ul);}});})(jQuery);

        var cache = {};
        function googleSuggest(request, response) {
            var term = request.term;
            if (term in cache) { response(cache[term]); return; }
            $.ajax({
                url: 'https://query.yahooapis.com/v1/public/yql',
                dataType: 'JSONP',
                data: { format: 'json', q: 'select * from xml where url="http://google.com/complete/search?output=toolbar&q='+term+'"' },
                success: function(data) {
                    var suggestions = [];
                    try { var results = data.query.results.toplevel.CompleteSuggestion; } catch(e) { var results = []; }
                    $.each(results, function() {
                        try {
                            var s = this.suggestion.data.toLowerCase();
                            suggestions.push({label: s.replace(term, '<b>'+term+'</b>'), value: s});
                        } catch(e){}
                    });
                    cache[term] = suggestions;
                    response(suggestions);
                }
            });
        }

        $(function() {
            $('#pages').tagEditor({
                placeholder: 'Enter pages ...',
                autocomplete: { source: googleSuggest, minLength: 3, delay: 250, html: true, position: { collision: 'flip' } }
            });

          
            $('#remove_all_tags').click(function() {
                var tags = $('#demo3').tagEditor('getTags')[0].tags;
                for (i=0;i<tags.length;i++){ $('#demo3').tagEditor('removeTag', tags[i]); }
            });

   
            function tag_classes(field, editor, tags) {
                $('li', editor).each(function(){
                    var li = $(this);
                    if (li.find('.tag-editor-tag').html() == 'red') li.addClass('red-tag');
                    else if (li.find('.tag-editor-tag').html() == 'green') li.addClass('green-tag')
                    else li.removeClass('red-tag green-tag');
                });
            }
            $('#demo6').tagEditor({ initialTags: ['custom', 'class', 'red', 'green', 'demo'], onChange: tag_classes });
            tag_classes(null, $('#demo6').tagEditor('getTags')[0].editor); // or editor == $('#demo6').next()
        });

        if (~window.location.href.indexOf('http')) {
            (function() {var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;po.src = 'https://apis.google.com/js/plusone.js';var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);})();
            (function(d, s, id) {var js, fjs = d.getElementsByTagName(s)[0];if (d.getElementById(id)) return;js = d.createElement(s); js.id = id;js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.4&appId=114593902037957";fjs.parentNode.insertBefore(js, fjs);}(document, 'script', 'facebook-jssdk'));
            !function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');
            $('#github_social').html('\
                <iframe style="float:left;margin-right:15px" src="//ghbtns.com/github-btn.html?user=Pixabay&repo=jQuery-tagEditor&type=watch&count=true" allowtransparency="true" frameborder="0" scrolling="0" width="110" height="20"></iframe>\
                <iframe style="float:left;margin-right:15px" src="//ghbtns.com/github-btn.html?user=Pixabay&repo=jQuery-tagEditor&type=fork&count=true" allowtransparency="true" frameborder="0" scrolling="0" width="110" height="20"></iframe>\
            ');
        }
        })(jQuery);

    </script>


<!-- JQeury code required for STEP wizard -->

  <script>
    $(document).ready(function () {

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
            url: '{{ url('storeStepthree') }}',
            success:function(data) {
               // $('#success_message').html(data);

               // if(data == 'false'){
               // //    // console.log(data);
               // //    $("#exist").css("display", "block");
               // //    $("#exist").css("color", "red");
               // //    $("#confirm").css("display", "block");
               // } 
               if(data == 'true') {
                  document.location = '{{ url('/quiz/stepfour') }}';
                  // location.reload();
                  // console.log(data);
               }              
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