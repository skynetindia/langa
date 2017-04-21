<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Mail;
use Redirect;
use Validator;
use DB;
use Storage;
use App\PDF\QuotationPDF;
use App\PDF\fpdf;

class HomeController extends Controller
{

  private $nomiMesi = array(null, "Gennaio", "Febbraio", "Marzo", "Aprile", "Maggio", "Giugno", "Luglio", "Agosto", "Settembre", "Ottobre", "Novembre", "Dicembre");
    /**
     * Create a new controller instance.
     *
     * @return void
     */
  public function __construct()
  {
	  
    $this->middleware('auth');

  }
  
  public function reset(Request $request) {
  	// email
  	$password = substr(str_shuffle("abcdefghilmnopqrstuvz1234567890"), 0, 7);
	$email = $request->email;

        DB::table('clienti')
	    ->where('email', $email)
	    ->update(array(
	          'password' => bcrypt($password)
      	));
      	
      	Mail::send('layouts.reset', ['email' => $email, 'password' => $password], function ($m) use ($email) {
		$m->from('gestione.langa@gmail.com', 'Reset Password LANGA Client');
		$m->to($email)->cc('gestione.langa@gmail.com')->subject('Reset Password');
	});
	


  	return redirect("/login")
              ->with('msg', '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4>Abbiamo inviato la tua nuova password all\'indirizzo email da te indicato</h4></div>');
  }
  
  public function resetpassword(Request $request) {


  	return redirect("/try/password");
  }
  	public function mostracoordinate(Request $request)
	{
		return view('coordinate');	
	}

public function mostrafatture(Request $request)
{
  return view('fatture');
}

public function mostracontatti(Request $request)
{
	return view('contatti');
}
public function segnalazionerrore(Request $request)
	{
		$user = $request->user();
        if($request->screen != null) {
            // Salvo lo screen con un nome unico
            $nome = time() . uniqid() . '-' . '-screen';
            Storage::put(
                'images/' . $nome,
                file_get_contents($request->file('screen')->getRealPath())
            );

            $url = url('/storage/app/images') . '/' . $nome;
        } else
            $url = null;
		if(isset($request->love)) {
			Mail::send('layouts.emailringraziamento', ['user' => $request->user(), 'love' => $request->love, 'screen' => $url], function ($m) use ($user) {
				$m->from($user->email, 'Valutazione');
				$m->to('gestione.langa@gmail.com')->cc('pier.tarasco@gmail.com')->subject('VALUTAZIONE IN EASY LANGA');
        	});
			return Redirect::back()
                        ->with('msg', '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4>Grazie per aver valutato Easy, ricordati che senza il tuo supporto Easy non sarebbe quello che è ora</h4></div>');
		} else {
			Mail::send('errors.bug', ['user' => $request->user(), 'url' => $request->posizione, 'errore' => $request->errore, 'screen' => $url], function ($m) use ($user) {
				$m->from($user->email, 'Errore');
				$m->to('gestione.langa@gmail.com')->cc('pier.tarasco@gmail.com')->subject('ERRORE IN EASY LANGA');
        	});
			return Redirect::back()
                        ->with('msg', '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4>Grazie per aver segnalato questo errore, scusaci per il disagio</h4></div>');
		}
	}
public function mostrachangelog(Request $request)
	{
		return view('changelog');	
	}
	
	public function mostrafaq(Request $request)
	{
		return view('faq');	
	}

public function stampaTesto(&$pdf, $x, $y, $testo, $larghezza, $allineamento, $spessore, $family, $type, $size)
  {
    $pdf->SetFont($family, $type, $size);
    $array = explode("\n", $testo);
    
    for($i = 0; $i < count($array); $i++) {
      $pdf->SetXY($x, $y + $i * $spessore);
      $pdf->Cell($larghezza, 0, $array[$i], 0, 1, $allineamento);
    }
  }
  
