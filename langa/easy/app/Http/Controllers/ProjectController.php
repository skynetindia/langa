<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\ProjectRepository;
use DB;
use Validator;
use Redirect;
use Storage;
use App\Http\Requests;
use App\Project;
use Route;
class ProjectController extends Controller
{
    protected $progetti;
    protected $modulo;
     
    public function __construct(ProjectRepository $projects) {
        $this->middleware('auth');

        $this->progetti = $projects;
        $this->modulo = 4;
        
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
			$updateData = DB::table('citazione_file')->where('code', $request->code)->get();						
			foreach($updateData as $prev) {
				$imagPath = url('/storage/app/images/quote/'.$prev->name);
				$html = '<tr class="quoteFile_'.$prev->id.'"><td><img src="'.$imagPath.'" height="100" width="100"><a class="btn btn-danger pull-right" style="text-decoration: none; color:#fff" onclick="deleteQuoteFile('.$prev->id.')"><i class="fa fa-eraser"></i></a></td></tr>';
				$html .='<tr class="quoteFile_'.$prev->id.'"><td>';
				$utente_file = DB::table('ruolo_utente')->select('*')->where('is_delete', '=', 0)->get();							
				foreach($utente_file as $key => $val){
					$html .=' <input type="radio" name="rdUtente" id="rdUtente_'.$val->ruolo_id.'" value="'.$val->ruolo_id.'" /> '.$val->nome_ruolo;
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

    public function index(Request $request)
    {
        return $this->show($request);
    }
    
	public function completaCodice(&$progetti)
	{
		foreach($progetti as $prog) {
			$anno = substr($prog->datainizio, -2);
			if($prog->id_ente != null)
				$prog->ente = DB::table('corporations')
					->where('id', $prog->id_ente)
					->first()->nomeazienda;
			$prog->codice = '::' . $prog->id . '/' . $anno;
		}
	}
	
	public function getJsonMiei(Request $request)
	{
		$progetti = $this->progetti->forUser2($request->user());
	
		$this->completaCodice($progetti);
		return json_encode($progetti);
	}
	
	public function getjson(Request $request)
	{

		$progetti = $this->progetti->forUser($request->user());
		$this->completaCodice($progetti);
		return json_encode($progetti);
	}
	
	public function miei(Request $request)
    {
                if (!$this->checkReadPermission($request,$this->modulo)) {
                    return response()->view('errors.403');
                }
		$buffer = DB::table('buffer')
					->where([
						'id_user' => $request->user()->id,
					])
					->first();
		if($buffer) {
			DB::table('projects')
				->where('id', $buffer->id_progetto)
				->delete();
			DB::table('buffer')
				  ->where('id', $buffer->id)
				  ->delete();
		}
        return view('progetti.main', [
			'miei' => 1
		]);
    }
	
    public function show(Request $request)
    {
     
        if (!$this->checkReadPermission($request,$this->modulo)) {
            return response()->view('errors.403');
        }
        return view('progetti.main');
    }
    
    public function aggiungi(Request $request)
    {
        if (!$this->checkPermission($request,$this->modulo)) {
            return response()->view('errors.403');
        }
        return view('progetti.aggiungi', [
            'utenti' => DB::table('users')
                        ->get(),
            'preventiviconfermati' => DB::table('quotes')->where('legameprogetto', 0)->having('usato', '=', 0)->get(),
			'statiemotivi' => DB::table('statiemotiviprogetti')
				->get(),
        ]);
    }
    
    public function store(Request $request)
    {
		
        $validator = Validator::make($request->all(), [
            'nomeprogetto' => 'required|max:50',
            'notetecniche' => 'max:1000',
        ]);
        
        
        if($validator->fails()) {
            return Redirect::back()
                ->withInput()
                ->with('error_code', 6)
                ->withErrors($validator);
        }
		
        $progetto = DB::table('projects')->insertGetId([
                        'user_id' => $request->user()->id,
                        'nomeprogetto' => $request->nomeprogetto,
                        'notetecniche' => $request->notetecniche,
                        'noteprivate' => $request->noteprivate,
                        'datainizio' => $request->datainizio,
                        'datafine' => $request->datafine,
                        'progresso' => $request->progresso,
						'statoemotivo' => $request->statoemotivo
                      ]);
		
		if($request->statoemotivo!=null) {
			// Memorizzo lo stato emotivo
			$tipo = DB::table('statiemotiviprogetti')
				->where('name', $request->statoemotivo)
				->first();
			DB::table('statiprogetti')->insert([
				'id_progetto' => $progetto,
				'id_tipo' => $tipo->id,
			]);
		}
		
		// Memorizza i file
		if(isset($request->file)) {
			$options = $request->file;
			for($i = 0; $i < count($options); $i++) {
                $nome = time() . uniqid() . '-' . '-progetto';
			    Storage::put(
    				'images/' . $nome,
    				file_get_contents($options[$i]->getRealPath())
			    );

				DB::table('progetti_files')->insert([
					'id_progetto' => $progetto,
					'nome' => $nome,
				]);
			}
		}
		
		// Memorizza i dati sensibili
		if(isset($request->dati)) {
			$options = $request->dati;
			for($i = 0; $i < count($options); $i++) {
				DB::table('progetti_datisensibili')->insert([
					'id_progetto' => $progetto,
					'dettagli' => $options[$i],
				]);
			}
		}
        
        // Memorizzo le note private
        if(isset($request->nome)) {
			$note = $request->nome;
			$password = $request->pass;
			$dettagli = $request->dett;
			$scadenza = $request->scad;
			for($i = 0; $i < count($note); $i++) {
				DB::table('progetti_noteprivate')->insert([
					'id_progetto' => $progetto,
					'nome' => $note[$i],
					'password' => $password[$i],
					'user' => $dettagli[$i],
					'scadenza' => $scadenza[$i]
				]);
			}
		}
        
        
        // Memorizza i partecipanti al progetto
        if(isset($request->partecipanti)) {
			$options = $request->partecipanti;
			for($i = 0; $i < count($options); $i++) {
				DB::table('progetti_partecipanti')->insert([
					'id_progetto' => $progetto,
					'id_user' => $options[$i],
				]);
			}
		}
        
        // Memorizzo le lavorazioni del progetto
        if(isset($request->ric)) {
			$appunti = $request->ric;
			$ricontattare = $request->ricontattare;
			$alle = $request->alle;
			$datainserimento = $request->datainserimento;
			$completato = $request->completato;
			for($i = 0; $i < count($appunti); $i++) {
			    if($completato[$i] == null)
			        $completato[$i] = 0;
			    else
			        $completato[$i] = 1;
				DB::table('progetti_lavorazioni')->insert([
					'user_id' => $request->user()->id,
				    'id_progetto' => $progetto,
					'nome' => $appunti[$i],
					'scadenza' => $ricontattare[$i],
					'alle' => $alle[$i],
					'programmato' => $datainserimento[$i],
					'completato' => $completato[$i],
				]);
			}
		}

		return redirect('/progetti/modify/project/' . $progetto)
                        ->with('error_code', 5)
                        ->with('msg', '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4>Progetto aggiunto correttamente!</h4></div>');
    }
    
    public function destroy(Request $request, Project $project)
    { 
                //due to ajax call need to echo error
                if (!$this->checkPermission($request,$this->modulo)) {
                     echo "error.403";
                     exit;
                }
                //$this->authorize('destroy', $project);
			
		DB::table('projects')
			->where('id', $project->id)
			->update(array(
            	'is_deleted' => 1
		));
		
		return Redirect::back()
                        ->with('error_code', 5)
                        ->with('msg', '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4>Progetto eliminato correttamente!</h4></div>');
    }
    
    public function duplicate(Request $request, Project $project)
    {
         //due to ajax call need to echo error
        if (!$this->checkPermission($request,$this->modulo)) {
             echo "error.403";
             exit;
        }
        //$this->authorize('duplicate', $project);        
        DB::table('projects')->insert([
            'user_id' => $request->user()->id,
            'nomeprogetto' => $project->nomeprogetto,
            'notetecniche' => $project->notetecniche,
            'noteprivate' => $project->noteprivate,
            'datainizio' => $project->datainizio,
            'datafine' => $project->datafine,
            'progresso' => $project->progresso
        ]);
		
		return Redirect::back()
                        ->with('error_code', 5)
                        ->with('msg', '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4>Progetto duplicato correttamente!</h4></div>');
    }
    
    public function modify(Request $request, Project $project)
    { 
        if (!$this->checkPermission($request,$this->modulo)) {
            return response()->view('errors.403');
        }
		//$this->authorize('modify', $project);
        return view('progetti.modifica', [
            'progetto' => DB::table('projects')
                            ->where('id', $project->id)
                            ->first(),
            'files' => DB::table('progetti_files')
                        ->where('id_progetto', $project->id)
                        ->get(),
            'datisensibili' => DB::table('progetti_datisensibili')
                        ->where('id_progetto', $project->id)
                        ->get(),
            'lavorazioni' => DB::table('progetti_lavorazioni')
                        ->where('id_progetto', $project->id)
                        ->get(),
            'partecipanti' => DB::table('progetti_partecipanti')
                                ->where('id_progetto', $project->id)
                                ->get(),
            'utenti' => DB::table('users')
                            ->get(),
            'noteprivate' => DB::table('progetti_noteprivate')
            					->where('id_progetto', $project->id)
            					->get(),
			'statiemotivi' => DB::table('statiemotiviprogetti')
				->get(),
			'statoemotivoselezionato' => DB::table('statiprogetti')
				->where('id_progetto', $project->id)
				->first(),
        ]);
    }
    
    public function vedifiles(Request $request, Project $project)
    {
		$files = DB::table('progetti_files')
						->where([
							'id_progetto' => $project->id,
						])
    					->get();
		$files_return = array();
		foreach($files as $f) {
			if($f->dipartimento == $request->user()->dipartimento || $f->dipartimento == '-')
				$files_return[] = $f;	
		}
    	return view('progetti.files', [
    		'progetto' => $project,
    		'files' => $files_return
    	]);
    }
    
    public function eliminafile(Request $request)
    {
    	DB::table('progetti_files')
    		->where('id', $request->project)
    		->delete();
    	
    	return Redirect::back()
                        ->with('error_code', 5)
                        ->with('msg', '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4>File eliminato correttamente!</h4></div>');
    }
    
    public function update(Request $request, Project $project)
    {
        if (!$this->checkPermission($request,$this->modulo)) {
            return response()->view('errors.403');
        }
        
        //$this->authorize('modify', $project);
        $validator = Validator::make($request->all(), [
            'nomeprogetto' => 'required|max:50',
            'notetecniche' => 'max:1000',
        ]);
        
        
        if($validator->fails()) {
            return Redirect::back()
                ->withInput()
                ->with('error_code', 6)
                ->withErrors($validator);
        }
		
		DB::table('buffer')
				->where('id_progetto', $project->id)
				->delete();
		
        DB::table('projects')->where('id', $project->id)
        ->update(array(
                        'nomeprogetto' => $request->nomeprogetto,
                        'notetecniche' => $request->notetecniche,
                        'noteprivate' => $request->noteprivate,
                        'datainizio' => $request->datainizio,
                        'datafine' => $request->datafine,
                        'progresso' => $request->progresso,
						'statoemotivo' => $request->statoemotivo
                      ));
		
		if($request->statoemotivo!=null) {
			// Aggiorno lo stato emotivo
			$tipo = DB::table('statiemotiviprogetti')
				->where('name', $request->statoemotivo)
				->first();
			DB::table('statiprogetti')
				->where('id_progetto', $project->id)
				->delete();
			DB::table('statiprogetti')
				->insert([
					'id_tipo' => $tipo->id,
					'id_progetto' => $project->id
				]);
		}
		
		// Salvo i file del preventivo, se è stato creato da un preventivo
		if(isset($request->salvafiles)) {
			$options = $request->salvafiles;
  
	    	DB::table('progetti_files')
				->where('id_preventivo', $options)
				->update(array(
					'id_progetto' => $project->id,
					'id_preventivo' => null
				));    
		}
		
		if(isset($request->dapreventivo)) {
			DB::table('quotes')
				->where('id', $request->dapreventivo)
				->update(array(
					'usato' => 1
				));
		}
		 
		
		// Aggiorno i file
		$options = $request->file;

			for($i = 0; $i < count($options); $i++) {
    			if(file_exists($options[$i])) {
                    $nome = time() . uniqid() . '-' . '-progetto';
    			    Storage::put(
	        			'images/' . $nome,
	        			file_get_contents($options[$i]->getRealPath())
    			    );
    			    	
	    
	    			DB::table('progetti_files')->insert([
	    				'id_progetto' => $project->id,
	    				'nome' => $nome,
	    			]);
			    }
		}
		
		// Memorizza le note private
		if(isset($request->nome)) {
			$note = $request->nome;
			$password = $request->pass;
			$dettagli = $request->dett;
			$scadenza = $request->scad;
			DB::table('progetti_noteprivate')
			    ->where('id_progetto', $project->id)
			    ->delete();
			
			for($i = 0; $i < count($note); $i++) {
				DB::table('progetti_noteprivate')->insert([
					'id_progetto' => $project->id,
					'nome' => $note[$i],
					'password' => $password[$i],
					'user' => $dettagli[$i],
					'scadenza' => $scadenza[$i]
				]);
			}
		} else {
		    DB::table('progetti_noteprivate')
			    ->where('id_progetto', $project->id)
			    ->delete();
		}
		
		// Memorizza i dati sensibili
		if(isset($request->dati)) {
			$options = $request->dati;
			
			DB::table('progetti_datisensibili')
			    ->where('id_progetto', $project->id)
			    ->delete();
			
			for($i = 0; $i < count($options); $i++) {
				DB::table('progetti_datisensibili')->insert([
					'id_progetto' => $project->id,
					'dettagli' => $options[$i],
				]);
			}
		} else {
		    DB::table('progetti_datisensibili')
			    ->where('id_progetto', $project->id)
			    ->delete();
		}
        
        // Memorizza i partecipanti al progetto
        if(isset($request->partecipanti)) {
			$options = $request->partecipanti;
			DB::table('progetti_partecipanti')
			    ->where('id_progetto', $project->id)
			    ->delete();
			for($i = 0; $i < count($options); $i++) {
				DB::table('progetti_partecipanti')->insert([
					'id_progetto' => $project->id,
					'id_user' => $options[$i],
				]);
			}
		} else {
		    DB::table('progetti_partecipanti')
			    ->where('id_progetto', $project->id)
			    ->delete();
		}
        
        // Memorizzo le lavorazioni del progetto
        if(isset($request->ric)) {
			$appunti = $request->ric;
			$ricontattare = $request->ricontattare;
			$alle = $request->alle;
			$datainserimento = $request->datainserimento;
			$completato = $request->completato;
			DB::table('progetti_lavorazioni')
			    ->where('id_progetto', $project->id)
			    ->delete();
			for($i = 0; $i < count($appunti); $i++) {
				DB::table('progetti_lavorazioni')->insert([
					'user_id' => $request->user()->id,
				    'id_progetto' => $project->id,
					'nome' => $appunti[$i],
					'scadenza' => $ricontattare[$i],
					'alle' => $alle[$i],
					'programmato' => $datainserimento[$i],
					'completato' => $completato[$i],
				]);
			}
		} else {
		    DB::table('progetti_lavorazioni')
			    ->where('id_progetto', $project->id)
			    ->delete();
		}

		return redirect("/progetti/modify/project/$project->id")
                        ->with('error_code', 5)
                        ->with('msg', '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4>Progetto modificato correttamente!</h4></div>');
    }
    
    public function creadapreventivo(Request $request)
    {
    	$quote = DB::table('quotes')
    		->where('id', $request->id)
    		->first();
		$nomecliente = DB::table('corporations')
			->where('id', $quote->idente)
			->first()->nomeazienda;
        $nuovoprogetto = DB::table('projects')->insertGetId([
            'nomeprogetto' => $quote->oggetto . '_' . $nomecliente,
            'id_ente' => $quote->idente,
            'id_preventivo' => $quote->id,
            'notetecniche' => $quote->notetecniche,
            'noteprivate' => $quote->noteimportanti,
            'datafine' => $quote->finelavori,
            'progresso' => 10
        ]);
		
		DB::table('progetti_partecipanti')
			->insert([
				'id_progetto' => $nuovoprogetto,
				'id_user' => $request->user()->id
			]);
			
		// Buffer per tenere il progetto in memoria (DB) fino a quando non l'ho salvato,
		// Se uno non salva ed esce esso verrà eliminato al prossimo login
		DB::table('buffer')
			->insert([
				'id_user' => $request->user()->id,
				'id_progetto' => $nuovoprogetto
			]);
        
        return view('progetti.modifica', [
        	'progetto' => DB::table('projects')
                            ->where('id', $nuovoprogetto)
                            ->first(),
            'utenti' => DB::table('users')
                            ->get(),
            'files' => DB::table('progetti_files')
                ->where('id_preventivo', $quote->id)
                ->get(),
            'datisensibili' => DB::table('progetti_datisensibili')
                        ->where('id_progetto', $nuovoprogetto)
                        ->get(),
            'lavorazioni' => DB::table('progetti_lavorazioni')
                        ->where('id_progetto', $nuovoprogetto)
                        ->get(),
            'partecipanti' => DB::table('progetti_partecipanti')
                                ->where('id_progetto', $nuovoprogetto)
                                ->get(),
            'noteprivate' => DB::table('progetti_noteprivate')
            					->where('id_progetto', $nuovoprogetto)
            					->get(),
			'dapreventivo' => 1,
			'idpreventivo' => $request->id,
			'statiemotivi' => DB::table('statiemotiviprogetti')
				->get(),
			'statoemotivoselezionato' => DB::table('statiprogetti')
				->where('id_progetto', $nuovoprogetto)
				->first(),
        ]);
    }
}
