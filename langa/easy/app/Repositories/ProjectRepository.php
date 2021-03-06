<?php

namespace App\Repositories;

use App\User;
use DB;
use App\Project;

class ProjectRepository
{
	// tutti
    public function forUser(User $user)
    {
    // 	$data = DB::table('projects')
				// ->where('is_deleted','0')
				// ->orderBy('id', 'asc')
				// ->get();

    	$data = DB::table('projects')
    			->join('users', 'projects.user_id', '=', 'users.id')
    			->select(DB::raw('projects.*, users.id as uid, users.is_delete'))
				->where('is_deleted','0')
				->where('users.is_delete', '=', 0)
				->orderBy('projects.id', 'asc')
				->get();

		
		foreach($data as $data) {				

				if($data->statoemotivo != ""){
					$statiemotivitipi = DB::table('statiemotivitipi')->where('name',$data->statoemotivo)->orderBy('id', 'asc')->get();

					if(isset($statiemotivitipi[0]->color)){

						$data->statoemotivo = '<span style="color:'.$statiemotivitipi[0]->color.'">'.$data->statoemotivo.'</span>';
					}
					
				}
				$ente_return[] = $data;	
			}	

			return $ente_return;

	   		// return Project::where('is_deleted', 0)
				// ->orderBy('id', 'asc')
				// ->get();
    }
	
	//miei
	public function forUser2(User $user)
    {
       if($user->id == 0) {

    // 	 $data = DB::table('projects')
				// ->where('is_deleted','0')
				// ->orderBy('id', 'asc')
				// ->get();

       	$data = DB::table('projects')
       			->join('users', 'projects.user_id', '=', 'users.id')
       			->select(DB::raw('projects.*, users.id as uid, users.is_delete'))
				->where('is_deleted','0')
				->where('users.is_delete', '=', 0)
				->orderBy('projects.id', 'asc')
				->get();


			foreach($data as $data) {				

				if($data->statoemotivo != ""){
					$statiemotivitipi = DB::table('statiemotivitipi')->where('name',$data->statoemotivo)->orderBy('id', 'asc')->get();

					if(isset($statiemotivitipi[0]->color)){

						$data->statoemotivo = '<span style="color:'.$statiemotivitipi[0]->color.'">'.$data->statoemotivo.'</span>';
					}
					
				}

				$ente_return[] = $data;	
			}	

			return $ente_return;

       //     return Project::where('is_deleted', 0)
		   		// ->get();

       } else {
			

//		$partecipanti = DB::table('progetti_partecipanti')
//			->select('id_progetto')
//			->where('id_user', $user->id)
//			->get();

		// $progetti = Project::whereIn('id', json_decode(json_encode($partecipanti), true))
		// 	->orWhere('user_id', $user->id)
		// 	->orderBy('id', 'asc')
		// 	->get();

               $projects =  DB::table('users')
                        ->select(DB::raw('projects.*, users.id as uid, users.is_delete'))
                        ->join('enti_partecipanti', 'enti_partecipanti.id_user', '=', 'users.id')
                        ->join('projects', 'projects.id_ente', '=', 'enti_partecipanti.id_ente')
                        ->where('users.id', $user->id)
                        ->where('users.is_delete', '=', 0)
                       ->orderBy('projects.id', 'asc')
                        ->get();
               
               //print_r($projects);die;
                
//		$progetti = Project::join('users', 'projects.user_id', '=', 'users.id')
//			->select(DB::raw('projects.*, users.id as uid, users.is_delete'))
//			->whereIn('projects.id', json_decode(json_encode($partecipanti), true))
//			->orWhere('projects.user_id', $user->id)
//			->where('users.is_delete', '=', 0)
//			->orderBy('projects.id', 'asc')
//			->get();
//		
//		foreach($progetti as $prog) {
//			if($prog->is_deleted == 0)
//				$prog_return[] = $prog;	
//		}
				
		return $projects;

		}
    }
    
}