<?php
namespace App\Repositories;

use App\User;
use DB;
use App\Corporation;

class CorporationRepository
{
	// I miei enti
	public function forUser(User $user)
    {

        if($user->id == 0) {

			// return Corporation::where('is_deleted', 0)->orderBy('id', 'asc')->get();

			return Corporation::join('users', 'corporations.user_id', '=', 'users.id')
					->where('is_deleted', 0)
					->where('users.is_delete', '=', 0)
					->orderBy('corporations.id', 'asc')
					->get();

		} else {

			$partecipanti = DB::table('enti_partecipanti')
				->select('id_ente')
				->where('id_user', $user->id)
				->orderBy('id', 'asc')
				->get();
				
			$enti = Corporation::join('users', 'corporations.user_id', 		'=', 'users.id')
					->where('privato', 0)
					->whereIn('corporations.id', json_decode(json_encode($partecipanti), true))
					->Where('user_id', $user->id)
					->where('users.is_delete', '=', 0)
					// ->orWhere('responsabilelanga', $user->name)
					->orderBy('corporations.id', 'asc')
					->get();			

			foreach($enti as $ente) {
				if($ente->is_deleted == 0)
					$ente_return[] = $ente;	
			}

			if(isset($ente_return)){
				return $ente_return;
			} else {
				return $enti;
			}			
			
		}
    }
	
	// Tutti gli enti
    public function forUser2(User $user)
    {
        if($user->id == 0)

        	// return Corporation::where('is_deleted', 0)
    		// ->where('is_approvato', 1)
			// ->orderBy('id', 'asc')
    		// ->get();
    		
        	return Corporation::join('users', 'corporations.user_id', 		'=', 'users.id')
        		->where('is_deleted', 0)
        		->where('users.is_delete', '=', 0)
        		->where('corporations.is_approvato', 1)
				->orderBy('corporations.id', 'asc')
                ->get();
   
			
		// $enti = Corporation::where('privato', 0)->orderBy('id', 'asc')->get();

        $enti = Corporation::join('users', 'corporations.user_id', 		'=', 'users.id')
        		->where('privato', 0)
        		->where('users.is_delete', '=', 0)
        		->orderBy('corporations.id', 'asc')->get();


		foreach($enti as $ente) {
			if($ente->is_deleted == 0)
				$ente_return[] = $ente;	
		}
		
		return $ente_return;
    }
}