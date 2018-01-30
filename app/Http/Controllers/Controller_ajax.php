<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Input;
use Auth;
use Hash;
use DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
class Controller_ajax extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
        public function pokaz_leki() {
            $data = new \App\Http\Controllers\data();
            $id = Input::get('id');
            $id_users = Auth::User()->id;
            $leki = DB::select("SELECT a.id_leku as id_leku, a.id_nastroj as id_nastroj, b.id as id FROM przekierowanie_lekow as a,leki as b,leki as c where a.id_nastroj = '$id'  and b.id_users = '$id_users' and b.id = a.id_leku group by  a.id_leku  ");
            //$leki = DB::select("SELECT id_leku from leki where id_leku = '$id'  '");
            $leki3 = array();
            $leki4 = array();
            //$leki5 = array();
            $i = 0;
            //print Input::get('id');
            foreach ($leki as $leki2) {
                //$leki[$i] = $leki2->id;
                $leki5 = DB::select("select nazwa,dawka,porcja,data_spozycia,id from leki where id = ' ". $leki2->id . " '");
                //print $leki[$i];
                //$j = 0;
                foreach ($leki5 as $leki6) {
                    $leki4[$i][0] = $leki6->nazwa;
                    $leki4[$i][1] = $leki6->dawka;
                    $leki4[$i][2] = $leki6->porcja;
                    $leki4[$i][3] = $data->oblicz_ilosc_minut_i_godzin($leki6->data_spozycia);
                    $leki4[$i][4] = $leki6->id;
                }
                
                $i++;
            }
            //var_dump($leki4);
            //print Input::get('id');
            return View('ajax_pokaz_leki')->with('leki',$leki4);
        }
        
        public function usun_lek() {
            $id = Input::get("id");
            $id_users = Auth::User()->id;
            $sprawdz_czy_twoje_id  = DB::select("SELECT id FROM leki where id = '$id' and id_users = '$id_users' ");
            foreach ($sprawdz_czy_twoje_id as $sprawdz_czy_twoje_id2) {}
            if ( empty($sprawdz_czy_twoje_id2->id) ) print "Lek o takim id nie jest twoim lekiem";
            else {
                DB::delete("delete from leki where id = '$id'");
                DB::delete("delete from przekierowanie_lekow where id_leku = '$id'");
                print "Pomyślnie usunięto lek";
            }
            
            
        }
        
        public function pokaz_opis() {
            $data = new \App\Http\Controllers\data();
            $id = Input::get('id');
            $id_users = Auth::User()->id;
            $opis = DB::select("SELECT co_robilem FROM `nastroj` WHERE id_users = '$id_users' and id = '$id'  ");
            //$leki = DB::select("SELECT id_leku from leki where id_leku = '$id'  '");
            $opis3 = array();
            //$leki4 = array();
            //$leki5 = array();
            $i = 0;
            //print Input::get('id');
            foreach ($opis as $opis2) {
                //$leki[$i] = $leki2->id;
                //$leki5 = DB::select("select nazwa,dawka,porcja,data_spozycia from leki where id = ' ". $leki2->id . " '");
                //print $leki[$i];
                //$j = 0;
                //$opis3[0] = $opis2->co_robilem;
                /*
                
                foreach ($leki5 as $leki6) {
                    $leki4[$i][0] = $leki6->nazwa;
                    $leki4[$i][1] = $leki6->dawka;
                    $leki4[$i][2] = $leki6->porcja;
                    $leki4[$i][3] = $data->oblicz_ilosc_minut_i_godzin($leki6->data_spozycia);
                }
                */
                //$i++;
            }
            //var_dump($leki4);
            //print Input::get('id');
            //return View('ajax_pokaz_leki')->with('leki',$leki4);
            return View('ajax_pokaz_opis')->with('opis',$opis2->co_robilem);
        }
    
    
}
