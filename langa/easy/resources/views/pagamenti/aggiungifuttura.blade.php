@extends('layouts.app')
@section('content')

<?php
//echo "<pre>";
//print_r($enti);die
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
<link href="{{asset('public/css/dropzone.css')}}" rel="stylesheet" />
<script type="text/javascript" src="{{asset('public/scripts/dropzone.js')}}"></script>


<style>

    tr:hover td {

        background: #f2ba81;

    }

</style>
<script src="{{asset('public/scripts/select2.full.min.js')}}"></script>
<link href="{{asset('public/css/dropzone.css')}}" rel="stylesheet" />

<script type="text/javascript" src="{{asset('public/scripts/dropzone.js')}}"></script>
<h1>Aggiungi fattura 
    <?php
    // if (!$tranche->idfattura)
    // echo "#0000/" . date('y');
//else
    //  echo $tranche->idfattura;
    ?></h1><hr>

@if(!empty(Session::get('msg')))
<script>
var msg = '<?php echo html_entity_decode(htmlentities(Session::get('msg'))); ?>';
document.write(msg);
</script>
@endif

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>

@include('common.errors')
<form action="{{url('/pagamenti/nuovotranche')}}" method="post">
    {{ csrf_field() }}
    <div class="row">
        <div class="col-md-8">
            <script>
"use strict";
$.datepicker.setDefaults(
        $.extend(
                {'dateFormat': 'dd/mm/yy'},
                $.datepicker.regional['nl']
                )
        );
