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

	public function stepfour(Request $request){
	  
	  return view('quiz.step-four', [
            'optional' => DB::table('optional')
                        ->get()
        ]);
	}

	public function storeStepthree(Request $request){
	  
	  $validator = Validator::make($request->all(), [
	  	  'pages' => 'required',
	      'colore_primario' => 'required',
	  ]);
	            
	    if($validator->fails()) {
	      return Redirect::back()
	        ->withInput()
	        ->withErrors($validator);
	    }	

	    $pages = $request->input('pages');
	    $total_pages = substr_count($pages, ',') + 1;

  		$true = DB::table('quiz_pages')
  			->insert([
  				'user_id' => $request->user()->id,
	  			'pagine' => $pages,
	  			'totale_pagine' => $total_pages,	  			
	  			'colore_primario' => $request->colore_primario,
	  			'colore_secondario' => $request->colore_secondario,
	  			'colore_alternativo' => $request->colore_alternativo,
	  			'font_dimensione' => $request->fontsize,
	  			'font_famiglia' => $request->fontfamily,
	  			'paragrafo' => $request->font_preview,
	  			
	  	]);


	    if($true){
	    	return "success";
	    } else {
	    	return "fail";
	    }
	}

	public function storestepfour(Request $request){
	  
	  $validator = Validator::make($request->all(), [
	  	  // 'pages' => 'required',
	     //  'colore_primario' => 'required',
	  ]);
	            
	    if($validator->fails()) {
	      return Redirect::back()
	        ->withInput()
	        ->withErrors($validator);
	    }	


  		$true = DB::table('store_optioanl')
  			->insert([
  				'user_id' => $request->user()->id,
	  			'optional_id' => $request->optioan_id,
	  			'label' => $request->icon_label,	  			
	  			'price' => $request->price	  			
	  	]);


	    if($true){
	    	return "success";
	    } else {
	    	return "fail";
	    }
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
