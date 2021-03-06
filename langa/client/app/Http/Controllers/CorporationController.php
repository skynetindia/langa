<?php

namespace App\Http\Controllers;

use DB;
use Storage;
use App\Corporation;
use Redirect;
use App\Repositories\CorporationRepository;
use Validator;
use Illuminate\Http\Request;
use Mail;
use App\Http\Controllers\Controller;

class CorporationController extends Controller {

    protected $corporations;
    protected $chiave;
    protected $stato;
    protected $modulo;

    public function __construct(CorporationRepository $corporations) {
        $this->middleware('auth');

        $this->corporations = $corporations;
        $this->modulo =1 ;
    }

    public function aggiornastatocliente(Request $request) {
        if ($request->cliente == 0) {
            $ente = DB::table('corporations')
                    ->where('id', $request->id)
                    ->first();

            DB::table('corporations')
                    ->where('id', $request->id)
                    ->update(array(
                        'id_cliente' => 0
            ));
            DB::table('clienti')
                    ->where('id', $ente->id_cliente)
                    ->delete();
        }
        return Redirect::back();
    }

    /**
     * Crea una nuovo cliente partendo da un ente
     * Le credenziali sono inviate via email all'ente
     */
    public function nuovocliente(Request $request, Corporation $corporation) {
        if ($request->user()->id == 0 ||
                $request->user()->dipartimento == "AMMINISTRAZIONE") {

            $password = substr(str_shuffle("abcdefghilmnopqrstuvz1234567890"), 0, 7);

            $user = DB::table('clienti')
                    ->insertGetId([
                'name' => $corporation->nomereferente,
                'password' => bcrypt($password),
                'email' => $corporation->email,
                'id_ente' => $corporation->id
            ]);

            DB::table('corporations')
                    ->where('id', $corporation->id)
                    ->update(array(
                        'id_cliente' => $user
            ));
            Mail::send('nuovocliente', ['nome' => $corporation->nomereferente, 'email' => $corporation->email, 'password' => $password], function ($m) use ($request, $corporation) {
                $m->from($request->user()->email, 'Easy LANGA');
                $m->to($corporation->email, $corporation->email)->subject('Credenziali per Pannello Clienti LANGA');
                $m->cc("amministrazione@langa.tv");
            });

            return Redirect::back();
        } else {
            return Redirect::back();
        }
    }

    public function compilaStatiEmotivi(&$enti) {
        $statiemotiviselezionati = DB::table('statiemotivi')
                ->get();
        $tabellastatiemotivi = DB::table('statiemotivitipi')
                ->get();
        foreach ($enti as $corp) {
            foreach ($statiemotiviselezionati as $statoselezionato) {
                if ($corp->id == $statoselezionato->id_ente) {
                    foreach ($tabellastatiemotivi as $statoemotivo) {
                        if ($statoemotivo->id == $statoselezionato->id_tipo) {
                            $corp->statoemotivo = "<p style='padding-left:5px;color:#ffffff;background-color: " . $statoemotivo->color . "'>" . $statoemotivo->name . "</p>";
                            break;
                        }
                    }
                }
            }
        }
    }

    public function compilaTipi(&$enti) {
        $tipiselezionati = DB::table('corporationtypes')->get();
        $tabellatipi = DB::table('masterdatatypes')->get();
        foreach ($enti as $corp) {
            foreach ($tipiselezionati as $tiposelezionato) {
                if ($corp->id == $tiposelezionato->id_ente) {
                    foreach ($tabellatipi as $tipo) {
                        if ($tipo->id == $tiposelezionato->id_tipo) {
                            $corp->tipo = "<p style='padding-left:5px;color:#ffffff;background-color:" . $tipo->color . "'>" . $tipo->name . "</p>";
                            break;
                        }
                    }
                }
            }
        }
    }

    public function getJsonMiei(Request $request) {
        $enti = $this->corporations->forUser($request->user());
        //$this->compilaStatiEmotivi($enti);
        //$this->compilaTipi($enti);
        // dd($enti);
        return json_encode($enti);
    }

