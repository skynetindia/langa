<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\AccountingRepository;
use App\Repositories\ProjectRepository;
use DB;
use Validator;
use Redirect;
use App\Http\Requests;
use App\Accounting;
use App\PDF\fpdf;

class AccountingController extends Controller
{
    protected $pagamenti;
	protected $progetti;
    
    public function __construct(AccountingRepository $accountings, ProjectRepository $projects)
    {
        $this->middleware('auth');
        $this->pagamenti = $accountings;
		$this->progetti = $projects;
		
    }
	
	public function mostracoordinate(Request $request)
	{
		return view('pagamenti.coordinate');	
	}
	
	public function aggiornacosto(Request $request)
	{
		DB::table('costi')
			->where('id', $request->id)
			->update(array(
				'oggetto' => $request->oggetto,
				'costo' => $request->costo,
				'datainserimento' => $request->datainserimento,
				'id_ente' => $request->ente
			));
		return Redirect::back()
		->with('msg', '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4>Costo modificato correttamente!</h4></div>');
	}
	
	public function modificacosto(Request $request)
	{
		$costo = DB::table('costi')
					->where('id', $request->id)
					->first();
		return view('modificacosto', [
			'costo' => $costo,
			'enti' => DB::table('corporations')->get()
		]);	
	}

	
	public function destroycosto(Request $request)
	{
		DB::table('costi')
			->where('id', $request->id)
			->delete();
		return Redirect::back();	
	}
	
	public function aggiungiNomeEnte(&$costi, $user)
	{
		$elenco_costi = [];
		foreach($costi as $costo) {
			$ente = DB::table('corporations')
							->where('id', $costo->id_ente)
							->first();
			$costo->ente = $ente->nomeazienda;
			if ($user->id === 0 || $user->dipartimento === "AMMINISTRAZIONE") {
            	$elenco_costi[] = $costo;
        	} else if($user->id == $tra->user_id) {
				$elenco_costi[] = $costo;	
			}
		}
		return $elenco_costi;
	}
	
	public function getjsoncosti(Request $request)
	{
		$costi = DB::table('costi')->get();
		$costi = $this->aggiungiNomeEnte($costi, $request->user());
		return json_encode($costi);
	}
	
	public function query($mese, $anno)
	{
		$spese = DB::table('costi')->get();
		$spese_array = [];
		foreach($spese as $spesa) {
			// gg/mm/aaaa
			$spesa_mese = substr($spesa->datainserimento, 3, 2);
			$spesa_anno = substr($spesa->datainserimento, 6, 4);
			if($spesa_mese == $mese && $spesa_anno == $anno)
				$spese_array[] = $spesa->costo;
		}
		return $spese_array;
	}
	
	public function queryRicavi($mese, $anno, $tipo)
	{
		$ricavi = DB::table('tranche')
					->where('privato', 0)
					->get();
		$ricavi_array = [];
		$utenti = DB::table('users')->get();
		foreach($ricavi as $ricavo) {
			// gg/mm/aaaa
			if($tipo == 1) {
				$ricavo_mese = substr($ricavo->datascadenza, 3, 2);
				$ricavo_anno = substr($ricavo->datascadenza, 6, 4);
			} else {
				$ricavo_mese = substr($ricavo->datainserimento, 3, 2);
				$ricavo_anno = substr($ricavo->datainserimento, 6, 4);
			}
			// Controllo se chi ha fatto la tranche è un commerciale,
			// se sì, allora devo contara il ricavo come una spesa (-)
			for($i = 0; $i < count($utenti); $i++) {
				if($utenti[$i]->id == $ricavo->user_id) {
					if($utenti[$i]->dipartimento === "COMMERCIALE") {
						$ricavo->imponibile *= -1;
					}
					break;	
				}	
			}
			if($ricavo_mese == $mese && $ricavo_anno == $anno)
				$ricavi_array[] = $ricavo->imponibile;
		}
		return $ricavi_array;
	}
	
	public function calcola($spese)
	{
		$totale = 0;
		for($i = 0; $i < count($spese); $i++)
			$totale += $spese[$i];
		return $totale;	
	}
	
	public function calcolaRicavi($spese)
	{
		$totale = 0;
		for($i = 0; $i < count($spese); $i++)
			$totale += $spese[$i];
		return $totale;	
	}
	
