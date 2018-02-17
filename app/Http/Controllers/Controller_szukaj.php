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
class Controller_szukaj extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    public $zapytanie;
    public function szukaj() {
        $data3 = new \App\Http\Controllers\data();
        $rok_zaczecia = $data3->rok_zaczecia(Auth::User()->id);
        return View('szukaj')->with('rok_zaczecia',$rok_zaczecia);
    
    }
    
    public function szukaj2() {
    
    $t=    $this->utworz_zapytanie_wyszukiwania();
   // return View('szukaj2')->with('t',$t);
    }
    private function utworz_zapytanie_wyszukiwania() {
    
        $zapytanie = "select poziom_nastroju,godzina_zaczecia,godzina_zakonczenia,poziom_leku,poziom_zdenerwania from nastroj ";
        if (Input::get('nastroj_od') != "" or Input::get('nastroj_do') != "" or Input::get('lek_od') != "" or Input::get('lek_do') != "" or Input::get('pobudzenie_od') != "" or Input::get('pobudzenie_do') != "" or Input::get('zdenerowania_od') != "" or Input::get('zdenerowania_do') != "" or Input::get('nastroj_rok') != "" or Input::get('nastroj_miesiac') != "" or Input::get('nastroj_dzien') != "" or Input::get('nastroj_rok2') != ""  or Input::get('nastroj_miesiac2') != ""  or Input::get('nastroj_dzien2') != "") {
        
        
        //print $zapytanie;
        /*
            $zapytanie .= " where ";
            if (Input::get('nastroj_od') != "") {
               
                $zapytanie .= "poziom_nastroju >= " . Input::get('nastroj_od') . " " . " and " . " ";
            
            }
            //$zapytanie =  $this->usun_and($zapytanie);
            if (Input::get('nastroj_do') != "") $zapytanie .=    " "  . " " .  "poziom_nastroju <=  " .  " " . Input::get('nastroj_do')  . " "   . Input::get('nastroj_lub') . " ";
            //$zapytanie =  $this->usun_and($zapytanie);
            if (Input::get('lek_od') != ""){
                //$zapytanie .= " and ";
                $zapytanie .= "poziom_leku >= " . Input::get('lek_od') . " " . " and "  . " ";
            }
            //$zapytanie =  $this->usun_and($zapytanie);
            if (Input::get('lek_do') != "") $zapytanie .= " poziom_leku <= " . Input::get('lek_do') .  " " .  Input::get('lek_lub') . " ";
            if (Input::get('pobudzenie_od') != ""){
                //$zapytanie .= " and ";
                $zapytanie .= "pobudzenie >= " . Input::get('pobudzenie_od') . " " . " and "  . " ";
            }
            //$zapytanie =  $this->usun_and($zapytanie);
            if (Input::get('pobudzenie_do') != "") $zapytanie .= " pobudzenie <= " . Input::get('pobudzenie_do') .  " " .  Input::get('pobudzenie_lub') . " ";
            if (Input::get('zdenerowania_od') != ""){
                //$zapytanie .= " and ";
                $zapytanie .= "poziom_zdenerwania >= " . Input::get('zdenerowania_od') . " " . " and "  . " ";
            }
            //$zapytanie =  $this->usun_and($zapytanie);
            if (Input::get('zdenerowania_do') != "") $zapytanie .= " poziom_zdenerwania <= " . Input::get('zdenerowania_do') .  " and ";
           // $zapytanie =  $this->usun_and($zapytanie);
            //if (Input::get('nastroj_lub') != "") $zapytanie .= "nastroj_od >= " . Input::get('nastroj_od');
            if (Input::get('nastroj_rok') != "") $zapytanie .= "( year(godzina_zaczecia) <=" . Input::get('nastroj_rok') . "  and " ;
            if (input::get('nastroj_miesiac') != "") $zapytanie .= " month(godzina_zaczecia) =" . Input::get('nastroj_miesiac') . ")";
            $zapytanie = $this->usun_and($zapytanie);
            $zapytanie2 = DB::select($zapytanie);
            print $zapytanie;
            //var_dump($zapytanie2);
        }*/
        //print Input::get('lek_do');
        $users = DB::table('nastroj');
         if (Input::get('nastroj_od') != "") {
           $users->Where('poziom_nastroju','=>',Input::get('nastroj_od'));
         }
         if (Input::get('nastroj_do') != "") {
            $users->Where('poziom_nastroju','<=',Input::get('nastroj_do'));
         }
         if (Input::get('lek_od') != "") {
            //print "dupa";
           $users->Where('poziom_leku','>=',Input::get('lek_od'));
         }
         if (Input::get('lek_do') != "" ) {
            
            $users->Where('poziom_leku','<=',Input::get('lek_do'));
         }
         if (Input::get('pobudzenie_od') != "" ) {
            
           $users->Where('pobudzenie','<=',Input::get('pobudzenie_od'));
         }
         if (Input::get('pobudzenie_do') != "") {
            print "dupa";
            $users->Where('pobudzenie','<=',Input::get('pobudzenie_do'));
         }
         if (Input::get('zdenerowania_od') != "" ) {
            
           $users->Where('poziom_zdenerwania','=>',Input::get('zdenerowania_od'));
         }
         if (Input::get('zdenerowania_do') != "" ) {
            
            $users->Where('poziom_zdenerwania','<=',Input::get('zdenerowania_do'));
         }
         if (Input::get('nastroj_rok') != "") $users->whereRaw("year(godzina_zaczecia) >=" . Input::get('nastroj_rok') );
         if (Input::get('nastroj_miesiac') != "") $users->whereRaw("month(godzina_zaczecia) >=" . Input::get('nastroj_miesiac') );
         if (Input::get('nastroj_dzien') != "") $users->whereRaw("day(godzina_zaczecia) >=" . Input::get('nastroj_dzien') );
         if (Input::get('nastroj_rok2') != "") $users->whereRaw("year(godzina_zaczecia) <=" . Input::get('nastroj_rok2') );
         if (Input::get('nastroj_miesiac2') != "") $users->whereRaw("month(godzina_zaczecia) <=" . Input::get('nastroj_miesiac2') );
         if (Input::get('nastroj_dzien2') != "") $users->whereRaw("day(godzina_zaczecia) <=" . Input::get('nastroj_dzien2') );
            //if (input::get('nastroj_miesiac') != "") $zapytanie .= " month(godzina_zaczecia) =" . Input::get('nastroj_miesiac') . ")";
      //   elseif (Input::get('lek_lub') == " and " and Input::get('lek_do') != "") {
        //    $users->andWhere('poziom_leku','<',Input::get('lek_do'));
         //}
         $this->zapytanie = $users->get();
         //print Input::get('nastroj_miesiac');
         //print $t;
         //$t = $users;
      //foreach ($t as $t2) {
      
      //print $t2->co_robilem;
      //}
         //$users->get();
        //$users = DB::table('nastroj')->where('poziom_nastroju',0)->Where('poziom_nastroju',0)->get();
    //return $t;
    
    }
    }
    private function wyszukaj_wg_opisu($dziel) {
        $tablica = array();
        for ($i=0;$i < count($dziel);$i++) {
           $wynik =  $this->znajdz_fraze(Input::get("opis"),$dziel[$i]);
               if ($wynik > 0.5) {
                $tablica[$i][0] = $wynik;
                $tablica[$i][1] = $zapytanie2[0];
                $i++;
            }
        }
        var_dump($tablica);
    }
    
    
  private function znajdz_fraze($text1,$text2) {
  
    $ile_1 = strlen($text1);
    $ile_2 = strlen($text2);
    
    if ($ile_1 > $ile_2) $ile = $ile_1;
    else $ile = $ile_2;
    //$licznik = 0;
    $prawidlowa = 0;
    for ($i=0;$i< $ile;$i++) {
    
      if (isset($text1[$i]) and isset($text2[$i]) and $text1[$i] != $text2[$i] ) $prawidlowa--;
      else if (isset($text1[$i]) and isset($text2[$i]) and  $text1[$i] == $text2[$i]) $prawidlowa++;
      
    
    /*
      if ($text1[$i] == $text2[$i]) $prawidlowa++;
      else if ($text1[$i] == "" or $text2[$i] == "") {}
      else {
	$prawidlowa--;
      }
    */
    }
  
    $wynik = ($ile_1 + $ile_2) / 2;
    return $prawidlowa / $wynik;
  }
    
    private function podziel_opis() {
        
        $dziel = explode(" ",Input::get('opis'));
        $dziel2 = array();
        for ($i=0;$i < count($dziel);$i++) {
            $dziel2[$i] = str_replace(' ','',$dziel[$i]);
            
        }
        return $dziel2;
    }
    
    private function usun_and($tekst) {
        $bool  = false;
        $tekst2 = substr($tekst, -5);
        if (strstr($tekst2,"and")  or strstr($tekst2,"or")) $bool = true;
       
        
        if ($bool == true) {
    $tekst = substr($tekst, 0, -5);
    }
    
    //substr($string, 0, -1);
     //$tekst =    str_replace(" and ", '', $tekst);
     return $tekst;
    }
    
}