    public function getjson(Request $request) {
        $enti = $this->corporations->forUser2($request->user());
        //$this->compilaStatiEmotivi($enti);
        //$this->compilaTipi($enti);
        return json_encode($enti);
    }

    // Mostra tutti gli enti
    public function show(Request $request) {
        return view('corporation', [
            'tabellatipi' => DB::table('masterdatatypes')
                    ->get(),
            'tabellastatiemotivi' => DB::table('statiemotivitipi')
                    ->get(),
        ]);
    }    
    public function index(Request $request) {
        return $this->show($request);
    }
//
//    // Mostra i miei enti
//    public function miei(Request $request) {
//        
//        if (!$this->checkReadPermission($request,$this->modulo)) {
//            return response()->view('errors.403');
//        }
//        
//        return view('corporation', [
//            'tabellatipi' => DB::table('masterdatatypes')
//                    ->get(),
//            'tabellastatiemotivi' => DB::table('statiemotivitipi')
//                    ->get(),
//            'miei' => 1,
//        ]);
//    }

//    public function duplicate(Request $request, Corporation $corporation) {
//        //due to ajax call need to echo error
//        if (!$this->checkPermission($request,$this->modulo)) {
//             echo "error.403";
//             exit;
//        }
//        //$this->authorize('duplicate', $corporation);
//        // Duplica ente
//        $request->user()->corporations()->create([
//            'nomeazienda' => $corporation->nomeazienda,
//            'statoemotivo' => $corporation->statoemotivo,
//            'nomereferente' => $corporation->nomereferente,
//            'settore' => $corporation->settore,
//            'piva' => $corporation->piva,
//            'cf' => $corporation->cf,
//            'telefonoazienda' => $corporation->telefonoazienda,
//            'sedelegale' => $corporation->sedelegale,
//            'indirizzospedizione' => $corporation->indirizzospedizione,
//            'cellulareazienda' => $corporation->cellulareazienda,
//            'emailsecondaria' => $corporation->emailsecondaria,
//            'fax' => $corporation->fax,
//            'logo' => $corporation->logo,
//            'email' => $corporation->email,
//            'iban' => $corporation->iban,
//            'noteenti' => $corporation->noteenti,
//            'indirizzo' => $corporation->indirizzo,
//            'responsabilelanga' => $corporation->responsabilelanga,
//            'telefonoresponsabile' => $corporation->telefonoresponsabile,
//        ]);
//        return Redirect::back()
//                        ->with('msg', '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4>Ente duplicato correttamente!</h4></div>');
//    }

//    public function update(Request $request, Corporation $corporation) {
//        $this->validate($request, [
//            'nomeazienda' => 'required|max:35',
//            'nomereferente' => 'required|max:35',
//            'settore' => 'max:50',
//            'piva' => 'max:11',
//            'cf' => 'max:16',
//            'telefonoazienda' => 'required|max:25',
//            'cellulareazienda' => 'max:25',
//            'emailsecondaria' => 'max:64',
//            'fax' => 'max:35',
//            'sedelegale' => 'max:1000',
//            'indirizzospedizione' => 'max:1000',
//            'email' => 'required|max:64',
//            /* 'indirizzo' => 'required', */
//            'noteenti' => 'max:255',
//            'iban' => 'max:64',
//            'statoemotivo' => 'max:64',
//            'responsabilelanga' => 'required|max:12',
//            'logo' => 'mimes:jpeg,jpg,png | max:1000',
//                /* 'telefonoresponsabile' => 'required|max:35', */
//        ]);
//        $nome = "";
//        $logo = DB::table('corporations')
//                ->select('logo')
//                ->where('id', $corporation->id)
//                ->first();
//        $arr = json_decode(json_encode($logo), true);
//        $nome = $arr['logo'];
//        if ($request->logo != null) {
//            $nome = time() . uniqid() . '-' . '-ente.' . pathinfo($request->file('logo')->getClientOriginalName(), PATHINFO_EXTENSION);
//
//            Storage::put('images/' . $nome, file_get_contents($request->file('logo')->getRealPath()));
//        }
//        if ($request->cliente == 0) {
//            DB::table('clienti')
//                    ->where('id', $corporation->id_cliente)
//                    ->delete();
//            DB::table('corporations')
//                    ->where('id', $corporation->id)
//                    ->update(array(
//                        'id_cliente' => 0
//            ));
//        }
//
//        DB::table('corporations')
//                ->where('id', $corporation->id)
//                ->update(array(
//                    'nomeazienda' => $request->nomeazienda,
//                    'statoemotivo' => $request->statoemotivo,
//                    'nomereferente' => $request->nomereferente,
//                    'settore' => $request->settore,
//                    'piva' => $request->piva,
//                    'cf' => $request->cf,
//                    'sedelegale' => $request->sedelegale,
//                    'indirizzospedizione' => $request->indirizzospedizione,
//                    'telefonoazienda' => $request->telefonoazienda,
//                    'cellulareazienda' => $request->cellulareazienda,
//                    'emailsecondaria' => $request->emailsecondaria,
//                    /* 'privato' => $request->privato, */
//                    'fax' => $request->fax,
//                    'email' => $request->email,
//                    'logo' => $nome,
//                    'iban' => $request->iban,
//                    'swift' => $request->swift,
//                    /* 'noteenti' => $request->noteenti, */
//                    'indirizzo' => $request->indirizzo,
//                    'responsabilelanga' => $request->responsabilelanga,
//                    'telefonoresponsabile' => $request->telefonoresponsabile,
//        ));
//
//        DB::table('enti_partecipanti')->where(
//                        'id_ente', $corporation->id
//                )
//                ->delete();
//
//        // Memorizza i partecipanti al progetto
//        if (isset($request->partecipanti)) {
//            $options = $request->partecipanti;
//            $partecipantiNotifiche = $request->partecipantiNotifiche;
//            /* echo count($options);
//              print_r($options);
//              print_r($partecipantiNotifiche);
//              exit; */
//            //$partecipantiNotifiche[$i] = isset($partecipantiNotifiche[$i]) ? $partecipantiNotifiche[$i] : '0';
//            for ($i = 0; $i < count($options); $i++) {
//                $notifiche = isset($partecipantiNotifiche[$options[$i]]) ? $partecipantiNotifiche[$options[$i]] : '0';
//                //$partecipantiNotifiche = $request->partecipantiNotifiche.$options[$i]
//                //$partecipantiNotifiche = isset() ? $request->partecipantiNotifiche.$options[$i] : '';
//                DB::table('enti_partecipanti')->insert([
//                    'id_ente' => $corporation->id,
//                    'id_user' => $options[$i],
//                    'notifiche' => $notifiche,
//                ]);
//            }
//        }
//
//        /* DB::table('corporationtypes')->where(
//          'id_ente', $corporation->id
//          )->delete(); */
//
//        // Memorizza i tipi
//        /* if(isset($request->tipi)) {
//          $options = $request->tipi;
//          for($i = 0; $i < count($options); $i++) {
//          // echo $options[$i];
//          // select id from masterdatatypes where name = $options[$i]
//          // and insert into corporationtypes(id_tipo, id_ente)
//          // VALUES(id preso da masterdatatypes,Corporation->id)
//          $tipo = DB::table('masterdatatypes')
//          ->where('name', $options[$i])
//          ->first();
//          DB::table('corporationtypes')->insert([
//          'id_tipo' => $tipo->id,
//          'id_ente' => $corporation->id,
//          ]);
//          }
//          } */
//
//        /*
//          Appunti = ric
//          Ricontattare il giorno = ricontattare
//          Alle = alle
//          Data inserimento = datainserimento
//         */
//        if (isset($request->ric)) {
//            $appunti = $request->ric;
//            $utente = $request->utente;
//            /* $ricontattare = $request->ricontattare;
//              $alle = $request->alle;
//              $datainserimento = $request->datainserimento; */
//            $datainserimento = $request->datepicker_to;
//            /* $da_data = $request->datepicker_from; */
//            $banca = $request->banca;
//            $cassa = $request->cassa;
//            $notifiche = $request->notifiche;
//
//            DB::table('messages')
//                    ->where('id_ente', $corporation->id)
//                    ->delete();
//            for ($i = 0; $i < count($appunti); $i++) {
//                $frequenza = $request->frequenza;
//                DB::table('messages')->insert([
//                    'id_ente' => $corporation->id,
//                    'id_utente' => $utente[$i],
//                    'appunti' => $appunti[$i],
//                    /* 'ricontattare' => $ricontattare[$i],
//                      'ora' => $alle[$i], */
//                    'datainserimento' => $datainserimento[$i],
//                    /* 'da_data' => $da_data[$i], */
//                    'banca' => $banca[$i],
//                    'cassa' => $cassa[$i],
//                    'frequenza' => isset($frequenza[$i]) ? $frequenza[$i] : "0",
//                    'notifiche' => isset($notifiche[$i]) ? $notifiche[$i] : '0',
//                ]);
//            }
//        } else {
//            DB::table('messages')
//                    ->where('id_ente', $corporation->id)
//                    ->delete();
//        }
//
//        /* if(isset($request->oggettocosto)) {
//          $appunti = $request->oggettocosto;
//          $ricontattare = $request->costi;
//          $alle = $request->datainserimentocosto;
//          DB::table('costi')
//          ->where('id_ente', $corporation->id)
//          ->delete();
//          for($i = 0; $i < count($appunti); $i++) {
//          DB::table('costi')->insert([
//          'id_ente' => $corporation->id,
//          'oggetto' => $appunti[$i],
//          'costo' => $ricontattare[$i],
//          'datainserimento' => $alle[$i],
//          ]);
//          }
//          } else {
//          DB::table('costi')
//          ->where('id_ente', $corporation->id)
//          ->delete();
//          } */
//
//        if ($request->statoemotivo != null) {
//            // Aggiorno lo stato emotivo
//            $tipo = DB::table('statiemotivitipi')
//                    ->where('name', $request->statoemotivo)
//                    ->first();
//            DB::table('statiemotivi')
//                    ->where('id_ente', $corporation->id)
//                    ->delete();
//            DB::table('statiemotivi')
//                    ->insert([
//                        'id_tipo' => $tipo->id,
//                        'id_ente' => $corporation->id
//            ]);
//        } else {
//            DB::table('statiemotivi')
//                    ->where('id_ente', $corporation->id)
//                    ->delete();
//        }
//        return Redirect::back()
//                        ->with('msg', '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4>Ente modificato correttamente!</h4></div>');
//    }
//
//    public function destroy(Request $request, Corporation $corporation) {
//        
//        //due to ajax call need to echo error
//        if (!$this->checkPermission($request,$this->modulo)) {
//             echo "error.403";
//             exit;
//        }
//        //$this->authorize('destroy', $corporation);
//        DB::table('corporations')
//                ->where('id', $corporation->id)
//                ->update(array(
//                    'is_deleted' => 1,
//        ));
//
//        return Redirect::back()
//                        ->with('msg', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4>Ente eliminato correttamente!</h4></div>');
//    }
//
//    public function store(Request $request) {
//        /* $validator = Validator::make($request->all(), [
//          'nomeazienda' => 'required|max:35',
//          'nomereferente' => 'required|max:35',
//          'settore' => 'max:50',
//          'piva' => 'max:11',
//          'cf' => 'max:16',
//          'telefonoazienda' => 'required|max:25',
//          'cellulareazienda' => 'max:25',
//          'emailsecondaria' => 'max:64',
//          'sedelegale' => 'max:1000',
//          'indirizzospedizione' => 'max:1000',
//          'fax' => 'max:35',
//          'email' => 'required|max:64',
//          'indirizzo' => 'required',
//          'noteenti' => 'max:255',
//          'iban' => 'max:64',
//          'statoemotivo' => 'max:64',
//          'responsabilelanga' => 'required|max:12',
//          'telefonoresponsabile' => 'required|max:35',
//          ]); */
//
//        $validator = Validator::make($request->all(), [
//                    'nomeazienda' => 'required|max:35',
//                    'nomereferente' => 'required|max:35',
//                    'settore' => 'max:50',
//                    'piva' => 'max:11',
//                    'cf' => 'max:16',
//                    'telefonoazienda' => 'required|max:25',
//                    'cellulareazienda' => 'max:25',
//                    'emailsecondaria' => 'max:64',
//                    'fax' => 'max:35',
//                    'sedelegale' => 'max:1000',
//                    'indirizzospedizione' => 'max:1000',
//                    'email' => 'required|max:64',
//                    /* 'indirizzo' => 'required', */
//                    'noteenti' => 'max:255',
//                    'iban' => 'max:64',
//                    'statoemotivo' => 'max:64',
//                    'responsabilelanga' => 'required|max:12',
//                        /* 'telefonoresponsabile' => 'required|max:35', */
//        ]);
//
//        if ($validator->fails()) {
//            return Redirect::back()
//                            ->withInput()
//                            ->with('error_code', 6)
//                            ->withErrors($validator);
//        }
//        $nome = "";
//        if ($request->logo != null) {
//            // Memorizzo l'immagine nella cartella public/imagesavealpha
//            $nome = time() . uniqid() . '-' . '-ente.' . pathinfo($request->file('logo')->getClientOriginalName(), PATHINFO_EXTENSION);
//            Storage::put(
//                    'images/' . $nome, file_get_contents($request->file('logo')->getRealPath())
//            );
//        } else {
//            // Imposto l'immagine di default
//            $nome = "mancalogo.jpg";
//        }
//
//        $corp = $request->user()->corporations()->create([
//            'nomeazienda' => $request->nomeazienda,
//            'nomereferente' => $request->nomereferente,
//            'settore' => $request->settore,
//            'piva' => $request->piva,
//            'cf' => $request->cf,
//            'telefonoazienda' => $request->telefonoazienda,
//            'cellulareazienda' => $request->cellulareazienda,
//            'emailsecondaria' => $request->emailsecondaria,
//            'sedelegale' => $request->sedelegale,
//            'indirizzospedizione' => $request->indirizzospedizione,
//            /* 'privato' => $request->privato, */
//            'fax' => $request->fax,
//            'email' => $request->email,
//            'logo' => $nome,
//            'iban' => $request->iban,
//            'swift' => $request->swift,
//            /* 'noteenti' => $request->noteenti, */
//            /* 'indirizzo' => $request->indirizzo, */
//            'responsabilelanga' => $request->responsabilelanga,
//            'telefonoresponsabile' => $request->telefonoresponsabile,
//        ]);
//
//        // Memorizza i partecipanti al progetto
//        if (isset($request->partecipanti)) {
//            $options = $request->partecipanti;
//            $partecipantiNotifiche = $request->partecipantiNotifiche;
//            for ($i = 0; $i < count($options); $i++) {
//                $notifiche = isset($partecipantiNotifiche[$options[$i]]) ? $partecipantiNotifiche[$options[$i]] : '0';
//                DB::table('enti_partecipanti')->insert([
//                    'id_ente' => $corp->id,
//                    'id_user' => $options[$i],
//                    'notifiche' => $notifiche,
//                ]);
//            }
//        }
//
//        // Memorizza i partecipanti al progetto
//        /* if(isset($request->partecipanti)) {
//          $options = $request->partecipanti;
//          for($i = 0; $i < count($options); $i++) {
//          DB::table('enti_partecipanti')->insert([
//          'id_ente' => $corp->id,
//          'id_user' => $options[$i],
//          ]);
//          }
//          } */
//
//        // Memorizza i tipi
//        /* if(isset($request->tipi)) {
//          $options = $request->tipi;
//          for($i = 0; $i < count($options); $i++) {
//          // echo $options[$i];
//          // select id from masterdatatypes where name = $options[$i]
//          // and insert into corporationtypes(id_tipo, id_ente)
//          // VALUES(id preso da masterdatatypes,Corporation->id)
//          $tipo = DB::table('masterdatatypes')
//          ->where('name', $options[$i])
//          ->first();
//          DB::table('corporationtypes')->insert([
//          'id_tipo' => $tipo->id,
//          'id_ente' => $corp->id,
//          ]);
//          }
//          } */
//
//
//        /*
//          Appunti = ric
//          Ricontattare il giorno = ricontattare
//          Alle = alle
//          Data inserimento = datainserimento
//         */
//        if (isset($request->ric)) {
//            $appunti = $request->ric;
//            $utente = $request->utente;
//            /* $ricontattare = $request->ricontattare;
//              $alle = $request->alle;
//              $datainserimento = $request->datainserimento; */
//
//            $datainserimento = $request->datepicker_to;
//            /* $da_data = $request->datepicker_from; */
//            $banca = $request->banca;
//            $cassa = $request->cassa;
//            $notifiche = $request->notifiche;
//
//            for ($i = 0; $i < count($appunti); $i++) {
//                $frequenza = $request->frequenza;
//                DB::table('messages')->insert([
//                    'id_ente' => $corp->id,
//                    'id_utente' => $utente[$i],
//                    'appunti' => $appunti[$i],
//                    /* 'ricontattare' => $ricontattare[$i],
//                      'ora' => $alle[$i], */
//                    'datainserimento' => $datainserimento[$i],
//                    /* 'da_data' => $da_data[$i], */
//                    'banca' => $banca[$i],
//                    'cassa' => $cassa[$i],
//                    'frequenza' => isset($frequenza[$i]) ? $frequenza[$i] : "0",
//                    'notifiche' => isset($notifiche[$i]) ? $notifiche[$i] : '0',
//                ]);
//            }
//        }
//
//        if ($request->statoemotivo != null) {
//            // Memorizzo lo stato emotivo
//            $tipo = DB::table('statiemotivitipi')
//                    ->where('name', $request->statoemotivo)
//                    ->first();
//            DB::table('statiemotivi')->insert([
//                'id_ente' => $corp->id,
//                'id_tipo' => $tipo->id,
//            ]);
//        }
//
//        return Redirect::back()
//                        ->with('error_code', 5)
//                        ->with('msg', '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4>Ente aggiunto correttamente!</h4></div>');
//    }
//
//    public function nuovo(Request $request) {
//        if (!$this->checkPermission($request,$this->modulo)) {
//            return response()->view('errors.403');
//        }
//        /* return view('modificaente', [
//          'action'=>'add',
//          'utenti' => DB::table('users')
//          ->get(),
//          'tipi' => DB::table('masterdatatypes')
//          ->get(),
//          'statiemotivi' => DB::table('statiemotivitipi')
//          ->get(),
//          ]); */
//        return view('modificaente', [
//            'action' => 'add',
//            'utenti' => DB::table('users')
//                    ->get(),
//            'tipi' => DB::table('masterdatatypes')
//                    ->get(),
//            'tipiselezionati' => [],
//            'statiemotivi' => DB::table('statiemotivitipi')
//                    ->get(),
//            'statoemotivoselezionato' => [],
//            'partecipanti' => [],
//            'chiamate' => [],
//            'utente' => "",
//            'costi' => []
//        ]);
//        /* return view('aggiungiente', [
//          'utenti' => DB::table('users')
//          ->get(),
//          'tipi' => DB::table('masterdatatypes')
//          ->get(),
//          'statiemotivi' => DB::table('statiemotivitipi')
//          ->get(),
//          ]); */
//    }
//
    public function modify(Request $request, Corporation $corporation) {
     
        return view('modificaente', [
            'corp' => $corporation,
            'utenti' => DB::table('users')
                    ->get(),
            'tipi' => DB::table('masterdatatypes')
                    ->get(),
            'tipiselezionati' => DB::table('corporationtypes')
                    ->where('id_ente', $corporation->id)
                    ->get(),
            'statiemotivi' => DB::table('statiemotivitipi')
                    ->get(),
            'statoemotivoselezionato' => DB::table('statiemotivi')
                    ->where('id_ente', $corporation->id)
                    ->first(),
            'partecipanti' => DB::table('enti_partecipanti')
                    ->where('id_ente', $corporation->id)
                    ->get(),
            'chiamate' => DB::table('messages')
                    ->where('id_ente', $corporation->id)
                    ->get(),
            'utente' => $request->user(),
            'costi' => DB::table('costi')
                    ->where('id_ente', $corporation->id)
                    ->orderBy('datainserimento', 'asc')
                    ->get()
        ]);
    }

//    public function add(Request $request) {
//        return redirect('/enti/add');
//    }


}