	public function compilaSpese(&$spese, $anno)
	{
		for($i = 1; $i <= 12; $i++) {
			if($i < 10)
				$i = '0' . $i;
			$spese[] = $this->calcola($this->query($i, $anno));
		}
	}
	
	public function compilaRicavi(&$ricavi, $anno, $tipo)
	{
		for($i = 1; $i <= 12; $i++) {
			if($i < 10)
				$i = '0' . $i;
			$ricavi[] = $this->calcolaRicavi($this->queryRicavi($i, $anno, $tipo));
		}
	}
	
	public function calcolaGuadagno(&$guadagno, $ricavi, $spese)
	{
		for($i = 0; $i < 12; $i++) {
			$guadagno[] = $ricavi[$i] + $spese[$i];
		}	
	}
	
	public function statisticheeconomiche(Request $request)
	{
		if ($request->user()->id === 0 || $request->user()->dipartimento === "AMMINISTRAZIONE") {
			$guadagno = [];
			$ricavi = [];
			$spese = [];
			$this->compilaSpese($spese, $request->anno);
			$this->compilaRicavi($ricavi, $request->anno, $request->tipo);
			$this->calcolaGuadagno($guadagno, $ricavi, $spese);
			return view('statistiche', [
				'guadagno' => $guadagno,
				'ricavi' => $ricavi,
				'spese' => $spese,
				'anno' => $request->anno,
				'tipo' => $request->tipo
			]);
		} else
			return redirect('/unauthorized');
	}
	
