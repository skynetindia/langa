@extends('layouts.app')



@section('content')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

		<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">

<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>

<!-- Param = day,

			 month,

			 year,

			 giorniMese,

			 nomiMesi,

			 giorniSettimana

-->

<h1>Calendario</h1>


<hr>



<style>
* {
    margin: 0;
}
.elimina {
	position: absolute;
	text-align:center;
	top: 50%;
	left:85%;
  	transform: translateY(-50%);
	text-decoration:none;
}
.orario {
	font-weight: bold;
}
.striscia {
	padding: 8px;
	color: #fff;
	position: relative;
}
html, body {
    height: 100%;
}
.wrapper {
    min-height: 100%;
    height: auto !important;
    height: 100%;
}
#push {
    height: auto;
}
#con {
  border: none;
  height: 2px;
  width: 2px;
  float: left;	
}
.inline {
  display:inline;
  width:200px;
  height:200px;
  padding: 5px;
  margin: auto;
  border:2px solid white;
  background-color:#fffff7;
  -moz-border-radius:1px; /* Firefox */
  border-radius:1px;
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
        background-color: #FFF;
    z-index: 20;
    position: fixed;
    display: inline-block;
    float: left;
      }
.modal {
    z-index: 20; 
	padding-top:51px;
}
.modal-backdrop {
    z-index: 10;        
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
td
{
    max-width: 10px;
    max-height: 150px;
    overflow: hidden;
}
</style>

<div class="wrapper">
<div class="table-responsive">

	<table class="table table-striped table-bordered">

		<tr><td colspan="5">

		<?php

			if($month == 1) {

				$link1 = "/calendario/show/day/0/month/12/year/" . ($year - 1);

				$link2 = "/calendario/show/day/0/month/" . ($month+1) . "/year/" . $year;

			} else if($month == 12) {

				$link1 = "/calendario/show/day/0/month/" . ($month-1) . "/year/" . $year;

				$link2 = "/calendario/show/day/0/month/1/year/" . ($year + 1);

			} else {

				$link1 = "/calendario/show/day/0/month/" . ($month-1) . "/year/" . $year;

				$link2 = "/calendario/show/day/0/month/" . ($month+1) . "/year/" . $year;

			}
		?>

		<a href="{{ url($link1) }}"><span class="glyphicon glyphicon-chevron-left"></span>{{ $nomiMesi[$month-1] or $nomiMesi[12] }} </a>

		{{ $nomiMesi[$month] }} {{ $year }}

		<a href="{{ url($link2) }}"> {{ $nomiMesi[$month+1] or $nomiMesi[1] }}<span class="glyphicon glyphicon-chevron-right"></span></a></td></tr>

		<tr>
		@for ($i = 1; $i <= $giorniMese; $i++)

			<td class="day"<?php if($i == $day) echo " style='color:#fff;background: #f37f0d;'"; ?> onclick="mostraEventi(<?php echo $i; ?>)">

				{{ $i }}

				<br>

				<?php $giorno = strftime('%A', mktime(0, 0, 0, $month, $i, $year));
                if($giorno == "Monday")
					$giorno = "Lunedì";
				else if($giorno == "Tuesday")
					$giorno = "Martedì";
				else if($giorno == "Wednesday")
					$giorno = "Mercoledì";
				else if($giorno == "Thursday")
					$giorno = "Giovedì";
				else if($giorno == "Friday")
					$giorno = "Venerdì";
				else if($giorno == "Saturday")
					$giorno = "Sabato";
				else if($giorno == "Sunday")
					$giorno = "Domenica";
                echo $giorno;
				$elenco_eventi = [];
                ?>
                <hr>

				<table>
                	<tr style="color:#fff">
					@foreach ($events as $event)
						@if($year <= $event->annoFine)
                        	@if($month <= $event->meseFine)
                            	<?php
									$utente = DB::table('users')
												->where('id', $event->user_id)
												->first();
									$colore = $utente->color;
								?>
                            	@if($month == $event->mese)
                                	@if($i >= $event->giorno)
                                    	@if($event->mese == $event->meseFine)
                                        	@if($i <= $event->giornoFine)
                                    			<td style="background-color:<?php echo $colore; ?>"> • </td>
                                                <?php $event->color = $colore ?>
                                                <?php $event->utente = $utente->name ?>
                                            @endif
                                        @else
                                        	<td style="background-color:<?php echo $colore; ?>"> • </td>
                                            <?php $event->color = $colore ?>
                                            <?php $event->utente = $utente->name ?>
                                        @endif
                                    @endif
                                @elseif($month == $event->meseFine)
                                	@if($i <= $event->giornoFine)
                                    	<td style="background-color:<?php echo $colore; ?>"> • </td>
                                        <?php $event->color = $colore ?>
                                        <?php $event->utente = $utente->name ?>
                                    @endif
                                @elseif($month > $event->mese && $month < $event->meseFine)
                                	<td style="background-color:<?php echo $colore; ?>"> • </td>
                                    <?php $event->color = $colore ?>
                                    <?php $event->utente = $utente->name ?>
                                @endif
                            @endif
                        @endif
					@endforeach
                    </tr>
				</table>

			</td>

			@if ($i % 5 == 0)

				</tr><tr>

			@endif

		@endfor

		</tr>

	</table>

</div>

<div id="push" style="display:none">
    <div id="content"></div>
</div>
<div class="footer">
</div>

</div>





<script src="{{ asset('public/scripts/jquery.min.js') }}"></script>

<script>




function conferma(e) {

	var confirmation = confirm("Sei sicuro?") ;

    if (!confirmation)

        e.preventDefault() ;

	return confirmation ;

}



</script>

        
<script>

var eventi = <?php echo json_encode($events); ?>;
var eventiDaStampare = [];


function removeAllChildren(theParent){

    // Create the Range object
    var rangeObj = new Range();

    // Select all of theParent's children
    rangeObj.selectNodeContents(theParent);

    // Delete everything that is selected
    rangeObj.deleteContents();
}

function mostraEventi(giorno) {
	$('#push').show();
	var content = $('#content');
	content.children().remove();
	eventiDaStampare = [];
	var year = <?php echo $year; ?>;
	var month = <?php echo $month; ?>;
	
	for(var i = 0; i < eventi.length; i++) {
		if(year <= eventi[i]["annoFine"]) {
			 if(month <= eventi[i]["meseFine"]) {
					if(month == eventi[i]["mese"]) {
						 if(giorno >= eventi[i]["giorno"]) {
							  if(eventi[i]["mese"] == eventi[i]["meseFine"]) {
									 if(giorno <= eventi[i]["giornoFine"]) {
											eventiDaStampare.push(eventi[i]);
						 			 }
						 	  } else {
									eventiDaStampare.push(eventi[i]);
						 	  }
						 }
					} else if(month == eventi[i]["meseFine"]) {
						  if(giorno <= eventi[i]["giornoFine"]) {
								eventiDaStampare.push(eventi[i]);
						   }
					} else if(month > eventi[i]["mese"] && month < eventi[i]["meseFine"]) {
						  eventiDaStampare.push(eventi[i]);
					}
			 }
		}
	}
	k = 0;
	
	for(var i = 0; i < eventiDaStampare.length; i++) {
		var link = document.createElement("a");
		link.href = "{{url('/calendario/edit/event/')}}" + '/' + eventiDaStampare[i]["id"];
		var striscia = document.createElement("p");
		striscia.style.backgroundColor = eventiDaStampare[i]["color"];
		striscia.className = "striscia";
		
		var orario = document.createElement("div");
		orario.className = "orario";
		var testoOrario = document.createTextNode(eventiDaStampare[i]["giorno"] + '/' + eventiDaStampare[i]["mese"] + ' - ' + eventiDaStampare[i]["giornoFine"] + '/' + eventiDaStampare[i]["meseFine"] + ' | ' + eventiDaStampare[i]["sh"] + ' - ' + eventiDaStampare[i]["eh"]);
		orario.appendChild(testoOrario);
		
		var ente = document.createElement("div");
		if(eventiDaStampare[i]["privato"] == 0) {
			var testoEnte = document.createTextNode(eventiDaStampare[i]["ente"]);
			ente.appendChild(testoEnte);
		}
		
		var titolo = document.createElement("div");
		if(eventiDaStampare[i]["privato"] == 0) {
			var testoTitolo = document.createTextNode(eventiDaStampare[i]["titolo"]);
			titolo.appendChild(testoTitolo);
		}
		
		var utente = document.createElement("div");
		var testoUtente = document.createTextNode(eventiDaStampare[i]["utente"]);
		utente.appendChild(testoUtente);
		
		var elimina = document.createElement("a");
		elimina.href = "{{url('/calendario/delete/event/')}}" + '/' + eventiDaStampare[i]["id"];
		elimina.className="elimina";
		elimina.onclick = function(e) {check = confirm("Sei sicuro di voler eliminare questo evento?"); if(!check) e.preventDefault();};
		elimina.className = "btn btn-danger btn-sm elimina";
		var tastoElimina = document.createElement("span");
		tastoElimina.className = "fa fa-eraser";
		elimina.appendChild(tastoElimina);
		
		striscia.appendChild(orario);
		striscia.appendChild(ente);
		striscia.appendChild(titolo);
		striscia.appendChild(utente);
		striscia.appendChild(elimina);
		link.appendChild(striscia);
		content.append(link);
		k++;
	}
	
	if(k == 0) {
		var el = document.createElement("h3");
		var testo = document.createTextNode("Nessun evento trovato...");
		el.appendChild(testo);
		content.append(el);	
	}	
}
</script>

@endsection