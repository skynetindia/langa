<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Storage;
use Redirect;
use Validator;
use Mail;

class AdminController extends Controller
{
    public function __construct(Request $request)
    {
        $this->middleware('auth');  
    }
    // Sconti
    // Elenco valore sconto legato al tipo ente (target_id) tramite DB (masterdatatypes)
        // 'quotationdiscount'

        // Elenco dei tipi enti
        // 'corporations'
    
    public function destroyutente(Request $request)
    {
        if($request->user()->id != 0) {
            return redirect('/home');
        } else {
             DB::table('users')
                    ->where('id', $request->utente)
                    ->delete();
            return Redirect::back()
                            ->with('msg', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4>Utente eliminato correttamente!</h4></div>');
        }
    }
    
    public function aggiornautente(Request $request)
    {
        if($request->user()->id != 0) {
            return redirect('/home');
        } else {
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:20',
                'email' => 'required|max:64',
                'idente' => 'required|max:35',
                'dipartimento' => 'required|max:64',
                'cellulare' => 'max:64',
                'password' => 'max:64',
            ]);

            if ($validator->fails()) {
                return Redirect::back()
                                ->withInput()
                                ->withErrors($validator);
            }
            
            $vecchiapassword = DB::table('users')
                                ->where('id', $request->utente)
                                ->first();
            $vecchiapassword = (String)$vecchiapassword->password;
            
            if($request->password!=null)
            {
                $vecchiapassword = bcrypt($request->password);
            }
                
                
            DB::table('users')
                    ->where('id', $request->utente)
                    ->update(array(
                        'name' => $request->name,
                        'email' => $request->email,
                        'id_ente' => $request->idente,
                        'dipartimento' => $request->dipartimento,
                        'cellulare' => $request->cellulare,
                        'password' => $vecchiapassword,
            ));
            
            return Redirect::back()
                            ->with('msg', '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4>Utente modificato correttamente!</h4></div>');
        }
    }
    
    public function modificautente(Request $request)
    {
        if($request->user()->id != 0) {
            return redirect('/home');
        } else {
            return view('modificautente', [
                'utente' => DB::table('users')
                                ->select('*')
                                ->where('id', $request->utente)
                                ->first(),
                'enti' => DB::table('corporations')
                            ->orderBy('nomeazienda')
                            ->get(),
            ]);
        }
    }
    
    public function attivapassword(Request $request)
    {
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
    
    public function utenti(Request $request)
    {
        if($request->user()->id != 0) {
            return redirect('/home');
        } else {
            return view('utenti', [
                'utenti' => DB::table('users')
                                ->select('*')
                                ->where('id', '!=', 0)
                                ->paginate(10),
            ]);
        }
    }
    
    public function aggiornascontobonus(Request $request)
    {
        if($request->user()->id != 0) {
            return redirect('/home');
        } else {
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:35',
                'tipoente' => 'required|max:35',
                'sconto' => 'required|max:3',
                'descrizione' => 'max:255',
            ]);

            if ($validator->fails()) {
                return Redirect::back()
                                ->withInput()
                                ->withErrors($validator);
            }

            DB::table('scontibonus')
                    ->where('id', $request->sc)
                    ->update(array(
                        'name' => $request->name,
                        'sconto' => $request->sconto,
                        'descrizione' => $request->descrizione,
            ));
            
           
            DB::table('entiscontibonus')->where('id_sconto', $request->sc)
			->update(array('id_tipo' => $request->tipoente));
            
            return Redirect::back()->with
                            ->with('msg', '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4>Sconto modificato correttamente!</h4></div>');
        }
    }
    
    public function modifyscontobonus(Request $request)
    {
        if($request->user()->id != 0) {
            return redirect('/home');
        } else {
            return view('modificascontobonus', [
                'sconto' => DB::table('scontibonus')
                                ->where('id', $request->sconto)
                                ->first(),
                'entisconti' => DB::table('entiscontibonus')
                                ->where('id_sconto', $request->sconto)
                                ->get(),
                // 'tipienti' = Elenco dei tipi enti (POTENZIALE, CLIENTE, ... con ->color)
                'tipienti' => DB::table('users')
                    ->get(),
            ]);
        }
    }
    
    public function destroyscontobonus(Request $request)
    {
        if($request->user()->id != 0) {
            return redirect('/home');
        } else {
            DB::table('scontibonus')
                    ->where('id', $request->sconto)
                    ->delete();
            DB::table('entiscontibonus')
                    ->where('id_sconto', $request->sconto)
                    ->delete();
            return Redirect::back()
                            ->with('msg', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4>Sconto eliminato correttamente!</h4></div>');
        }
    }
    
    public function salvascontobonus(Request $request)
    {
        if($request->user()->id != 0) {
            return redirect('/home');
        } else {
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:35',
                'tipoente' => 'required|max:35',
                'sconto' => 'required|max:3',
                'descrizione' => 'max:255',
            ]);

            if ($validator->fails()) {
                return Redirect::back()
                                ->withInput()
                                ->withErrors($validator);
            }
            
            // Salvo il pacchetto
            $scontoid = DB::table('scontibonus')->insertGetId([
                'name' => $request->name,
                'sconto' => $request->sconto,
                'descrizione' => $request->descrizione,
            ]);
            
            
            $tipo = DB::table('users')
                         ->where('id', $request->tipoente)
                         ->first();
            DB::table('entiscontibonus')->insert([
                'id_sconto' => $scontoid,
                'id_tipo' => $tipo->id,
            ]);
                    
            return Redirect::back()
                           ->with('msg', '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4>Sconto aggiunto correttamente!</h4></div>');
	}
    }
    
    public function aggiungiscontobonus(Request $request)
    {
        if($request->user()->id != 0) {
            return redirect('/home');
        } else {
            return view('aggiungiscontobonus', [
                'tipienti' => DB::table('users')
                                ->get(),
            ]);
        }
    }
    
    public function mostrascontibonus(Request $request)
    {
        if($request->user()->id != 0) {
            return redirect('/home');
        } else {
            return view('scontibonus', [
                'sconti' => DB::table('scontibonus')
                    ->paginate(10),
                // 'entisconti' = legame tra lo id_sconto e id_tipo ente,
                'entisconti' => DB::table('entiscontibonus')
                    ->get(),
                // 'tipienti' = Elenco dei tipi enti (POTENZIALE, CLIENTE, ... con ->color)
                'tipienti' => DB::table('users')
                    ->get(),
            ]);  
        }
    }
    // FINE SCONTI BONUS
    
    public function aggiornasconto(Request $request)
    {
        if($request->user()->id != 0) {
            return redirect('/home');
        } else {
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:35',
                'tipoente' => 'required|max:35',
                'sconto' => 'required|max:3',
                'descrizione' => 'max:255',
            ]);

            if ($validator->fails()) {
                return Redirect::back()
                                ->withInput()
                                ->withErrors($validator);
            }

            DB::table('sconti')
                    ->where('id', $request->sc)
                    ->update(array(
                        'name' => $request->name,
                        'sconto' => $request->sconto,
                        'descrizione' => $request->descrizione,
            ));
            
           
            DB::table('entisconti')->where('id_sconto', $request->sc)
			->update(array('id_tipo' => $request->tipoente));
            
            return Redirect::back()
                            ->with('msg', '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4>Sconto modificato correttamente!</h4></div>');
        }
    }
    
    public function modifysconto(Request $request)
    {
        if($request->user()->id != 0) {
            return redirect('/home');
        } else {
            return view('modificasconto', [
                'sconto' => DB::table('sconti')
                                ->where('id', $request->sconto)
                                ->first(),
                'entisconti' => DB::table('entisconti')
                                ->where('id_sconto', $request->sconto)
                                ->get(),
                // 'tipienti' = Elenco dei tipi enti (POTENZIALE, CLIENTE, ... con ->color)
                'tipienti' => DB::table('masterdatatypes')
                    ->get(),
            ]);
        }
    }
    
    public function destroysconto(Request $request)
    {
        if($request->user()->id != 0) {
            return redirect('/home');
        } else {
            DB::table('sconti')
                    ->where('id', $request->sconto)
                    ->delete();
            DB::table('entisconti')
                    ->where('id_sconto', $request->sconto)
                    ->delete();
            return Redirect::back()
                            ->with('msg', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4>Sconto eliminato correttamente!</h4></div>');
        }
    }
    
    public function salvasconto(Request $request)
    {
        if($request->user()->id != 0) {
            return redirect('/home');
        } else {
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:35',
                'tipoente' => 'required|max:35',
                'sconto' => 'required|max:3',
                'descrizione' => 'max:255',
            ]);

            if ($validator->fails()) {
                return Redirect::back()
                                ->withInput()
                                ->withErrors($validator);
            }
            
            // Salvo il pacchetto
            $scontoid = DB::table('sconti')->insertGetId([
                'name' => $request->name,
                'sconto' => $request->sconto,
                'descrizione' => $request->descrizione,
            ]);
            
            
            $tipo = DB::table('masterdatatypes')
                         ->where('id', $request->tipoente)
                         ->first();
            DB::table('entisconti')->insert([
                'id_sconto' => $scontoid,
                'id_tipo' => $tipo->id,
            ]);
                    
            return Redirect::back()
                           ->with('msg', '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4>Sconto aggiunto correttamente!</h4></div>');
	}
    }
    
    public function aggiungisconto(Request $request)
    {
        if($request->user()->id != 0) {
            return redirect('/home');
        } else {
            return view('aggiungisconto', [
                'tipienti' => DB::table('masterdatatypes')
                                ->get(),
            ]);
        }
    }
    
    public function mostrasconti(Request $request)
    {
        if($request->user()->id != 0) {
            return redirect('/home');
        } else {
            return view('sconti', [
                'sconti' => DB::table('sconti')
                    ->paginate(10),
                // 'entisconti' = legame tra lo id_sconto e id_tipo ente,
                'entisconti' => DB::table('entisconti')
                    ->get(),
                // 'tipienti' = Elenco dei tipi enti (POTENZIALE, CLIENTE, ... con ->color)
                'tipienti' => DB::table('masterdatatypes')
                    ->get(),
            ]);  
        }
    }
    
    // FINE SCONTI
    
    public function aggiornapacchetto(Request $request)
    {
        if($request->user()->id != 0) {
            return redirect('/home');
        } else {
            $validator = Validator::make($request->all(), [
                'code' => 'required|max:35',
                'label' => 'required|max:35',
            ]);

            if ($validator->fails()) {
                return Redirect::back()
                                ->withInput()
                                ->withErrors($validator);
            }
            $logo = DB::table('pack')
                    ->select('icon')
                    ->where('id', $request->pacchetto)
                    ->first();
            
            $arr = json_decode(json_encode($logo), true);
            $nome = $arr['icon'];
            
            if ($request->logo != null) {
                // Memorizzo l'immagine nella cartella public/imagesavealpha
                Storage::put(
                        'images/' . $request->file('logo')->getClientOriginalName(), file_get_contents($request->file('logo')->getRealPath())
                );
                $nome = $request->file('logo')->getClientOriginalName();
            }

            DB::table('pack')
                    ->where('id', $request->pacchetto)
                    ->update(array(
                        'code' => $request->code,
                        'icon' => $nome,
                        'label' => $request->label,
            ));
            
           
            DB::table('optional_pack')->where('pack_id', $request->pacchetto)
			->delete();
            
            // Aggiorno i tipi
            if(isset($request->optional)) {
		$options = $request->optional;
		for($i = 0; $i < count($options); $i++) {
                    $tipo = DB::table('optional')
                                ->where('id', $options[$i])
				->first();
                    DB::table('optional_pack')->insert([
                    	'optional_id' => $tipo->id,
                    	'pack_id' => $request->pacchetto,
                    ]);
		}
            }

            return Redirect::back()
                            ->with('msg', '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4>Pacchetto modificato correttamente!</h4></div>');
        }
    }
    
    public function modifypacchetto(Request $request)
    {
        if($request->user()->id != 0) {
            return redirect('/home');
        } else {
            return view('modificapacchetto', [
                'optional' => DB::table('optional')
                                ->get(),
                'optionalselezionati' => DB::table('optional_pack')
                                            ->where('pack_id', $request->pacchetto)
                                            ->get(),
                'pacchetto' => DB::table('pack')
                                  ->where('id', $request->pacchetto)
                                  ->first(),
            ]);
        }
    }
    
    public function destroypacchetto(Request $request)
    {
        if($request->user()->id != 0) {
            return redirect('/home');
        } else {
            DB::table('optional_pack')
                    ->where('pack_id', $request->pacchetto)
                    ->delete();
            DB::table('pack')
                    ->where('id', $request->pacchetto)
                    ->delete();
            return Redirect::back()
                            ->with('msg', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4>Pacchetto eliminato correttamente!</h4></div>');
        }
    }
    
    public function salvapacchetto(Request $request)
    {
        if($request->user()->id != 0) {
            return redirect('/home');
        } else {
            $validator = Validator::make($request->all(), [
                'code' => 'required|max:35',
                'label' => 'required|max:35',
            ]);

            if ($validator->fails()) {
                return Redirect::back()
                                ->withInput()
                                ->withErrors($validator);
            }
            $nome = "";
            if ($request->logo != null) {
                // Memorizzo l'immagine nella cartella public/imagesavealpha
                Storage::put(
                        'images/' . $request->file('logo')->getClientOriginalName(), file_get_contents($request->file('logo')->getRealPath())
                );
                $nome = $request->file('logo')->getClientOriginalName();
            } else {
                // Imposto l'immagine di default
                $nome = "mancalogo.jpg";
            }
            
            // Salvo il pacchetto
            $packid = DB::table('pack')->insertGetId([
                'code' => $request->code,
                'icon' => $nome,
                'label' => $request->label,
            ]);
            
            // Salvo gli optional che compongono il pacchetto
            if(isset($request->optional)) {
                $opt = $request->optional;
		for($i = 0; $i < count($opt); $i++) {
                    $tipo = DB::table('optional')
                        ->where('id', $opt[$i])
			->first();
                    DB::table('optional_pack')->insert([
			'optional_id' => $tipo->id,
			'pack_id' => $packid,
                    ]);
		}
            }
            
            return Redirect::back()
                            ->with('msg', '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4>Pacchetto aggiunto correttamente!</h4></div>');
        }
    }
    
    // Mostra la pagina per creare un nuovo pacchetto
    public function aggiungipacchetto(Request $request)
    {
        if($request->user()->id != 0) {
            return redirect('/home');
        } else {
            return view('aggiungipacchetto', [
                'optional' => DB::table('optional')
                                ->get(),
            ]);
        }
    }
    
    // Pacchetti
    public function mostrapacchetti(Request $request)
    {
        if($request->user()->id != 0) {
            return redirect('/home');
        } else {
        // Elenco in cui ogni optional è legato ad un id di un pacchetto
        // optional_id => id dell'optional
        // pack_id => id del pacchetto
        // 'optionalpack'

        // Elenco di tutti i pacchetti, che saranno popolati tramite id
        // dall' optional pack
        // 'pack'
            return view('pacchetti', [
                'pack' => DB::table('pack')
                    ->paginate(10),
                'optionalpack' => DB::table('optional_pack')
                        ->get(),
                'optional' => DB::table('optional')
                                ->get(),
            ]);    
        }
    }
    
    // Optional
    public function destroyoptional(Request $request)
    {
        if ($request->user()->id != 0) {
            return redirect('/home');
        } else {

            DB::table('optional')
                    ->where('id', $request->optional)
                    ->delete();
            return Redirect::back()
                            ->with('msg', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4>Optional eliminato correttamente!</h4></div>');
        }
    }
    
    public function salvamodificheoptional(Request $request)
    {
        if ($request->user()->id != 0) {
            return redirect('/home');
        } else {
            $validator = Validator::make($request->all(), [
                        'code' => 'required|max:35',
                        'label' => 'required|max:35',
                        'description' => 'max:255',
                        'price' => 'max:16',
                        'frequenza' => 'required',
                        'dipartimento' => 'required'
            ]);

            if ($validator->fails()) {
                return Redirect::back()
                                ->withInput()
                                ->withErrors($validator);
            }
            $logo = DB::table('optional')
                    ->select('icon')
                    ->where('id', $request->optional)
                    ->first();
            $arr = json_decode(json_encode($logo), true);
            $nome = $arr['icon'];
            if ($request->logo != null) {
                // Memorizzo l'immagine nella cartella public/imagesavealpha
                Storage::put(
                        'images/' . $request->file('logo')->getClientOriginalName(), file_get_contents($request->file('logo')->getRealPath())
                );
                $nome = $request->file('logo')->getClientOriginalName();
            }

            DB::table('optional')
                    ->where('id', $request->optional)
                    ->update(array(
                        'code' => $request->code,
                        'icon' => $nome,
                        'label' => $request->label,
                        'description' => $request->description,
                        'price' => $request->price,
                        'frequenza' => $request->frequenza,
                        'dipartimento' => $request->dipartimento,
            ));

            return Redirect::back()
                            ->with('msg', '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4>Optional modificato correttamente!</h4></div>');
        }
    }
    
    public function modificaoptional(Request $request)
    {
        if($request->user()->id != 0)
            return redirect('/home');
	else {
            return view('modificaoptional', [
                'optional' => DB::table('optional')
                    ->where('id', $request->optional)
                    ->first(),
		'dipartimenti' => DB::table('departments')
                        ->get(),
                'frequenze' => DB::table('frequenze')
                        ->get(),
            ]);
        }
    }
    
    public function salvaoptional(Request $request)
    {
        if ($request->user()->id != 0) {
            return redirect('/home');
        } else {
            $validator = Validator::make($request->all(), [
                        'code' => 'required|max:35',
                        'label' => 'required|max:35',
                        'description' => 'max:255',
                        'price' => 'max:16',
                        'frequenza' => 'required',
                        'dipartimento' => 'required'
            ]);

            if ($validator->fails()) {
                return Redirect::back()
                                ->withInput()
                                ->withErrors($validator);
            }
            $nome = "";
            if ($request->logo != null) {
                // Memorizzo l'immagine nella cartella public/imagesavealpha
                Storage::put(
                        'images/' . $request->file('logo')->getClientOriginalName(), file_get_contents($request->file('logo')->getRealPath())
                );
                $nome = $request->file('logo')->getClientOriginalName();
            } else {
                // Imposto l'immagine di default
                $nome = "mancalogo.jpg";
            }

            DB::table('optional')->insert([
                'code' => $request->code,
                'icon' => $nome,
                'label' => $request->label,
                'description' => $request->description,
                'price' => $request->price,
                'frequenza' => $request->frequenza,
                'dipartimento' => $request->dipartimento,
            ]);

            return Redirect::back()
                            ->with('msg', '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4>Dipartimento aggiunto correttamente!</h4></div>');
        }
    }
    
    public function aggiungioptional(Request $request)
    {
        if ($request->user()->id != 0) {
            return redirect('/home');
        } else {
            return view('aggiungioptional', [
                'dipartimenti' => DB::table('departments')
                        ->get(),
                'frequenze' => DB::table('frequenze')
                        ->get()
            ]);
        }
    }
    
    public function mostraoptional(Request $request)
    {
        if($request->user()->id != 0) {
            return redirect('/home');
        } else {
                // Elenco di tutti gli optional
            return view('optional', ['optional' => DB::table('optional')->paginate(10)]);    
        }
    }
    
    // INIZIO VENDITA
    public function vendita(Request $request)
    {
        if($request->user()->id != 0) {
            return redirect('/home');
        } else {
            return view('vendita');
        }
    }
    
    // FINE VENDITA
    
    public function destroydipartimento(Request $request)
	{
        if($request->user()->id != 0) {
            return redirect('/home');
        } else {
            DB::table('departments')
                    ->where('id', $request->department)
                    ->delete();
            return Redirect::back()
                            ->with('msg', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4>Dipartimento eliminato correttamente!</h4></div>');
        }
    }
    
    public function aggiornadipartimento(Request $request)
    {
        if ($request->user()->id != 0) {
            return redirect('/home');
        } else {
            $validator = Validator::make($request->all(), [
                        'nomedipartimento' => 'required|max:35',
                        'nomereferente' => 'required|max:35',
                        'settore' => 'max:50',
                        'piva' => 'max:11',
                        'cf' => 'max:16',
                        'telefonodipartimento' => 'required|max:20',
                        'cellularedipartimento' => 'max:20',
                        'email' => 'required|max:64',
                        'emailsecondaria' => 'max:64',
                        'fax' => 'max:64',
                        'indirizzo' => 'required',
                        'noteenti' => 'max:255',
                        'iban' => 'max:64',
            ]);

            if ($validator->fails()) {
                return Redirect::back()
                                ->withInput()
                                ->withErrors($validator);
            }
            $logo = DB::table('departments')
                    ->select('logo')
                    ->where('id', $request->department)
                    ->first();
            $arr = json_decode(json_encode($logo), true);
            $nome = $arr['logo'];
            if ($request->logo != null) {
                // Memorizzo l'immagine nella cartella public/imagesavealpha
                Storage::put(
                        'images/' . $request->file('logo')->getClientOriginalName(), file_get_contents($request->file('logo')->getRealPath())
                );
                $nome = $request->file('logo')->getClientOriginalName();
            }

            DB::table('departments')
                    ->where('id', $request->department)
                    ->update(array(
                        'nomedipartimento' => $request->nomedipartimento,
                        'nomereferente' => $request->nomereferente,
                        'settore' => $request->settore,
                        'piva' => $request->piva,
                        'cf' => $request->cf,
                        'logo' => $nome,
                        'telefonodipartimento' => $request->telefonodipartimento,
                        'cellularedipartimento' => $request->cellularedipartimento,
                        'email' => $request->email,
                        'emailsecondaria' => $request->emailsecondaria,
                        'fax' => $request->fax,
                        'indirizzo' => $request->indirizzo,
                        'noteenti' => $request->noteenti,
                        'iban' => $request->iban
            ));

            return Redirect::back()
                            ->with('msg', '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4>Dipartimento modificato correttamente!</h4></div>');
        }
    }
    
    public function modificadipartimento(Request $request)
    {
        if ($request->user()->id != 0) {
            return redirect('/home');
        } else {
            return view('modificadipartimento', [
                'utenti' => DB::table('users')
                        ->get(),
                'dipartimento' => DB::table('departments')
                        ->where('id', $request->department)
                        ->first(),
            ]);
        }
    }
    
    public function salvadipartimento(Request $request)
    {
        if ($request->user()->id != 0) {
            return redirect('/home');
        } else {
            $validator = Validator::make($request->all(), [
                        'nomedipartimento' => 'required|max:35',
                        'nomereferente' => 'required|max:35',
                        'settore' => 'max:50',
                        'piva' => 'max:11',
                        'cf' => 'max:16',
                        'telefonodipartimento' => 'required|max:20',
                        'cellularedipartimento' => 'max:20',
                        'email' => 'required|max:64',
                        'emailsecondaria' => 'max:64',
                        'fax' => 'max:64',
                        'indirizzo' => 'required',
                        'noteenti' => 'max:255',
                        'iban' => 'max:64',
            ]);

            if ($validator->fails()) {
                return Redirect::back()
                                ->withInput()
                                ->withErrors($validator);
            }
            $nome = "";
            if ($request->logo != null) {
                // Memorizzo l'immagine nella cartella public/imagesavealpha
                Storage::put(
                        'images/' . $request->file('logo')->getClientOriginalName(), file_get_contents($request->file('logo')->getRealPath())
                );
                $nome = $request->file('logo')->getClientOriginalName();
            } else {
                // Imposto l'immagine di default
                $nome = "mancalogo.jpg";
            }

            DB::table('departments')->insert([
                'nomedipartimento' => $request->nomedipartimento,
                'nomereferente' => $request->nomereferente,
                'settore' => $request->settore,
                'piva' => $request->piva,
                'cf' => $request->cf,
                'telefonodipartimento' => $request->telefonodipartimento,
                'cellularedipartimento' => $request->cellularedipartimento,
                'email' => $request->email,
                'logo' => $nome,
                'emailsecondaria' => $request->emailsecondaria,
                'fax' => $request->fax,
                'indirizzo' => $request->indirizzo,
                'noteenti' => $request->noteenti,
                'iban' => $request->iban
            ]);

            return Redirect::back()
                            ->with('msg', '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4>Dipartimento aggiunto correttamente!</h4></div>');
        }
    }
    
    public function nuovo()
	{
		return view('aggiungidipartimento', [
			'utenti' => DB::table('users')
                            ->get(),
		]);
	}
    
    public function add(Request $request)
	{
		return redirect('admin/tassonomie/dipartimenti/add');
	}
	
	public function show(Request $request)
	{
		return view('admin', [
			'logo' =>  base64_encode(Storage::get('images/logo.png')),
                        'profilazioni' => DB::table('profilazione')
                                            ->select('*')
                                            ->get(),
		]);
	}
	
	public function deleteStatiEmotivi(Request $request)
	{
		DB::table('statiemotivitipi')
			->where('id', $request->id)
			->delete();
                return Redirect::back();
	}

	public function delete(Request $request)
	{
		DB::table('masterdatatypes')
			->where('id', $request->id)
			->delete();
		return Redirect::back();
	}
	
	public function tassonomieUpdate(Request $request)
	{
            if ($request->user()->id != 0) {
            return redirect('/home');
        } else {
            DB::table('masterdatatypes')
                    ->where('id', $request->id)
                    ->update(array(
                        'name' => $request->name,
                        'description' => $request->description,
                        'color' => $request->color,
            ));
            return Redirect::back();
        }
    }
	
	public function aggiornaStatiEmotivi(Request $request)
	{
            if ($request->user()->id != 0) {
            return redirect('/home');
        } else {
            DB::table('statiemotivitipi')
                    ->where('id', $request->id)
                    ->update(array(
                        'name' => $request->name,
                        'description' => $request->description,
                        'color' => $request->color,
            ));
            return Redirect::back();
        }
    }

	public function nuovoStatoEmotivo(Request $request)
	{
		if($request->user()->id != 0)
			return redirect('/home');
		else {
			// Creo il nuovo tipo e lo memorizzo nel DB masterdatatypes
			DB::table('statiemotivitipi')->insert([
				'name' => $request->name,
				'description' => $request->description,
				'color' => $request->color,
			]);
			return Redirect::back();
		}
	}

	public function nuovoTipo(Request $request)
	{
            if ($request->user()->id != 0) {
            return redirect('/home');
        } else {
            // Creo il nuovo tipo e lo memorizzo nel DB masterdatatypes
            DB::table('masterdatatypes')->insert([
                'name' => $request->name,
                'description' => $request->description,
                'color' => $request->color,
            ]);
            return Redirect::back();
        }
    }
	
	public function mostraTassonomie()
	{
		return view('tassonomie_enti', [
			'tipi' => DB::table('masterdatatypes')
				->get(),
			'statiemotivitipi' => DB::table('statiemotivitipi')
				->get(),
		]);
	}
        
        public function mostraDipartimenti()
	{
		return view('tassonomie_dipartimenti', [
			'dipartimenti' => DB::table('departments')
                            ->orderBy('id')
                            ->limit(50)
                            ->get(),
		]);
	}
	
	public function enti(Request $request)
	{
            if ($request->user()->id != 0) {
            return redirect('/home');
        } else {
            return $this->mostraTassonomie();
        }
    }
        
        public function dipartimenti(Request $request)
	{
            if ($request->user()->id != 0) {
            return redirect('/home');
        } else {
            return $this->mostraDipartimenti();
        }
    }
	
	public function store(Request $request)
	{
            if ($request->user()->id != 0) {
            return redirect('/home');
        } else {
            // Salvo le impostazioni
            $fileName = $request->logo;
            Storage::put(
                    'images/logo.png', file_get_contents($request->logo->getRealPath())
            );
        }
        return $this->show($request);
	}
	
	public function index(Request $request)
	{
            if ($request->user()->id != 0) {
            return redirect('/home');
        } else {
            return $this->show($request);
        }
    }
}
