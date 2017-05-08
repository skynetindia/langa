<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;
use DB;

class Controller extends BaseController {

    use AuthorizesRequests,
        AuthorizesResources,
        DispatchesJobs,
        ValidatesRequests;

    //bhavika:to check permission of read and write
    public function checkPermission($request, $modulo) {
        $flag = 1; //To diplay modify page
        $user_prmission = $request->user()->permessi;

        $permessi = DB::table('ruolo_utente')
                ->select('permessi')
                ->where('ruolo_id', $request->user()->dipartimento)
                ->first();

        $admin_permissoin = $permessi->permessi;
        $submodule = DB::table('modulo')
                ->where('modulo_sub', $modulo)
                ->get();

        $user_prmission = json_decode($user_prmission);
        $admin_permissoin = json_decode($admin_permissoin);
        //$write[] = $modulo . "|0|scrittura";
        $write = [];
        foreach ($submodule as $sub) {
            $write[] = $modulo . '|' . $sub->id . '|scrittura';
        }
        if (empty($user_prmission) && empty($admin_permissoin)) {
            $flag = 0; //To diplay 403 page
        }
        if (empty($user_prmission) && !empty($admin_permissoin)) {
            $writeperm = array_intersect($admin_permissoin, $write);
            if (empty($writeperm)) //No write permission
                $flag = 0;
        }elseif (!empty($user_prmission) && empty($admin_permissoin)) {
            $writeperm = array_intersect($user_prmission, $write);
            if (empty($writeperm)) //No write permission
                $flag = 0;
        } elseif (!empty($user_prmission) && !empty($admin_permissoin)) {
            //when both not empty then check for only admin permission
            $writeperm = array_intersect($user_prmission, $write);
            if (empty($writeperm)) //No write permission
                $flag = 0;
        }
        return $flag;
    }

    //bhavika:to check only read permissoin
    public function checkReadPermission($request, $modulo) {
        $flag = 1; //To diplay modify page
        $user_prmission = $request->user()->permessi;
        $permessi = DB::table('ruolo_utente')
                ->select('permessi')
                ->where('ruolo_id', $request->user()->dipartimento)
                ->first();

        $admin_permissoin = $permessi->permessi;
//        $submodule = DB::table('modulo')
//                ->where('modulo_sub', $modulo)
//                ->get();
        //print_r($submodule);die;
        $user_prmission = json_decode($user_prmission);
        $admin_permissoin = json_decode($admin_permissoin);
        $url1 = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REDIRECT_URL'];
        $url2 = str_replace("index.php","",$_SERVER['PHP_SELF']);
        $url2 = "http://" . $_SERVER['HTTP_HOST'] .$url2;
        $link = "/" . str_replace($url2, "", $url1);
        $pos = strpos($link, 'statistiche/economiche');
        if ($pos) {
            $link = '/statistiche/economiche';
        }
        $submodule = DB::table('modulo')
                ->where('modulo_link', $link)
                ->get();
        //$read[] = $modulo . "|0|lettura";
        $read = [];
        foreach ($submodule as $sub) {
            $read[] = $modulo . '|' . $sub->id . '|lettura';
        }
        if (empty($user_prmission) && empty($admin_permissoin)) {
            $flag = 0; //To diplay 403 page
        } else
        if (empty($user_prmission) && !empty($admin_permissoin)) {
            $readperm = array_intersect($admin_permissoin, $read);
            if (empty($readperm)) //No read permission
                $flag = 0;
        }elseif (!empty($user_prmission) && empty($admin_permissoin)) {
            $readperm = array_intersect($user_prmission, $read);
            if (empty($readperm)) //No read permission
                $flag = 0;
        } elseif (!empty($user_prmission) && !empty($admin_permissoin)) {
            //when both not empty then check for only admin permission
            $readperm = array_intersect($user_prmission, $read);
            if (empty($readperm)) //No read permission
                $flag = 0;
        }
        return $flag;
    }

}