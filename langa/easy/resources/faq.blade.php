@extends('layouts.app')
@section('content')

<div class="container">
    <br />
    <br />

    <div class="panel-group" id="accordion">
 <div class="faqHeader">Bacheca</div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse1">Cos’è la bacheca Easy LANGA?</a>
                </h4>
            </div>
            <div id="collapse1" class="panel-collapse collapse">
                <div class="panel-body">
                    La Bacheca Easy LANGA è la prima pagina che viene visualizzata dall’utente dopo aver fatto accesso al gestionale.
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse2">Chi può vedere la bacheca Easy LANGA?</a>
                </h4>
            </div>
            <div id="collapse2" class="panel-collapse collapse">
                <div class="panel-body">
                    Tutti le profilazioni Easy LANGA:
                    <ul><br />
                        <li><b>AMMINISTRAZIONE</b></li>
                        <li><b>TECNICO</b></li>
                        <li><b>COMMERCIALE</b></li>
                        <li><b>CLIENTE</b></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse3">Dove trovo la bacheca Easy LANGA?</a>
                </h4>
            </div>
            <div id="collapse3" class="panel-collapse collapse">
                <div class="panel-body">
                    E’ la prima voce del menu, si trova in alto a sinistra.
                    <br />
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse4">Perchè utilizzare la bacheca Easy LANGA?</a>
                </h4>
            </div>
            <div id="collapse4" class="panel-collapse collapse">
                <div class="panel-body">
                  La bacheca EasyLanga si può personalizzare a seconda delle proprie esigenze. Si possono inserire gli strumenti più utilizzati per avere in un unica pagina un quadro generale della situazione.</br></br>
