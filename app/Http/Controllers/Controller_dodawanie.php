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
class Controller_dodawanie extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
        
        public function dodaj_wpis2() {
            print Input::get('ajax');
        }
    public function dodaj_wpis() {
        $data3 = new \App\Http\Controllers\data();
        $leki = array();
        $leki2 = array();
        $leki3 = array();
        $leki_rok = array();
        $leki_miesiac = array();
        $leki_dzien = array();
        $leki_godzina = array();
        $leki_minuta = array();
        //print Input::get('nastroj');
        $bledy = array();
        $rok_a = Input::get('rok_a');
        $rok_b = Input::get('rok_b');
        $miesiac_a = Input::get('miesiac_a');
        $miesiac_b = Input::get('miesiac_b');
        $dzien_a = Input::get('dzien_a');
        $dzien_b = Input::get('dzien_b');
        $godzina_a = Input::get('godzina_a');
        $godzina_b = Input::get('godzina_b');
        $minuta_a = Input::get('minuta_a');
        $minuta_b = Input::get('minuta_b');
        $leki = Input::get("leki");
        $leki2 = Input::get("leki2");
        $leki3 = Input::get("leki3");
        $leki_rok = Input::get("leki_rok");
        $leki_miesiac = Input::get("leki_miesiac");
        $leki_dzien = Input::get("leki_dzien");
        $leki_godzina = Input::get("leki_godzina");
        $leki_minuta = Input::get("leki_minuta");
        $co_robilem = Input::get("co_robilem");
        $psychotyczne = Input::get("psychotyczne");
        //print $psychotyczne;
        $pobudzenie = Input::get("pobudzenie");
        $nastroj = Input::get('nastroj');
        $lek = Input::get('lek');
        $zdenerowanie = Input::get('zdenerowanie');
        //sprawdza czy liczba jest liczbą i czy ma zakres od -20 do 20
        $nastroj2=  $this->sprawdz_nastroj_lek(Input::get('nastroj'));
        $lek2 =     $this->sprawdz_nastroj_lek(Input::get('lek'));
        $pobudzenie2 =     $this->sprawdz_nastroj_lek(Input::get("pobudzenie"));
        $zdenerowanie2 = $this->sprawdz_nastroj_lek(Input::get('zdenerowanie'));

        $bool = false;
        $i = 0;
        if ($nastroj2 == -1) {
            $bledy[$i] = "Pole nastroj musi mieć wartości od -20 do +20";
            $bool=true;
            $i++;
        }
        if ($lek2 == -1) {
            $bool=true;
            $bledy[$i] = "Pole lęk musi mieć wartości od -20 do +20";
            $i++;
        }
        if ($zdenerowanie2 == -1) {
            $bool=true;
            $bledy[$i] = "Pole zdenerowanie musi mieć wartości od -20 do +20";
            $i++;
        }        
        if ($pobudzenie2 == -1) {
            $bool=true;
            $bledy[$i] = "Pole pobudzenie musi mieć wartości od -20 do +20";
            $i++;           
        }
        //ustawia datę czyli z 2018 i 01 i 01 robi 2018-01-01
        $data11 = $data3->ustaw_date($rok_a,$miesiac_a,$dzien_a,$godzina_a,$minuta_a);
        //print $godzina_a;
        $data22 = $data3->ustaw_date($rok_b,$miesiac_b,$dzien_b,$godzina_b,$minuta_b);
        //print $data22;
        //sprawdza czy dwie daty są mniejsze od sibie i dokładnie uzupełnione 
        $wynik = $data3->sprawdz_date($rok_a,$miesiac_a,$dzien_a,$godzina_a,$minuta_a);
        $wynik2 = $data3->sprawdz_date($rok_b,$miesiac_b,$dzien_b,$godzina_b,$minuta_b);
        //sprawdza czy pierwsza data jest większa od drugiej
        $wynik3 = $data3->porownaj_dwie_daty($rok_a,$rok_b,$miesiac_a,$miesiac_b,$dzien_a,$dzien_b,$godzina_a,$godzina_b,$minuta_a,$minuta_b);
        //sprawdza czy leki są dokładnie uzupełnione i też sprawdza poprawność daty lekow
        $wynik4 = $this->sprawdz_leki($leki,$leki2,$leki3,$leki_rok,$leki_miesiac,$leki_dzien,$leki_godzina,$leki_minuta);
        //sprawdza czy dawke jest liczbą
        $wynik5 = $this->sprawdz_dawke_leku($leki2);
        
        //sprawdza czy nazwa ma określoną długośc znakow
        $wynik6 = $this->sprawdz_nazwe_leku($leki);
        //$wynik5 = array_search(-3,$wynik4);
        //print $wynik5;
        $data1 = $rok_a . "-" . $miesiac_a . "-" . $dzien_a . " " . $godzina_a . ":" . $minuta_a . ":00";
        $data2 = $rok_b . "-" . $miesiac_b . "-" . $dzien_b . " " . $godzina_b . ":" . $minuta_b . ":00";
        if ($wynik == -1) {
            $bool=true;
            $bledy[$i] = "Błędy format daty 1";
            $i++;            
        }
        if ($wynik4 == -1) {
            $bool=true;
            $bledy[$i] = "Błędy format daty w jakimś leku";
            $i++;            
        }
        if ($wynik4 == -5) {
            $bool=true;
            $bledy[$i] = "Nie masz uzupełnione dobrze leku";
            $i++;            
        }
        if ($wynik == -3) {
            $bool=true;
            $bledy[$i] = "Nie poprawna data 1";
            $i++;            
        }
        if ($wynik4 == -3) {
            $bool=true;
            $bledy[$i] = "Nie poprawna data  w jakimś leku";
            $i++;            
        }
        if ($wynik == -2 or $wynik == -4) {
            $bool=true;
            $bledy[$i] = "Podana data 1 jest większa od teraźniejszej daty";
            $i++;            
        }
        if ($wynik4 == -2 or $wynik4 == -4) {
            $bool=true;
            $bledy[$i] = "Podana data jakiegos leku jest większa od teraźniejszej daty";
            $i++;            
        }
        if ($wynik2 == -1) {
            $bool=true;
            $bledy[$i] = "Błędy format daty 2";
            $i++;            
        }
        if ($wynik5 == -1) {
            $bool=true;
            $bledy[$i] = "dawka ktoregoś z lekow musi być liczbą";
            $i++;             
        }
        if ($wynik6 == -1) {
            $bool=true;
            $bledy[$i] = "nazwa ktoregoś z lekow musi być mniejsza niż 100 znakow";
            $i++;             
        }
        if ($wynik2 == -3) {
            $bool=true;
            $bledy[$i] = "Nie poprawna data 2";
            $i++;            
        }
        if ($wynik2 == -2 or $wynik2 == -4) {
            $bool=true;
            $bledy[$i] = "Podana data 2 jest większa od teraźniejszej daty";
            $i++;            
        }
        if ($wynik3 == -1) {
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
        else {
           //ustawia datę czyli z 2018 i 01 i 01 robi 2018-01-01
           $data = $data3->ustaw_date($rok_a,$rok_b,$miesiac_a,$miesiac_b,$dzien_a,$dzien_b,$godzina_a,$godzina_b,$minuta_a,$minuta_b);
           $id = $this->dodaj_nowy_nastroj($data11,$data22,$nastroj,$lek,$zdenerowanie,$co_robilem,$psychotyczne,$pobudzenie);
           if ($wynik4 != 1) {
               //dodaje do bazy nowe leki
            $this->dodaj_nowe_leki($leki,$leki2,$leki3,$leki_rok,$leki_miesiac,$leki_dzien,$leki_godzina,$leki_minuta,$id);
           }
           return back()->withInput()->with(true);
           //print response()->download(input::get('leki'));
        }
        //if ($wynik == -1 or $wynik == -2) {
        //$wynik = $this->porownaj_dwie_daty($rok_a,$rok_b,$miesiac_a,$miesiac_b,$dzien_a,$dzien_b,$godzina_a,$godzina_b,$minuta_a,$minuta_b);
        //}
        //$wynik2 = $this->porownaj_dwie_daty2($godzina_a,$minuta_a,$godzina_b,$minuta_b);
        //print var_dump(Input::get('leki'));
    }
    private function dodaj_nowe_leki($leki,$leki2,$leki3,$leki_rok,$leki_miesiac,$leki_dzien,$leki_godzina,$leki_minuta,$id) {
        $data3 = new \App\Http\Controllers\data();
        $daty_lekow = array();
        $wynik  = array();
        $id3 = array();
        for ($i=0;$i < count($leki_rok);$i++) {
            //print $leki_rok[$i];
            $daty_lekow[$i] = $data3->ustaw_date($leki_rok[$i],$leki_miesiac[$i],$leki_dzien[$i],$leki_godzina[$i],$leki_minuta[$i]);
            $wynik[$i] = $this->sprawdz_czy_dodawac_lek($leki[$i],$leki2[$i]);
            if ($wynik[$i] == -1) {
                $id2 = $this->dodaj_pojedynczy_lek($leki[$i],$leki2[$i],$leki3[$i],$daty_lekow[$i]);
                    $id3[$i] = $id;
                    $this->dodaj_przekierowanie_leku($id2,$id);
            }
        }
        //$this->ustaw_date($rok_a,$miesiac_a,$dzien_a,$godzina_a,$minuta_a);
    }
    private function dodaj_przekierowanie_leku($id_leku,$id_nastroju) {
        DB::insert("insert into przekierowanie_lekow  (id_leku,id_nastroj) values('$id_leku','$id_nastroju')");
    }
    private function dodaj_pojedynczy_lek($leki,$leki2,$leki3,$data) {
        $id_users = Auth::User()->id;
        //$data = $leki_rok . "-" . $leki_miesiac . "-" . $leki_dzien . " " . $leki_godzina . ":" . $leki_minuta . ":00";
        //print $data;
        DB::insert("insert into leki  (nazwa,data_spozycia,id_users,dawka,porcja) values('$leki','$data','$id_users','$leki2','$leki3')");
        $id_ostatniego_leku = DB::select("select id from leki where id_users = '$id_users' order by id DESC limit 1");
        foreach ($id_ostatniego_leku as $id_ostatniego_leku2) {
            
        }
        return $id_ostatniego_leku2->id;
        //print "<font color=red>$a</font>";
        
    }
  
    private function sprawdz_dawke_leku($dawka) {
        $bool = false;
        for ($i=0;$i < count($dawka);$i++) {
            if (is_numeric($dawka[$i]) != true and $dawka[$i] != null) $bool = true;
        }
        if ($bool == true) {
            return -1;
        }
        else {
            return 0;
        }
    }
    private function dodaj_nowy_nastroj($data1,$data2,$nastroj,$lek,$zdenerowanie,$co_robilem,$psychotyczne,$pobudzenie) {
        //print "dobrze";
        if ($psychotyczne == "") $psychotyczne = 0;
        $id_users = Auth::User()->id;
        DB::insert("insert into nastroj  (godzina_zaczecia,godzina_zakonczenia,id_users,poziom_nastroju,co_robilem,poziom_leku,poziom_zdenerwania,epizod_psychotyczne,pobudzenie ) values('$data1','$data2','$id_users','$nastroj','$co_robilem','$lek','$zdenerowanie','$psychotyczne',$pobudzenie)");
        $id = DB::select("select id from nastroj where id_users = '$id_users' order by id DESC limit 1");
        foreach ($id as $id2) {}
        print $id2->id;
        return $id2->id;
        
    }
    
    
    private function sprawdz_nazwe_leku($nazwa) {
        $bool = false;
        for ($i=0;$i < count($nazwa);$i++) {
            if (strlen($nazwa[$i]) > 100) $bool = true;
        }
        if ($bool == true) {
            return -1;
        }
        else {
            return 0;
        }
    }

    private function sprawdz_czy_dodawac_lek($leki,$leki2) {
        /*$wynik = array();
        for ($i=0;$i < count($leki);$i++) {
            if($leki[$i] == "" and $leki2[$i]) $wynik[$i] = false;
            else $wynik[$i] = true;
        }
        */
        if ($leki == "" and $leki2 == "") return 0;
        return -1;
        
    }
    private function sprawdz_leki($leki,$leki2,$leki3,$leki_rok,$leki_miesiac,$leki_dzien,$leki_godzina,$leki_minuta) {
        $data3 = new \App\Http\Controllers\data();
        for ($i=0;$i < count($leki_rok);$i++) {
            //if ($leki[$i] == "" and $leki2[$i] == "") return 1;
            if ($leki[$i] == "" xor $leki2[$i] == "" ) return -5;
            $wynik[$i] = $data3->sprawdz_date($leki_rok[$i],$leki_miesiac[$i],$leki_dzien[$i],$leki_godzina[$i],$leki_minuta[$i]);
            if ($wynik[$i] == -1 or $wynik[$i] == -2 or $wynik[$i] == -3 or $wynik[$i] == -4) return $wynik[$i];
        }
        return 0;
       

    }
    private function sprawdz_nastroj_lek($liczba) {
            $wynik = is_numeric($liczba);
            if ($liczba >= -20 and $liczba <= 20 and $wynik == true) {
                return 0;
                
            }
            else {
                return -1;
            }
    }

}
