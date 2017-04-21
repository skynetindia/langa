<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use DB;

class ZoneController extends Controller
{

    public function getStateList(Request $request)
    {
        $states = DB::table("stato")
                    ->lists("nome_stato","id_stato");

        return response()->json($states);
    }
    
    public function getCityList($id)
    {
                $cities = DB::table("citta")

                    ->where("id_stato",$id)

                    ->lists("nome_citta","id_citta");

                return json_encode($cities);

    }
}
