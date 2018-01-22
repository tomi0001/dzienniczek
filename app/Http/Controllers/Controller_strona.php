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
class Controller_strona extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    public $wpisy;
    public function glowna($rok = "",$miesiac = "",$dzien = "",$akcja = "") {
        //zmienna potrzebna do przechowywania ustawień zmiennych aktualnie wykonywanych do ustawień miesiąca
        $date = array();
        
        if (Auth::check()) {
   
        //to jest ta zmienna
        $date = $this->ustaw_date($miesiac,$akcja,$dzien,$rok);
        //zmienna potrzeba do tego, żeby zaznaczyć dzień miesiaca w kalendarzu
        $dzien3 = 0;
          //jeżeli była akcja wstecz to do zmiennej $dzien3 przypisz poprzedni miesiac
          if ($date[4] == "wstecz") {
            $dzien3 = $this->sprawdz_miesiac($date[0],$date[1]);
          }
          if ($date[4] == "dalej")  {
            $dzien3 = 1;
          }
          //zmienne drukujące poprzedniego miesiąca i nastepnego
        $poprzedni = $this->zwroc_poprzedni_miesiac($date[0],$date[1]);
        $nastepny = $this->zwroc_nastepny_miesiac($date[0],$date[1]);
            $jaki_dzien_miesiaca = $this->sprawdz_miesiac($date[0],$date[1]);
        //print $date[3];
        //licznik
          $dzien1 = 1;
            $dzien2 = 1;
            //$dzien3 = "";
    $miesiac2 = $this->zwroc_miesiac_text($date[0]);
  //if (!empty($date[4]) ) {
    //if ($date[4] == "wstecz") {
      //$day3 = $this->sum_how_day_month($date[0],$date[1]);
      //$_GET["dzien"] = $dzien3;
    //}
    //if ($date[4] == "dalej")  {
      
      //$_GET["dzien"] = 1;
    //}
    //$date[2] = $day3;
  //}
  $tablica_godzin3 = array();
            $rok_zaczecia = $this->rok_zaczecia(Auth::User()->id);
            $sprawdz = $this->wyciagnij_godzine_ostatniego_wpisu(Auth::User()->id);
            if ($sprawdz == 0) {
                $tablica_godzin2 = $this->rysuj_dla_godziny(date("H"),1);
                $tablica_godzin = $this->rysuj_dla_godziny(date("H"),1);
                $tablica_minut2 = $this->rysuj_dla_minuty();
                //print 'dobrze';
            }
            else {
                $tablica_godzin2 = $this->rysuj_dla_godziny($sprawdz[0],3);
                $tablica_godzin = $this->rysuj_dla_godziny(date("H"),1);
                $tablica_minut2 = $this->rysuj_dla_minuty($sprawdz[1]);
                //var_dump($sprawdz);
                //print $sprawdz[0];
                //print 'dobrzeddd';
            }
            
            $tablica_godzin3 = $this->rysuj_dla_godziny(date("H"),0);
            $tablica_godzin4 = $this->rysuj_dla_godziny(date("H"),2);
            //print $tablica_godzin3;
            $tablica_minut = $this->rysuj_dla_minuty();
            $wynik = $this->wyciagnij_dane("poziom_nastroju",$date[1],$date[2],$date[0]);
            //print "<br>" . $wynik;
            //if (empty($bledy)) $bledy = "tomke";
            //print );
            //print "tablica godzin=";
            //var_dump($tablica_godzin);
            //print "tablica godzin2=";
            //print $date[2];
            //$this->wybierz_nastroj_sen($date[1],$date[2],$date[0]);
            //print $date[2];
            //print $dzien;
            $this->wybierz_nastroj_sen($date[1],$date[2],$date[0]);
            //var_dump($tablica_godzin);
            return View('glowna')->with('miesiac',$date[0])->with('miesiac2',$miesiac2)->with('rok',$date[1])->with('jaki_dzien_miesiaca',$jaki_dzien_miesiaca)->with('dzien',$date[2])->with('dzien1',$dzien1)->with('dzien_tygodnia',$date[3])->with('dzien3',$dzien3)->with('dzien2',$dzien2)->with('dzien4',1)->with('nastepny',$nastepny)->with('poprzedni',$poprzedni)->with('rok_zaczecia',$rok_zaczecia)->with('tablica_godzin',$tablica_godzin)->with('tablica_godzin2',$tablica_godzin2)->with('tablica_minut',$tablica_minut)->with('tablica_minut2',$tablica_minut2)->with('tablica_godzin3',$tablica_godzin3)->with('tablica_godzin4',$tablica_godzin4)->with('wpisy',$this->wpisy);
        }
        else {
            return Redirect('blad')->with('login_error','Nie masz dostępu do tej części strony');
        }
        
    }
    
    private function wyciagnij_dane($typ,$rok,$dzien,$miesiac) {
        $id_users = Auth::User()->id;
        $dane_nastrojow = array();
        $poszczegolne_dane = DB::select("select godzina_zaczecia,godzina_zakonczenia,$typ from nastroj where year(godzina_zaczecia) = '$rok'  and month(godzina_zaczecia) = '$miesiac' and day(godzina_zaczecia) = '$dzien' and id_users = '$id_users' order by godzina_zaczecia ASC");
        $i = 0;
        $wynik2 = 0;
        $wynik3 = 0;
        foreach ($poszczegolne_dane as $poszczegolne_dane2) {
            $dane_nastrojow[$i][0] = $poszczegolne_dane2->godzina_zaczecia;
            $dane_nastrojow[$i][1] = $poszczegolne_dane2->godzina_zakonczenia;
            $dane_nastrojow[$i][2] = $poszczegolne_dane2->$typ;
            $wynik = $this->oblicz_sume_nastrojow_dla_danego_dnia($dane_nastrojow[$i][0],$dane_nastrojow[$i][1],$dane_nastrojow[$i][2]);
            //print $wynik . " " .  77 $dane_nastrojow[$i][0] . "<br>";
            $wynik2 += $wynik[0];
            $wynik3 += $wynik[1];
            $i++;
            
            
        }
        //print $wynik3;
        $wynik4 = $wynik2 - $wynik3;
        print $wynik4 . " " . $wynik3;
        return $wynik2;
        //var_dump($dane_nastrojow);
    }
    
    private function oblicz_sume_nastrojow_dla_danego_dnia($godzina_zaczecia,$godzina_zakonczenia,$poziom) {
        //for ($i=0;$i < count($typ_danych);$i++) {
        
        $wynik  = strtotime($godzina_zaczecia);
        $wynik2 = strtotime($godzina_zakonczenia);
        $wynik3 = $wynik2 - $wynik;
        
        $wynik4 = ($wynik3 * $poziom) + $wynik3;
        //print $wynik3 . "<br>" .  $wynik4 .  "<Br>";
        return array($wynik4,$wynik3);
        //}
        
        
    }
    private function wybierz_nastroj_sen($rok,$dzien,$miesiac) {
        $id_users = Auth::User()->id;
        $nastroj3 = array();
        $nastroj = DB::select("select godzina_zaczecia,poziom_nastroju,id,godzina_zakonczenia,co_robilem,poziom_leku,poziom_zdenerwania,epizod_psychotyczne,pobudzenie from nastroj where year(godzina_zaczecia) = '$rok'  and month(godzina_zaczecia) = '$miesiac' and day(godzina_zaczecia) = '$dzien' and id_users = '$id_users' order by godzina_zaczecia ASC");
        $i = 0;
        foreach ($nastroj as $nastroj2) {
            $nastroj3[$i][0] = $nastroj2->godzina_zaczecia;
            $nastroj3[$i][1] = $nastroj2->poziom_nastroju;
            $nastroj3[$i][2] = $nastroj2->godzina_zakonczenia;
            $nastroj3[$i][3] = $nastroj2->id;
            $nastroj3[$i][4] = $nastroj2->co_robilem;
            $nastroj3[$i][5] = $nastroj2->poziom_leku;
            $nastroj3[$i][6] = $nastroj2->poziom_zdenerwania;
            $nastroj3[$i][7] = $nastroj2->epizod_psychotyczne;
            $nastroj3[$i][8] = $nastroj2->pobudzenie;
            //print $nastroj3[$i][0] . "<br>";
            $i++;
            
        }
        $sen3 = array();
        $sen = DB::select("select data_rozpoczecia,ilosc_wybudzen,data_zakonczenia,id from sen where  year(data_rozpoczecia) = '$rok'  and month(data_rozpoczecia) = '$miesiac' and day(data_rozpoczecia) = '$dzien' ");
        $i = 0;
        foreach ($sen as $sen2) {
            $sen3[$i][0] = $sen2->data_rozpoczecia;
            $sen3[$i][1] = $sen2->ilosc_wybudzen;
            $sen3[$i][2] = $sen2->data_zakonczenia;
            $sen3[$i][3] = $sen2->id;
            $sen3[$i][4] = true;
            //print $nastroj3[$i][0] . "<br>";
            $i++;        
        }
        //var_dump($sen3);
        $this->sortuj_wpisy($nastroj3,$sen3);
    }
    
    private function uporzadkuj_dane() {
        $data = new \App\Http\Controllers\data();
        $tablica = $this->wpisy;
        //var_dump($tablica);
     //   $data->oblicz_jaki_jest_dzien('d','godzina_b');
        for ($i=0;$i < count($tablica);$i++) {
           $wynik =  $data->oblicz_jaki_jest_dzien($tablica[$i][0],$tablica[$i][2]);
           $this->wpisy[$i][9] = $wynik[0];
           $this->wpisy[$i][10] = $wynik[1];
            //print $wynik[0] . $wynik[1] . "<br>";
        }
        //return $wynik;
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
            //$nowa_tablica[$i][9] = strtotime($tablica1[$i][0]);
            //$nowa_tablica[$i][9] = $tablica1[$i][9];
            $i++;
        }
        $j = 0;
        
        while ($j < count($tablica2) ) {
            //print   "<br>" . $i;
            $nowa_tablica[$i][0] = $tablica2[$j][0];
            $nowa_tablica[$i][1] = $tablica2[$j][1];

            $nowa_tablica[$i][2] = $tablica2[$j][2];
            $nowa_tablica[$i][3] = $tablica2[$j][3];
            $nowa_tablica[$i][4] = 0;
            $nowa_tablica[$i][5] = 0;
            $nowa_tablica[$i][6] = 0;
            $nowa_tablica[$i][7] = 0;
            $nowa_tablica[$i][8] = 0;
            $i++;
            $j++;
        }
        //print  "<br>" .  $nowa_tablica[5][0];
    
        //print "<br>" .  count ($nowa_tablica);
        //array_multisort ($nowa_tablica2, $nowa_tablica);
        //$nowa_tablica2 = array();
        array_multisort($nowa_tablica,SORT_ASC);
         //print_r($nowa_tablica);
        $this->wpisy = $nowa_tablica;
        $this->uporzadkuj_dane();
        //var_dump($this->wpisy);
        //print $this->wpisy[0][4];
       // $a=array("2018-01-01 22:00:00","2018-01-01 21:00:00","2018-01-01 22:45:00","2018-01-01 24:00:00","2018-01-01 17:00:00");
        /*
        $a[0][0] = "2018-01-01 22:00:00";
        $a[1][0] = "2018-01-01 21:00:00";
        $a[2][0] = "2018-01-01 22:45:00";
        $a[3][0] = "2018-01-01 24:00:00";
        $a[4][0] = "2018-01-01 17:00:00";

        $a[0][1] = 2;
        $a[1][1] = 5;
        $a[2][1] = 1;
        $a[3][1] = 3;
        $a[4][1] = 4;
        
        array_multisort($a);
        print_r($a);
        */
        //$this->s();
        //var_dump($nowa_tablica);
        //print $nowa_tablica[0][0];
        //$nowa_tablica2 = array();
        //for ($i=0;$i < count ($nowa_tablica);$i++) {
          //  $czas_unixa = strtotime($nowa_tablica[$i][0]);
        //print $i;
        //print $nowa_tablica[$i][0] . "<br>";
          //  $nowa_tablica2[$i][0] = $nowa_tablica[$i][0];
            //$nowa_tablica2[$i][1] =                       $nowa_tablica[$i][1];
            //$nowa_tablica2[$i][2] =                       $nowa_tablica[$i][2];
            //$nowa_tablica2[$i][3] =                       $nowa_tablica[$i][3];
        

        //}
        
    //var_dump($nowa_tablica);
    
    
    }
 
    private function wyciagnij_godzine_ostatniego_wpisu($id_users) {
        $wpis = DB::select("SELECT godzina_zakonczenia FROM `nastroj` where id_users = '$id_users' order by godzina_zakonczenia DESC limit 1");
        foreach ($wpis as $wpis2) {}
        
        if (empty($wpis2->godzina_zakonczenia) ) return 0;
        else {
            //print "<font color=red>" . $wpis2->godzina_zakonczenia . "</font>";
            $podziel_wpis = explode(" ",$wpis2->godzina_zakonczenia);
            $podziel_wpis2 = explode(":",$podziel_wpis[1]);
            //var_dump($podziel_wpis2);
            return array($podziel_wpis2[0],$podziel_wpis2[1]);
        }
        
        
    }
    
    //funkcja rysuje poszeczegolne godziny 
    private function rysuj_dla_godziny($godzina,$status) {
        if ($status == 1) {
            $aktualna_godzina = $godzina- 1;
            if ($aktualna_godzina < 0) {
                $aktualna_godzina = 23;
            }
        }
        else if ($status == 2) {
            $aktualna_godzina = $godzina- 8;
//            $dzien = date("Y-m-d");
                if ($aktualna_godzina < 0) {
                    $aktualna_godzina = 24 + $aktualna_godzina;
                }
  //          $dzien2 = strtotime($dzien);
        }
        else if ($status == 3) {
            $aktualna_godzina = $godzina;
            //print $godzina;
        }
        else {
            $aktualna_godzina = $godzina;
        }
        $tablica = array();
        for ($i=0;$i < 24;$i++) {
            if ($aktualna_godzina == $i) {
                $tablica[$i] = "= $i selected";
            }
            else {
                $tablica[$i] = "= $i";
            }
        }
        return $tablica;
    }
    private function rysuj_dla_minuty($sprawdz = "") {
        if ($sprawdz != "") {
            $aktualna_minuta = $sprawdz;
        }
        else {
            $aktualna_minuta = date("i");
        }
        $tablica = array();
        for ($i=0;$i < 60;$i++) {
            if ($aktualna_minuta == $i) {
                $tablica[$i] = "= $i selected";
            }
            else {
                $tablica[$i] = "= $i";
            }
        }
        return $tablica;
    }
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
            
            //if ($miesiac == "" and $rok == "" and $dzien == "") {
              //  $miesiac = $miesiac;
                //$rok = $rok;
                //$dzien = $dzien;
            
            
            //else {
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
	  //$month = $month;
	  //$years = $years;
	}
	//}
	//}
	if ( !empty($rok) or  !empty($miesiac)) {
	//$_GET["rok"] = atak_sql($_GET["rok"]);
	//$_GET["miesiac"] = atak_sql($_GET["miesiac"]);
	//$rok = $_GET["rok"];
	//$miesiac = $_GET["miesiac"];
	$dzien_tygodnia = $this->ustal_dzien_tygodnia("$rok-$miesiac-1");
      }
      else {
	$rok = date("Y");
	$miesiac = date("m");
	$dzien_tygodnia = $this->ustal_dzien_tygodnia("Y-m-1");
      }
      //print $dzien_tygodnia;
  
      if ($dzien_tygodnia == 0) {
	  $dzien_tygodnia = 7;
      }
	
	return array($miesiac,$rok,$dzien,$dzien_tygodnia,$akcja);
    }
    
    
      private function ustal_dzien_tygodnia($data) {

        //$dzien_tyg = date("w",strtotime($data));
        //return $dzien_tyg; 
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
