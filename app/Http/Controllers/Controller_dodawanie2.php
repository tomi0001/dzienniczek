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
        $godzina_aa = explode(":",Input::get('godzina_a'));
        $godzina_a = $godzina_aa[0];
        $godzina_bb = explode(":",Input::get('godzina_b'));
        $minuta_a = $godzina_aa[1];
        $godzina_b = $godzina_bb[0];
        $minuta_b = $godzina_bb[1];

        $wybudzenia = Input::get('wybudzenia');
        $wynik = $data3->sprawdz_date($rok_a,$miesiac_a,$dzien_a,$godzina_a,$minuta_a,false);
        $wynik2 = $data3->sprawdz_date($rok_b,$miesiac_b,$dzien_b,$godzina_b,$minuta_b);
        $i = 0;
        print $wynik . "<br>";
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
        if ($wynik == -1) {
            $bool=true;
            $bledy[$i] = "Podana data 1 jest większa od  daty 2";
            $i++;            
        }
        if ($bool == true) {
            print "dobrze";
            //return Redirect::to('glowna')->with('bledy','fffff');
            return back()->withInput()->withErrors($bledy);
            //return Redirect::to('glowna')->with('bledy',$bledy);
        }
        
        if ($wynik == 1) {
            $data11 = $data3->ustaw_date_1($rok_a,$miesiac_a,$dzien_a,$godzina_a,$minuta_a);
            
        }
        else {
            $data11 = $data3->ustaw_date($rok_a,$miesiac_a,$dzien_a,$godzina_a,$minuta_a);
        }
        //print $godzina_a;
        $data22 = $data3->ustaw_date($rok_b,$miesiac_b,$dzien_b,$godzina_b,$minuta_b);
        $this->zapisz_sen($data11,$data22,$wybudzenia);
        //$wynik3 = $data3->porownaj_dwie_daty($rok_a,$rok_b,$miesiac_a,$miesiac_b,$dzien_a,$dzien_b,$godzina_a,$godzina_b,$minuta_a,$minuta_b);
        print $data11 . "<br>" . $data22;
    }
    private function zapisz_sen($data1,$data2,$wybudzenia) {
        if ($wybudzenia == "") $wybudzenia = 0;
        $id_users = Auth::User()->id;
        DB::insert("insert into sen  (data_rozpoczecia,data_zakonczenia,id_users,ilosc_wybudzen) values('$data1','$data2','$id_users','$wybudzenia')");
    
    }
    
}
