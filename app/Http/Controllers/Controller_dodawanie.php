<?php
/*
Copyright 2018 roku Autor Tomasz Leszczyński <tomi0001@gmail.com>






*/
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
            //print Input::get('ajax');
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
        $bool = false;
        $i = 0;
        $bledy = array();
        //tutaj początek
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
        //przypadek jeżeli użytkownik nie poda żadnej godziny
        if (!strstr(Input::get('godzina_a'),":") or  !strstr(Input::get('godzina_b'),":")) {
            $bool=true;
            $bledy[$i] = "Podana data 1 lub 2 ma niewłaściwy format";
            $i++;  
            $godzina_aa = "00:00:00";
            $godzina_bb = "00:00:00";
        }
        else {
            $godzina_aa = explode(":",Input::get('godzina_a'));
            $godzina_bb = explode(":",Input::get('godzina_b'));
        }
        //print $godzina_a;
        $godzina_a = $godzina_aa[0];
        
        $minuta_a = $godzina_aa[1];
        $godzina_b = $godzina_bb[0];
        $minuta_b = $godzina_bb[1];
        $tablica_godzin2 = $data3->rysuj_dla_godziny($godzina_b,3);
        //tutaj koniec
        $tablica_godzin2 = $tablica_godzin2 . ":00:00";
        $leki = Input::get("leki");
        $leki2 = Input::get("leki2");
        
        $leki3 = Input::get("leki3");
        $leki_rok = Input::get("leki_rok");
        $leki_godzina = Input::get("leki_godzina");
        $co_robilem = Input::get("co_robilem");
        //poczatek
        $psychotyczne = Input::get("psychotyczne");
   
        $pobudzenie = Input::get("pobudzenie");
        $nastroj = Input::get('nastroj');
        $lek = Input::get('lek');
        $zdenerowanie = Input::get('zdenerowanie');
	
        $nastroj2=  $this->sprawdz_nastroj_lek(Input::get('nastroj'));
        $lek2 =     $this->sprawdz_nastroj_lek(Input::get('lek'));
        $pobudzenie2 =     $this->sprawdz_nastroj_lek(Input::get("pobudzenie"));
        $zdenerowanie2 = $this->sprawdz_nastroj_lek(Input::get('zdenerowanie'));

        //koniec
        //pocztaek
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
        if ($rok_a == "" and $miesiac_a == "" and $dzien_a == "" and $godzina_a > $godzina_b) {
            $data11 = $data3->ustaw_date($rok_a,$miesiac_a,$dzien_a,$godzina_a,$minuta_a,true,false);
        }
       else {
            $data11 = $data3->ustaw_date($rok_a,$miesiac_a,$dzien_a,$godzina_a,$minuta_a,false,false);
        }
        
      
        $data22 = $data3->ustaw_date($rok_b,$miesiac_b,$dzien_b,$godzina_b,$minuta_b,false,true);
  
        $ostatnia_godzina = $data3->sprawdz_czy_dany_nastroj_sen_nie_nanosi_sie_na_poprzedni_nastroj($data11,$data22);
        $wynik = $data3->sprawdz_date($rok_a,$miesiac_a,$dzien_a,$godzina_a,$minuta_a,false);
        $wynik2 = $data3->sprawdz_date($rok_b,$miesiac_b,$dzien_b,$godzina_b,$minuta_b,true,false);
  
        //sprawdza czy pierwsza data jest większa od drugiej
        $wynik3 = $data3->porownaj_dwie_daty($rok_a,$rok_b,$miesiac_a,$miesiac_b,$dzien_a,$dzien_b,$godzina_a,$godzina_b,$minuta_a,$minuta_b);
  
        //sprawdza czy leki są dokładnie uzupełnione i też sprawdza poprawność daty lekow
        $wynik4 = $this->sprawdz_leki($leki,$leki2,$leki3,$leki_rok,$leki_godzina,$data3->data1,$data3->data2);
        //sprawdza czy dawke jest liczbą
        $wynik5 = $this->sprawdz_dawke_leku($leki2);
        
        //sprawdza czy nazwa ma określoną długośc znakow
        $wynik6 = $this->sprawdz_nazwe_leku($leki);
        
        $data1 = $rok_a . "-" . $miesiac_a . "-" . $dzien_a . " " . $godzina_a . ":" . $minuta_a . ":00";
        $data2 = $rok_b . "-" . $miesiac_b . "-" . $dzien_b . " " . $godzina_b . ":" . $minuta_b . ":00";
        if ($ostatnia_godzina == false) {
        
            $bool=true;
            $bledy[$i] = "Dane któregos nastroju pokładają się z datą poprzedniego nastroju";
            $i++;  
        }
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
        if ($wynik4 == -6) {
             $bool=true;
            $bledy[$i] = "Jakiś lek nie jest w podanym przedziale czasowym";
            
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
        if ($wynik3 == -5) {
            $bool = true;
            $bledy[$i] = "Przedział czasowy musi sie mieścić w granicach 14 godzin";
            $i++;  
        }
        if ($bool == true) {
        
           return Redirect('glowna')->withInput()->withErrors($bledy);
        
        }
        else {
           //ustawia datę czyli z 2018 i 01 i 01 robi 2018-01-01
           $data = $data3->ustaw_date($rok_a,$rok_b,$miesiac_a,$miesiac_b,$dzien_a,$dzien_b,$godzina_a,$godzina_b,$minuta_a,$minuta_b);
           $nastroj_dnia = $this->oblicz_sume_nastrojow_dla_danego_przedzialu($data11,$data22,$nastroj);
           //$id_dnia = $this->zapisz_poziom_nastroju_dla_danego_dnia($data11,$nastroj_dnia);
        
           $id = $this->dodaj_nowy_nastroj($data11,$data22,$nastroj,$lek,$zdenerowanie,$co_robilem,$psychotyczne,$pobudzenie);
           
        
           if ($wynik4 != 1) {
            //dodaje do bazy nowe leki
            $this->dodaj_nowe_leki($leki,$leki2,$leki3,$leki_rok,$leki_godzina,$id);
           }
           return back()->withInput()->with(true);
           
        }
        
    }
    private function dodaj_nowe_leki($leki,$leki2,$leki3,$leki_rok,$leki_godzina,$id) {
        $data3 = new \App\Http\Controllers\data();
        $daty_lekow = array();
        $wynik  = array();
        $id3 = array();
        for ($i=0;$i < count($leki_rok);$i++) {
        
            if (strstr($leki_rok[$i],"-") ) {
                $leki_tymcza = explode("-",$leki_rok[$i]);
                $leki_rok2[$i] = $leki_tymcza[0];
                $leki_miesiac[$i] = $leki_tymcza[1];
                $leki_dzien[$i] = $leki_tymcza[2];
            }
            else {
                $leki_rok2[$i] = "";
                $leki_miesiac[$i] = "";
                $leki_dzien[$i] = "";
            }
            if ( strstr($leki_godzina[$i],":") ) {
                $leki_tymcza2 = explode(":",$leki_godzina[$i]);
                $leki_godzina2[$i] = $leki_tymcza2[0];
                $leki_minuta[$i] = $leki_tymcza2[1];
                
            }
            $daty_lekow[$i] = $data3->ustaw_date($leki_rok2[$i],$leki_miesiac[$i],$leki_dzien[$i],$leki_godzina2[$i],$leki_minuta[$i]);
            $wynik[$i] = $this->sprawdz_czy_dodawac_lek($leki[$i],$leki2[$i]);
            if ($wynik[$i] == -1) {
                $id2 = $data3->dodaj_pojedynczy_lek($leki[$i],$leki2[$i],$leki3[$i],$daty_lekow[$i]);
                    $id3[$i] = $id;
                    $data3->dodaj_przekierowanie_leku($id2,$id);
            }
        }
        
    }
    /*
    private function zapisz_poziom_nastroju_dla_danego_dnia($data11,$nastroj_dnia) {
        $id_user = Auth::User()->id;
        $data = explode(" ",$data11);
        $dni_nastrojow = DB::select("select nastroj,data,liczba_sekund from dni_nastrojow where id_dnia = '$id_user' and data = '$data[0]' ");
        foreach ($dni_nastrojow as $dni_nastrojow2) {}
        
        if (empty($dni_nastrojow2->data) ) {
            DB::insert("insert into dni_nastrojow(nastroj,data,id_dnia) values('$nastroj_dnia[0]','" . $data[0] . "','$id_user')");
        }
        else {
            
            DB::table('dni_nastrojow')
            ->where('id_dnia', $id_user)->where('data',$data[0])
            ->update(['nastroj' => $nastroj_dnia[0] + $dni_nastrojow2->nastroj],['liczba_sekund'=> $nastroj_dnia[1] + $dni_nastrojow2->liczba_sekund]);
        }
        $jakie_id = DB::select("select id from dni_nastrojow where id_dnia = '$id_user' order by id desc limit 1 ");
        foreach ($jakie_id as $jakie_id2) {}
        
        return $jakie_id2->id;
    }
    */
    private function oblicz_sume_nastrojow_dla_danego_przedzialu($godzina_zaczecia,$godzina_zakonczenia,$poziom) {
        
        $wynik  = strtotime($godzina_zaczecia);
        $wynik2 = strtotime($godzina_zakonczenia);
        $wynik3 = $wynik2 - $wynik;
        
            $wynik4 = ($wynik3 * $poziom);
            
        
        return array($wynik4,$wynik3);
        
        
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
        
        if ($psychotyczne == "") $psychotyczne = 0;
        $id_users = Auth::User()->id;
        DB::insert("insert into 
        nastroj  (godzina_zaczecia,godzina_zakonczenia,id_users,poziom_nastroju,co_robilem,poziom_leku,poziom_zdenerwania,epizod_psychotyczne,pobudzenie ) 
        values('$data1','$data2','$id_users','$nastroj','$co_robilem','$lek','$zdenerowanie','$psychotyczne','$pobudzenie')");
        $id = DB::select("select id from nastroj where id_users = '$id_users' order by id DESC limit 1");
        foreach ($id as $id2) {}
       
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
        if ($leki == "" and $leki2 == "") return 0;
        return -1;
        
    }
    private function sprawdz_leki($leki,$leki2,$leki3,$leki_rok,$leki_godzina,$data1,$data2) {
        $data3 = new \App\Http\Controllers\data();
        
        for ($i=0;$i < count($leki_rok);$i++) {
            if (strstr($leki_rok[$i],"-") ) {
                $leki_tymcza = explode("-",$leki_rok[$i]);
                $leki_rok2[$i] = $leki_tymcza[0];
                $leki_miesiac[$i] = $leki_tymcza[1];
                $leki_dzien[$i] = $leki_tymcza[2];
            }
            else {
                $leki_rok2[$i] = "";
                $leki_miesiac[$i] = "";
                $leki_dzien[$i] = "";
            }
            if ( strstr($leki_godzina[$i],":") ) {
                $leki_tymcza2 = explode(":",$leki_godzina[$i]);
                $leki_godzina2[$i] = $leki_tymcza2[0];
                $leki_minuta[$i] = $leki_tymcza2[1];
                
            }
            else return -7;
            
            if ($leki[$i] == "" xor $leki2[$i] == "" ) return -5;
            else if ($leki[$i] != "" or $leki2[$i] != "") {
                $wynik[$i] = $data3->sprawdz_date($leki_rok2[$i],$leki_miesiac[$i],$leki_dzien[$i],$leki_godzina2[$i],$leki_minuta[$i]);
                $wynik2[$i] = $data3->sprawdz_czy_dany_lek_jest_w_danym_przedziale_czasowym($leki_rok2[$i],$leki_miesiac[$i],$leki_dzien[$i],$leki_godzina2[$i],$leki_minuta[$i],$data1,$data2);
                if ($wynik[$i] == -1 or $wynik[$i] == -2 or $wynik[$i] == -3 or $wynik[$i] == -4) return $wynik[$i];
                else if ($wynik2[$i] == -6) return -6;
            }
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
