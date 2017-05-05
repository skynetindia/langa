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

	    $pacchetto = DB::table('pacchetto')
	    		->where('id', 1)
	    		->first();

    	$quiz = DB::table('quiz_user')
			->leftjoin('quiz_dati', 'quiz_user.quiz_id', '=',
				'quiz_dati.id')
			->select(DB::raw('quiz_user.*, quiz_dati.id as quiz_id, quiz_dati.nome_azienda, quiz_dati.settore_merceologico,quiz_dati.indirizzo, quiz_dati.telefono'))
    		->where('quiz_user.user_id', $request->user()->id)
    		->first();

	   	$pacchetto_pages = $pacchetto->pagine_totali;
	   	$pacchetto_price = $pacchetto->prezzo_pacchetto;
	   	$price_perpage = $pacchetto->per_pagina_prezzo;

	    $pages = $request->input('pages');
	    $total_pages = substr_count($pages, ',') + 1;

	    if( $total_pages > $pacchetto_pages ) {
	    	$extra_pages = $total_pages - $pacchetto_pages;
	    	$additional_price = $price_perpage * $extra_pages;
	    	$pacchetto_price = $pacchetto_price + $additional_price;
	    } 
	
  		$true = DB::table('quiz_pages')
  			->insert([
  				'user_id' => $request->user()->id,
  				'quiz_id' => $quiz->quiz_id,
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

	    	$order_id = DB::table('quiz_order')
				->insertGetId([
					'quiz_id' => $quiz->quiz_id,
	  				'user_id' => $request->user()->id,
		  			'nome_azienda' => $quiz->nome_azienda,
		  			'settore_merceologico' => $quiz->settore_merceologico,
		  			'indirizzo' => $quiz->indirizzo,
		  			'telefono' => $quiz->telefono,
		  			'totale_elementi' => 1,	  			
		  			'totale_prezzo' => $pacchetto_price
	  			]);

	  		DB::table('order_record')
  			->insert([
  				'order_id' => $order_id,
	  			'quiz_id' => $quiz->quiz_id,
	  			'nome_azienda' => $quiz->nome_azienda,	
	  			'pacchetto_id' => $pacchetto->id,
	  			'optional_id' => '',
	  			'tipo' => 'pacchetto',
	  			'qty' => $total_pages,
	  			'prezzo_base' => $pacchetto->prezzo_pacchetto,
	  			'prezzo_totale' => $pacchetto_price
	  		]);

	    	return "success";
	    } else {
	    	return "fail";
	    }
	}

	public function storestepfour(Request $request){
	  
	  $validator = Validator::make($request->all(), [
	  	 
	  ]);
	            
	    if($validator->fails()) {
	      return Redirect::back()
	        ->withInput()
	        ->withErrors($validator);
	    }	

	    $quiz = DB::table('quiz_user')
			->leftjoin('quiz_dati', 'quiz_user.quiz_id', '=',
				'quiz_dati.id')
			->select(DB::raw('quiz_user.*, quiz_dati.id as quiz_id, quiz_dati.nome_azienda, quiz_dati.settore_merceologico,quiz_dati.indirizzo, quiz_dati.telefono'))
    		->where('quiz_user.user_id', $request->user()->id)
    		->first();

    	$order = DB::table('quiz_order')
    		->where('quiz_id', $quiz->quiz_id)
    		->first();

    	$totale_elementi = $order->totale_elementi + 1;
    	$totale_prezzo = $order->totale_prezzo + $request->price;

  		$true = DB::table('store_optioanl')
  			->insert([
  				'user_id' => $request->user()->id,
	  			'optional_id' => $request->optioan_id,
	  			'label' => $request->icon_label,	  			
	  			'price' => $request->price	  			
	  	]);

	    if($true){

	    	DB::table('order_record')
  			->insert([
  				'order_id' => $order->order_id,
	  			'quiz_id' => $quiz->quiz_id,
	  			'nome_azienda' => $quiz->nome_azienda,	
	  			'pacchetto_id' => '',
	  			'optional_id' => $request->optioan_id,
	  			'tipo' => 'optional',
	  			'qty' => 1,
	  			'prezzo_base' => $request->price,
	  			'prezzo_totale' => $request->price
	  		]);

	    	DB::table('quiz_order')
                ->where('quiz_id', $quiz->quiz_id)               
                ->update(array(
                    'totale_elementi' => $totale_elementi,
                    'totale_prezzo' => $totale_prezzo
                ));

	    	return "true";

	    } else {
	    	return "false";
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
      
	  	$quiz_id = DB::table('quiz_dati')
	  		->insertGetId([
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
	  			'quiz_id' => $quiz_id,
	  			'ente_id' => $ente_id,
	  			'user_id' => $request->user()->id
	  	]);
	    
	    return "true";

	}
}
