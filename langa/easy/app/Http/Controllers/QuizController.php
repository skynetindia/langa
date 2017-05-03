<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Redirect;
use DB;

use App\Http\Requests;

class QuizController extends Controller
{
    
	public function __construct(){
	   $this->middleware('auth');
  	}	

	public function index(Request $request){
	  return view('quiz.quiz');
	}

	public function quizStep_1(Request $request){
	  return view('quiz.step_1');
	}

	public function stepthree(Request $request){
	  return view('quiz.step-three');
	}

	public function storequizStep_1(Request $request){
	  
	  $validator = Validator::make($request->all(), [
	  	  'nome_azienda' => 'required',
	      'ref_name' => 'required',
	      'settore_merceologico' => 'required',
	      'indirizzo' => 'required',
	      'telefono' => 'required',
	      'email' => 'required',
	  ]);
	            
	    if($validator->fails()) {
	      return Redirect::back()
	        ->withInput()
	        ->withErrors($validator);
	    }	



	    $step = DB::table('corporations')
	    		->select('id','nomeazienda')
	    		->where('nomeazienda', $request->nome_azienda)
                ->first();
 

        if(!empty($step->nomeazienda)) {
        		 
        		$quiz_user = DB::table('quiz_user')        			
        			->where('ente_id', $step->id)
        			->where('user_id', $request->user()->id)
	                ->first();

             	if(!empty($quiz_user)) {
	             	return "false";

	            } else {

	            	DB::table('quiz_user')
				  		->insert([
				  			'ente_id' => $step->id,
				  			'user_id' => $request->user()->id
				  	]);
	      
	  				return "true";
	            }           
        } 


		$ente_id = DB::table('corporations')
	  		->insertGetId([
	  			'nomeazienda' => $request->nome_azienda,
	  			'user_id' => $request->user()->id,
	  			'nomereferente' => $request->ref_name,
	  			'settore' => $request->settore_merceologico,
	  			'indirizzo' => $request->indirizzo,
	  			'telefonoazienda' => $request->telefono,
	  			'email' => $request->email,
	  	]);	      	
      
	  	DB::table('quiz_dati')
	  		->insert([
	  			'nome_azienda' => $request->nome_azienda,
	  			'user_id' => $request->user()->id,
	  			'ref_name' => $request->ref_name,
	  			'settore_merceologico' => $request->settore_merceologico,
	  			'indirizzo' => $request->indirizzo,
	  			'telefono' => $request->telefono,
	  			'email' => $request->email,
	  	]);

  		DB::table('quiz_user')
	  		->insert([
	  			'ente_id' => $ente_id,
	  			'user_id' => $request->user()->id
	  	]);
	      
	  	return "true";

	}
}