var $j = jQuery.noConflict();
var clickEvent = new MouseEvent("click", {
    "view": window,
    "bubbles": true,
    "cancelable": false
});
$j('#prev').on("change", function () {
    var id = $j("#prev").val();
    var link = document.createElement("a");
    link.href = "{{ url('/progetti/add') }}" + '/' + id;
    link.dispatchEvent(clickEvent);
});
            </script></label>
            <div class="col-md-12">
                <div class="col-md-6">
                    <label for="fattura">Fattura <input type="text" disabled value=":cod/anno" class="form-control"></label>
                    <a href="{{ url('/pagamenti/tranche/pdf')  }}" style="text-decoration:none;background:#DDDDDD" target="new" class="btn" type="button"><i class="fa fa-file-pdf-o"></i></a>
                </div>

                <div class="col-md-6">
                    <label for="fattura">Legame a Progetto</label>

                    <select name="project_id" id="project_id" class="project_id js-example-basic-single form-control">
                        <option></option>
                        @foreach($progetti as $proget)
                        <option value="{{$proget->id}}">Progetto ::{{$proget->id}} | {{date("y", strtotime($proget->datainizio))}} {{$proget->nomeprogetto}}</option>
                        @endforeach
                    </select></div>
            </div>

            <h4>Intestazione fattura</h4>
            <div class="col-md-12">
                <div class="col-md-3">
                    <!-- colonna a sinistra -->
                    <label for="sedelegaleente">Sede legale ente (DA)</label>
                    <select name="DA" id="sedelegaleente" class="js-example-basic-single form-control">
                        <option></option>
                        @foreach($enti as $ente)
                        <option value="{{$ente->id}}">{{$ente->id}} | {{$ente->nomeazienda}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="sedelegaleentea">Sede legale ente (A)</label>
                    <select id="sedelegaleentea" name="A" class="js-example-basic-single form-control">
                        <option></option>
                        @foreach($enti as $ente)
                        <option value="{{$ente->id}}">{{$ente->id}} | {{$ente->nomeazienda}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="id">n° fattura</label>
                    <input value="" type="text" id="id" name="idfattura" placeholder="Codice del pagamento" class="form-control"><br>

                </div>
                <div class="col-md-3">
                    <label for="Tipo">Tipo di fattura</label>
                    <select id="Tipo" name="tipofattura" class="form-control">

                        <option value="0" selected>Fattura di vendita</option>
                        <option value="1">Nota di credito</option>

                    </select>
                </div>
            </div>
            <b>Note:</b>
            <div class="col-md-12">
                <div class="col-md-4">
                    <br>

                    <!--                    <label for="id">n° fattura</label>-->
                    <input value="" type="text" id="id" name="idfattura" placeholder="Codice del pagamento" class="form-control"><br>

                </div>
                <div class="col-md-4"><label for="emissione">Emissione del</label>
                    <input type="text" name="emissione" id="emissione" class="form-control" value=""><br></div>
                <div class="col-md-4">
                    <label for="base">Su base</label>
                    <input class="form-control" type="text" name="base" id="base" placeholder="Su base" value="">
                    <br>
                    <script>

                        var today = new Date();
                        var dd = today.getDate();
                        var mm = today.getMonth() + 1; //January is 0!
                        var yyyy = today.getFullYear();
                        var tbody = document.createElement("tbody");
                        if (dd < 10) {
                            dd = '0' + dd;
                        }
                        if (mm < 10) {
                            mm = '0' + mm;
                        }
                        var vecchiaData = "";
                        var dataInserimento = vecchiaData.toString();
                        var impedisciModifica = function (e) {
                            this.blur();
                            this.value = dataInserimento;
                        }
                    </script>
                </div>
            </div>
            <div class="col-md-12">
                <div class="col-md-4">

                    <label for="modalita">Modalità di pagamento</label>
                    <input value="" type="text" class="form-control" id="modalita" name="modalita" placeholder="Modalità di pagamento"><br>



                </div>
                <div class="col-md-4">
                    <label for="iban">IBAN Societario</label>
                    <select name="iban" id="iban" class="js-example-basic-single form-control">
                        <option></option>
                        @foreach($enti as $ente)
                        <option value="{{$ente->iban}}">{{$ente->id}} | {{$ente->nomeazienda}}</option>
                        @endforeach
                    </select><script type="text/javascript">

                        $(".js-example-basic-single").select2();

                    </script>
                </div>
                <div class="col-md-4">
                    <label for="indirizzospedizione">Indirizzo di spedizione</label>
                    <select name="indirizzospedizione" id="indirizzospedizione" class="js-example-basic-single form-control">
                        <option></option>
                        @foreach($enti as $ente)
                        <option value="{{$ente->indirizzospedizione}}">{{$ente->id}} | {{$ente->nomeazienda}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <h4>Corpo fattura</h4>

            <div class="col-md-12">
                <a target="new" href="{{url('/pagamenti/tranche/corpofattura')}}" class="btn btn-info" style="color:#ffffff;text-decoration: none" title="Vedi Corpo fattura esistenti"><i class="fa fa-info"></i></a>
                <a class="btn btn-warning" style="text-decoration: none; color:#fff" id="aggiungiCorpo"><i class="fa fa-plus"></i></a>
                <a class="btn btn-danger" style="text-decoration: none; color:#fff" id="eliminaCorpo"><i class="fa fa-eraser"></i></a>
            </div><br>
            <table class="table table-striped">
                <thead>
                <th>#</th>
                <th>r.to Fattura</th>
                <th>Descrizione                                                       </th>
                <th>Q.tà</th>
                <th>Subtotale</th>
                <th>Totale</th>
    <!--                <th>% Sconto</th>
                <th>% Sc. bonus</th>
                <th>Netto</th>
                <th>% IVA</th>-->
                </thead>
                <tbody id="corpofattura">
                </tbody>
                <script>
                    var kCorpo = 0;
                    var selezioneCorpo = [];
                    var nCorpo = 0;
                    $j('#aggiungiCorpo').on("click", function () {                       
                        
                        if($(".project_id").val() == ""){
                            alert("Please select project");
                            return false;
                        }                                                
                        var ord1 = $("#ord1").val();
                        var ord2 = $("#ord2").val();
                        var tab = document.getElementById("corpofattura");
                        var tr = document.createElement("tr");
                        var check = document.createElement("td");
                        var checkbox = document.createElement("input");
                        checkbox.type = "checkbox";
                        checkbox.className = "selezione";
                        check.appendChild(checkbox);

                        var ord = document.createElement("td");
                        var ordine = document.createElement("input");
                        ordine.type = "text";
                        ordine.className = "form-control";
                        ordine.name = "ordine[]";
                        ordine.value =ord1;
                        ord.appendChild(ordine);

                        var quote = document.createElement("input");
                        quote.type = "text";
                        quote.className = "form-control";
                        quote.name = "ordine1[]";
                        quote.value = ord2;
                        ord.appendChild(quote);

                        var td = document.createElement("td");
                        var descrizione = document.createElement("textarea");
                        descrizione.className = "form-control";
                        descrizione.name = "desc[]";
                        td.appendChild(descrizione);
                        var qt = document.createElement("td");
                        var quantita = document.createElement("input");
                        quantita.type = "text";
                        quantita.className = "form-control";
                        quantita.name = "qt[]";
                        qt.appendChild(quantita);
                        var pr = document.createElement("td");
                        var prezzo = document.createElement("input");
                        prezzo.type = "text";
                        prezzo.className = "form-control";
                        prezzo.name = "subtotale[]";
                        pr.appendChild(prezzo);

                        var perc = document.createElement("td");
                        var totale = document.createElement("input");
                        totale.type = "text";
                        totale.className = "form-control";
                        totale.name = "totale[]";
                        perc.appendChild(totale);

                        //                        var perc = document.createElement("td");
                        //                        var percentualesconto = document.createElement("input");
                        //                        percentualesconto.type = "text";
                        //                        percentualesconto.className = "form-control";
                        //                        percentualesconto.name = "scontoagente[]";
                        //                        perc.appendChild(percentualesconto);

                        //                        var per = document.createElement("td");
                        //                        var percentual = document.createElement("input");
                        //                        percentual.type = "text";
                        //                        percentual.className = "form-control";
                        //                        percentual.name = "scontobonus[]";
                        //                        per.appendChild(percentual);
                        //                        var netto = document.createElement("td");
                        //                        var prezzonetto = document.createElement("input");
                        //                        prezzonetto.type = "text";
                        //                        prezzonetto.className = "form-control";
                        //                        prezzonetto.name = "prezzonetto[]";
                        //                        netto.appendChild(prezzonetto);
                        //                        var perciva = document.createElement("td");
                        //                        var iva = document.createElement("input");
                        //                        iva.type = "text";
                        //                        iva.className = "form-control";
                        //                        iva.name = "iva[]";
                        //                        perciva.appendChild(iva);
                        tr.appendChild(check);
                        tr.appendChild(ord);
                        tr.appendChild(td);
                        tr.appendChild(qt);
                        tr.appendChild(pr);
                        tr.appendChild(perc);
                        //tr.appendChild(per);
                        //tr.appendChild(netto);
                        //tr.appendChild(perciva);
                        kCorpo++;

                        tab.appendChild(tr);

                        $j('.selezione').on("click", function () {
                            selezioneCorpo[nCorpo] = $j(this).parent().parent();
                            nCorpo++;
                        });
                    });

                    $j('#eliminaCorpo').on("click", function () {
                        for (var i = 0; i < nCorpo; i++) {
                            selezioneCorpo[i].remove();
                        }
                        nCorpo = 0;
                    });
                </script>
            </table>
            <div id='base_fatture'>
                <h4>Base fattura</h4><a onclick="calcola()" style="text-decoration:none" class="" title="Compilazione assistita"><br>Clicca <i class="fa fa-info"></i> per compilazione</i></a>
                <table class="table table-striped">
                    <thead>
        <!--	   			<th>Peso (Kg)</th>-->

                    <th>Netto lavorazioni</th>
                    <th>Sconto aggiuntivo</th>
                    <th>Netto totale</th>
                    <th>Imponibile fattura</th>
                    <th>Prezzo IVA</th>
                    <th>% IVA</th>
                    <th>Totale da pagare</th>
                    </thead>
                    <tbody>


                    <td><input id="netto" class="form-control" type="text" name="netto" value=""></td>
                    <td><input id="sconto" class="form-control" type="text" name="scontoaggiuntivo" value=""></td>
                    <td><input id="nettototal" class="form-control" type="text" name="nettototal" value=""></td>
                    <td><input id="imponibile" class="form-control" type="text" name="imponibile" value=""></td>
                    <td><input id="prezzoiva" class="form-control" type="text" name="prezzoiva" value=""></td>
                    <td><input id="percentualeiva" class="form-control" type="text" name="percentualeiva" value=""></td>
                    <td><input id="dapagare" class="form-control" type="text" name="dapagare" value=""></td>
                    <script>
                        function approssima(x) {

                        }
                        function calcola() {
                            var percentuale = $j('#percentuale').val() || 0;

                            var netto = $j('#netto').val() || 0;
                            var sconto = $j('#sconto').val() || 0;
                            var nettototal = $j('#nettototal').val() || 0;

                            var imponibile = $j('#imponibile').val() || 0;
                            var prezzoiva = $j('#prezzoiva').val() || 0;
                            var percentualeiva = $j('#percentualeiva').val() || 0;
                            var dapagare = $j('#dapagare').val() || 0;

                            var importototale = eval(prompt("Inserisci l'importo equivalente al 100%", netto));

                            sconto = eval(prompt("Inserisci lo sconto aggiuntivo (€)", sconto));

                            nettototal = eval(prompt("Inserisci lo netto total (€)", (importototale - sconto)));

                            imponibile = eval(prompt("Inserisci l'imponibile (€)", nettototal));

                            //percentuale = eval(prompt("Inserisci la percentuale (%)", percentuale));

                            //netto = eval(prompt("Inserisci il prezzo netto (€)", (importototale - sconto) * percentuale / 100));

                            percentualeiva = eval(prompt("Inserisci la l'iva (%)", 22));

                            prezzoiva = eval(prompt("Inserisci il prezzo con iva (€)", imponibile * percentualeiva / 100));

                            dapagare = eval(prompt("Inserisci il totale da pagare (€)", imponibile + prezzoiva));

                            approssima(netto);
                            approssima(imponibile);
                            approssima(prezzoiva);
                            approssima(dapagare);


                            $j('#percentuale').val(percentuale);
                            $j('#netto').val(importototale);
                            $j('#sconto').val(sconto);

                            $j('#nettototal').val(nettototal);

                            $j('#imponibile').val(imponibile);

                            $j('#prezzoiva').val(prezzoiva);

                            $j('#percentualeiva').val(percentualeiva);

                            $j('#dapagare').val(dapagare);
                        }

                    </script>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-md-4">
            <label for="statoemotivo">Stato emotivo</label>
            <select name="statoemotivo" class="form-control" id="statoemotivo" style="color:#ffffff">
                <!-- statoemotivoselezionato -->

                @foreach($statiemotivi as $statoemotivo)
                <option style="background-color:{{$statoemotivo->color}};color:#ffffff" value="{{$statoemotivo->name}}">{{$statoemotivo->name}}</option>
                @endforeach

            </select>
            <script>
                var yourSelect = document.getElementById("statoemotivo");
                document.getElementById("statoemotivo").style.backgroundColor = yourSelect.options[yourSelect.selectedIndex].style.backgroundColor;
                $('#statoemotivo').on("change", function () {
                    var yourSelect = document.getElementById("statoemotivo");
                    document.getElementById("statoemotivo").style.backgroundColor = yourSelect.options[yourSelect.selectedIndex].style.backgroundColor;
                });
            </script>

            <label for="privato">Nascondi statistiche <i class="fa fa-eye-slash" title="Se sì, questa disposizione non influenzerà le statistiche economiche"></i>
                <select class="form-control" name="privato">
                    <option value="0">No</option>
                    <option value="1" selected>Si</option>                    
                </select>
                <br>
                <label for="tipo">Tipo</label>
                <select name="tipo" id="tipo" class="form-control">
                    <option selected value="0">Pagamento</option>
                    <option value="1">Rinnovo</option>
                    <option value="2">Performa</option>
                </select>
                <br><label for="percentuale">% importo totale (Inserisci 0 per importo non %) <p style="color:#f37f0d;display:inline">(*)</p></label>
                <input id="percentuale" name="percentuale" class="form-control" value="" placeholder="% disposizione">
                <br><label for="datascadenza">Data scadenza disposizione <p style="color:#f37f0d;display:inline">(*)</p></label><br>
                <input value="" class="form-control" name="datascadenza" id="datascadenza"></input><br>            
                <br>
                <script>
                    $j('#datains').datepicker();
                    var testo = "";
                    function mostra() {
                        if ($j('#dettagli').val()) {
                            testo = $j('#dettagli').val();
                            $j('#dettagli').val("");
                        } else {
                            $j('#dettagli').val(testo);
                            testo = "";
                        }
                    }
                    function mostra2() {
                        if (!$j('#dettagli').val())
                            $j('#dettagli').val(testo);
                    }
                </script> 
                <br>
                <div id="frequenza">
                    <br><label for="frequ">Frequenza <p style="color:#f37f0d;display:inline">(In giorni)</p></label>
                    <input value="" id="frequ" name="frequenza" class="form-control" placeholder="Frequenza">
                </div>

                <br>
                <div id="percentualediv">
                    <br><label for="frequ">Importo</label>
                    <input name="importo_nopercentuale" class="form-control" placeholder="Importo" value="">
                </div>
                <script>
                    if ($j('#tipo').val() == 1) {
                        // Mostro l'importo
                        $j('#frequenza').show();

                    } else {
                        // Nascondo l'importo
                        $j('#frequenza').hide();
                    }
                    if ($j('#tipo').val() == 2) {
                        $j('#base_fatture').hide();
                    } else {
                        $j('#base_fatture').show();
                    }

                    function test() {
                        if ($j('#percentuale').val() == 0) {
                            // Mostro l'importo
                            $j('#percentualediv').show();

                        } else {
                            // Nascondo l'importo
                            $j('#percentualediv').hide();
                        }
                    }
                    test();

                    $j('#percentuale').on("change", function () {
                        test();
                    });

                </script>

                <script>
                    $j('#datainserimento').datepicker();
                    $j('#datascadenza').datepicker();
                    $j('#emissione').datepicker();

                    $(".project_id").change(function () {                         
                        var ordine1 = $(this).val() +':'+ $("#year").val();                       
                        var ordine2 = $("#quote").val() +':'+ $("#year").val();                       
                        $("#ord1").val(ordine1);   
                        $("#ord2").val(ordine2);                           
                    });

                    $j('#tipo').on("change", function () {
                        if ($j('#tipo').val() == 0 || $j('#tipo').val() == 2) {
                            // Nascondo la frequenza
                            $j('#frequenza').hide();
                        } else {
                            // Mostro la frequenza
                            $j('#frequenza').show();
                        }
                        if ($j('#tipo').val() == 0 || $j('#tipo').val() == 1) {
                            $j('#base_fatture').show();
                        } else {
                            $j('#base_fatture').hide();
                        }
                    });
                </script>
        </div>
    </div>
    <div class="col-md-2" style="padding-top:20px;padding-bottom:10px;">
        <input onclick="mostra2()" type="submit" class="btn btn-warning" value="Salva">
    </div>



<!-- <label for="datainserimento">Data inserimento disposizione <p style="color:#f37f0d;display:inline">(*)</p></label><br>
            <input id="datains" value="" class="form-control" name="datainserimento"></input>-->
    <!--
                    <br><label for="nomereferente">Note private per l'amministrazione</label><a onclick="mostra()" id="mostra"> <i class="fa fa-eye"></i></a>
                    <textarea class="form-control" placeholder="Note amministrative accordate verbalmente/scritte a mano sul preventivo" title="Note nascoste, clicca l'occhio per mostrare"></textarea>-->

<!--                <label for="nomereferente">Note private dell'amministrazione</label><a onclick="mostra()" id="mostra"> <i class="fa fa-eye"></i></a>
<textarea class="form-control" name="dettagli" id="dettagli" placeholder="Inserisci note amministrative relative alla disposizione" title="Note nascoste, clicca l'occhio per mostrare" style="background:#f39538;color:#ffffff"></textarea>-->

    <input type="hidden" name="year" id="year"  value="{{date("y", strtotime($proget->datainizio))}}">
    <input type="hidden" name="quote" id="quote"  value="{{$proget->id_preventivo}}">
    <input type="hidden" name="ord1" id="ord1"  value="">
    <input type="hidden" name="ord2" id="ord2" value="" />
    

<?php $mediaCode = date('dmyhis');
?>
{{ csrf_field() }}
<input type="hidden" name="idutente" value="{{$utenti[0]->id}}">
<input type="hidden" name="mediaCode" id="mediaCode" value="{{$mediaCode}}" />

</form>

<div class="col-md-4">
    <label for="scansione">Allega file amministrativo (Scansione pagamenti, contratto, ...)</label><br>
    <br>
    <div class="col-md-12">
        <div class="image_upload_div">
            <?php echo Form::open(array('url' => '/pagamenti/tranche/modifica/uploadfiles/' . $mediaCode . '/', 'files' => true, 'class' => 'dropzone')) ?>
            {{ csrf_field() }}
            </form>				
        </div><script>
            var $j = jQuery.noConflict();
            var url = '<?php echo url('/pagamenti/tranche/modifica/getfiles/' . $mediaCode); ?>';
            Dropzone.autoDiscover = false;
            $(".dropzone").each(function () {
                $(this).dropzone({
                    complete: function (file) {
                        if (file.status == "success") {
                            $j.ajax({url: url, success: function (result) {
                                    $j("#files").html(result);
                                    $j(".dz-preview").remove();
                                    $j(".dz-message").show();
                                }});
                        }
                    }
                });
            });
            function deleteQuoteFile(id) {
                var urlD = '<?php echo url('/pagamenti/tranche/modifica/deletefiles/'); ?>/' + id;
                $j.ajax({url: urlD, success: function (result) {
                        $j(".quoteFile_" + id).remove();
                    }});
            }
            function updateType(typeid, fileid) {
                var urlD = '<?php echo url('/pagamenti/tranche/modifica/updatefiletype/'); ?>/' + typeid + '/' + fileid;
                $j.ajax({url: urlD, success: function (result) {
                        //$j(".quoteFile_"+id).remove();
                    }});
            }
        </script>
        <table class="table table-striped table-bordered">	                
            <tbody><?php
                if (isset($tranche->id) && isset($tranchefiles)) {


                    foreach ($tranchefiles as $prev) {
                        $imagPath = url('/storage/app/images/fattura/' . $prev->name);
                        $html = '<tr class="quoteFile_' . $prev->id . '"><td><img src="' . $imagPath . '" height="100" width="100"><a class="btn btn-danger pull-right" style="text-decoration: none; color:#fff" onclick="deleteQuoteFile(' . $prev->id . ')"><i class="fa fa-eraser"></i></a></td></tr>';
                        $html .= '<tr class="quoteFile_' . $prev->id . '"><td>';
                        $utente_file = DB::table('ruolo_utente')->select('*')->where('is_delete', '=', 0)->get();
                        foreach ($utente_file as $key => $val) {
                            $check = '';
                            if ($val->ruolo_id == $prev->type) {
                                $check = 'checked';
                            }
                            $html .= ' <input type="radio" name="rdUtente_' . $prev->id . '"  ' . $check . ' id="rdUtente_' . $val->ruolo_id . '" onchange="updateType(' . $val->ruolo_id . ',' . $prev->id . ');"  value="' . $val->ruolo_id . '" /> ' . $val->nome_ruolo;
                        }
                        echo $html .= '</td></tr>';
                    }
                }
                ?></tbody>
            <tbody id="files">
            </tbody>

            <script>

                var $j = jQuery.noConflict();
                var selezione = [];
                var nFile = 0;
                var kFile = 0;
                $j('#aggiungiFile').on("click", function () {
                    var tab = document.getElementById("files");
                    var tr = document.createElement("tr");
                    var check = document.createElement("td");
                    var checkbox = document.createElement("input");
                    checkbox.type = "checkbox";
                    checkbox.className = "selezione";
                    check.appendChild(checkbox);
                    kFile++;
                    var td = document.createElement("td");
                    var fileInput = document.createElement("input");
                    fileInput.type = "file";
                    fileInput.className = "form-control";
                    fileInput.name = "filee[]";
                    td.appendChild(fileInput);
                    tr.appendChild(check);
                    tr.appendChild(td);
                    tab.appendChild(tr);
                    $j('.selezione').on("click", function () {
                        selezione[nFile] = $j(this).parent().parent();
                        nFile++;
                    });
                });
                $j('#eliminaFile').on("click", function () {
                    for (var i = 0; i < nFile; i++) {
                        selezione[i].remove();
                    }
                    nFile = 0;
                });
            </script>
        </table><hr>
    </div>

</div>

@endsection