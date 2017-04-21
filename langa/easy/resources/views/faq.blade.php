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
* Per poter personalizzare la bacheca bisogna entrare nelle impostazioni del proprio profilo che trovate in alto sulla destra del gestionale. Potete anche accedere alle impostazioni della vostra profilazione cliccando sull'icona <span class="fa fa-user" aria-hidden="true"></span> user al fondo del menu in basso a sinistra.
                </div>
            </div>
        </div>
        <br><br/>
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
                        <li><b>AMMINISTRAZIONE</b> > può vedere, creare, modificare e cancellare enti</li>
                        <li><b>TECNICO</b> > può vedere, creare, modificare e cancellare enti solamente se viene fatto partecipante</li>
                        <li><b>COMMERCIALE</b> > può vedere e creare enti</li>
                        <li><b>CLIENTE</b> > può vedere e modificare solamente il suo ente. Non può cancellarlo.</li>
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
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse7a">Come faccio a vedere gli enti?</a>
                </h4>
            </div>
            <div id="collapse7a" class="panel-collapse collapse">
                <div class="panel-body">
                    Se vuoi vedere un tuo ente clicca sul modulo "Enti", vai su "Miei" e arrivi alla lista dei tuoi enti. Seleziona l'ente interessato e clicca sull'icona <i class="fa fa-pencil"></i></button> per visualizzarlo. Ora potrai modificare tutte le informazioni dell'ente.</br></br>
                    Se vuoi visualizzare tutti gli enti clicca sul modulo "Enti", vai su "Tutti" e arrivi alla lista di tutti gli enti. Qui vedi gli enti creati da tutti gli utenti ma non puoi modificare le informazioni, a meno che tu non sia stato attribuito come partecipante o responsabile.</br></br>In "Miei" e "Tutti" puoi ricercare un determinato ente attraverso una semplice barra posta sopra la lista degli enti.
                </div>
            </div>
        </div>
        <br><br/>
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
                        <li><b>AMMINISTRAZIONE</b> > può vedere, creare, modificare e cancellare eventi</li>
                        <li><b>TECNICO</b> > può vedere, creare, modificare e cancellare eventi</li>
                        <li><b>COMMERCIALE</b> > può vedere, creare, modificare e cancellare eventi</li>
                        <li><b>CLIENTE</b> > può vedere solamente gli eventi legati al suo ente</li>
                    </ul>
                    * gli eventi creati da AMMINISTRAZIONE, TECNICO e COMMERCIALE sono pubblici. Ogni profilazione ha comunque la possibilità di rendere private le specifiche di un evento (ente + oggetto). La profilazione CLIENTE non può visualizzare gli eventi delle altre profilazioni.
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
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse11a">Come faccio a vedere gli eventi del calendario?</a>
                </h4>
            </div>
            <div id="collapse11a" class="panel-collapse collapse">
                <div class="panel-body">
                    Se vuoi visualizzare i tuoi eventi nel calendario clicca sul modulo "Calendario", vai su "Miei" e accedi al calendario. Se clicchi sul giorno dell'evento appare un rettangolo colorato al fondo della pagina con tutte le specifiche. Cliccando sul rettangolo colorato si aprirà un popup dove potrai decidere se rendere privato l'evento ed inviare notifiche.</br></br>Se vuoi visualizzare tutti gli eventi nel calendario clicca sul modulo "Calendario", vai su "Miei" e accedi al calendario. Qui potrai visualizzare gli eventi di tutti gli utenti.
                </div>
            </div>
        </div>
        <br><br/>
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
                        <li><b>AMMINISTRAZIONE</b> > può vedere, creare, modificare e cancellare preventivi</li>
                        <li><b>TECNICO</b> > può vedere solamente la lista dei preventivi eseguiti</li>
                        <li><b>COMMERCIALE</b> > può vedere, creare, modificare e cancellare preventivi</li>
                        <li><b>CLIENTE</b> > può vedere solamente i preventivi legati al suo ente</li>
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
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse15a">Come faccio a vedere i miei preventivi?</a>
                </h4>
            </div>
            <div id="collapse15a" class="panel-collapse collapse">
                <div class="panel-body">
                    Se vuoi visualizzare i tuoi preventivi clicca sul modulo "Preventivi", vai su "Miei" e accedi alla lista di tutti i tuoi preventivi. Seleziona il preventivo interessato e clicca sull'icona PDF <span class="fa fa-file-pdf-o"></span> per visualizzarlo.</br></br>
