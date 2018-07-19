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
Use Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
class Controller_dodawanie2 extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function dodaj_sen() {
        $data3 = new \App\Http\Controllers\data();
        $bledy = array();
        $i = 0;
        $bool = false;
        if ( strstr(Input::get('rok_b'),"-")) {
            $rok_bb = explode("-",Input::get('rok_b'));
            $rok_b = $rok_bb[0];
            $miesiac_b = $rok_bb[1];
            $dzien_b = $rok_bb[2];
        }
        else {
            $rok_b = "";
            $miesiac_b = "";
            $dzien_b = "";
        
        }
        if ( strstr(Input::get('rok_a'),"-")) {
            $rok_aa = explode("-",Input::get('rok_a'));
            $rok_a = $rok_aa[0];
            $miesiac_a = $rok_aa[1];
            $dzien_a = $rok_aa[2];
        }
        else {
            $rok_a = "";
            $miesiac_a = "";
            $dzien_a = "";
        
        }
        if (!strstr(Input::get('godzina_a'),":") or  !strstr(Input::get('godzina_b'),":")) {
            $bool=true;
            $bledy[$i] = "Podana data 1 lub 2 ma niewłaściwy format";
            $i++;      
            $wybudzenia = Input::get('wybudzenia');
            $wynik = 0;
            $wynik2 = 0;
            $wynik3 = 0;
            $godzina_aa = "00:00:00";
            $godzina_bb = "00:00:00";
        }
        else {
        $godzina_aa = explode(":",Input::get('godzina_a'));
        
        $godzina_bb = explode(":",Input::get('godzina_b'));
        
        
        $wybudzenia = Input::get('wybudzenia');
        //print Input::get('godzina_a');
        
        }
        $godzina_a = (int) $godzina_aa[0];
        $minuta_a = (int) $godzina_aa[1];
        $godzina_b = (int) $godzina_bb[0];
        $minuta_b = (int) $godzina_bb[1];
        $wynik = $data3->sprawdz_date($rok_a,$miesiac_a,$dzien_a,$godzina_a,$minuta_a,false);
        $wynik2 = $data3->sprawdz_date($rok_b,$miesiac_b,$dzien_b,$godzina_b,$minuta_b);
        $wynik3 = $data3->porownaj_dwie_daty($rok_a,$rok_b,$miesiac_a,$miesiac_b,$dzien_a,$dzien_b,$godzina_a,$godzina_b,$minuta_a,$minuta_b,false);
        
        if ($wynik == 1) {
            $data11 = $data3->ustaw_date_1($rok_a,$miesiac_a,$dzien_a,$godzina_a,$minuta_a);
            
        }
        else {
            $data11 = $data3->ustaw_date($rok_a,$miesiac_a,$dzien_a,$godzina_a,$minuta_a);
        }
        
        //print $godzina_a;
        $data22 = $data3->ustaw_date($rok_b,$miesiac_b,$dzien_b,$godzina_b,$minuta_b);
        $ostatnia_godzina = $data3->sprawdz_czy_dany_nastroj_sen_nie_nanosi_sie_na_poprzedni_nastroj($data11,$data22);
        if ($wynik2 == -2 or $wynik2 == -4) {
            $bool=true;
            $bledy[$i] = "Podana data 2 jest większa od teraźniejszej daty";
            $i++;            
        }
        if ($wynik == -3) {
            $bool=true;
            $bledy[$i] = "Błędy format daty 1";
            $i++;            
        }
        if ($wynik2== -3) {
            $bool=true;
            $bledy[$i] = "Błędy format daty 2";
            $i++;            
        }
        if ($wynik2 == -1) {
            $bool=true;
            $bledy[$i] = "Podana data 2 jest większa od  daty 2";
            $i++;            
        }
        if ($wynik == -2 or $wynik == -4) {
            $bool=true;
            $bledy[$i] = "Podana data 1 jest większa od teraźniejszej daty";
            $i++;            
        }
        if ($wynik3 == -1) {
            $bool=true;
            $bledy[$i] = "Podana data 1 jest większa od  daty 2";
            $i++;            
        }
        if ($ostatnia_godzina == false) {
        
            $bool=true;
            $bledy[$i] = "Dane któregos nastroju pokładają się z datą poprzedniego nastroju";
            $i++;  
        }
        if ($bool == true) {
            
            
            return back()->withInput()->withErrors($bledy);
      
        }
        //var_dump($bledy);
        
        
        
        if ($bool == false) {
        $this->zapisz_sen($data11,$data22,$wybudzenia);
        return back()->with(true)->with("godzina",true);
            
        
        }
        //$wynik3 = $data3->porownaj_dwie_daty($rok_a,$rok_b,$miesiac_a,$miesiac_b,$dzien_a,$dzien_b,$godzina_a,$godzina_b,$minuta_a,$minuta_b);
      //  print $data11 . "<br>" . $data22;
    }
    private function zapisz_sen($data1,$data2,$wybudzenia) {
        if ($wybudzenia == "") $wybudzenia = 0;
        $id_users = Auth::User()->id;
        DB::insert("insert into sen  (data_rozpoczecia,data_zakonczenia,id_users,ilosc_wybudzen) values('$data1','$data2','$id_users','$wybudzenia')");
    
    }
    
}
