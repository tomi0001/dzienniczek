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
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
class Controller_szukaj extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    public $zapytanie;
    public $zapytanie2;
    public $strona;
    public $ilosc_stron;
    public $ilosc_lekow;
    public function szukaj() {
        
        $data3 = new \App\Http\Controllers\data();
        $rok_zaczecia = $data3->rok_zaczecia(Auth::User()->id);
        //var_dump($rok_zaczecia);
        return View('szukaj')->with('rok_zaczecia',$rok_zaczecia);
    
    }
    
    public function szukaj2($strona = "",$nastroj_od = "",$nastroj_do = "") {
    if (Auth::check()) {
    
    if ($strona == "") $strona = 1;
    $this->strona = $strona;
    
     $this->utworz_zapytanie_wyszukiwania();

    $count =  count($this->zapytanie2);
    $ilosc_stron = $this->ilosc_stron / 10;
    $tablica = $this->rysuj_hiperlacza_do_stron($ilosc_stron,$this->strona);


     return view("szukaj2")->with("wpisy",$this->zapytanie2)
     ->with('ilosc_nastrojow',$count)
     ->with('strona',$strona)
     ->with('ilosc_stron',$ilosc_stron)
     ->with('nastroj_od',Input::get("nastroj_od"))
     ->with('nastroj_do',Input::get("nastroj_do"))
     ->with('lek_od',Input::get('lek_od'))
     ->with('lek_do',Input::get('lek_do'))
     ->with('pobudzenie_od',Input::get('pobudzenie_od'))
     ->with('pobudzenie_do',Input::get('pobudzenie_do'))
     ->with('zdenerowania_od',Input::get('zdenerowania_od'))
     ->with('zdenerowania_do',Input::get('zdenerowania_do'))
     ->with('nastroj_rok',Input::get('nastroj_rok'))
     ->with('nastroj_miesiac',Input::get('nastroj_miesiac'))
     ->with('nastroj_dzien',Input::get('nastroj_dzien'))
     ->with('nastroj_miesiac2',Input::get('nastroj_miesiac2'))
     ->with('nastroj_rok2',Input::get('nastroj_rok2'))
     ->with('nastroj_dzien2',Input::get('nastroj_dzien2'))
     ->with('opis',urlencode(Input::get('opis')))
     ->with('sortuj',Input::get('sortuj'))
     ->with('leki',urlencode(Input::get('leki')))
     ->with('tablica',$tablica)
     ->with('nastroj_godzina',Input::get('nastroj_godzina'))
     ->with('nastroj_godzina2',Input::get('nastroj_godzina2'));

   }
    }
    private function rysuj_hiperlacza_do_stron($ilosc_stron,$strona) {
            if (strstr($ilosc_stron,".") ){
                
               $ilosc_stron =  (int)$ilosc_stron + 1;
            }
            $bool = false;
            $bool2 = false;
      
            $tablica = array();
            $j = 0;
            for ($i = 1;$i <= $ilosc_stron;$i++) {
                if ($i == 1) {
                    $tablica[$j][0] =  $i;
                    if ($i == $strona) {
                        $tablica[$j][1] = true;
                    }
                    else {
                        $tablica[$j][1] = false;
                    }
                    
                    $j++;
                }
                elseif ($i+5 > $strona and  $i-5 < $strona) {
                    $tablica[$j][0] =  $i ;
                    if ($i == $strona) {
                        $tablica[$j][1] = true;
                    }
                    else {
                        $tablica[$j][1] = false;
                    }
                 
                    $j++;
                }
                
                elseif ($ilosc_stron == $i) {
                    $tablica[$j][0] = $i;
                    if ($i == $strona) {
                        $tablica[$j][1] = true;
                    }
                    else {
                        $tablica[$j][1] = false;
                    }
                  
                    $j++;
                }
                elseif($bool == false and $i < $strona)  {
                    $bool = true;
                    $tablica[$j][0] = "...";
                    $tablica[$j][1] = true;
                    $j++;
                }
                elseif ($bool2 == false and $i> $strona) {
                    $bool2 = true;
                    $tablica[$j][0] = "...";
                    $tablica[$j][1] = true;
                    $j++;
                }
                
            }
            return $tablica;
        
    }
    private function utworz_zapytanie_wyszukiwania() {
        $data3 = new \App\Http\Controllers\data();
        //jeżeli pole leki będzie miało jakąś wartość to utwórz zapytanie wyciągające dane i leki
        if (Input::get('leki') != "") {
        $users = "SELECT  UNIX_TIMESTAMP(godzina_zakonczenia) - UNIX_TIMESTAMP(godzina_zaczecia) as czas
        ,id,godzina_zaczecia,godzina_zakonczenia,poziom_nastroju,poziom_leku,pobudzenie,poziom_zdenerwania FROM 
        nastroj WHERE
        ID IN ( SELECT nastroj.id FROM `nastroj` INNER JOIN przekierowanie_lekow ON nastroj.id = przekierowanie_lekow.id_nastroj 
        LEFT JOIN leki ON leki.id = przekierowanie_lekow.id_leku AND leki.nazwa in (";
        //to samo tylko dla liczby rekordów
        $liczba_rekordow = "SELECT  count(*) as t,
        UNIX_TIMESTAMP(godzina_zakonczenia) - UNIX_TIMESTAMP(godzina_zaczecia) as czas
        ,id,godzina_zaczecia,godzina_zakonczenia,poziom_nastroju,poziom_leku,pobudzenie,poziom_zdenerwania FROM nastroj WHERE ID IN 
        ( SELECT nastroj.id FROM `nastroj` 
        INNER JOIN przekierowanie_lekow ON nastroj.id = przekierowanie_lekow.id_nastroj 
        LEFT JOIN leki ON leki.id = przekierowanie_lekow.id_leku AND leki.nazwa in (";
        //dzieli leki na spacje 
       $leki = $this->podziel_leki();
       
        //dodaje do zapytania poszczególne leki
       for ($i = 0;$i< count($leki);$i++) {
    
                $users .= "'$leki[$i]',";
                $liczba_rekordow .= "'$leki[$i]',";
       }
       }
       else {
            //w przeciwnym razie kiedy nie będzie leków to tworzy inne zapytanie
            $users = "SELECT  UNIX_TIMESTAMP(godzina_zakonczenia) - UNIX_TIMESTAMP(godzina_zaczecia) as czas,id,godzina_zaczecia,godzina_zakonczenia,poziom_nastroju,poziom_leku,pobudzenie,poziom_zdenerwania FROM nastroj ";
            $liczba_rekordow = "SELECT  count(*) as t,UNIX_TIMESTAMP(godzina_zakonczenia) - UNIX_TIMESTAMP(godzina_zaczecia) as czas,id,godzina_zaczecia,godzina_zakonczenia,poziom_nastroju,poziom_leku,pobudzenie,poziom_zdenerwania FROM nastroj ";
       
       }
       //odejmuje ostatni znak dotyczy to leków bo ostatni znak zawsze będzie ,
       $users = substr($users,0,strlen($users)-1);
       $liczba_rekordow = substr($liczba_rekordow,0,strlen($liczba_rekordow)-1);
       if (Input::get('leki') != "") {
        $users .= ")";
        $liczba_rekordow .= ")";
       }
       $id_user = Auth::User()->id;
       if (Input::get('leki') != "") {
        $users.=" and nastroj.id_users = $id_user ";
        $liczba_rekordow .= " and nastroj.id_users = $id_user ";
       }
       else {
        $users.=" where nastroj.id_users = $id_user ";
        $liczba_rekordow .= " where nastroj.id_users = $id_user ";
       }

       if (Input::get("nastroj_od") != "" or Input::get("nastroj_do") != "" or Input::get('lek_od') != "" or Input::get('lek_do') != "" or Input::get('pobudzenie_od') != "" or Input::get('pobudzenie_do') != "" or Input::get('zdenerowania_od') != "" or Input::get('zdenerowania_do') != "" or Input::get('nastroj_rok') != "" or Input::get('nastroj_miesiac') != "" or Input::get('nastroj_dzien') != "" or Input::get('nastroj_rok2') != ""  or Input::get('nastroj_miesiac2') != ""  or Input::get('nastroj_dzien2') != "" or Input::get('opis') != "" or Input::get('nastroj_godzina') != "" or Input::get('nastroj_godzina2') != "") {

          if (Input::get('opis') != "") {
            
            $opis = Input::get('opis');
            $users .= " and co_robilem like '%$opis%' ";
            $liczba_rekordow .= " and co_robilem like '%$opis%' ";
         }
         if (Input::get("nastroj_od") != "") {
           $users .= " and poziom_nastroju >= " . Input::get("nastroj_od") ." ";
           $liczba_rekordow .= " and poziom_nastroju >= " . Input::get("nastroj_od") ." ";
         }
         if (Input::get("nastroj_do") != "") {
           $users .= " and poziom_nastroju <= " . Input::get("nastroj_do") ." ";
           $liczba_rekordow .= " and poziom_nastroju <= " . Input::get("nastroj_do") ." ";
         }
         if (Input::get('lek_od') != "") {
           $users .= " and poziom_leku >= " . Input::get("lek_od") ." ";
           $liczba_rekordow .= " and poziom_leku >= " . Input::get("lek_od") ." ";
         }
         if (Input::get('lek_do') != "" ) {
            
           $users .= " and poziom_leku <= " . Input::get("lek_do") ." ";
           $liczba_rekordow .= " and poziom_leku <= " . Input::get("lek_do") ." ";
         }
         if (Input::get('pobudzenie_od') != "" ) {
            
           $users .= " and pobudzenie >= " . Input::get("pobudzenie_od") ." ";
           $liczba_rekordow .= " and pobudzenie >= " . Input::get("pobudzenie_od") ." ";
         }
         if (Input::get('pobudzenie_do') != "") {
            $users .= " and pobudzenie <= " . Input::get("pobudzenie_do") ." ";
           $liczba_rekordow .= " and pobudzenie <= " . Input::get("pobudzenie_do") ." ";
         }
         if (Input::get('zdenerowania_od') != "" ) {
            
           $users .= " and poziom_zdenerwania >= " . Input::get("zdenerowania_od") ." ";
           $liczba_rekordow .= " and poziom_zdenerwania >= " . Input::get("zdenerowania_od") ." ";
         }
         if (Input::get('zdenerowania_do') != "" ) {
            
           $users .= " and poziom_zdenerwania <= " . Input::get("zdenerowania_do") ." ";
           $liczba_rekordow .= " and poziom_zdenerwania <= " . Input::get("zdenerowania_do") ." ";
         }
         if (Input::get('nastroj_rok') != "" and Input::get('nastroj_miesiac') != "" and (Input::get('nastroj_dzien') != "") ) {
            $users .= " and godzina_zaczecia >= '" . Input::get('nastroj_rok') . "-" . Input::get('nastroj_miesiac') . "-" . Input::get('nastroj_dzien') . " '";
            $liczba_rekordow .= " and godzina_zaczecia >= '" . Input::get('nastroj_rok') . "-" . Input::get('nastroj_miesiac') . "-" . Input::get('nastroj_dzien') . " '";
         }
         if (Input::get('nastroj_rok2') != "" and Input::get('nastroj_miesiac2') and (Input::get('nastroj_dzien2') != "") ) {
            $users .= " and godzina_zaczecia <= '" . Input::get('nastroj_rok2') . "-" . Input::get('nastroj_miesiac2') . "-" . Input::get('nastroj_dzien2') . " '";
            $liczba_rekordow .= " and godzina_zaczecia <= '" . Input::get('nastroj_rok2') . "-" . Input::get('nastroj_miesiac2') . "-" . Input::get('nastroj_dzien2') . " '";
         }
         
         else {
         
	  if (Input::get('nastroj_rok') != "") {
	    $users .= " and year(godzina_zaczecia) >=" . Input::get('nastroj_rok') ;
	    $liczba_rekordow .= " and year(godzina_zaczecia) >=" . Input::get('nastroj_rok') ;
	  }
	  if (Input::get('nastroj_miesiac') != "") {
	    $users .= " and month(godzina_zaczecia) >=" . Input::get('nastroj_miesiac') ;
	    $liczba_rekordow .= " and month(godzina_zaczecia) >=" . Input::get('nastroj_miesiac');
	  }
	  if (Input::get('nastroj_dzien') != "") {
	    $users .= " and day(godzina_zaczecia) >=" . Input::get('nastroj_dzien') ;
	    $liczba_rekordow .= " and day(godzina_zaczecia) >=" . Input::get('nastroj_dzien') ;
	  }
	  if (Input::get('nastroj_rok2') != "") {
	    $users .= " and year(godzina_zaczecia) <=" . Input::get('nastroj_rok2') ;
	    $liczba_rekordow .= " and year(godzina_zaczecia) <=" . Input::get('nastroj_rok2') ;
	  }
	  if (Input::get('nastroj_miesiac2') != "") {
	  
	    $users .= " and month(godzina_zaczecia) <=" . Input::get('nastroj_miesiac2');
	    $liczba_rekordow .= " and month(godzina_zaczecia) <=" . Input::get('nastroj_miesiac2');
	  }
	  if (Input::get('nastroj_dzien2') != "") {
	    $users .= " and day(godzina_zaczecia) <=" . Input::get('nastroj_dzien2') ;
	    $liczba_rekordow .= " and day(godzina_zaczecia) <=" . Input::get('nastroj_dzien2') ;
	  }
	  if (Input::get('nastroj_godzina') != "") {
	  //print "dupa";
	    $users .= " and hour(godzina_zaczecia) >=" . Input::get('nastroj_godzina');
	    $liczba_rekordow .= " and hour(godzina_zaczecia) >=" . Input::get('nastroj_godzina');
	  }
	  if (Input::get('nastroj_godzina2') != "") {
	    $users .= " and hour(godzina_zaczecia) <=" . Input::get('nastroj_godzina2') ;
	    $liczba_rekordow .= " and hour(godzina_zaczecia) <=" . Input::get('nastroj_godzina2') ;
	  }
         }
        
   
       }

    if (Input::get('leki') != "") {
            $users .= "
            GROUP BY 
            nastroj.id
            HAVING
                COUNT(DISTINCT leki.id) = " .  $this->ilosc_lekow . ") ";
            $liczba_rekordow .= "
                GROUP BY 
                nastroj.id
                HAVING
                COUNT(DISTINCT leki.id) = " .  $this->ilosc_lekow . ") ";
    }   
    
             $sortuj = Input::get("sortuj");
             $users .= " order by $sortuj DESC limit " . ($this->strona-1) * 10 . " ,   10";
             
           
            
             $users = DB::select($users);
             $liczba_rekordow = DB::select($liczba_rekordow);
             
             foreach ($liczba_rekordow as $liczba_rekordow2) {
             
             }
             $this->ilosc_stron = $liczba_rekordow2->t; 
         
        

         $zapytanie2 = array();
         $i = 0;
         
         $wynik = array();
         foreach ($users as $zapytanie) {
            //zmiennna zawiera dzień nastrjów
            $wynik = $data3->oblicz_jaki_jest_dzien($zapytanie->godzina_zaczecia,$zapytanie->godzina_zakonczenia);
            $this->zapytanie2[$i][0] = $zapytanie->godzina_zaczecia;
          
           $data = explode(" ",$this->zapytanie2[$i][0]);
           //potrzebne aby rozdzielić nastroje z innych dni
           if ($i == 0) {
            $data2 = 0;
           }
           else {
	    $data2 = explode(" ",$this->zapytanie2[$i-1][0]);
           }
            if ( $data[0] != $data2[0]) {
                
                $this->zapytanie2[$i][1] = $data[0];
            }
            else {
                   $this->zapytanie2[$i][1] = 0;
            }
      
            
            $this->zapytanie2[$i][2] = $wynik[0];
            $this->zapytanie2[$i][3] = $zapytanie->id;
            $this->zapytanie2[$i][4] = $data3->oblicz_ilosc_minut_i_godzin2($zapytanie->godzina_zaczecia,$zapytanie->godzina_zakonczenia);
            $this->zapytanie2[$i][5] = $zapytanie->poziom_nastroju;
            $this->zapytanie2[$i][6] = $zapytanie->poziom_leku;
            $this->zapytanie2[$i][7] = $zapytanie->poziom_zdenerwania;
            $this->zapytanie2[$i][8] = $zapytanie->pobudzenie;
            $this->zapytanie2[$i][9] = $wynik[1];
            $this->zapytanie2[$i][10] = $zapytanie->godzina_zakonczenia;
        
            $this->zapytanie2[$i][11] = $data3->sprawdz_czy_cos_robilem($zapytanie->id);
            $this->zapytanie2[$i][13] = $data3->ustaw_dzien_miesiaca($zapytanie->godzina_zakonczenia);
            $this->zapytanie2[$i][15] = $data3->sprawdz_czy_bralem_leki_dla_danego_dnia($zapytanie->id);
            $i++;
            
         }
         $this->zapytanie2 = $data3->okres_kolor_dla_diva($this->zapytanie2,false);
         $this->zapytanie2 = $data3->okresl_dlugosc_daty_w_procentach($this->zapytanie2 ,false);
       
    }

    
    

    
    private function podziel_leki() {
        $dziel2 = preg_split( '/[?!.,;: ]+/', Input::get('leki') );

        $this->ilosc_lekow = count($dziel2);;

        return $dziel2;
    }
    

    
}