Se vuoi visualizzare tutti i preventivi clicca sul modulo "Preventivi", vai su "Tutti" e arrivi alla lista di tutti i preventivi. Qui vedi i preventivi creati da tutti gli utenti ma non puoi modificare le informazioni.</br></br>In "Miei" e "Tutti" puoi ricercare un determinato preventivo attraverso una semplice barra posta sopra la lista dei preventivi. 
                </div>
            </div>
        </div>
        <br><br/>
        <div class="faqHeader">Progetti</div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse16">Cosa sono i progetti Easy LANGA?</a>
                </h4>
            </div>
            <div id="collapse16" class="panel-collapse collapse">
                <div class="panel-body">
                    I progetti Easy LANGA corrispondono alla lista dei progetti svolti. Ad ogni singolo progetto si applicano percentuale di completamento, stato emotivo, lavorazioni, files, note e dati sensibili.
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
                        <li><b>AMMINISTRAZIONE</b> > può vedere, creare, modificare e cancellare progetti</li>
                        <li><b>TECNICO</b> > può vedere, creare, modificare e cancellare progetti</li>
                        <li><b>COMMERCIALE</b> > può vedere solamente i progetti di cui è partecipante</li>
                        <li><b>CLIENTE</b> > può vedere solamente i progetti legati al suo ente</li>
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
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse19a">Come faccio a vedere i miei progetti?</a>
                </h4>
            </div>
            <div id="collapse19a" class="panel-collapse collapse">
                <div class="panel-body">
                    Se vuoi visualizzare i tuoi progetti clicca sul modulo "Progetti", vai su "Miei" e arrivi alla lista dei tuoi progetti. Seleziona il progetto interessato e clicca sull'icona <i class="fa fa-pencil"></i> e accedi al progetto. Rimani aggiornato sul progresso del progetto, le lavorazioni e lo stato emotivo.</br></br>
