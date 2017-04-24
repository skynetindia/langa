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

    // user read alert notification
    public function userreadalert(Request $request)
    {

        $today = date("Y-m-d h:i:s");
        $alert_id = $request->input('alert_id');
      
         DB::table('inviare_avviso')
                ->where('alert_id', $alert_id)
                ->update(array(
                    'data_lettura' => $today
                    ));
                
        return Redirect::back();
        
    }

    // make comment in alert notification
    public function alertmakecomment(Request $request)
    {
        $messaggio = $request->input('messaggio');
        $alert_id = $request->input('alert_id');
        
         DB::table('inviare_avviso')
                ->where('alert_id', $alert_id)
                ->update(array(
                    'comment' => $messaggio,
                    'conferma' => 'LETTO'
                    ));
                
        return Redirect::back();
        
    }    

    // add admin alert
    public function addadminalert(Request $request)
    {
        if($request->user()->id != 0) {
            return redirect('/unauthorized');
        } else {
            
            return view('addalertform', [
                'enti' => DB::table('corporations')
                    ->get(),
                'ruolo_utente' => DB::table('ruolo_utente')
                    ->get()                
            ]);
        }
    }

    // store admin alert
    public function storeadminalert(Request $request)
    {
        if($request->user()->id != 0) {
            
            return redirect('/unauthorized');

        } else {

            $validator = Validator::make($request->all(), [
                'nome_alert' => 'required',
                'tipo_alert' => 'required',
                'ente' => 'required',
                'ruolo' => 'required',
                'messaggio' => ''
            ]);

            if ($validator->fails()) {
                return Redirect::back()
                    ->withInput()
                    ->withErrors($validator);
            }
            
            $ente = implode(",", $request->input('ente'));
            $ruolo = implode(",", $request->input('ruolo'));  

            DB::table('alert')->insert([
                'nome_alert' => $request->nome_alert,
                'tipo_alert' => $request->tipo_alert,
                'ente' => $ente,
                'ruolo' => $ruolo,
                'messaggio' => $request->messaggio
            ]);

            return Redirect::back()
                ->with('msg', '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4>Alert add correttamente!</h4></div>');
        }
    }

    // send alert notification to users
    public function sendalert(Request $request)
    {
        if($request->user()->id != 0) {
            
            return redirect('/unauthorized');

        } else {

            $today = date("Y-m-d");

            $alert = DB::table('alert')
                ->where('created_at', $today)
                ->get();
            
            foreach ($alert as $value) {
                
                $ente = explode(",", $value->ente);
                $ruolo = explode(",", $value->ruolo);
                
                foreach ($ente as $ente) {

                    $getente = DB::table('enti_partecipanti')
                        ->select('id_user')
                        ->where('id_ente', $ente)
                        ->get();

                    foreach ($getente as $getente) {
 
                        $getrole = DB::table('users')
                            ->select('dipartimento')
                            ->where('id', $getente->id_user)
                            ->get();

                        if($getrole) {
                        
                            $corporations = DB::table('corporations')
                                ->where('id', $value->ente)
                                ->first();

                             $true = DB::table('inviare_avviso')->insert([
                                    'id_ente' => $corporations->id,
                                    'alert_id' => $value->alert_id,
                                    'nome_azienda' => $corporations->nomeazienda,
                                    'nome_referente' => $corporations->nomereferente,
                                    'settore' => $corporations->settore,
                                    'telefono_azienda' => $corporations->telefonoazienda,
                                    'email' => $corporations->email,
                                    'data_lettura' => '',
                                    'responsible_langa' => $corporations->responsabilelanga,
                                    'conferma' => 'NON LETTO'
                                ]);

                            if($true){

                                return "alert send succesfully.!";

                            } else {

                                return false;
                            }

                        } 
                    }
                }
            }
        }
    }

    // send notification to users
    public function sendnotification(Request $request)
    {
        if($request->user()->id != 0) {
            
            return redirect('/unauthorized');

        } else {


            $id = 231;
            $current_date = date("Y-m-d"); 

            $alert = DB::table('alert')
                ->where('created_at', $today)
                ->get();
            
            foreach ($alert as $value) {
                
                $ente = explode(",", $value->ente);
                $ruolo = explode(",", $value->ruolo);
                
                foreach ($ente as $ente) {

                    $getente = DB::table('enti_partecipanti')
                        ->select('id_user')
                        ->where('id_ente', $ente)
                        ->get();

                    foreach ($getente as $getente) {
 
                        $getrole = DB::table('users')
                            ->select('dipartimento')
                            ->where('id', $getente->id_user)
                            ->get();

                        if($getrole) {
                        
                            $corporations = DB::table('corporations')
                                ->where('id', $value->ente)
                                ->first();

                             $true = DB::table('inviare_avviso')->insert([
                                    'id_ente' => $corporations->id,
                                    'alert_id' => $value->alert_id,
                                    'nome_azienda' => $corporations->nomeazienda,
                                    'nome_referente' => $corporations->nomereferente,
                                    'settore' => $corporations->settore,
                                    'telefono_azienda' => $corporations->telefonoazienda,
                                    'email' => $corporations->email,
                                    'data_lettura' => '',
                                    'responsible_langa' => $corporations->responsabilelanga,
                                    'conferma' => 'NON LETTO'
                                ]);

                            if($true){

                                return "alert send succesfully.!";

                            } else {

                                return false;
                            }

                        } 
                    }
                }
            }
        }
    }

    public function getalertjson(Request $request)
    {
        $ente = DB::table('inviare_avviso')
                    ->get();  

        return json_encode($ente);
    }


    // getting list of users
    public function newregistratoutente(Request $request)
    {
        if($request->user()->id != 0) {
            return redirect('/unauthorized');
        } else {
            return view('newregistratoutente', [
                'utenti' => DB::table('users')
                                ->select('*')
                                ->where('is_approvato', '=', 0)
                                ->paginate(10),
            ]);
        }
    }

    // getting list of enti
    public function newregistratoenti(Request $request)
    {
        if($request->user()->id != 0) {
            return redirect('/unauthorized');
        } else {
            return view('newregistratoenti', [
                'corporations' => DB::table('corporations')
                                ->select('*')
                                ->where('is_approvato', '=', 0)
                                ->paginate(10),
            ]);
        }
    }

    // approve user
    public function approvareutente(Request $request)
    {
        if($request->user()->id != 0) {
            return redirect('/unauthorized');
        } else {
            
            DB::table('users')
                ->where('id', $request->id)
                ->update(array(
                    'is_approvato' => 1));

             // DB::table('rivenditore')
             //    ->where('id', $request->id)
             //    ->update(array(
             //        'is_approvato' => 1));
        
            return Redirect::back()->with('success', 'Approve Successfully..!!');;

        }
    }

    // rejct user
    public function rifiutareutente(Request $request)
    {
        if($request->user()->id != 0) {
            return redirect('/unauthorized');
        } else {
            
            DB::table('users')
                ->where('id', $request->id)
                ->update(array(
                    'is_approvato' => 2));
            
            // DB::table('rivenditore')
            //     ->where('id', $request->id)
            //     ->update(array(
            //         'is_approvato' => 2));
                
            return Redirect::back()->with('success', 'Reject Successfully..!!');;

        }
    }

    // approve enti
    public function approvareenti(Request $request)
    {
        if($request->user()->id != 0) {
            return redirect('/unauthorized');
        } else {
            
            DB::table('corporations')
                ->where('id', $request->id)
                ->update(array(
                    'is_approvato' => 1));

             // DB::table('rivenditore')
             //    ->where('id', $request->id)
             //    ->update(array(
             //        'is_approvato' => 1));
        

            return redirect()->back()->with('success', 'Approve Successfully..!!');   

        }
    }

    // rejct enti
    public function rifiutareenti(Request $request)
    {
        if($request->user()->id != 0) {
            return redirect('/unauthorized');
        } else {
            
            DB::table('corporations')
                ->where('id', $request->id)
                ->update(array(
                    'is_approvato' => 2));
            
            // DB::table('rivenditore')
            //     ->where('id', $request->id)
            //     ->update(array(
            //         'is_approvato' => 2));
                
            return Redirect::back()->with('success', 'Reject Successfully..!!');   

        }
    }

    // view user role page 
    public function permessiutente(Request $request)
    {
        if($request->user()->id != 0) {
            return redirect('/unauthorized');
        } else {

        $ruolo_utente = DB::table('ruolo_utente')
            ->get();

        return view('role_permessi')->with('ruolo_utente', $ruolo_utente);
          
        }
    }

    // view permessi page 
    public function permessirole(Request $request)
    {
        if($request->user()->id != 0) {
            return redirect('/unauthorized');
        } 
        else {

              $module = DB::table('modulo')
                    ->where('modulo_sub', null)
                    ->get();    


            if($request->ruolo_id){

                $ruolo_utente = DB::table('ruolo_utente')
                    ->where('ruolo_id', '=', $request->ruolo_id)
                    ->get();

                $permessi = array();

                if(isset($ruolo_utente[0]->permessi) && !empty($ruolo_utente[0]->permessi)){
                    $permessi = json_decode($ruolo_utente[0]->permessi);
                }


                return view('permessi')->with('module', $module)->with('ruolo_utente', $ruolo_utente)->with('permessi', $permessi)->with('ruolo_id',$request->ruolo_id);

            } else {

                return view('permessi')->with('module', $module);

            }
                      
        }
    }
    
    // store permessi 
    public function storepermessi(Request $request)
    {
        if($request->user()->id != 0) {
            return redirect('/unauthorized');
        } else {
            
            $reading = $request->input('lettura');
            $writing = $request->input('scrittura');
            $nome_ruolo = $request->input('nome_ruolo');
            
            $permessi = json_encode(array_merge($reading, $writing));

            if($nome_ruolo) {

                $ruolo_utente =  DB::table('ruolo_utente')
                    ->where('ruolo_id', $nome_ruolo)
                    ->update(array('permessi' => $permessi));
 
                return Redirect::back()
                    ->with('msg', '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4> permessi updated succesfully..!</h4></div>');
            } else {

                $new_ruolo = $request->input('new_ruolo');

                    DB::table('ruolo_utente')->insert(        
                        ['nome_ruolo' => $new_ruolo, 'permessi' => $permessi ]
                        );
 
                return Redirect::back()
                    ->with('msg', '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4> Role Add succesfully..!</h4></div>');
            }
        }
    }

    // delete ruolo  
    public function deleterole(Request $request)
    {
        if($request->user()->id != 0) {
            return redirect('/unauthorized');
        } else {


        $ruolo_utente = DB::table('ruolo_utente')
            ->where('ruolo_id', '=', $request->ruolo_id)
            ->delete();

        return Redirect::back()
                ->with('msg', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4> Ruolo deleted succesfully..!</h4></div>');
          
        }
    }
    
    // show list of provinces
    public function showprovincie(Request $request) {
        if($request->user()->id != 0) {
            return redirect('/unauthorized');
        } else {
            $provincie = DB::table('citta')
                        ->get();
            $stato = DB::table('stato')
                        ->get();

            return view('provincie')->with('provincie', $provincie)->with('stato', $stato);
        }
    }

    // store provincie 
    public function storeprovincie(Request $request)
    {
        if($request->user()->id != 0) {
            return redirect('/unauthorized');
        } else {
            
        $citta = $request->input('citta');
        $provincie = $request->input('provincie');
        $id_citta = $request->input('id_citta');
        
        foreach ($citta as $index => $nome_citta) {

            foreach ($id_citta as $key => $value) {

                if($index == $key){

                    DB::table('citta')
                        ->where('id_citta', $value)
                        ->update(['nome_citta' => $nome_citta]);
                }
            }
        }

        foreach ($provincie as $index => $provincie) {

            foreach ($id_citta as $key => $value) {

                if($index == $key){

                    DB::table('citta')
                        ->where('id_citta', $value)
                        ->update(['provincie' => $provincie]);
                }
            }
        }

       return Redirect::back()
                ->with('msg', '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4> provincie updated succesfully..!</h4></div>');
          
        }
    }

    // add new provincie 
    public function addprovincie(Request $request)
    {
        if($request->user()->id != 0) {
            return redirect('/unauthorized');
        } else {
            
        $stato = $request->input('stato');
        $citta = $request->input('citta');
        $provincie = $request->input('provincie');

        $check_citta = DB::table('citta')->get();

        foreach ($check_citta as $check_citta) {

        if($check_citta->nome_citta == $citta && $check_citta->id_stato == $stato)
        {

            return '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4> can not add same city in same state.! </h4></div>';
        } else {

            DB::table('citta')->insert(        
                ['id_stato' => $stato, 'nome_citta' => $citta, 
                'provincie' => $provincie]
            );

            return '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4> Provincie added succesfully..!! </h4></div>';
      
        }

        }

        }
   
    }


    public function addutente(Request $request)
    {
        
        if($request->user()->id != 0) {
            return redirect('/unauthorized');
        } else {

            $module = DB::table('modulo')
                            ->where('modulo_sub', null)
                            ->get();

            return view('modificautente', [
                'enti' => DB::table('corporations')
                            ->select('id', 'nomereferente')
                            ->orderBy('nomeazienda')
                            ->get(),
                'citta' => DB::table('citta')
                            ->select('*')
                            ->get(),
                
            ])->with(array('module'=>$module));
        }
    }
    
    public function aggiornanewsletter(Request $request) {
        if($request->user()->id != 0) {
            return redirect('/unauthorized');
        } else {
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:35',
                'dipartimento' => 'required',
                'contenuto' => 'max:5000'
            ]);

            if ($validator->fails()) {
                return Redirect::back()
                    ->withInput()
                    ->withErrors($validator);
            }

            DB::table('newsletter')
                ->where('id', $request->id)
                ->update(array(
                    'name' => $request->name,
                    'dipartimento' => $request->dipartimento,
                    'contenuto' => $request->contenuto,
            ));

            return Redirect::back()
                ->with('msg', '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4>Newsletter modificata correttamente!</h4></div>');
        }
    }

    public function storenewsletter(Request $request) {
        if($request->user()->id != 0) {
            return redirect('/unauthorized');
        } else {
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:35',
                'dipartimento' => 'required',
                'contenuto' => 'max:5000'
            ]);

            if ($validator->fails()) {
                return Redirect::back()
                    ->withInput()
                    ->withErrors($validator);
            }
            
            DB::table('newsletter')->insert([
                'name' => $request->name,
                'dipartimento' => $request->dipartimento,
                'contenuto' => $request->contenuto,
            ]);

            return Redirect::back()
                ->with('msg', '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4>Newsletter aggiunta correttamente!</h4></div>');
        }
    }

    public function modifynewsletter(Request $request) {
        if($request->user()->id != 0) {
            return redirect('/unauthorized');
        } else {
            $newsletter = DB::table('newsletter')
                ->where('id', $request->id)
                ->first();
            return view('modificanewsletter', ['newsletter' => $newsletter]);
        }
    }
    
    public function deletenewsletter(Request $request) {
        if($request->user()->id != 0) {
            return redirect('/unauthorized');
        } else {
            DB::table('newsletter')
                ->where('id', $request->id)
                ->delete();

            return Redirect::back()
                ->with('msg', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4>Newsletter eliminata correttamente!</h4></div>');
        }
    }

    public function aggiunginewsletter(Request $request) {
        if($request->user()->id != 0) {
            return redirect('/unauthorized');
        } else {
            return view('aggiunginewsletter');
        }
    }

    public function elencotemplatenewsletter(Request $request) {
        if($request->user()->id != 0) {
            return redirect('/unauthorized');
        } else {
            return view('elenconewsletter');
        }
    }
    // Sconti
    // Elenco valore sconto legato al tipo ente (target_id) tramite DB (masterdatatypes)
        // 'quotationdiscount'
        // Elenco dei tipi enti
        // 'corporations'
    
    public function destroyutente(Request $request)
    {
        if($request->user()->id != 0) {
            return redirect('/unauthorized');
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
            return redirect('/unauthorized');
        } else {

            $user_id = $request->input('user_id');

            $dipartimento = $request->input('dipartimento');

            if($request->utente){

            $validator = Validator::make($request->all(), [
                'name' => 'required|max:20',
                'email' => 'required|email|max:255|unique:users,email,'.$user_id.',id',
                'idente' => 'required|max:35',
                'dipartimento' => 'required|max:64',
                'colore' => 'max:30',
                'sconto' => 'required|numeric',
                'sconto_bonus' => 'required|numeric',
                'rendita' => 'required|numeric',
                'rendita_reseller' => 'required|numeric',
                'zone' => 'required',
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

            $idente = implode(",", $request->input('idente'));

            $zone = implode(",", $request->input('zone'));        

            $reading = $request->input('lettura');
            $writing = $request->input('scrittura');
                        
            $permessi = json_encode(array_merge($reading, $writing));

            if($dipartimento == 1 || $dipartimento == 3) {

                DB::table('users')
                ->where('id', $request->utente)
                ->update(array(
                'name' => $request->name,
                'email' => $request->email,
                'id_ente' => $idente,
                'dipartimento' => $request->dipartimento,
                'color' => $request->colore,
                'cellulare' => $request->cellulare,
                'password' => $request->password,
                'permessi' => $permessi
            ));

            } else if($dipartimento == 4 ) {

                DB::table('users')
                ->where('id', $request->utente)
                ->update(array(
                'name' => $request->name,
                'email' => $request->email,
                'id_ente' => $idente,
                'id_citta' => $zone,
                'dipartimento' => $request->dipartimento,
                'color' => $request->colore,
                'cellulare' => $request->cellulare,
                'password' => $request->password,
                'sconto' => $request->sconto,
                'sconto_bonus' => $request->sconto_bonus,
                'rendita_reseller' => $request->rendita_reseller,
                'permessi' => $permessi
            ));

            } else {

               DB::table('users')
                ->where('id', $request->utente)
                ->update(array(
                'name' => $request->name,
                'email' => $request->email,
                'id_ente' => $idente,
                'id_citta' => $zone,
                'dipartimento' => $request->dipartimento,
                'color' => $request->colore,
                'cellulare' => $request->cellulare,
                'password' => $request->password,
                'sconto' => $request->sconto,
                'sconto_bonus' => $request->sconto_bonus,
                'rendita' => $request->rendita,
                'rendita_reseller' => $request->rendita_reseller,
                'permessi' => $permessi
                ));
            }

            return Redirect::back()
                ->with('msg', '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4>Utente modificato correttamente!</h4></div>');
            
         } else {

            $permessi = DB::table('ruolo_utente')
                        ->select('permessi')
                        ->where('ruolo_id', $request->dipartimento)
                        ->first();

            if($request->password!=null)
            {
                $vecchiapassword = bcrypt($request->password);
            }

            $idente = implode(",", $request->input('idente'));

            $zone = implode(",", $request->input('zone'));  

            $validator = Validator::make($request->all(), [
                'name' => 'required|unique:users',
                'email' => 'required|email|max:255|unique:users'
            ]);

            if ($validator->fails()) {
                return Redirect::back()
                                ->withInput()
                                ->withErrors($validator);
            }


            DB::table('users')->insert(array(
                'name' => $request->name,
                'email' => $request->email,
                'id_ente' => $idente,
                'id_citta' => $zone,
                'dipartimento' => $request->dipartimento,
                'color' => $request->colore,
                'cellulare' => $request->cellulare,
                'password' => $request->password,
                'sconto' => $request->sconto,
                'sconto_bonus' => $request->sconto_bonus,
                'rendita' => $request->rendita,
                'rendita_reseller' => $request->rendita_reseller,
                'permessi' => $permessi->{'permessi'}
            
            ));
            
            return Redirect::back()
            ->with('msg', '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4>Utente Add correttamente!</h4></div>');

        }
        
        }
            
    }

    public function modificautente(Request $request)
    {
    
        if($request->user()->id != 0) {
            return redirect('/unauthorized');
        } else {
 
            $module = DB::table('modulo')
                            ->where('modulo_sub', null)
                            ->get();

            if($request->utente){

                $utente = DB::table('users')
                        ->select('*')
                        ->where('id', $request->utente)
                        ->first();

                $permessi = array();

                if(isset($utente->permessi) && !empty($utente->permessi)){
                    $permessi = json_decode($utente->permessi);
                }
                
                return view('modificautente', [
                    'enti' => DB::table('corporations')
                                ->select('id', 'nomereferente')
                                ->orderBy('nomeazienda')
                                ->get(),
                    'citta' => DB::table('citta')
                                ->select('*')
                                ->get(),
                
                ])->with(array('module'=>$module, 'utente' => $utente, 'permessi' => $permessi));

            } else {

                    return view('modificautente', [
                    'enti' => DB::table('corporations')
                                ->select('id', 'nomereferente')
                                ->orderBy('nomeazienda')
                                ->get(),
                    'citta' => DB::table('citta')
                                ->select('*')
                                ->get(),
                
                ])->with(array('module'=>$module));
            }
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
            return redirect('/unauthorized');
        } else {
            return view('utenti', [
                'utenti' => DB::table('users')
                                ->select('*')
                                ->where('id', '!=', 0)
                                ->where('is_approvato', '=', 1)
                                ->paginate(10),
            ]);
        }
    }
    
    public function aggiornascontobonus(Request $request)
    {
        if($request->user()->id != 0) {
            return redirect('/unauthorized');
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
            
            return Redirect::back()
                            ->with('msg', '<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4>Sconto modificato correttamente!</h4></div>');
        }
    }
    
    public function modifyscontobonus(Request $request)
    {
        if($request->user()->id != 0) {
            return redirect('/unauthorized');
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
            return redirect('/unauthorized');
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
            return redirect('/unauthorized');
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
            return redirect('/unauthorized');
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
            return redirect('/unauthorized');
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
            return redirect('/unauthorized');
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
            return redirect('/unauthorized');
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
            return redirect('/unauthorized');
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
            return redirect('/unauthorized');
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
            return redirect('/unauthorized');
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
            return redirect('/unauthorized');
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
            return redirect('/unauthorized');
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
            return redirect('/unauthorized');
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
            return redirect('/unauthorized');
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
            return redirect('/unauthorized');
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
            return redirect('/unauthorized');
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
            return redirect('/unauthorized');
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
            return redirect('/unauthorized');
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
            return redirect('/unauthorized');
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
            return redirect('/unauthorized');
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
            return redirect('/unauthorized');
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
            return redirect('/unauthorized');
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
            return redirect('/unauthorized');
        } else {
                // Elenco di tutti gli optional
            return view('optional', ['optional' => DB::table('optional')->paginate(10)]);    
        }
    }
    
    // INIZIO VENDITA
    public function vendita(Request $request)
    {
        if($request->user()->id != 0) {
            return redirect('/unauthorized');
        } else {
            return view('vendita');
        }
    }
    
    // FINE VENDITA
    
    public function destroydipartimento(Request $request)
	{
        if($request->user()->id != 0) {
            return redirect('/unauthorized');
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
            return redirect('/unauthorized');
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
            return redirect('/unauthorized');
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
            return redirect('/unauthorized');
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
	
	public function deleteStatiProgetti(Request $request)
	{
		DB::table('statiemotiviprogetti')
			->where('id', $request->id)
			->delete();
                return Redirect::back();
	}
	
	public function deleteStatiPreventivi(Request $request)
	{
		DB::table('statiemotivipreventivi')
			->where('id', $request->id)
			->delete();
                return Redirect::back();
	}
	
	public function deleteStatiPagamenti(Request $request)
	{
		DB::table('statiemotivipagamenti')
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
            return redirect('/unauthorized');
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
            return redirect('/unauthorized');
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
	
	public function aggiornaStatiProgetti(Request $request)
	{
            if ($request->user()->id != 0) {
            return redirect('/unauthorized');
        } else {
            DB::table('statiemotiviprogetti')
                    ->where('id', $request->id)
                    ->update(array(
                        'name' => $request->name,
                        'description' => $request->description,
                        'color' => $request->color,
            ));
            return Redirect::back();
        }
    }
	
	public function aggiornaStatiPreventivi(Request $request)
	{
            if ($request->user()->id != 0) {
            return redirect('/unauthorized');
        } else {
            DB::table('statiemotivipreventivi')
                    ->where('id', $request->id)
                    ->update(array(
                        'name' => $request->name,
                        'description' => $request->description,
                        'color' => $request->color,
            ));
            return Redirect::back();
        }
    }
	
	public function aggiornaStatiPagamenti(Request $request)
	{
            if ($request->user()->id != 0) {
            return redirect('/unauthorized');
        } else {
            DB::table('statiemotivipagamenti')
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
			return redirect('/unauthorized');
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
	
	public function nuovoStatoEmotivoProgetto(Request $request)
	{
		if($request->user()->id != 0)
			return redirect('/unauthorized');
		else {
			DB::table('statiemotiviprogetti')->insert([
				'name' => $request->name,
				'description' => $request->description,
				'color' => $request->color,
			]);
			return Redirect::back();
		}
	}
	
	public function nuovoStatoEmotivoPreventivo(Request $request)
	{
		if($request->user()->id != 0)
			return redirect('/unauthorized');
		else {
			DB::table('statiemotivipreventivi')->insert([
				'name' => $request->name,
				'description' => $request->description,
				'color' => $request->color,
			]);
			return Redirect::back();
		}
	}
	
	public function nuovoStatoEmotivoPagamento(Request $request)
	{
		if($request->user()->id != 0)
			return redirect('/unauthorized');
		else {
			DB::table('statiemotivipagamenti')->insert([
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
            return redirect('/unauthorized');
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
            return redirect('/unauthorized');
        } else {
            return $this->mostraTassonomie();
        }
    }
	
	public function mostraTassonomieProgetti()
	{
		return view('tassonomie_progetti', [
			'statiemotiviprogetti' => DB::table('statiemotiviprogetti')
				->get(),
		]);
	}
	
	public function mostraTassonomiePreventivi()
	{
		return view('tassonomie_preventivi', [
			'statiemotiviprogetti' => DB::table('statiemotivipreventivi')
				->get(),
		]);
	}
	
	public function mostraTassonomiePagamenti()
	{
		return view('tassonomie_pagamenti', [
			'statiemotivipagamenti' => DB::table('statiemotivipagamenti')
				->get(),
		]);
	}
	
	public function progetti(Request $request)
	{
        if ($request->user()->id != 0) {
            return redirect('/unauthorized');
        } else {
            return $this->mostraTassonomieProgetti();
        }
    }
	
	public function preventivi(Request $request)
	{
        if ($request->user()->id != 0) {
            return redirect('/unauthorized');
        } else {
            return $this->mostraTassonomiePreventivi();
        }
    }
	
	public function pagamenti(Request $request)
	{
        if ($request->user()->id != 0) {
            return redirect('/unauthorized');
        } else {
            return $this->mostraTassonomiePagamenti();
        }
    }
        
        public function dipartimenti(Request $request)
	{
            if ($request->user()->id != 0) {
            return redirect('/unauthorized');
        } else {
            return $this->mostraDipartimenti();
        }
    }
	
	public function store(Request $request)
	{
            if ($request->user()->id != 0) {
            return redirect('/unauthorized');
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
            return redirect('/unauthorized');
        } else {
            return $this->show($request);
        }
    }
}
