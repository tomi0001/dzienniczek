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
   use PDF;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class Controller_strona extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    
    public $wpisy = array();
    public $wpisy2 = array();

    public function generate_pdf() {
            if (substr_count(Input::get("rok_aa"),"-") != 2 or substr_count(Input::get("rok_bb"),"-") != 2 ) {
                  return Redirect('blad')->with('login_error','zły format daty');
            }
            $data1 = explode("-",Input::get("rok_aa"));
            $data2 = explode("-",Input::get("rok_bb"));
            
            $sprawdz  = checkdate($data1[1], $data1[2], $data1[0]);
            $sprawdz2 = checkdate($data2[1], $data2[2], $data2[0]);
            
            if ($sprawdz == false or $sprawdz2 == false) {
                return Redirect('blad')->with('login_error','Data nieprawidłowa');
            }
            else {
                $tablica = $this->wyciagnij_dane_pdf(Input::get("rok_aa"),Input::get("rok_bb"),false);
            }
            
	    $pdf = PDF::loadView('welcome',compact('tablica'));
	    return $pdf->stream();
    }
    
    
    
    
    private function wyciagnij_dane_pdf($data1,$data2,$co_robilem = true) {
      $id_users = Auth::User()->id;
      $zapytanie = DB::select("select godzina_zaczecia,godzina_zakonczenia,poziom_nastroju,co_robilem,poziom_leku,poziom_zdenerwania,epizod_psychotyczne,pobudzenie from nastroj where godzina_zaczecia >= '$data1' and godzina_zaczecia <= '$data2' and id_users = '$id_users' order by godzina_zaczecia");
      $zapytanie3 = array();
      $i = 0;
      foreach ($zapytanie as $zapytanie2) {
	  $zapytanie3[$i][0] = $zapytanie2->godzina_zaczecia;
	  $zapytanie3[$i][1] = $zapytanie2->godzina_zakonczenia;
	  $zapytanie3[$i][2] = $zapytanie2->poziom_nastroju;
	  $zapytanie3[$i][3] = $zapytanie2->poziom_leku;
	  $zapytanie3[$i][4] = $zapytanie2->poziom_zdenerwania;
	  $zapytanie3[$i][5] = $zapytanie2->epizod_psychotyczne;
	  $zapytanie3[$i][6] = $zapytanie2->pobudzenie;
	  if ($co_robilem == true) {
	    $zapytanie3[$i][7] = $zapytanie2->co_robilem;
	  }
	  else {
	    $zapytanie3[$i][7] = null;
	  }
	$data1 = explode(" ",$zapytanie2->godzina_zaczecia);
	$zapytanie3[$i][8] = $data1[0];
	if ($i == 0 or $zapytanie3[$i][8] > $zapytanie3[$i-1][8]) {
          $data22 = explode("-",$data1[0]);
          $tmp = $this->oblicz_ile_czasu_trwaly_nastroje_danego_dnia($data22[0], $data22[1], $data22[2], "poziom_nastroju");
          $zapytanie3[$i][10] = round((($tmp[1] / $tmp[0] )),2);
	  $zapytanie3[$i][9] = $data1[0];
	}
	else {
	  $zapytanie3[$i][9] = null;
	}
	$i++;
      }
      return $zapytanie3;
    }
    
    
    public function glowna($rok = "",$miesiac = "",$dzien = "",$akcja = "") {
	//$a = array();
	
	//var_dump($a);
	//$this->generate_pdf();
        $data3 = new \App\Http\Controllers\data();

        //zmienna potrzebna do przechowywania ustawień zmiennych aktualnie wykonywanych do ustawień miesiąca
        $date = array();

        if (Auth::check()) {
	
        //to jest ta zmienna
        $date = $this->ustaw_date($miesiac,$akcja,$dzien,$rok);
        //zmienna potrzeba do tego, żeby zaznaczyć dzień miesiaca w kalendarzu
        $dzien3 = 0;
          //jeżeli była akcja wstecz to do zmiennej $dzien3 przypisz poprzedni miesiac
        $dzien1 = 1;
                 
        $dzien2 = 1;
          if ($date[4] == "wstecz") {
            $dzien3 = $this->sprawdz_miesiac($date[0],$date[1]);
           // $dzien3 = $dzien2;
            $dzien = $dzien3;
            $date[2] = $this->sprawdz_miesiac($date[0],$date[1]);
           
          }
          if ($date[4] == "dalej")  {
            $dzien3 = 1;
          }
          print $date[3];
          //zmienne drukujące poprzedniego miesiąca i nastepnego
        $poprzedni = $this->zwroc_poprzedni_miesiac($date[0],$date[1]);
        $nastepny = $this->zwroc_nastepny_miesiac($date[0],$date[1]);
        $jaki_dzien_miesiaca = $this->sprawdz_miesiac($date[0],$date[1]);

        $miesiac2 = $this->zwroc_miesiac_text($date[0]);
        $tablica_godzin3 = array();
  
            //$rok_zaczecia = $data3->rok_zaczecia(Auth::User()->id);
            $sprawdz = $this->wyciagnij_godzine_ostatniego_wpisu(Auth::User()->id);
            if ($sprawdz == 0) {
                $tablica_godzin2 = $data3->rysuj_dla_godziny(date("H"),1);
                $tablica_godzin = $data3->rysuj_dla_godziny(date("H"),1);
                $tablica_minut2 = $data3->rysuj_dla_minuty();
        
            }
            else {
            
                $tablica_godzin2 = $data3->rysuj_dla_godziny($sprawdz[0],3);
                $tablica_godzin = $data3->rysuj_dla_godziny(date("H"),1);
                $tablica_minut2 = $data3->rysuj_dla_minuty($sprawdz[1]);
        
            }
            
            $tablica_godzin3 = $data3->rysuj_dla_godziny(date("H"),0);
            $tablica_godzin4 = $data3->rysuj_dla_godziny(date("H"),2);
            $tablica_minut = $data3->rysuj_dla_minuty();
            $godziny = $tablica_godzin2 . ":" . $tablica_minut2 . ":00";
            $godziny2 = $tablica_godzin . ":" . $tablica_minut . ":00";
            $godziny3 = $tablica_godzin3 . ":" . $tablica_minut . ":00";
            
            $godziny4 = $tablica_godzin4 . ":" . $tablica_minut . ":00";
            
            $wynik = $this->wyciagnij_dane("poziom_nastroju",$date[1],$date[0]);
            
            $wynik2 = $this->wyciagnij_dane("poziom_nastroju",$date[1],$date[0],$date[2]);
            $wynik3 = $this->wyciagnij_dane("poziom_leku",$date[1],$date[0],$date[2]);
            $wynik4 = $this->wyciagnij_dane("poziom_zdenerwania",$date[1],$date[0],$date[2]);
            $wynik5 = $this->wyciagnij_dane("pobudzenie",$date[1],$date[0],$date[2]);
             
           
            $this->wybierz_nastroj_sen($date[1],$date[2],$date[0],true,true);
            $this->wpisy = $data3->okresl_dlugosc_daty_w_procentach($this->wpisy);
            $this->okres_kolor_dla_diva();
            $ilosc_nastrojow = count($this->wpisy);
	    //$a = $this->generate_pdf();
	    //var_dump($this->wpisy2);
            return View('glowna')->with('miesiac',$date[0])
            ->with('miesiac2',$miesiac2)
            ->with('rok',$date[1])
            ->with('jaki_dzien_miesiaca',$jaki_dzien_miesiaca)
            ->with('dzien',$date[2])
            ->with('dzien1',$dzien1)
            ->with('dzien_tygodnia',$date[3])
            ->with('dzien3',$dzien3)
            ->with('dzien2',$dzien2)
            ->with('dzien4',1)
            ->with('nastepny',$nastepny)
            ->with('poprzedni',$poprzedni)
            ->with('tablica_godzin',$godziny2)
            ->with('tablica_godzin2',$godziny)
            ->with('tablica_minut',$tablica_minut)
            ->with('tablica_minut2',$tablica_minut2)
            ->with('tablica_godzin3',$godziny3)
            ->with('tablica_godzin4',$godziny4)
            ->with('wpisy',$this->wpisy)
            ->with('wynik',$wynik)
            ->with('ilosc_nastrojow',$ilosc_nastrojow)
            ->with('wynik2',$wynik2)
            ->with('wynik3',$wynik3)
            ->with('wynik4',$wynik4)
            ->with('wynik5',$wynik5)
            ->with("godzina",false);
        }   
        else {
            return Redirect('blad')->with('login_error','Nie masz dostępu do tej części strony');
        }
        
    }
    


    private function okres_kolor_dla_diva() {
        for($i=0;$i < count($this->wpisy);$i++) {
            if ($this->wpisy[$i][1] >= -20 and $this->wpisy[$i][1] <= -16) $this->wpisy[$i][12] = "div1";
            else if ($this->wpisy[$i][1] > -16 and $this->wpisy[$i][1] <= -12) $this->wpisy[$i][12] = "div2";
            else if ($this->wpisy[$i][1] > -12 and $this->wpisy[$i][1] <= -9) $this->wpisy[$i][12] = "div3";
            else if ($this->wpisy[$i][1] > -9 and $this->wpisy[$i][1] <= -6) $this->wpisy[$i][12] = "div4";
            else if ($this->wpisy[$i][1] > -6 and $this->wpisy[$i][1] <= -3) $this->wpisy[$i][12] = "div5";
            else if ($this->wpisy[$i][1] > -3 and $this->wpisy[$i][1] < 0) $this->wpisy[$i][12] = "div6";
            else if ($this->wpisy[$i][1] == 0) $this->wpisy[$i][12] = "div7";
            else if ($this->wpisy[$i][1] > 0 and $this->wpisy[$i][1] <= 4) $this->wpisy[$i][12] = "div8";
            else if ($this->wpisy[$i][1] > 4 and $this->wpisy[$i][1] <= 7) $this->wpisy[$i][12] = "div9";
            else if ($this->wpisy[$i][1] > 7 and $this->wpisy[$i][1] <= 10) $this->wpisy[$i][12] = "div10";
            else if ($this->wpisy[$i][1] > 10 and $this->wpisy[$i][1] <= 14) $this->wpisy[$i][12] = "div11";
            else if ($this->wpisy[$i][1] > 14 and $this->wpisy[$i][1] <= 20) $this->wpisy[$i][12] = "div12";
            else $this->wpisy[$i][12] = "div13";
        }
        
    }
    private function wyciagnij_dane_dla_poszczegolnego_dnia_nastroju($dzien,$rok,$miesiac) {
        $id_users = Auth::User()->id;
        $poszczegolne_dane = DB::select("select nastroj,data from dni_nastrojow where year(data) = '$rok'  and month(data) = '$miesiac' and day(data)=  '$dzien' and id_dnia = '$id_users' order by data");
        foreach ($poszczegolne_dane as $poszczegolne_dane2) {
            
        }
        $wynik = $this->oblicz_ile_czasu_trwaly_nastroje_danego_dnia($rok,$miesiac,$dzien);
        //print "<font color=green>" . $poszczegolne_dane2->nastroj . "</font>";
        if (empty($poszczegolne_dane2->nastroj) ) return null;
        else return (int)round(( $wynik[1] / $wynik[0] ));
    }
    private function oblicz_ile_czasu_trwaly_nastroje_danego_dnia($rok,$miesiac,$dzien,$typ) {
        $id_users = Auth::User()->id;
        $nastroje = array();
        $wynik = 0;
        $wynik2 = 0;
        $wynik5 = 0;
        $poszczegolne_dane = DB::select("select godzina_zaczecia,godzina_zakonczenia,$typ from nastroj 
        where year(godzina_zaczecia) = '$rok'  and 
        month(godzina_zaczecia) = '$miesiac' and 
        day(godzina_zaczecia) = '$dzien'  and 
        id_users = '$id_users'");
        foreach ($poszczegolne_dane as $poszczegolne_dane2) {
            $wynik2 = strtotime($poszczegolne_dane2->godzina_zaczecia);
            $wynik3 = strtotime($poszczegolne_dane2->godzina_zakonczenia);
            $wynik4 = $wynik3 - $wynik2;
            $wynik5 = $wynik5 + ($wynik4 * $poszczegolne_dane2->$typ);
            $wynik += $wynik4;
            
        }
        return array($wynik,$wynik5);
    }
    private function wyciagnij_dane($typ,$rok,$miesiac,$dzien="") {
        $id_users = Auth::User()->id;
        $dane_nastrojow2 = array();
        if ($dzien != "") {
            
            $j = $dzien;
            $k = $dzien;
        }
        else {
            $j = 0;
            $k = 31;
        }
        $m = 0;
        for ($i=$j;$i <= $k;$i++) {

                $wynik = $this->oblicz_ile_czasu_trwaly_nastroje_danego_dnia($rok,$miesiac,$i,$typ);
                    if ($wynik[0] == 0) {
                        $dane_nastrojow2[$m][0] = 23;
                        //
                    }
                    else {
                        //print "kupa";
                        $dane_nastrojow2[$m][0] = round((($wynik[1] / $wynik[0] )),2);
                    }
                $dane_nastrojow2[$m][1] = $this->wybierz_kolor_dla_dnia($dane_nastrojow2[$m][0]);
            $m++;
            
        }
        
        return $dane_nastrojow2;

    }
    
    private function wybierz_kolor_dla_dnia($liczba) {
        //print $liczba;
        
        
        if ($liczba > 22) return "div11 opacity";
        else if ($liczba >= -20 and $liczba < -12) return  "div2 radios";
        else if ($liczba > -12 and $liczba <= -9) return "div3 radios";
        else if ($liczba > -9 and $liczba <= -6) return "div4 radios";
        else if ($liczba > -6 and $liczba <= -3) return "div5 radios";
        else if ($liczba > -3 and $liczba <= -1) return "div6 radios";
        else if ($liczba > -1 and $liczba < 0) return "div16 radios";
        else if ($liczba >= 0  and $liczba < 0.29) return  "div14 radios";
        else if ($liczba >= 0.29  and $liczba < 0.75) return  "div17 radios";
        else if ($liczba >= 0.75 and $liczba <= 1) return  "div8 radios";
        else if ($liczba >= 1 and $liczba <= 2) return  "div18 radios";
        else if ($liczba > 2 and $liczba <= 4) return "div15 radios";
        else if ($liczba > 4 and $liczba < 7) return  "div9 radios";
        else if ($liczba > 7 and $liczba < 10) return  "div10 radios";
        else if ($liczba > 10 and $liczba < 14) return  "div20 radios";
        else if ($liczba > 14 and $liczba <= 20) return "div12 radios";
        

        else  return "div11 opacity";
    
    }
    
    private function oblicz_sume_nastrojow_dla_danego_przedzialu($godzina_zaczecia,$godzina_zakonczenia,$poziom) {
        $wynik  = strtotime($godzina_zaczecia);
        $wynik2 = strtotime($godzina_zakonczenia);
        $wynik3 = $wynik2 - $wynik;
        if($poziom > 0) {
            $wynik4 = ($wynik3 * $poziom);
        }
        else {
            $wynik4 = ($wynik3 * $poziom);
        }
        return array($wynik4,$wynik3);
        
    }
    private function wybierz_nastroj_sen($rok,$dzien,$miesiac,$czy_nastroj = "",$czy_sen = "") {
        $data = new \App\Http\Controllers\data();
        $id_users = Auth::User()->id;
        $data1  = $rok . "-" . $miesiac . "-" . $dzien;
        $data1 .= " 23:59:00";
        $data2 = strtotime($data1);
        
        $data2 = $data2 -  86400;
        $data3 = date("Y-m-d",$data2);
        $data3 .= " 15:00:00";
        $data4= explode("-",$data3);
        $nastroj3 = array();
        if ($czy_nastroj == true) {
	    $nastroj = DB::select("select godzina_zaczecia,poziom_nastroju,id,godzina_zakonczenia,co_robilem,poziom_leku,poziom_zdenerwania,epizod_psychotyczne,pobudzenie from nastroj where 
	    year(godzina_zaczecia) = '$rok'  
	    and month(godzina_zaczecia) = '$miesiac'
	    and day(godzina_zaczecia) = '$dzien' 
	    and id_users = '$id_users' 
	    order by godzina_zaczecia ASC");
	    $i = 0;
	    foreach ($nastroj as $nastroj2) {
		$nastroj3[$i][0] = $nastroj2->godzina_zaczecia;
		$nastroj3[$i][1] = $nastroj2->poziom_nastroju;
		$nastroj3[$i][2] = $nastroj2->godzina_zakonczenia;
		$nastroj3[$i][3] = $nastroj2->id;
		$nastroj3[$i][4] = $data->oblicz_ilosc_minut_i_godzin2($nastroj3[$i][0],$nastroj3[$i][2]);
		$nastroj3[$i][5] = $nastroj2->poziom_leku;
		$nastroj3[$i][6] = $nastroj2->poziom_zdenerwania;
		$nastroj3[$i][7] = $nastroj2->epizod_psychotyczne;
		$nastroj3[$i][8] = $nastroj2->pobudzenie;
		$nastroj3[$i][9] = $data->sprawdz_czy_bralem_leki_dla_danego_dnia($nastroj2->id);
		$nastroj3[$i][13] = $data->sprawdz_czy_cos_robilem($nastroj2->id);
		$i++;
		
	    }
        }
        if ($czy_sen == true) {
	    $sen3 = array();
	    $sen = DB::select("
	    select data_rozpoczecia,ilosc_wybudzen,data_zakonczenia,id from sen where data_rozpoczecia >= '$data3' AND data_rozpoczecia  <= '$data1'  and id_users = '$id_users' order by data_rozpoczecia ASC 
	    
	    ");
	    $i = 0;
	    foreach ($sen as $sen2) {
		$sen3[$i][0] = $sen2->data_rozpoczecia;
		$sen3[$i][1] = $sen2->ilosc_wybudzen;
		$sen3[$i][2] = $sen2->data_zakonczenia;
		$sen3[$i][3] = $sen2->id;
		$sen3[$i][4] = $data->oblicz_ilosc_minut_i_godzin2($sen3[$i][0],$sen3[$i][2]);
		$sen3[$i][5] = -21;
		$i++;        
	    }
        }
        $this->sortuj_wpisy($nastroj3,$sen3);
    }
    
    private function uporzadkuj_dane() {
        $data = new \App\Http\Controllers\data();
        $tablica = $this->wpisy;

        for ($i=0;$i < count($tablica);$i++) {
           $wynik =  $data->oblicz_jaki_jest_dzien($tablica[$i][0],$tablica[$i][2]);
           
	    $this->wpisy[$i][10] = $wynik[0];
	    $this->wpisy[$i][11] = $wynik[1];
           
        }

    }
    
    private function sortuj_wpisy($tablica1,$tablica2) {
        $nowa_tablica = array();
        $i = 0;
        while ($i < count($tablica1)) {
            $nowa_tablica[$i][0] = $tablica1[$i][0];
            $nowa_tablica[$i][1] = $tablica1[$i][1];
            $nowa_tablica[$i][2] = $tablica1[$i][2];
            $nowa_tablica[$i][3] = $tablica1[$i][3];
            $nowa_tablica[$i][4] = $tablica1[$i][4];
            $nowa_tablica[$i][5] = $tablica1[$i][5];
            $nowa_tablica[$i][6] = $tablica1[$i][6];
            $nowa_tablica[$i][7] = $tablica1[$i][7];
            $nowa_tablica[$i][8] = $tablica1[$i][8];
            $nowa_tablica[$i][9] = $tablica1[$i][9];
            $nowa_tablica[$i][13] = $tablica1[$i][13];
            $i++;
        }
        $j = 0;
        
        while ($j < count($tablica2) ) {
            $nowa_tablica[$i][0] = $tablica2[$j][0];
            $nowa_tablica[$i][1] = $tablica2[$j][1];

            $nowa_tablica[$i][2] = $tablica2[$j][2];
            $nowa_tablica[$i][3] = $tablica2[$j][3];
            $nowa_tablica[$i][4] = $tablica2[$j][4];
            $nowa_tablica[$i][5] = $tablica2[$j][5];
            $nowa_tablica[$i][6] = 0;
            $nowa_tablica[$i][7] = 0;
            $nowa_tablica[$i][8] = 0;
            $nowa_tablica[$i][9] = 0;
            $nowa_tablica[$i][13] = 0;
            $i++;
            $j++;
        }
        array_multisort($nowa_tablica,SORT_ASC);
	
	$this->wpisy = $nowa_tablica;
        
        $this->uporzadkuj_dane();
    
    
    }
 
    private function wyciagnij_godzine_ostatniego_wpisu($id_users) {
        $wpis = DB::select("SELECT godzina_zakonczenia FROM `nastroj` where id_users = '$id_users' order by godzina_zakonczenia DESC limit 1");
        foreach ($wpis as $wpis2) {}
       // print $wpis2->godzina_zakonczenia;
        $sen = DB::select("SELECT data_zakonczenia FROM `sen` where id_users = '$id_users' order by data_zakonczenia DESC limit 1");
        foreach ($sen as $sen2) {}
        if (empty($wpis2->godzina_zakonczenia) ) return 0;
        else {
            if ( isset($sen2->data_zakonczenia) and strtotime($sen2->data_zakonczenia) > strtotime($wpis2->godzina_zakonczenia)) {
                    $podziel_wpis = explode(" ",$sen2->data_zakonczenia);
                    $podziel_wpis2 = explode(":",$podziel_wpis[1]);
            }
            else {

            $podziel_wpis = explode(" ",$wpis2->godzina_zakonczenia);
            $podziel_wpis2 = explode(":",$podziel_wpis[1]);
            }

            return array($podziel_wpis2[0],$podziel_wpis2[1]);
        }
        
        
    }
    
    //funkcja rysuje poszeczegolne godziny 
    /*
    private function rok_zaczecia($id_user)  {
        $tablica = array();
        $najmlodszy_rok = DB::select("select data_dodania from dziennik where id_users = '$id_user' order by data_dodania limit 1");
        foreach ($najmlodszy_rok as $najmlodszy_rok2) {
            
        }
        if (empty($najmlodszy_rok2->data_dodania) ) $data_dodania = date("Y");
        else $data_dodania = $najmlodszy_rok2->data_dodania;
        $i = $data_dodania;
        $j = 0;
        while ($i <= date("Y")) {
            $tablica[$j] = $i;
            $i++;
            $j++;
        }
        
        return $tablica;
    }
    */
    private function dodaj_nastroj($godzina_zaczecia,$godzina_zakonczenia,$co_robilem,$poziom_nastroju,$poziom_leku,$epizody_psychotyczne) {
    
    }
       private function zwroc_miesiac_text($miesiac) {
    
    switch($miesiac) {
      case 1 : return "Styczeń";
      case 2 : return "Luty";
      case 3 : return "Marzec";
      case 4 : return "Kwiecień";
      case 5 : return "Maj";
      case 6 : return "Czerwiec";
      case 7 : return "Lipiec";
      case 8 : return "Sierpień";
      case 9 : return "Wrzesień";
      case 10 : return "Październik";
      case 11: return "Listopad";
      case 12 : return "Grudzień";
    }

  }
    
    private function zwroc_poprzedni_miesiac($miesiac,$rok) {
    if ($miesiac == 1) {
      $rok--;
      $miesiac = 12;
    }
    else {
      $miesiac--;
    }
    return array($rok,$miesiac);
  }

  private function zwroc_nastepny_miesiac($miesiac,$rok) {
    if ($miesiac == 12) {
      $rok++;
      $miesiac = 1;
    }
    else {
      $miesiac++;
    }
    return array($rok,$miesiac);
  }
    private function oblicz_nastroj($rok,$miesiac) {
        //$data_pocztakowa = $rok
        $id_users = Auth::User()->id;
        $nastroj = array();
        $baza_nastrojow = DB::select("SELECT poziom_leku,poziom_nastroju  FROM `nastroj` WHERE YEAR(data) = '$rok' and month(data) = '$miesiac' and id_users = '$id_users' ");
        $nastroj[0][0] = 10;
        $nastroj[0][1] = "";
        
        
    }
    

    
        private function ustaw_date($miesiac,$akcja,$dzien,$rok) {
            
 
            if (empty($miesiac) ) {
                $miesiac = date("m");
                $rok = date("Y");
            }
            
            if ( empty($dzien) and empty($akcja) ) {
                $dzien = date("d");
            }
            else {
                if ( !empty($dzien) ) {
                    $dzien = $dzien;
                }

            }

            if ( !empty($rok) or  !empty($miesiac)) {

                $dzien_tygodnia = $this->ustal_dzien_tygodnia("$rok-$miesiac-1");
            }
            else {
                $rok = date("Y");
                $miesiac = date("m");
                $dzien_tygodnia = $this->ustal_dzien_tygodnia("Y-m-1");
            }

        
            if ($dzien_tygodnia == 0) {
                $dzien_tygodnia = 7;
            }
            
            return array($miesiac,$rok,$dzien,$dzien_tygodnia,$akcja);
    }
    
    
      private function ustal_dzien_tygodnia($data) {
        return date("w",strtotime($data));
      }
        private function sprawdz_miesiac($miesiac,$rok) {

            if ($miesiac == 12) {
            return 31;
            }
            else if ($miesiac == 11) {
            return 30;
            }
            else if ($miesiac == 10) {
            return 31;
            }
            else if ($miesiac == 9) {
            return 30;
            }
            else if ($miesiac == 8) {
            return 31;
            }
            else if ($miesiac == 7) {
            return 31;
            }
            else if ($miesiac == 6) {
            return 30;
            }
            else if ($miesiac == 5) {
            return 31;
            }
            else if ($miesiac == 4) {
            return 30;
            }
            else if ($miesiac == 3) {
            return 31;
            }
            else if ($miesiac == 2) {

            if ( $this->czy_przystepny($rok) == 1) {
                return 29;
            }
            else {
                return 28;
            }

            }
            else if ($miesiac == 1) {
            return 31;
            }


  }
  
  private function czy_przystepny($rok)
  {
       return (($rok%4 == 0 && $rok%100 != 0) || $rok%400 == 0);
  }
    
}