Se vuoi visualizzare tutti i progetti clicca sul modulo "Progetti", vai su "Tutti" e arrivi alla lista di tutti i progetti. Qui vedi i progetti creati da tutti gli utenti ma non puoi modificare le informazioni, a meno che tu non sia stato attribuito come partecipante.</br></br>In "Miei" e "Tutti" puoi ricercare un determinato progetto attraverso una semplice barra posta sopra la lista dei progetti. 
                </div>
            </div>
        </div>
        <br><br/>
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
                        <li><b>AMMINISTRAZIONE</b> > può vedere, creare, modificare, cancellare tutte le disposizioni e le fatture</li>
                        <li><b>TECNICO</b> > può vedere solamente la lista delle disposizioni e delle fatture</li>
                        <li><b>COMMERCIALE</b> > può vedere, creare, modificare, cancellare solo le sue disposizioni e le sue fatture</li>
                        <li><b>CLIENTE</b> > può vedere solamente le disposizioni e le fatture relative al suo ente</li>
                    </ul>
                    * la profilazione COMMERCIALE non potrà mai vedere, modificare o cancellare le disposizioni e le fatture della profilazione AMMINISTRAZIONE
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
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse22a">Come faccio a scaricare le mie fatture?</a>
                </h4>
            </div>
            <div id="collapse22a" class="panel-collapse collapse">
                <div class="panel-body">
                    Se vuoi scaricare la fattura relativa a un progetto clicca sul modulo "Contabilità", vai su "Fatture" e accedi alla lista delle tue fatture. Ora seleziona la fattura e clicca sull'icona PDF <span class="fa fa-file-pdf-o"></span> per poterla scaricare sul tuo computer.</br></br>Se hai più progetti e vuoi scaricare una fattura inerente a un determinato progetto clicca sul modulo "Contabilità", vai su "Pagamenti e rinnovi", clicca su "Disposizioni" e accedi alla lista delle tue disposizioni per progetto.</br>Seleziona la disposizione interessata, clicca sull'icona <span class="fa fa-eye"></span> e accedi all'elenco delle fatture inerenti al progetto. Ora seleziona la fattura e clicca sull'icona PDF <span class="fa fa-file-pdf-o"></span> per poterla scaricare sul tuo computer.
                </div>
            </div>
        </div>
        <br><br/>
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
                        <li><b>AMMINISTRAZIONE</b> > può inviare le mail della profilazione AMMINISTRAZIONE e vedere le mail di tutte le profilazioni</li>
                        <li><b>TECNICO</b> > può inviare e vedere solo le mail legate alla profilazione tecnica</li>
                        <li><b>COMMERCIALE</b> > può inviare le mail della profilazione COMMERCIALE e vedere le mail legate alla profilazione TECNICA</li>
                        <li><b>CLIENTE</b> > non può vedere il modulo mailistica</li>
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
        <br><br/>
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
                        <li><b>AMMINISTRAZIONE</b> > può visualizzare le statistiche della profilazione AMMINISTRAZIONE e le statistiche della profilazione COMMERCIALE</li>
                        <li><b>TECNICO</b> > non può vedere statistiche</li>
                        <li><b>COMMERCIALE</b> > può solo visualizzare le statistiche della profilazione COMMERCIALE</li>
                        <li><b>CLIENTE</b> > non può vedere statistiche</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse28">Dove trovo le statistiche?</a>
                </h4>
            </div>
            <div id="collapse28" class="panel-collapse collapse">
                <div class="panel-body">
                    E’ la prima voce del menu speciale.
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse29">Perchè devo utilizzare le statistiche Easy LANGA?</a>
                </h4>
            </div>
            <div id="collapse29" class="panel-collapse collapse">
                <div class="panel-body">
                    Le statistiche Easy LANGA danno all’utente una situazione chiara della situazione economica basandosi su un rapporto tra spese e ricavi. Con questo strumento puoi sapere esattamente quanti soldi sono stati spesi un determinato mese, qual’è stato il ricavo  e il relativo guadagno.
                </div>
            </div>
        </div>
        <br><br/>
        <div class="faqHeader">Info</div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse30">Cosa sono le info Easy LANGA?</a>
                </h4>
            </div>
            <div id="collapse30" class="panel-collapse collapse">
                <div class="panel-body">
                    Le info Easy LANGA sono il modulo dedicato alle informazioni generali del gestionale. Qui troverete contatti, FAQ e Changelog Easy (una sezione dove l’utente può trovare informazioni su versione in uso, aggiornamenti e correzzioni di bug).
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse31">Chi può vedere le info?</a>
                </h4>
            </div>
            <div id="collapse31" class="panel-collapse collapse">
                <div class="panel-body">
                       <ul>
                        <li><b>AMMINISTRAZIONE</b> > può visualizzare tutte le info</li>
                        <li><b>TECNICO</b> > può visualizzare tutte le info</li>
                        <li><b>COMMERCIALE</b> > può visualizzare tutte le info</li>
                        <li><b>CLIENTE</b> > può visualizzare tutte le info</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse32">Dove trovo le info?</a>
                </h4>
            </div>
            <div id="collapse32" class="panel-collapse collapse">
                <div class="panel-body">
                    E’ la seconda voce del menu speciale.
                </div>
            </div>
        </div>
        <br><br/>
        <div class="faqHeader">Segnalazioni</div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse33">Cosa sono le segnalazioni Easy LANGA?</a>
                </h4>
            </div>
            <div id="collapse33" class="panel-collapse collapse">
                <div class="panel-body">
                    Le segnalazioni Easy LANGA sono utili a tutti gli utenti che trovano un problema nel nostro gestionale e vogliono comunicarlo a chi di dovere per poterlo risolvere in maniera semplice e veloce. Questo modulo nasce per dare un supporto continuo a tutti gli utenti e migliorare la loro esperienza su Easy LANGA.
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse34">Chi può vedere le segnalazioni?</a>
                </h4>
            </div>
            <div id="collapse34" class="panel-collapse collapse">
                <div class="panel-body">
                       <ul>
                        <li><b>AMMINISTRAZIONE</b> > può visualizzare le segnalazioni</li>
                        <li><b>TECNICO</b> = può visualizzare le segnalazioni</li>
                        <li><b>COMMERCIALE</b> > può visualizzare le segnalazioni</li>
                        <li><b>CLIENTE</b> > può visualizzare le segnalazioni</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse35">Dove trovo le segnalazioni?</a>
                </h4>
            </div>
            <div id="collapse35" class="panel-collapse collapse">
                <div class="panel-body">
                    E’ la terza ed ultima voce del menu speciale.
                </div>
            </div>
        </div>
        <br><br/>
        <div class="faqHeader">Errori</div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse36">Perchè ottengo un 403?</a>
                </h4>
            </div>
            <div id="collapse36" class="panel-collapse collapse">
                <div class="panel-body">
                    Perchè la profilazione con la quale utilizzi Easy LANGA non ha i permessi per accedere a una determinata pagina.
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse37">Perchè ottengo un 404?</a>
                </h4>
            </div>
            <div id="collapse37" class="panel-collapse collapse">
                <div class="panel-body">
                     Perchè hai tentato di accedere a una pagina che su Easy LANGA non esiste.
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse38">Perchè ottengo un 503?</a>
                </h4>
            </div>
            <div id="collapse38" class="panel-collapse collapse">
                <div class="panel-body">
                    Perchè la pagina alla quale hai tentato di accedere non è al momento disponibile, è ancora in fase di lavorazione.
                </div>
            </div>
        </div>
        <br><br/>
        <div class="faqHeader">Altro...</div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse39">A cosa mi servono le icone al fondo del menu Easy LANGA?</a>
                </h4>
            </div>
            <div id="collapse39" class="panel-collapse collapse">
                <div class="panel-body">
                    <span class="fa fa-user" aria-hidden="true"></span>   Con l'icona profilo cambi le impostazioni della tua profilazione.<br><span class="fa fa-arrows-alt" aria-hidden="true"></span>   Con l'icona fullscreen attivi la modalità a schermo intero.<br><span class="fa fa-trash" aria-hidden="true"></span>   Con l'icona cestino accedi alla pagina cestino, dove puoi visualizzare tutto ciò che hai eliminato.<br><span class="fa fa-sign-out" aria-hidden="true"></span>   Con l'icona logout esci dal sistema.
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse40">Come posso visualizzare le notifiche Easy LANGA?</a>
                </h4>
            </div>
            <div id="collapse40" class="panel-collapse collapse">
                <div class="panel-body">
                     Per visualizzare le notifiche Easy LANGA clicca sull'icona <i class="fa fa-envelope-o"></i> in alto sulla destra del gestionale, vicino all'immagine del tuo profilo.
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse41">Quando compaiono le notifiche Easy LANGA?</a>
                </h4>
            </div>
            <div id="collapse41" class="panel-collapse collapse">
                <div class="panel-body">
                    <ul>
                        <li><b>SCADENZA EVENTO CALENDARIO</b> > 1 giorno prima</li>
                        <li><b>SCADENZA PREVENTIVO</b> > 3 giorni prima</li>
                        <li><b>SCADENZA LAVORAZIONE PROGETTO</b> > 1 giorno prima</li>
                        <li><b>SCADENZA DISPOSIZIONE PAGAMENTO</b> > 3 giorno prima</li>
                        
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<br><br/><br><br/><br><br/><br><br/>

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