<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\QuoteRepository;
use App\Repositories\CorporationRepository;
use Validator;
use Redirect;
use App\Quote;
use DB;
use Storage;

use App\PDF\QuotationPDF;
use App\PDF\QuotationPDFNoPrezzi;

class QuoteController extends Controller {

    protected $quotes;
    protected $corporations;
     protected $modulo;

    public function __construct(QuoteRepository $quotes, CorporationRepository $corporations) {
        $this->middleware('auth');

		$this->quotes = $quotes;
		
		$this->corporations = $corporations;
        $this->modulo = 3; //modulo is 2 for preventivi
	}
	
	public function filepreventivo(Request $request) {
		return view('preventivi.files', [
			'files' => DB::table('progetti_files')
				->where([
					'id_preventivo' => $request->id,
					'dipartimento' => $request->user()->dipartimento
				])
				->get(),
			'oggetto' => DB::table('quotes')
				->where('id', $request->id)
				->first()->oggetto
		]);
	}
	
	public function completaCodice(&$preventivi)
	{
		$statiemotivi = DB::table('statiemotivipreventivi')->get();
		foreach($preventivi as $prev) {
			$id = $prev->id;
			$prev->id = ':' . $prev->id . '/' . $prev->anno;
			$prev->ente = DB::table('corporations')
				->where('id', $prev->idente)
				->first()->nomeazienda;
			switch($prev->dipartimento) {
				case 1:
					$prev->dipartimento = "LANGA WEB";
					break;
				case 2:
					$prev->dipartimento = "LANGA PRINT";
					break;
				case 3:
					$prev->dipartimento = "LANGA VIDEO";
					break;
				default:
					$prev->dipartimento = "FOO99";
					break;
			}
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
	/* File uploader : paras */
	public function fileupload(Request $request){
			/*$validator = Validator::make($request->all(), [
                        'code' => 'required',
						'file'=>'mimes:jpeg,jpg,png|max:1000',	
            ]);
            if ($validator->fails()) {
                return Redirect::back()
                                ->withInput()
                                ->withErrors($validator);
            }*/			
			Storage::put(
					'images/quote/' . $request->file('file')->getClientOriginalName(), file_get_contents($request->file('file')->getRealPath())
			);
			$nome = $request->file('file')->getClientOriginalName();			
				DB::table('citazione_file')->insert([
				'name' => $nome,
				'code' => $request->code,
			]);					
	}
	
		public function fileget(Request $request){
			/*$validator = Validator::make($request->all(), [
                        'code' => 'required',			
            ]);
            if ($validator->fails()) {
			    return Redirect::back()
                                ->withInput()
                                ->withErrors($validator);
            }*/
			if(isset($request->quote_id)){
				$updateData = DB::table('citazione_file')->where('quote_id', $request->quote_id)->get();										
			}
			else {
				$updateData = DB::table('citazione_file')->where('code', $request->code)->get();				
			}
						
			foreach($updateData as $prev) {
				$imagPath = url('/storage/app/images/quote/'.$prev->name);
				$html = '<tr class="quoteFile_'.$prev->id.'"><td><img src="'.$imagPath.'" height="100" width="100"><a class="btn btn-danger pull-right" style="text-decoration: none; color:#fff" onclick="deleteQuoteFile('.$prev->id.')"><i class="fa fa-eraser"></i></a></td></tr>';
				$html .='<tr class="quoteFile_'.$prev->id.'"><td>';
				$utente_file = DB::table('ruolo_utente')->select('*')->get();							
				foreach($utente_file as $key => $val){
					$html .=' <input type="radio" name="rdUtente_'.$prev->id.'" id="rdUtente_'.$val->ruolo_id.'" onchange="updateType('.$val->ruolo_id.','.$prev->id.');"  value="'.$val->ruolo_id.'" /> '.$val->nome_ruolo;
				}
				echo $html .='</td></tr>';
			}
			exit;			
		}
		
	public function filedelete(Request $request){
		/*$validator = Validator::make($request->all(), ['code' => 'required']);
		if ($validator->fails()) {
			return Redirect::back()
							->withInput()
							->withErrors($validator);
		}*/
	    $response = DB::table('citazione_file')->where('id', $request->id)->delete();
		if($response){
			echo 'success';
		}
		else {
			echo 'fail';
		}
		exit;
	}
	public function filetypeupdate(Request $request){
		/*$validator = Validator::make($request->all(), ['code' => 'required']);
		if ($validator->fails()) {
			return Redirect::back()
							->withInput()
							->withErrors($validator);
							
		}*/
	 	$response = DB::table('citazione_file')
			->where('id', $request->id)
			->update(array('type' => $request->typeid));	    
		if($response){
			echo 'success';
		}
		else {
			echo 'fail';
		}
		exit;
	}
	

	public function getJsonMiei(Request $request)
	{
		if($request->user()->id == 0) {

			// $preventivi = DB::table('quotes')
			// 	->where('is_deleted', 0)
			// 	->get();

			$preventivi = DB::table('quotes')
				->join('users', 'quotes.user_id', '=', 'users.id')
				->select(DB::raw('quotes.*, users.id as uid, users.is_delete'))
				->where('is_deleted', 0)
				->where('users.is_delete', '=', 0)
				->get();		

			$this->completaCodice($preventivi);
			return json_encode($preventivi);
		}
		
//        $preventivi = DB::table('quotes')
//                ->where('is_deleted', 0)
//                ->get();
         $id = $request->user()->id;
        $to_return = DB::table('users')
        ->select(DB::raw('quotes.*'))                                
        ->join('enti_partecipanti', 'enti_partecipanti.id_user', '=', 'users.id')
        ->join('quotes', 'quotes.idente', '=', 'enti_partecipanti.id_ente')
        ->where('users.id',$id)
        ->where('quotes.is_deleted',0)                
        ->where('users.is_delete', '=', 0)     
        ->get();
//   
//        foreach ($preventivi as $prev) {
//            if ($prev->user_id == $id ||
//                    $prev->idutente == $id)
//                $to_return[] = $prev;
//        }
			
		$this->completaCodice($to_return);
		return json_encode($to_return);
	}
	
	public function getjson(Request $request)
	{
		// $preventivi = DB::table('quotes')
		// 	->where('is_deleted', 0)
		// 	->get();

		$preventivi = DB::table('quotes')
			->join('users', 'quotes.user_id', '=', 'users.id')
			->select(DB::raw('quotes.*, users.id as uid, users.is_delete'))
			->where('is_deleted', 0)
			->where('users.is_delete', '=', 0)
			->get();

		$this->completaCodice($preventivi);
		return json_encode($preventivi);
	}
	
	// Calls the show method
	public function index(Request $request)
	{
		return $this->show($request);
	}
	
    public function miei(Request $request) {
        if (!$this->checkReadPermission($request,$this->modulo)) {
           return response()->view('errors.403');
        }
        return view('preventivi.main', [
            'miei' => 1
        ]);
    }
	
	// Render the preventivi views
    public function show(Request $request) {
         if (!$this->checkReadPermission($request,$this->modulo)) {
            return response()->view('errors.403');
        }
        return view('preventivi.main');
    }
	
	public function nuovo(Request $request){
        //due to ajax call need to echo error
        if (!$this->checkPermission($request,$this->modulo)) {
            return response()->view('errors.403');
        }        
        return $this->aggiungi($request);
	}
	
	// Mostra la pagina per aggiungere un nuovo preventivo
	public function aggiungi(Request $request)
	{
		return view('preventivi.aggiungi', [
			'utenti' => DB::table('users')
							->select('*')
							->get(),
			'enti' => $this->corporations->forUser2($request->user()),
			'dipartimenti' => DB::table('departments')
								->select('*')
								->get(),
			'optional' => DB::table('optional')
							->select('*')
							->get(),
			'pacchetti' => DB::table('pack')
							->select('*')
							->get(),
			'optional_pack' => DB::table('optional_pack')
								->select('*')
								->get(),
			'statiemotivi' => DB::table('statiemotivipreventivi')->get()
		]);
	}
	
	// Salvo il preventivo nel DB
	public function store(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'data' => 'required',
			'oggetto' => 'required|max:150',
			'dipartimento' => 'required',
			'metodo' => 'required|max:1000',
			'considerazioni' => 'required|max:2000',
			'valenza' => 'required',
			'finelavori' => 'required',
		]);
		
		if($validator->fails()) {
			return Redirect::back()
				->withInput()
				->withErrors($validator);
		}
		
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
		if($scontoagente > $scontoagente_max) {
					return Redirect::back()
						->withInput()
						->with('msg', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4>Non ti è permesso imporre uno sconto agente maggiore a ' . $scontoagente_max . '</h4></div>');
		} else if($scontobonus > $scontobonus_max) {
					return Redirect::back()
						->withInput()
						->with('msg', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4>Non ti è permesso imporre uno sconto bonus maggiore a ' . $scontobonus_max . '</h4></div>');	
		}
		
		$nuovopreventivo = $request->user()->quotes()->create([
			'anno' => date('y'),
			'idutente' => $request->user()->id,
				'idente' => $request->idente,
				'data' => $request->data,
				'oggetto' => $request->oggetto,
				'dipartimento' => $request->dipartimento,
				'noteintestazione' => $request->noteintestazione,
				'metodo' => $request->metodo,
				'considerazioni' => $request->considerazioni,
				'noteimportanti' => $request->noteimportanti,
				'valenza' => $request->valenza,
				'finelavori' => $request->finelavori,
				/*'notetecniche' => $request->notetecniche,*/
				'lineebianche' => $request->lineebianche,
				'id_notifica' => 0,
				'subtotale' => $request->subtotale,
				'scontoagente' => $request->scontoagente,
				'scontobonus' => $request->scontobonus,
				'totale' => $request->totale,
				'totaledapagare'  => $request->totaledapagare,
				'legameprogetto' => $request->legameprogetto
		]);
		
		if($request->statoemotivo!=null) {
			// Memorizzo lo stato emotivo
			$tipo = DB::table('statiemotivipreventivi')
				->where('name', $request->statoemotivo)
				->first();
			DB::table('statipreventivi')->insert([
				'id_preventivo' => $nuovopreventivo,
				'id_tipo' => $tipo->id,
			]);
		}
		
		if(isset($request->filetecnico)) {
			$options = $request->filetecnico;
			for($i = 0; $i < count($options); $i++) {
				$nome = time() . uniqid() . '-' . '-preventivo';
				Storage::put(
					'images/' . $nome,
					file_get_contents($options[$i]->getRealPath())
				);

				DB::table('progetti_files')->insert([
					'id_preventivo' => $nuovopreventivo,
					'nome' => $nome,
					'dipartimento' => "TECNICO"
				]);
			}
		}
		
		if(isset($request->filee)) {
			$optionss = $request->filee;
			for($i = 0; $i < count($optionss); $i++) {
				$nome = time() . uniqid() . '-' . '-scansione_preventivo';
				Storage::put(
					'images/' . $nome,
					file_get_contents($optionss[$i]->getRealPath())
				);

				DB::table('progetti_files')->insert([
					'id_preventivo' => $nuovopreventivo,
					'nome' => $nome,
					'dipartimento' => "AMMINISTRAZIONE"
				]);
			}
		}
		
		// Salvo i pacchetti e gli optional
		if(isset($request->codici)) {
			$codice = $request->codici;
			$oggetto = $request->oggetti;
			$descrizione = $request->desc;
			$qta = $request->qt;
			$prezzounitario = $request->pru;
			$totale = $request->tot;
			$asterisca = $request->ast;
			for($i = 0; $i < count($codice); $i++) {
				if(!isset($asterisca[$i]) || $asterisca[$i] == 0)
					$asterisca[$i] = 0;
				else
					$asterisca[$i] = 1;
				// Salvo l'optional
				DB::table('optional_preventivi')->insert([
					'id_preventivo' => $nuovopreventivo->id,
					'codice' => $codice[$i],
					'oggetto' => $oggetto[$i],
					'descrizione' => $descrizione[$i],
					'qta' => $qta[$i],
					'prezzounitario' => $prezzounitario[$i],
					'totale' => $totale[$i],
					'asterisca' => $asterisca[$i]
				]);
				
				$optional = DB::table('optional_preventivi')
								->select('codice')
								->where('codice', $codice[$i])
								->first();
								
				// Collego l'optional al preventivo
				DB::table('tabellaoptionalpreventivi')->insert([
					'id_opt' => $optional->codice,
					'id_preventivo' => $nuovopreventivo->id
				]);
			}
		}
		/* Update Quote Id in Media files Paras */
			DB::table('citazione_file')
			->where('code', $request->mediaCode)
			->update(array('quote_id' => $nuovopreventivo->id));
		/* Update Quote Id in Media files */
		return redirect('/preventivi/modify/quote/' . $nuovopreventivo->id)
				->with('msg', '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4>Preventivo creato correttamente!</h4></div>');
	}
	
	// Mostro la pagina di modifica di un preventivo
	public function modify(Request $request, Quote $quote){
        if (!$this->checkPermission($request, $this->modulo)) {
            return response()->view('errors.403');
        }
        //$this->authorize('modify', $quote);
		return view('preventivi.modifica', [
			'preventivo' => DB::table('quotes')
								->select('*')
								->where('id', $quote->id)
								->first(),
			'quotefiles' => DB::table('citazione_file')
								->select('*')
								->where('quote_id', $quote->id)
								->get(),															
			'utenti' => DB::table('users')
							->select('*')
							->get(),
			'enti' => $this->corporations->forUser2($request->user()),
			'dipartimenti' => DB::table('departments')
								->select('*')
								->get(),
			'optional' => DB::table('optional')
							->select('*')
							->get(),
			'pacchetti' => DB::table('pack')
							->select('*')
							->get(),
			'optional_pack' => DB::table('optional_pack')
								->select('*')
								->get(),
			'optional_preventivi' => DB::table('optional_preventivi')
					->where('id_preventivo', $quote->id)
					->get(),
			'statiemotivi' => DB::table('statiemotivipreventivi')->get(),
			'statoemotivoselezionato' => DB::table('statipreventivi')
				->where('id_preventivo', $quote->id)
				->first()
		]);
	}
	
    // Salvo le modifiche di un preventivo
    public function modifica(Request $request, Quote $quote) {
        if (!$this->checkPermission($request, $this->modulo)) {
            return response()->view('errors.403');
        }
        //$this->authorize('modify', $quote);
		$validator = Validator::make($request->all(), [
			'data' => 'required',
			'oggetto' => 'required|max:150',
			'dipartimento' => 'required',
			/*'metodo' => 'required|max:1000',*/
			'considerazioni' => 'required|max:2000',
			'valenza' => 'required',
			'finelavori' => 'required',
		]);
		
		if($validator->fails()) {
			return Redirect::back()
				->withInput()
				->withErrors($validator);
		}
		
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
				if($sc) {
				$sconto = DB::table('sconti')
							->where('id', $sc->id_sconto)
							->first();
				}
				
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
		if($scontoagente > $scontoagente_max) {
					return Redirect::back()
						->withInput()
						->with('msg', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4>Non ti è permesso imporre uno sconto agente maggiore a ' . $scontoagente_max . '</h4></div>');
		} else if($scontobonus > $scontobonus_max) {
					return Redirect::back()
						->withInput()
						->with('msg', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4>Non ti è permesso imporre uno sconto bonus maggiore a ' . $scontobonus_max . '</h4></div>');	
		}
		
		DB::table('notifiche')
			->where('id', $quote->id_notifica)
			->delete();
		
		DB::table('quotes')
			->where('id', $quote->id)
			->update(array(
				'idutente' => $request->idutente,
				'idente' => $request->idente,
				'data' => $request->data,
				'oggetto' => $request->oggetto,
				'dipartimento' => $request->dipartimento,
				'noteintestazione' => $request->noteintestazione,
				/*'metodo' => $request->metodo,*/
				'considerazioni' => $request->considerazioni,
				'noteimportanti' => $request->noteimportanti,
				'valenza' => $request->valenza,
				'finelavori' => $request->finelavori,
				/*'notetecniche' => $request->notetecniche,*/
				'lineebianche' => $request->lineebianche,
				'id_notifica' => 0,
				'subtotale' => $request->subtotale,
				'scontoagente' => $request->scontoagente,
				'scontobonus' => $request->scontobonus,
				'totale' => $request->totale,
				'totaledapagare'  => $request->totaledapagare,
				'legameprogetto' => $request->legameprogetto
		));
		if($request->statoemotivo!=null) {
			// Aggiorno lo stato emotivo
			$tipo = DB::table('statiemotivipreventivi')
				->where('name', $request->statoemotivo)
				->first();
			DB::table('statipreventivi')
				->where('id_preventivo', $quote->id)
				->delete();
			DB::table('statipreventivi')
				->insert([
					'id_tipo' => $tipo->id,
					'id_preventivo' => $quote->id
				]);
		}
		
		if(isset($request->filetecnico)) {
			$options = $request->filetecnico;
			for($i = 0; $i < count($options); $i++) {
				$nome = time() . uniqid() . '-' . '-preventivo';
				Storage::put(
					'images/' . $nome,
					file_get_contents($options[$i]->getRealPath())
				);

				DB::table('progetti_files')->insert([
					'id_preventivo' => $quote->id,
					'nome' => $nome,
					'dipartimento' => "TECNICO"
				]);
			}
		}
		
		if(isset($request->filee)) {
			$optionss = $request->filee;
			for($i = 0; $i < count($optionss); $i++) {
				$nome = time() . uniqid() . '-' . '-scansione_preventivo';
				Storage::put(
					'images/' . $nome,
					file_get_contents($optionss[$i]->getRealPath())
				);

				DB::table('progetti_files')->insert([
					'id_preventivo' => $quote->id,
					'nome' => $nome,
					'dipartimento' => "AMMINISTRAZIONE"
				]);
			}
		}
		
		
		// Salvo i pacchetti e gli optional
		if(isset($request->codici)) {
			$codice = $request->codici;
			$oggetto = $request->oggetti;
			$descrizione = $request->desc;
			$qta = $request->qt;
			$prezzounitario = $request->pru;
			$totale = $request->tot;
			$ordine = $request->ordine;
			$asterisca = $request->ast;
			for($i = 0; $i < count($codice); $i++) {
				if(!isset($asterisca[$i]) || $asterisca[$i] == 0)
					$asterisca[$i] = 0;
				else
					$asterisca[$i] = 1;
				// Salvo l'optional
				DB::table('optional_preventivi')->insert([
					'id_preventivo' => $quote->id,
					'codice' => $codice[$i],
					'oggetto' => $oggetto[$i],
					'descrizione' => $descrizione[$i],
					'qta' => $qta[$i],
					'prezzounitario' => $prezzounitario[$i],
					'totale' => $totale[$i],
					'ordine' => $ordine[$i],
					'asterisca' => $asterisca[$i]
				]);
				
				$optional = DB::table('optional_preventivi')
								->select('codice')
								->where('codice', $codice[$i])
								->first();
								
				// Collego l'optional al preventivo
				DB::table('tabellaoptionalpreventivi')->insert([
					'id_opt' => $quote->id,
					'id_preventivo' => $quote->id
				]);
			}
		}
		/* Update Quote Id in Media files Paras */
			DB::table('citazione_file')
			->where('code', $request->mediaCode)
			->update(array('quote_id' => $quote->id));
		/* Update Quote Id in Media files */

		
		return Redirect::back()
				->with('msg', '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4>Preventivo modificato correttamente!</h4></div>');
	}
	
	// Elimina un preventivo
	public function elimina(Request $request, Quote $quote){
       //due to ajax call need to echo error
        if (!$this->checkPermission($request,$this->modulo)) {
             echo "error.403";
             exit;
        }
        // Prendo i dati del preventivo
        //$this->authorize('destroy', $quote);
		DB::table('quotes')
			->where('id', $quote->id)
			->update(array(
				'is_deleted' => 1
		));
		
		return Redirect::back()
				->with('msg', '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4>Preventivo eliminato correttamente!</h4></div>');
	}
	
	public function eliminaoptionaldalprev(Request $request, Quote $quote)
	{
		DB::table('optional_preventivi')
			->where('id', $request->id)
			->delete();
			return Redirect::back()
				->with('msg', '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4>Optional eliminato correttamente!</h4></div>');
	}
	
	public function eliminaoptional(Request $request, Quote $quote)
	{
		return view('preventivi.optional', [
			'preventivo' => $quote,
			'optional' => DB::table('optional_preventivi')
							->where('id_preventivo', $quote->id)
							->get(),
		]);
	}
	
	public function aggiornaoptional(Request $request)
	{
		DB::table('optional_preventivi')
			->where('id_preventivo', $request->id)
			->delete();

		  $ordine = $request->ord;
		  $oggetto = $request->oggetti;
		  $descrizione = $request->desc;
		  $qta = $request->qt;
		  $prezzounitario = $request->pru;
		  $totale = $request->tot;
		  $asterisca = $request->ast;
		  for($i = 0; $i < count($ordine); $i++) {
			if(!isset($asterisca[$i]) || $asterisca[$i] == 0)
				$asterisca[$i] = 0;
			else
				$asterisca[$i] = 1;
			// Salvo l'optional
			DB::table('optional_preventivi')->insert([
			  'id_preventivo' => $request->id,
			  'ordine' => $ordine[$i],
			  'oggetto' => $oggetto[$i],
			  'descrizione' => $descrizione[$i],
			  'qta' => $qta[$i],
			  'prezzounitario' => $prezzounitario[$i],
			  'totale' => $totale[$i],
			  'asterisca' => $asterisca[$i]
			]);
		  }
		
		return Redirect::back()
				->with('msg', '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4>Optional modificato correttamente!</h4></div>');
	}
	
	public function duplica(Request $request, Quote $quote){
        //due to ajax call need to echo error
        if (!$this->checkPermission($request,$this->modulo)) {
             echo "error.403";
             exit;
        }
        //$this->authorize('duplicate', $quote);
		$id = $request->user()->quotes()->create([
			'anno' => date('y'),
			'user_id' => $request->user()->id,
			'idente' => $quote->idente,
			'data' => $quote->data,
			'oggetto' => $quote->oggetto,
			'dipartimento' => $quote->dipartimento,
			'noteintestazione' => $quote->noteintestazione,
			'metodo' => $quote->metodo,
			'considerazioni' => $quote->considerazioni,
			'noteimportanti' => $quote->noteimportanti,
			'notetecniche' => $quote->notetecniche,
			'valenza' => $quote->valenza,
			'finelavori' => $quote->finelavori,
			'subtotale' => $quote->subtotale,
			'scontoagente' => $quote->scontoagente,
			'scontobonus' => $quote->scontobonus,
			'totale' => $quote->totale,
			'totaledapagare'  => $quote->totaledapagare,
			'lineebianche' => $quote->lineebianche
		])->id;

		$items = DB::table('optional_preventivi')
			->where('id_preventivo', $quote->id)
			->get();

		foreach($items as $item) {
			DB::table('optional_preventivi')->insert([
					'id_preventivo' => $id,
					'codice' => $item->codice,
					'ordine' => $item->ordine,
					'oggetto' => $item->oggetto,
					'descrizione' => $item->descrizione,
					'qta' => $item->qta,
					'prezzounitario' => $item->prezzounitario,
					'totale' => $item->totale,
					'asterisca' => $item->asterisca
				]);
		}

		return Redirect::back()
				->with('msg', '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4>Preventivo duplicato correttamente!</h4></div>');
	}
	
	// PDF
	
	public function pdfnoprezzi(Request $request, Quote $quote) {
		// Prendo i dati del preventivo
		$this->authorize('visualizzapdf', $quote);
		$preventivo = DB::table('quotes')
						->where('id', $quote->id)
						->first();
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
		$pdf = new QuotationPDFNoPrezzi($preventivo, $ente, $ente_DA);
		$pdf->AddFont('Nexa', '', 'NexaLight.php');
		$pdf->AddFont('Nexa', 'B', 'NexaBold.php');
		//$pdf->writePdf();
	}
	
	public function pdf(Request $request, Quote $quote)
	{
        if (!$this->checkPermission($request,$this->modulo)) {
            return response()->view('errors.403');
        }  
        // Prendo i dati del preventivo
        //$this->authorize('visualizzapdf', $quote);
		$preventivo = DB::table('quotes')
						->where('id', $quote->id)
						->first();
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
						
		$pdf = new QuotationPDF($preventivo, $ente, $ente_DA,$utente);
		$pdf->AddFont('Nexa', '', 'NexaLight.php');
		$pdf->AddFont('Nexa', 'B', 'NexaBold.php');
		//$pdf->writePdf();
	}
}