	public function mostrastatistiche(Request $request)
	{
		$request->anno = date('Y');
		$request->tipo = 0;
		return $this->statisticheeconomiche($request);
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
			$tra->ente = DB::table('corporations')
				->where('id', $tra->A)
				->first()->nomeazienda;
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
			if ($user->id === 0 || $user->dipartimento === "AMMINISTRAZIONE") {
            	$elenco_tranche[] = $tra;
        	} else if($user->id == $tra->user_id) {
				$elenco_tranche[] = $tra;	
			}
		}
		return $elenco_tranche;
	}
	
	public function getjsontuttetranche(Request $request)
	{
		$tranche = DB::table('tranche')->get();
		foreach($tranche as $tr) {
			if($tr->is_deleted == 0)
				$tranche_return[] = $tr;	
		}
		$tranche_return = $this->aggiungiNomeQuadro($tranche_return, $request->user());
		return json_encode($tranche_return);
	}
	
	public function elencotranche(Request $request)
	{
		if ($request->user()->id === 0 || $request->user()->dipartimento === "AMMINISTRAZIONE")
			return view('pagamenti.elencotranche');
		else
			return redirect('/unauthorized');
	}
	
	public function modificadisposizione(Request $request, Accounting $accounting)
	{
		$this->authorize('modify', $accounting);
       
		$validator = Validator::make($request->all(), [
            'nomeprogetto' => 'required|max:50',
        ]);
        
        
        if($validator->fails()) {
            return Redirect::back()
                ->withInput()
                ->with('error_code', 6)
                ->withErrors($validator);
        }
		
        DB::table('accountings')
			->where('id', $accounting->id)
			->update(array(
				'nomeprogetto' => $request->nomeprogetto,
				'id_progetto' => $request->idprogetto,
        	));
		
		return Redirect::back()
                        ->with('error_code', 5)
                        ->with('msg', '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4>Disposizione per progetto modificata correttamente!</h4></div>');
	}
	
	public function aggiornacorpofattura(Request $request)
	{
		// Controllo lo sconto e lo sconto bonus
			$scontoagente = $request->scontoagente;
			$scontobonus = $request->scontobonus;
			$scontibonus = [];
			// Seleziono l'ente relativo alla utenza in uso
			$ente = DB::table('corporations')
						->where('id', $request->user()->id_ente)
						->first();
	
			$elenco = DB::table('corporationtypes')
						->where('id_ente', $ente->id)
						->get();
			// Variabile per contenere gli sconto assegnati a quell'ente
			$sconti = [];
			// Per tutti i tipi assegnati a quell'ente
			for($i = 0; $i < count($elenco); $i++) {
				$sc = DB::table('entisconti')
							->where('id_sconto', $elenco[$i]->id_tipo)
							->first();
				if($sc)
				$sconto = DB::table('sconti')
							->where('id', $sc->id_sconto)
							->first();
				if(isset($sconto))
				$sconti[] = $sconto->sconto;
			}
			$max = 0;
			for($i = 0; $i < count($sconti); $i++) {
				if($max < $sconti[$i])
					$max = $sconti[$i];
			}
			$scontoagente_max = $max;
			// Sconto bonus
			$elenco = DB::table('entiscontibonus')
						->where('id_tipo', $request->user()->id)
						->get();
			$sconti = [];
			for($i = 0; $i < count($elenco); $i++) {
				$sconto = DB::table('scontibonus')
							->where('id', $elenco[$i]->id_sconto)
							->first();
				if($sconto)
				$scontibonus[] = $sconto->sconto;
			}
			$max = 0;
			for($i = 0; $i < count($scontibonus); $i++) {
				if($max < $scontibonus[$i])
					$max = $scontibonus[$i];
			}
			$scontobonus_max = $max;
			foreach($scontoagente as $sc) {
				if($sc > $scontoagente_max) {
					return Redirect::back()
						->withInput()
                        ->with('msg', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4>Non ti è permesso imporre uno sconto agente maggiore a ' . $scontoagente_max . '</h4></div>');
				}
			}
		

			foreach($scontobonus as $sc) {
				if($sc > $scontobonus_max) {
							return Redirect::back()
								->withInput()
		                        ->with('msg', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4>Non ti è permesso imporre uno sconto bonus maggiore a ' . $scontobonus_max . '</h4></div>');	
				}
			}


		

		DB::table('corpofattura')
      ->where('id_tranche', $request->id)
      ->delete();

          $ord = $request->ord;
		  $ordine = $request->ordine_numerico;
          $qt = $request->qt;
          $desc = $request->desc;
          $sub = $request->sub;
          $scontoagente = $request->scontoagente;
          $scontobonus = $request->scontobonus;
          $netto = $request->netto;
          $iva = $request->iva;

          for($i = 0; $i < count($netto); $i++) {
            DB::table('corpofattura')->insert([
            	'id_tranche' => $request->id,
              'ordine' => $ord[$i],
							'descrizione' => $desc[$i],
							'qta' => $qt[$i],
							'subtotale' => $sub[$i],
							'scontoagente' => $scontoagente[$i],
							'scontobonus' => $scontobonus[$i],
							'netto' => $netto[$i],
							'percentualeiva' => $iva[$i],
							'ordine_numerico' => $ordine[$i]
            ]);
          }
		
		return Redirect::back()
                        ->with('error_code', 5)
                        ->with('msg', '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4>Corpo fattura modificato correttamente!</h4></div>');
	}
	
	/**
	 * Elimina un 'pezzo' del corpo di una fattura di una tranche
	 */
	public function eliminacorpofattura(Request $request)
	{
		DB::table('corpofattura')
			->where('id', $request->id)
			->delete();
		
		return Redirect::back()
                        ->with('error_code', 5)
                        ->with('msg', '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4>Corpo fattura eliminato correttamente!</h4></div>');
	}
	
	/**
	 * Mostra il corpo fattura (precedentemente inserito)
	 * di una tranche ($request->id)
	 */
	public function vedicorpofattura(Request $request)
	{
		return view('pagamenti.corpofattura', [
    		'tranche' => $request->id,
    		'corpofattura' => DB::table('corpofattura')
    					->where('id_tranche', $request->id)
    					->orderBy('ordine_numerico', 'asc')
    					->get()
    	]);
	}
	
	/**
	 * Aggiorna una tranche
	 */
	public function aggiornatranche(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'datainserimento' => 'required',
			'datascadenza' => 'required',
			'percentuale' => 'required',
			'dettagli' => 'max:1000',
			'DA' => 'max:1000',
			'A' => 'max:1000',
			'idfattura' => 'max:30',
			'indirizzospedizione' => 'max:1000',
			'base' => 'max:100',
			'modalita' => 'max:100',
			'iban' => 'max:100',
        ]);
        
        
        if($validator->fails()) {
            return Redirect::back()
                ->withInput()
                ->with('error_code', 6)
                ->withErrors($validator);
        }
		
		// Controllo lo sconto e lo sconto bonus
		if(isset($request->ordine)) {
			$scontoagente = $request->scontoagente;
			$scontobonus = $request->scontobonus;
			$scontibonus = [];
			// Seleziono l'ente relativo alla utenza in uso
			$ente = DB::table('corporations')
						->where('id', $request->user()->id_ente)
						->first();
	
			$elenco = DB::table('corporationtypes')
						->where('id_ente', $ente->id)
						->get();
			// Variabile per contenere gli sconto assegnati a quell'ente
			$sconti = [];
			// Per tutti i tipi assegnati a quell'ente
			for($i = 0; $i < count($elenco); $i++) {
				$sc = DB::table('entisconti')
							->where('id_sconto', $elenco[$i]->id_tipo)
							->first();
				if($sc)
				$sconto = DB::table('sconti')
							->where('id', $sc->id_sconto)
							->first();
				if(isset($sconto))
				$sconti[] = $sconto->sconto;
			}
			$max = 0;
			for($i = 0; $i < count($sconti); $i++) {
				if($max < $sconti[$i])
					$max = $sconti[$i];
			}
			$scontoagente_max = $max;
			// Sconto bonus
			$elenco = DB::table('entiscontibonus')
						->where('id_tipo', $request->user()->id)
						->get();
			$sconti = [];
			for($i = 0; $i < count($elenco); $i++) {
				$sconto = DB::table('scontibonus')
							->where('id', $elenco[$i]->id_sconto)
							->first();
				if($sconto)
				$scontibonus[] = $sconto->sconto;
			}
			$max = 0;
			for($i = 0; $i < count($scontibonus); $i++) {
				if($max < $scontibonus[$i])
					$max = $scontibonus[$i];
			}
			$scontobonus_max = $max;
			for($i = 0; $i < count($scontoagente); $i++) {
				if($scontoagente[$i] > $scontoagente_max) {
					return Redirect::back()
						->withInput()
                        ->with('msg', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4>Non ti è permesso imporre uno sconto agente maggiore a ' . $scontoagente_max . '</h4></div>');
				} else if($scontobonus[$i] > $scontobonus_max) {
					return Redirect::back()
						->withInput()
                        ->with('msg', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4>Non ti è permesso imporre uno sconto bonus maggiore a ' . $scontobonus_max . '</h4></div>');	
				}
			}
		}
		
		$iddisposizione = DB::table('tranche')
							->where('id', $request->id)
							->first();
		
		if($request->tipofattura == 0) {
			$tipofattura = "FATTURA DI VENDITA";	
		} else {
			$tipofattura = "NOTA DI CREDITO";	
		}
		
		$tranche = DB::table('tranche')
					->where('id', $request->id)
					->first();
		
		DB::table('notifiche')
			->where('id', $tranche->id_notifica)
			->delete();
		
		DB::table('tranche')
			->where('id', $request->id)
			->update(array(
            	'user_id' => $request->user()->id,
				'tipo' => $request->tipo,
				'datainserimento' => $request->datainserimento,
				'datascadenza' => $request->datascadenza,
				'percentuale' => $request->percentuale,
				'dettagli' => $request->dettagli,
				'frequenza' => $request->frequenza,
				'DA' => $request->DA,
				'A' => $request->A,
				'idfattura' => $request->idfattura,
				'emissione' => $request->emissione,
				'indirizzospedizione' => $request->indirizzospedizione,
				'testoimporto' => $request->importo_nopercentuale,
				'id_notifica' => 0,
				'privato' => $request->privato,
				'base' => $request->base,
				'modalita' => $request->modalita,
				'tipofattura' => $tipofattura,
				'iban' => $request->iban,
				'peso' => $request->peso,
				'netto' => $request->netto,
				'scontoaggiuntivo' => $request->scontoaggiuntivo,
				'imponibile' => $request->imponibile,
				'prezzoiva' => $request->prezzoiva,
				'percentualeiva' => $request->percentualeiva,
				'dapagare' => $request->dapagare,
        ));
		
		if($request->statoemotivo!=null) {
			// Aggiorno lo stato emotivo
			$tipo = DB::table('statiemotivipagamenti')
				->where('name', $request->statoemotivo)
				->first();
			DB::table('statipagamenti')
				->where('id_pagamento', $request->id)
				->delete();
			DB::table('statipagamenti')
				->insert([
					'id_tipo' => $tipo->id,
					'id_pagamento' => $request->id
				]);
		}
		
		// Aggiorno il corpo fattura
		if(isset($request->ordine)) {
			$ordine = $request->ordine;
			$descrizione = $request->desc;
			$qt = $request->qt;
			$subtotale = $request->subtotale;
			$scontoagente = $request->scontoagente;
			$prezzonetto = $request->prezzonetto;
			$iva = $request->iva;
			for($i = 0; $i < count($ordine); $i++) {
				DB::table('corpofattura')->insert([
					'id_tranche' => $request->id,
					'ordine' => $ordine[$i],
					'descrizione' => $descrizione[$i],
					'qta' => $qt[$i],
					'subtotale' => $subtotale[$i],
					'scontoagente' => $scontoagente[$i],
					'netto' => $prezzonetto[$i],
					'percentualeiva' => $iva[$i],
				]);
			}
		}
					  
		return redirect('/pagamenti/mostra/accounting/' . $iddisposizione->id_disposizione)
                        ->with('msg', '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4>Disposizione modificata correttamente!</h4></div>');
	}
	
	/**
	 * Mostro Modifica una tranche (pagina modificatranche)
	 */
	public function modificatranche(Request $request)
	{
		$tranche = DB::table('tranche')
					->where('id', $request->id)
					->first();
		return view('pagamenti.modificatranche', [
			'tranche' => $tranche,
			'utenti' => DB::table('users')
							->get(),
			'enti' => DB::table('corporations')
							->orderBy('id', 'asc')
							->get(),
			'statiemotivi' => DB::table('statiemotivipagamenti')
				->get(),
			'statoemotivoselezionato' => DB::table('statipagamenti')
				->where('id_pagamento', $tranche->id)
				->first(),
		]);
	}
	
	/**
	 * Duplico una tranche (pagina mostra)
	 */
	public function duplicatranche(Request $request)
	{
		$tranche = DB::table('tranche')
					->where('id', $request->id)
					->first();
					
		$id = DB::table('tranche')->insertGetId([
            'user_id' => $request->user()->id,
            'id_disposizione' => $tranche->id_disposizione,
			'tipo' => $tranche->tipo,
			'datainserimento' => $tranche->datainserimento,
			'datascadenza' => $tranche->datascadenza,
			'percentuale' => $tranche->percentuale,
			'dettagli' => $tranche->dettagli,
			'frequenza' => $tranche->frequenza,
			'DA' => $tranche->DA,
			'A' => $tranche->A,
			'idfattura' => $tranche->idfattura,
			'emissione' => $tranche->emissione,
			'indirizzospedizione' => $tranche->indirizzospedizione,
			'privato' => $tranche->privato,
			'base' => $tranche->base,
			'modalita' => $tranche->modalita,
			'iban' => $tranche->iban,
			'peso' => $tranche->peso,
			'netto' => $tranche->netto,
			'scontoaggiuntivo' => $tranche->scontoaggiuntivo,
			'imponibile' => $tranche->imponibile,
			'prezzoiva' => $tranche->prezzoiva,
			'percentualeiva' => $tranche->percentualeiva,
			'dapagare' => $tranche->dapagare,
        ]);
		
		$items = DB::table('corpofattura')
            ->where('id_tranche', $request->id)
            ->get();

        foreach($items as $item) {
            DB::table('corpofattura')->insert([
				'id_tranche' => $id,
				'ordine' => $item->ordine,
				'descrizione' => $item->descrizione,
				'qta' => $item->qta,
				'subtotale' => $item->subtotale,
				'scontoagente' => $item->scontoagente,
				'scontobonus' => $item->scontobonus,
				'netto' => $item->netto,
				'percentualeiva' => $item->percentualeiva
			]);
        }

		//return Redirect::back()
           //             ->with('error_code', 5)
            //            ->with('msg', '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4>Disposizione duplicata correttamente!</h4></div>');
	}
	
	/**
	 * Elimino una tranche (pagina mostra)
	 */
	public function eliminatranche(Request $request)
	{
        DB::table('tranche')
			->where('id', $request->id)
			->update(array(
				'is_deleted' => 1	
		));
		
		return Redirect::back()
                        ->with('error_code', 5)
                        ->with('msg', '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4>Disposizione eliminata correttamente!</h4></div>');
	}
	
	/**
	 * Duplico una disposizione (pagina main)
	 */
	public function duplicadisposizione(Request $request, Accounting $accounting)
	{
		$this->authorize('duplicate', $accounting);
        
        DB::table('accountings')->insert([
            'user_id' => $request->user()->id,
            'nomeprogetto' => $accounting->nomeprogetto,
			'id_progetto' => $accounting->idprogetto,
        ]);
		
		return Redirect::back()
                        ->with('error_code', 5)
                        ->with('msg', '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4>Disposizione per progetto duplicato correttamente!</h4></div>');
	}
	
	/**
	 * Salvo una tranche di una relativa fattura nel DB
	 */
	public function salvatranche(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'datainserimento' => 'required',
			'datascadenza' => 'required',
			'percentuale' => 'required',
			'dettagli' => 'max:1000',
			'DA' => 'max:1000',
			'A' => 'max:1000',
			'idfattura' => 'max:30',
			'indirizzospedizione' => 'max:1000',
			'base' => 'max:100',
			'modalita' => 'max:100',
			'iban' => 'max:100',
        ]);
        
        if($validator->fails()) {
            return Redirect::back()
                ->withInput()
                ->with('error_code', 6)
                ->withErrors($validator);
        }
		
		// Controllo lo sconto e lo sconto bonus
		if(isset($request->ordine)) {
			$scontoagente = $request->scontoagente;
			$scontobonus = $request->scontobonus;
			$scontibonus = [];
			// Seleziono l'ente relativo alla utenza in uso
			$ente = DB::table('corporations')
						->where('id', $request->user()->id_ente)
						->first();
	
			$elenco = DB::table('corporationtypes')
						->where('id_ente', $ente->id)
						->get();
			// Variabile per contenere gli sconto assegnati a quell'ente
			$sconti = [];
			// Per tutti i tipi assegnati a quell'ente
			for($i = 0; $i < count($elenco); $i++) {
				$sc = DB::table('entisconti')
							->where('id_sconto', $elenco[$i]->id_tipo)
							->first();
				if($sc)
				$sconto = DB::table('sconti')
							->where('id', $sc->id_sconto)
							->first();
				if(isset($sconto))		
				$sconti[] = $sconto->sconto;
			}
			$max = 0;
			for($i = 0; $i < count($sconti); $i++) {
				if($max < $sconti[$i])
					$max = $sconti[$i];
			}
			$scontoagente_max = $max;
			// Sconto bonus
			$elenco = DB::table('entiscontibonus')
						->where('id_tipo', $request->user()->id)
						->get();
			$sconti = [];
			for($i = 0; $i < count($elenco); $i++) {
				$sconto = DB::table('scontibonus')
							->where('id', $elenco[$i]->id_sconto)
							->first();
				if($sconto)
				$scontibonus[] = $sconto->sconto;
			}
			$max = 0;
			for($i = 0; $i < count($scontibonus); $i++) {
				if($max < $scontibonus[$i])
					$max = $scontibonus[$i];
			}
			$scontobonus_max = $max;
			for($i = 0; $i < count($scontoagente); $i++) {
				if($scontoagente[$i] > $scontoagente_max) {
					return Redirect::back()
						->withInput()
                        ->with('msg', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4>Non ti è permesso imporre uno sconto agente maggiore a ' . $scontoagente_max . '</h4></div>');
				} else if($scontobonus[$i] > $scontobonus_max) {
					return Redirect::back()
						->withInput()
                        ->with('msg', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4>Non ti è permesso imporre uno sconto bonus maggiore a ' . $scontobonus_max . '</h4></div>');	
				}
			}
		}
					  
		if($request->tipofattura == 0) {
			$tipofattura = "FATTURA DI VENDITA";	
		} else {
			$tipofattura = "NOTA DI CREDITO";	
		}
		
		$tranche = DB::table('tranche')->insertGetId([
                        'user_id' => $request->user()->id,
                        'id_disposizione' => $request->id_disposizione,
						'tipo' => $request->tipo,
						'datainserimento' => $request->datainserimento,
						'datascadenza' => $request->datascadenza,
						'percentuale' => $request->percentuale,
						'dettagli' => $request->dettagli,
						'frequenza' => $request->frequenza,
						'DA' => $request->DA,
						'A' => $request->A,
						'idfattura' => $request->idfattura,
						'emissione' => $request->emissione,
						'indirizzospedizione' => $request->indirizzospedizione,
						'privato' => $request->privato,
						'testoimporto' => $request->importo_nopercentuale,
						'base' => $request->base,
						'modalita' => $request->modalita,
						'tipofattura' => $tipofattura,
						'iban' => $request->iban,
						'peso' => $request->peso,
						'netto' => $request->netto,
						'scontoaggiuntivo' => $request->scontoaggiuntivo,
						'imponibile' => $request->imponibile,
						'prezzoiva' => $request->prezzoiva,
						'percentualeiva' => $request->percentualeiva,
						'dapagare' => $request->dapagare,
                      ]);
					  
		if($request->statoemotivo!=null) {
			// Memorizzo lo stato emotivo
			$tipo = DB::table('statiemotivipagamenti')
				->where('name', $request->statoemotivo)
				->first();
			DB::table('statipagamenti')->insert([
				'id_pagamento' => $tranche,
				'id_tipo' => $tipo->id,
			]);
		}
		
		// Salvo il corpo fattura
		if(isset($request->ordine)) {
			$ordine = $request->ordine;
			$descrizione = $request->desc;
			$qt = $request->qt;
			$subtotale = $request->subtotale;
			$scontoagente = $request->scontoagente;
			$scontobonus = $request->scontobonus;
			$prezzonetto = $request->prezzonetto;
			$iva = $request->iva;
			for($i = 0; $i < count($ordine); $i++) {
				DB::table('corpofattura')->insert([
					'id_tranche' => $tranche,
					'ordine' => $ordine[$i],
					'descrizione' => $descrizione[$i],
					'qta' => $qt[$i],
					'subtotale' => $subtotale[$i],
					'scontoagente' => $scontoagente[$i],
					'scontobonus' => $scontobonus[$i],
					'netto' => $prezzonetto[$i],
					'percentualeiva' => $iva[$i],
				]);
			}
		}
					  
		return redirect('/pagamenti/mostra/accounting/' . $request->id_disposizione)
                        ->with('error_code', 5)
                        ->with('msg', '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4>Disposizione aggiunta correttamente!</h4></div>');
	}
	
	/**
	 * Compila il campo tipo di una tranche
	 */
	public function compilaTranche(&$tranche)
	{
		foreach($tranche as $tra) {
			if($tra->tipo == 1) {
				$tra->tipo = "Rinnovo";
			} else {
				$tra->tipo = "Pagamento";
			}
			$tra->ente = DB::table('corporations')
				->where('id', $tra->A)
				->first()->nomeazienda;
			// Compilo lo stato emotivo
			$stato = DB::table('statipagamenti')
						->where('id_pagamento', $tra->id)
						->first();
			if($stato) {
				$statoemotivo = DB::table('statiemotivipagamenti')
								->where('id', $stato->id_tipo)
								->first();
						
				$tra->statoemotivo = $statoemotivo->name;
			}
		}
	}
	
	/**
	 * Restituisce in json le tranche di una relativa fattura
	 */
	public function getjsontranche(Request $request)
	{
		$tranche = DB::table('tranche')
			->where('id_disposizione', $request->id)
			->get();
			
		foreach($tranche as $tr) {
			if($tr->is_deleted == 0)
				$tranche_return[] = $tr;	
		}
		$this->compilaTranche($tranche_return);
		return json_encode($tranche_return);
	}
	
	/**
	 * Mostra l'elenco delle tranche di una relativa fattura
	 */
	public function mostradisposizione(Request $request, Accounting $accounting)
	{

		$this->authorize('mostra', $accounting);

		return view('pagamenti.mostra', [
			'idfattura' => $accounting->id
		]);
	}
	
	/**
	 * Elimina una disposizione di progetto
	 */
	public function destroydisposizione(Request $request, Accounting $accounting)
	{
		$this->authorize('destroy', $accounting);
		
		DB::table('tranche')
			->where('id_disposizione', $accounting->id)
			->delete();
		
		$accounting->delete();
		
		return Redirect::back()
                        ->with('error_code', 5)
                        ->with('msg', '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4>Quadro disposizione eliminato correttamente!</h4></div>');
	}
	
	/**
	 * @param Elenco di pagamenti
	 * @return function
	 * @desc Dato un vettore di pagamenti, completare
	 *       i campi necessari alla stampa in tabella
	 */ 
	public function compila(&$pagamenti)
	{
		foreach($pagamenti as $pagamento) {
			$progetto = DB::table('projects')
				->get();
			foreach($progetto as $prog) {
				if($prog->id == $pagamento->id_progetto) {
					$pagamento->id_progetto = $prog->nomeprogetto;
					if($prog->id_ente != null)
						$pagamento->ente = DB::table('corporations')
							->where('id', $prog->id_ente)
							->first()->nomeazienda;
					break;
				}	
			}
		}
	}
	
	/**
	 * Quando ricevo una richiesta ajax get,
	 * restituisco tutti i pagamenti in json
	 */
	public function getjson(Request $request)
	{
		$pagamenti = $this->pagamenti->forUser($request->user());
		$this->compila($pagamenti);
		return json_encode($pagamenti);
	}
	
	/**
	 * Salvo una nuova disposizione nel
	 * DB accountings
	 */
	public function creadisposizione(Request $request)
	{
		$validator = Validator::make($request->all(), [
            'nomeprogetto' => 'required|max:50',
        ]);
        
        
        if($validator->fails()) {
            return Redirect::back()
                ->withInput()
                ->with('error_code', 6)
                ->withErrors($validator);
        }
		
		$progetto = DB::table('accountings')->insertGetId([
                        'user_id' => $request->user()->id,
                        'nomeprogetto' => $request->nomeprogetto,
						'id_progetto' => $request->idprogetto,
                      ]);
					  
		return Redirect::back()
                        ->with('error_code', 5)
                        ->with('msg', '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4>Quadro disposizioni aggiunto correttamente!</h4></div>');
	}
	
	/**
	 * Richiesta per l'elenco di tutti i pagamenti
	 */
	public function index(Request $request)
	{

		if ($request->user()->id === 0 || $request->user()->dipartimento !== "TECNICO") {
		
            return view('pagamenti.main', [
				'progetti' => $this->progetti->forUser2($request->user()),
				'dipartimenti' => DB::table('departments')->get(),
				'quadri' => DB::table('accountings')->get()
			]);
        } else {
        	
			return view('errors.403');
		}
	}
	
	/**
	 * Mostra la pagina per aggiungere una tranche 
	 * di pagamento
	 */
	public function aggiungi(Request $request)
    {
		if ($request->user()->id === 0 || $request->user()->dipartimento !== "TECNICO") {
			 
			 $disposizione = DB::table('accountings')
			 				->where('id', $request->id)
							->first();
			 $progetto = DB::table('projects')
			 				->where('id', $disposizione->id_progetto)
							->first();
			 $preventivo = DB::table('quotes')
			 				->where('id', $progetto->id_preventivo)
							->first();
			 if($preventivo) {
				 $corpofattura = DB::table('optional_preventivi')
									->where('id_preventivo', $preventivo->id)
									->get();
				$ordine = $preventivo->id;
				$anno = $preventivo->anno;
				$prev = DB::table('quotes')->where('id', $preventivo->id)->first();
				$sconto = $prev->scontoagente;
				$scontobonus = $prev->scontobonus;
			 } else {
			 	$ordine = null;
				$anno = null;
				$corpofattura = null;
				$sconto = null;
				$scontobonus = null;
			 }
             return view('pagamenti.aggiungitranche', [
				'utenti' => DB::table('users')
							->get(),
				'enti' => DB::table('corporations')
							->orderBy('id', 'asc')
							->get(),
				'idfattura' => $request->id,
				'statiemotivi' => DB::table('statiemotivipagamenti')
									->get(),
				'preventiviconfermati' => DB::table('quotes')
            					->where('legameprogetto', 1)
								->having('usato', '=', 0)
            					->get(),
				'corpofattura' => $corpofattura,
				'ordine' => $ordine,
				'anno' => $anno,
				'sconto' => $sconto,
				'scontobonus' => $scontobonus
        	]);
        } else {
			return view('errors.403');
		}
    }
	
	/**
	 * Siamo nell'elenco delle tranche di un progetto,
	 * e abbiamo cliccato su aggiungi tranche
	 */
    public function aggiungitranche(Request $request)
    {
        return $this->aggiungi($request);
    }
    
	/**
	 * dato che fpdf non è ancora in grado di gestire la stampa correttamente,
	 * questo semplice metodo permette la stampa di testo sia sinsola linea che multi linea
	 * 
	 * @param $pdf => Istanza di FPDF
	 *		  $x   => Ascissa di partenza
	 *		  $y   => Ordinata di partenza
	 *		  $testo => testo da stampare
	 *		  $larghezza => larghezza del campo di testo
	 *		  $allineamento => ( L => allineamento a sinistra
	 *		  					 C => // centrale
	 *							 R => // destra
	 * 						   )
	 *		  $spessore => spessore del campo, per calcolare l'ordinata
	 *		               del prossimo campo
	 */
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
		if ($user->id === 0 || $user->dipartimento === "AMMINISTRAZIONE") {
            return true;
    	}
    	return $accounting->user_id === $user->id;
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
							->orderBy('ordine_numerico', 'asc')
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
}