* Per poter personalizzare la bacheca bisogna entrare nelle impostazioni del proprio profilo che trovate in alto sulla destra del gestionale. Potete anche accedere alle impostazioni della vostra profilazione cliccando sull'icona a forma di user al fondo del menu in basso a sinistra.
                </div>
            </div>
        </div>
        <div class="faqHeader">Enti</div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse5">Cosa sono gli enti?</a>
                </h4>
            </div>
            <div id="collapse5" class="panel-collapse collapse">
                <div class="panel-body">
                    Gli enti fanno parte dell’anagrafica del gestionale Easy LANGA. Corrispondono a persone, aziende, clienti e fornitori.
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse6">Chi può vedere gli enti?</a>
                </h4>
            </div>
            <div id="collapse6" class="panel-collapse collapse">
                <div class="panel-body">
                     <ul>
                        <li><b>AMMINISTRAZIONE</b> => può vedere, creare, modificare e cancellare enti</li>
                        <li><b>TECNICO</b> => può vedere, creare, modificare e cancellare enti solamente se viene fatto partecipante</li>
                        <li><b>COMMERCIALE</b> => può vedere e creare enti</li>
                        <li><b>CLIENTE</b> => può vedere e modificare solamente il suo ente. Non può cancellarlo.</li>
                    </ul>
                </div>
            </div>
        </div>
                <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse7">Dove trovo gli enti?</a>
                </h4>
            </div>
            <div id="collapse7" class="panel-collapse collapse">
                <div class="panel-body">
                    E’ la seconda voce del menu, si trova in alto a sinistra sotto la bacheca.
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse8">Perchè utilizzare gli enti?</a>
                </h4>
            </div>
            <div id="collapse8" class="panel-collapse collapse">
                <div class="panel-body">
                    Gli enti servono a fare ordine in una anagrafica. L’utente EasyLanga può ricercare e trovare un ente per nome azienda, nome referente, settore, telefono, email, indirizzo, responsabile LANGA, stato emotivo o tipo.
                </div>
            </div>
        </div>
        <div class="faqHeader">Calendario</div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse9">Cos’è il calendario Easy LANGA?</a>
                </h4>
            </div>
            <div id="collapse9" class="panel-collapse collapse">
                <div class="panel-body">
                    Il calendario EasyLanga è lo strumento utilizzato per la gestione di eventi.
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse10">Chi può vedere il calendario?</a>
                </h4>
            </div>
            <div id="collapse10" class="panel-collapse collapse">
                <div class="panel-body">
                       <ul>
                        <li><b>AMMINISTRAZIONE</b> => può vedere, creare, modificare e cancellare eventi</li>
                        <li><b>TECNICO</b> => può vedere, creare, modificare e cancellare eventi</li>
                        <li><b>COMMERCIALE</b> => può vedere, creare, modificare e cancellare eventi</li>
                        <li><b>CLIENTE</b> => può vedere solamente gli eventi legati al suo ente</li>
                    </ul>
                    *Gli eventi creati da AMMINISTRAZIONE, TECNICO e COMMERCIALE sono pubblici. Ogni profilazione ha comunque la possibilità di rendere private le specifiche di un evento. La profilazione CLIENTE non può visualizzare gli eventi delle altre profilazioni.
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse11">Dove trovo il calendario?</a>
                </h4>
            </div>
            <div id="collapse11" class="panel-collapse collapse">
                <div class="panel-body">
                    E’ la terza voce del menu, si trova in alto a sinistra sotto enti.
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse12">Perchè utilizzare il calendario Easy LANGA?</a>
                </h4>
            </div>
            <div id="collapse12" class="panel-collapse collapse">
                <div class="panel-body">
                    Il calendario EasyLanga è utile per la gestione di eventi lavorativi o personali. Ogni evento può essere legato ad un ente. In base all’evento l’utente può scegliere se rendere pubblico o privato il suo contenuto.
                </div>
            </div>
        </div>
                <div class="faqHeader">Preventivi</div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse13">Cosa sono i preventivi Easy LANGA?</a>
                </h4>
            </div>
            <div id="collapse13" class="panel-collapse collapse">
                <div class="panel-body">
                    I preventivi Easy LANGA sono proposte commerciali personalizzabili all’interno del modulo preventivi. Inserendo le informazioni corrette, come: l’ente, i pacchetti e gli optional, il sistema genererà automaticamente un PDF con la relativa proposta da inviare al cliente.
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse14">Chi può vedere i preventivi?</a>
                </h4>
            </div>
            <div id="collapse14" class="panel-collapse collapse">
                <div class="panel-body">
                       <ul>
                        <li><b>AMMINISTRAZIONE</b> => può vedere, creare, modificare e cancellare preventivi</li>
                        <li><b>TECNICO</b> => può vedere solamente la lista dei preventivi eseguiti</li>
                        <li><b>COMMERCIALE</b> => può vedere, creare, modificare e cancellare preventivi</li>
                        <li><b>CLIENTE</b> => può vedere solamente i preventivi legati al suo ente</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse15">Dove trovo i preventivi?</a>
                </h4>
            </div>
            <div id="collapse15" class="panel-collapse collapse">
                <div class="panel-body">
                    E’ la quarta voce del menu, si trova in alto a sinistra sotto calendario.
                </div>
            </div>
        </div>
                        <div class="faqHeader">Progetti</div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse16">Cosa sono i progetti Easy LANGA?</a>
                </h4>
            </div>
            <div id="collapse16" class="panel-collapse collapse">
                <div class="panel-body">
                    I progetti Easy LANGA corrispondono alla lista dei progetti svolti. Ad ogni singolo progetto possono essere apllicate caratteristiche diverse come la % di completamento e lo stato emotivo.
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse17">Chi può vedere i progetti?</a>
                </h4>
            </div>
            <div id="collapse17" class="panel-collapse collapse">
                <div class="panel-body">
                       <ul>
                        <li><b>AMMINISTRAZIONE</b> => può vedere, creare, modificare e cancellare progetti</li>
                        <li><b>TECNICO</b> => può vedere, creare, modificare e cancellare progetti</li>
                        <li><b>COMMERCIALE</b> => può vedere solamente i progetti di cui è partecipante</li>
                        <li><b>CLIENTE</b> => può vedere solamente i progetti legati al suo ente</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse18">Dove trovo i progetti?</a>
                </h4>
            </div>
            <div id="collapse18" class="panel-collapse collapse">
                <div class="panel-body">
                    E’ la quinta voce del menu, si trova in alto a sinistra sotto preventivi.
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse19">Perchè devo utilizzare i progetti Easy LANGA?</a>
                </h4>
            </div>
            <div id="collapse19" class="panel-collapse collapse">
                <div class="panel-body">
                    I progetti Easy LANGA servono ad archiviare tutti i progetti svolti. All’interno di ogni singolo progetto hai la possibilità di tenere lo storico di tutte le lavorazioni. Se usi la profilazione CLIENTE avrai la possibilità di controllare le varie fasi lavorative dei tuoi progetti.
                </div>
            </div>
        </div>
        <div class="faqHeader">Contabilità</div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse20">Cos’è la contabilità Easy LANGA?</a>
                </h4>
            </div>
            <div id="collapse20" class="panel-collapse collapse">
                <div class="panel-body">
                    La contabilità Easy LANGA è il modulo comprendente le disposizioni di pagamento e le relative fatture. Le disposizioni si trovano all’interno di un contenitore chiamato “quadro”. Ogni quadro è legato a un ente per il quale si può avere più di una disposizione.
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse21">Chi può vedere la contabilità?</a>
                </h4>
            </div>
            <div id="collapse21" class="panel-collapse collapse">
                <div class="panel-body">
                       <ul>
                        <li><b>AMMINISTRAZIONE</b> => può vedere, creare, modificare, cancellare tutte le disposizioni e le fatture</li>
                        <li><b>TECNICO</b> => può vedere solamente la lista delle disposizioni e delle fatture</li>
                        <li><b>COMMERCIALE</b> => può vedere, creare, modificare, cancellare solo le sue disposizioni e le sue fatture</li>
                        <li><b>CLIENTE</b> => può vedere solamente le disposizioni e le fatture relative al suo ente</li>
                    </ul>
                    *La profilazione COMMERCIALE non potrà mai vedere, modificare o cancellare le disposizioni e le fatture della profilazione AMMINISTRAZIONE
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse22">Dove trovo la contabilità?</a>
                </h4>
            </div>
            <div id="collapse22" class="panel-collapse collapse">
                <div class="panel-body">
                    E’ la sesta voce del menu, si trova a metà del menu, sotto progetti.
                </div>
            </div>
        </div>
        <div class="faqHeader">Mailistica</div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse23">Cos’è la mailistica Easy LANGA?</a>
                </h4>
            </div>
            <div id="collapse23" class="panel-collapse collapse">
                <div class="panel-body">
                    La mailistica Easy LANGA è un sistema d’invio di mail ufficiali. Le mail verranno inviate attraverso questo modulo direttamente agli enti selezionati dall’utente.
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse24">Chi può vedere la mailistica?</a>
                </h4>
            </div>
            <div id="collapse24" class="panel-collapse collapse">
                <div class="panel-body">
                       <ul>
                        <li><b>AMMINISTRAZIONE</b> => può inviare le mail della profilazione AMMINISTRAZIONE e vedere le mail di tutte le profilazioni</li>
                        <li><b>TECNICO</b> => può inviare e vedere solo le mail legate alla profilazione tecnica</li>
                        <li><b>COMMERCIALE</b> => può inviare le mail della profilazione COMMERCIALE e vedere le mail legate alla profilazione TECNICA</li>
                        <li><b>CLIENTE</b> => non può vedere il modulo mailistica</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse25">Dove trovo la mailistica?</a>
                </h4>
            </div>
            <div id="collapse25" class="panel-collapse collapse">
                <div class="panel-body">
                    E’ la settima voce del menu, si trova a metà del menu, sotto contabilità.
                </div>
            </div>
        </div>
        <div class="faqHeader">Statistiche</div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse26">Cosa sono le statistiche Easy LANGA?</a>
                </h4>
            </div>
            <div id="collapse26" class="panel-collapse collapse">
                <div class="panel-body">
                    Le statistiche Easy LANGA comprendono un grafico che tiene aggiornato l’utente sull’andamento di spese, guadagni e ricavi.
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse27">Chi può vedere le statistiche?</a>
                </h4>
            </div>
            <div id="collapse27" class="panel-collapse collapse">
                <div class="panel-body">
                       <ul>
                        <li><b>AMMINISTRAZIONE</b> => può visualizzare le statistiche della profilazione AMMINISTRAZIONE e le statistiche della profilazione COMMERCIALE</li>
                        <li><b>TECNICO</b> => può inviare e vedere solo le mail legate alla profilazione tecnica</li>
                        <li><b>COMMERCIALE</b> => può inviare le mail della profilazione COMMERCIALE e vedere le mail legate alla profilazione TECNICA</li>
                        <li><b>CLIENTE</b> => non può vedere il modulo mailistica</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse25">Dove trovo la mailistica?</a>
                </h4>
            </div>
            <div id="collapse25" class="panel-collapse collapse">
                <div class="panel-body">
                    E’ la settima voce del menu, si trova a metà del menu, sotto contabilità.
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .faqHeader {
        font-size: 27px;
        margin: 20px;
    }

    .panel-heading [data-toggle="collapse"]:after {
        font-family: 'Glyphicons Halflings';
        content: "+"; /* "play" icon */
        float: right;
        color: #F58723;
        font-size: 18px;
        line-height: 22px;
        /* rotate "play" icon from > (right arrow) to down arrow */
        -webkit-transform: rotate(-90deg);
        -moz-transform: rotate(-90deg);
        -ms-transform: rotate(-90deg);
        -o-transform: rotate(-90deg);
        transform: rotate(-90deg);
    }

    .panel-heading [data-toggle="collapse"].collapsed:after {
        /* rotate "play" icon from > (right arrow) to ^ (up arrow) */
        -webkit-transform: rotate(90deg);
        -moz-transform: rotate(90deg);
        -ms-transform: rotate(90deg);
        -o-transform: rotate(90deg);
        transform: rotate(90deg);
        color: #454444;
    }
</style>

@endsection