  public function hasPower($user, $accounting)
  {
    return $accounting->A == $user->id_ente;
  }

public function generapdftranche(Request $request)
{
  $idtranche = $request->id;
    $tranche = DB::table('tranche')
              ->where('id', $idtranche)
              ->first();
    $user = $request->user();
    
    if(!$this->hasPower($user, $tranche)) {
      return redirect('/unauthorized');
    }

    $pdf = new FPDF('P', 'mm', 'A4');
    $pdf->AddPage();
    $pdf->AddFont('Nexa', '', 'NexaLight.php');
    $pdf->AddFont('Nexa', 'B', 'NexaBold.php');
    

    // Stampo lo scheletro della fattura
    $pdf->Image('http://easy.langa.tv/public/images/PDF/FATTURA.png',0,0,210,297,'PNG');
    
    /**
     * Stampo il logo dell'ente di chi ha fatto la fattura (DA)
     */ 
    
    $ente_DA = DB::table('corporations')
          ->where('id', $tranche->DA)
          ->first();
          
    $disposizione = DB::table('accountings')
              ->where('id', $tranche->id_disposizione)
              ->first();

    $pdf->SetTitle($tranche->idfattura . '_' . $disposizione->nomeprogetto . '_LANGA Group');
    
    // Stampo il logo
    $logo = 'http://easy.langa.tv/storage/app/images' . '/' . $ente_DA->logo;
    if(substr($logo, -3) == "png")
      $estensione = "PNG";
    else if(substr($logo, -3) == "jpg")
      $estensione = "JPG";
    else
      $estensione = "JPEG";
    $pdf->Image($logo, 10, 7.5, 20, 20, $estensione);
    /**
     * Stampo la sede legale dell'ente (DA)
     */
    // Stampo la sede legale dell'ente DA
    
    $this->stampaTesto($pdf, 140, 10, $ente_DA->sedelegale, 58, 'R', 3, 'Nexa', '', 8);
    /**
     * Stampo il tipo di fattura, l'emissione, la base
     */
    if($tranche->tipofattura == 0) {
      $tipofattura = "FATTURA DI VENDITA";
    } else {
      $tipofattura = "NOTA DI CREDITO";
    }
    // Stampo il tipofattura
    $this->stampatesto($pdf, 10, 33.5, $tipofattura, 27, 'L', 1, 'Nexa', '', 8);
    // Stampo l'id della fattura
    $this->stampatesto($pdf, 39, 33.5, $tranche->idfattura, 17, 'L', 1, 'Nexa', 'B', 7.75);
    // Stampo l'emissione
    $this->stampatesto($pdf, 56, 33.5, "EMISSIONE DEL", 180, 'L', 1, 'Nexa', '', 8);
    $this->stampatesto($pdf, 78, 33.5, $tranche->emissione, 34, 'L', 1, 'Nexa', 'B', 7.75);
    // Stampo su base
    $this->stampatesto($pdf, 96, 33.5, "SU BASE", 12, 'L', 1, 'Nexa', '', 8);
    $this->stampatesto($pdf, 110, 33.5, $tranche->base, 80, 'L', 1, 'Nexa', 'B', 7.75);
    /**
     * Stampo la sede legale del cliente (A) e l'indirizzo di spedizione (A)
     */
    $ente_A = DB::table('corporations')
          ->where('id', $tranche->A)
          ->first();
    // Stampo la sede legale (A)
    $this->stampatesto($pdf, 11, 47.5, $ente_A->sedelegale, 90, 'L', 2.5, 'Nexa', '', 8);
    // Stampo lindirizzo di spedizione (A)
    $this->stampatesto($pdf, 104.5, 47.5, $tranche->indirizzospedizione, 90, 'L', 1, 'Nexa', '', 8);
    /**
     * Stampo la modalità, la scadenza di disposizione, l'iban e la % del laovoro
     */
    // Stampo la modalita
    $this->stampatesto($pdf, 34, 71.5, $tranche->modalita, 35, 'C', 1, 'Nexa', 'B', 7.75);
    // Stampo la scadenza di disposizione
    $pdf->SetTextColor(243, 127, 13);
    $this->stampatesto($pdf, 101, 71.5, $tranche->datascadenza, 35, 'L', 1, 'Nexa', 'B', 7.75);
    $pdf->SetTextColor(0, 0, 0);
    // Stampo l'iban
    $this->stampatesto($pdf, 148, 71.5, $tranche->iban, 50, 'L', 1, 'Nexa', 'B', 7.75);
    // Stampo la % della fattura
    if($tranche->percentuale == 0) {
      $this->stampatesto($pdf, 33, 76.5, "FATTURA RELATIVA A TRANCHE CONCORDATA DI EURO ", 30, 'C', 1, 'Nexa', '', 7.75);
      $this->stampatesto($pdf, 82.5, 76.5, $tranche->testoimporto, 16, 'C', 1, 'Nexa', 'B', 7.75);
    } else {
      $this->stampatesto($pdf, 20, 76.5, "FATTURA SUL TOTALE LAVORO DEL ", 30, 'C', 1, 'Nexa', '', 7.75);
      $this->stampatesto($pdf, 56, 76.5, $tranche->percentuale . '%', 16, 'C', 1, 'Nexa', 'B', 7.75);
    }
    // Se è un rinnovo stampo 'Rinnovo per &n giorni da data emissione'
    if($tranche->tipo == 1) {
      $this->stampatesto($pdf, 147, 76.5, "RINNOVO PER " . $tranche->frequenza . " GIORNI DA DATA EMISSIONE", 40, 'C', 1, 'Nexa', '', 7.75);
    }
    /**
     * Stampo il corpo della fattura
     */
    $corpofattura = json_decode(json_encode(DB::table('corpofattura')
              ->where('id_tranche', $idtranche)
              ->get()), true);
    // Ascisse per gli elementi del corpo fattura
    $posizioni_x = array(
      0 => 11,
      1 => 26,
      2 => 123,
      3 => 133,
      4 => 151,
      5 => 169,
      6 => 187
    );
    // 'Larghezza' del campo di un elemento di un corpo fattura a partire dalla fine dell'elemento precedente
    $larghezza = array(
      0 => 14,
      1 => 95,
      2 => 9,
      3 => 17,
      4 => 17,
      5 => 17,
      6 => 17
    );
    $index = array(
      'ordine',
      'descrizione',
      'qta',
      'subtotale',
      'scontoagente',
      'netto',
      'percentualeiva'
    );
    // Elimino i campi che hanno qt, prezzo, %sconto, netto o %iva a 0
    for($i = 0; $i < count($corpofattura); $i++) {
      for($k = 2; $k < count($index); $k++) {
        if($corpofattura[$i][$index[$k]] == 0) {
          $corpofattura[$i][$index[$k]] = "";
        }
      }
    }
    for($i = 0; $i < count($corpofattura); $i++) {
      for($k = 0; $k < count($posizioni_x); $k++) {
        if($index[$k] =="descrizione") {
          $this->stampatesto($pdf, $posizioni_x[$k], 90.5 + $i * 10, $corpofattura[$i][$index[$k]], $larghezza[$k], 'L', 3, 'Nexa', '', 7); 
        } else {
          $this->stampatesto($pdf, $posizioni_x[$k], 90.5 + $i * 10, $corpofattura[$i][$index[$k]], $larghezza[$k], 'L', 1, 'Nexa', '', 7);
        }
      }
    }
    /**
     * Stampo la base della fattura
     */
    $pdf->SetAutoPageBreak(false);
    if($tranche->peso == 0) $tranche->peso = "";
    if($tranche->netto == 0) $tranche->netto = "";
    if($tranche->scontoaggiuntivo == 0) $tranche->scontoaggiuntivo = "";
    if($tranche->imponibile == 0) $tranche->imponibile = "";
    if($tranche->prezzoiva == 0) $tranche->prezzoiva = "";
    if($tranche->percentualeiva == 0) $tranche->percentualeiva = "";
    if($tranche->dapagare == 0) $tranche->dapagare = "";
    $this->stampatesto($pdf, 11, -13, $tranche->peso, 24, 'L', 1, 'Nexa', '', 7);
    $this->stampatesto($pdf, 34, -13, $tranche->netto, 24, 'L', 1, 'Nexa', '', 7);
    $this->stampatesto($pdf, 67, -13, $tranche->scontoaggiuntivo, 24, 'L', 1, 'Nexa', '', 7);
    $this->stampatesto($pdf, 99, -13, $tranche->imponibile, 24, 'L', 1, 'Nexa', '', 7);
    $this->stampatesto($pdf, 122, -13, $tranche->prezzoiva, 24, 'L', 1, 'Nexa', '', 7);
    $this->stampatesto($pdf, 137, -13, $tranche->percentualeiva, 24, 'L', 1, 'Nexa', '', 7);
    $this->stampatesto($pdf, 178, -13, $tranche->dapagare, 24, 'L', 1, 'Nexa', 'B', 8);
    $id_perfile = substr($tranche->idfattura, 0, 5) . '-' . substr($tranche->idfattura, 6);
    $pdf->Output($id_perfile . '_' . $disposizione->nomeprogetto . '_LANGA Group' . '.pdf', 'I');
}

public function aggiungiNomeQuadro(&$tranche, $user)
  {
    $elenco_tranche = [];
    foreach($tranche as $tra) {
      if($tra->tipo == 1) {
        $tra->tipo = "Rinnovo";
      } else {
        $tra->tipo = "Pagamento";
      }
      $disposizione = DB::table('accountings')
              ->where('id', $tra->id_disposizione)
              ->first();
      $tra->nomequadro = $disposizione->nomeprogetto;
      $stato = DB::table('statipagamenti')
            ->where('id_pagamento', $tra->id)
            ->first();
      if($stato) {
        $statoemotivo = DB::table('statiemotivipagamenti')
                ->where('id', $stato->id_tipo)
                ->first();
            
        $tra->statoemotivo = $statoemotivo->name;
      }
      if($user->id_ente == $tra->A) {
        $elenco_tranche[] = $tra; 
      }
    }
    return $elenco_tranche;
  }

public function getfatturejson(Request $request) {
  $tranche = DB::table('tranche')->get();
  $tranche = $this->aggiungiNomeQuadro($tranche, $request->user());
  return json_encode($tranche);
}


public function richiedimodifica(Request $request) {
  Mail::send('richiestamodifica', ['sezione' => $request->sezione, 'email' => $request->user()->email, 'nome' => $request->user()->name,'id' => $request->id], function ($m) use ($request) {
        $m->from($request->user()->email, 'Easy LANGA');
        $m->to('amministrazione@langa.tv')->subject('Cliente LANGA - Richiesta Modifica');
      });
  return Redirect::back();
}

public function pdfpreventivo(Request $request) {
        $preventivo = DB::table('quotes')
                        ->where('id', $request->id)
                        ->first();
    if($preventivo->idente != $request->user()->id_ente)
      return Redirect::back();
    // Prendo i dati dell'ente a cui è indirizzato il preventivo
    $ente = DB::table('corporations')
          ->where('id', $preventivo->idente)
          ->first();
    $utente = DB::table('users')
          ->where('id', $preventivo->user_id)
          ->first();
    $ente_DA = DB::table('corporations')
          ->where('id', $utente->id_ente)
          ->first();
        $pdf = new QuotationPDF($preventivo, $ente, $ente_DA);
        $pdf->AddFont('Nexa', '', 'NexaLight.php');
    $pdf->AddFont('Nexa', 'B', 'NexaBold.php');
    //$pdf->writePdf();
}

public function completaCodice(&$preventivi)
  {
        $statiemotivi = DB::table('statiemotivipreventivi')->get();
    foreach($preventivi as $prev) {
            $id = $prev->id;
      $prev->id = ':' . $prev->id . '/' . $prev->anno;
            $statoselezionato = DB::table('statipreventivi')
                ->where('id_preventivo', $id)
                ->first();
            foreach($statiemotivi as $stat) {
                if($statoselezionato != null)
                    if($statoselezionato->id_tipo == $stat->id) {
                        $prev->statoemotivo = $stat->name;
                        break;
                    }
            }
    }
  }

public function getpreventivijson(Request $request) {
  $preventivi = DB::table('quotes')
    ->select('*')
    ->where('idente', $request->user()->id_ente)
    ->get();
      
  $this->completaCodice($preventivi);
  return json_encode($preventivi);
}

public function completaCodiceProgetti(&$progetti)
  {
    foreach($progetti as $prog) {
      $anno = substr($prog->datainizio, -2);
      $prog->codice = '::' . $prog->id . '/' . $anno;
    }
  }

public function getprogettijson(Request $request) {
  $progetti = DB::table('projects')
    ->select('*')
    ->where('id_ente', $request->user()->id_ente)
    ->get();
  $this->completaCodiceProgetti($progetti);
  return json_encode($progetti);
}

public function mostrapreventivi(Request $request) {
  return view('preventivi');
}

public function mostraprogetti(Request $request) {
  return view('progetti');
}

public function show(Request $request)
{
        if($request->month == date('n') && $request->day == 0 && $request->year == date('Y'))
            $request->day = date('j');
    
      $eventi = DB::table('events')->where('id_ente', $request->user()->id_ente)
            ->where('meseFine', '>=', $request->month)
            ->where('annoFine', '>=', $request->year)
            ->orderBy('giorno', 'asc')
            ->get();
    
        return view('calendario', [
            'day' => $request->day,
            'month' => $request->month,
            'year' => $request->year,
            'giorniMese' => date('t', mktime(0, 0, 0, $request->month, $request->day, $request->year)),
            'nomiMesi' => $this->nomiMesi,
            'events' => $eventi,
        ]);
}

public function mostracalendario(Request $request)
{
  $request->day = date('j');
  $request->month = date('n');
  $request->year = date('Y');
  return $this->show($request);
}








// FINE CLIENTE
  public function homepage(Request $request) {

    return view('welcome', [
      
    ]);
  }

  public function attivapassword(Request $request) {
    $emailutente = preg_replace("/%40/", '@', $request->email);
            DB::table('users')->where('id', $request->id)
                    ->update(array(
                'password' => bcrypt($request->password),
                'email' => $emailutente,
            ));
           
        $nuovoutente = DB::table('users')
                            ->select('*')
                            ->where('id', $request->id)
                            ->first();
                            
            
        Mail::send('confermautente', ['user' => $nuovoutente->name, 'pswd' => $request->password, 'emailutente' => $nuovoutente->email], function ($m) use ($nuovoutente) {
            $m->from("amministrazione@langa.tv", 'Easy LANGA');
            $m->to($nuovoutente->email)->subject('Account Easy LANGA attivo');
        });
        
        return redirect("/conferma");
  }
	
    public function confermautente(Request $request) {
        Session::put('confermaregistrazione', 'gg');
        return redirect('/');
    }
    
    public function nuovoutente(Request $request)
    {
        Session::put('nuovaregistrazione', 'gg');
        return redirect('/logout');
    }
    
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('/');
    }
}
