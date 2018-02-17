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
        public function usun_nastroj() {
        $id = Input::get("id");
        $id_users = Auth::User()->id;
        $sprawdz = DB::select("select id_users from nastroj where id_users = '$id_users' and id = '$id'");
        foreach ($sprawdz as $sprawdz2) {}
        if (empty($sprawdz2->id_users) ) print "błąd";
        else {
            $zapytanie = DB::select("select id_leku from przekierowanie_lekow where id_nastroj = '$id'");
            foreach ($zapytanie as $zapytanie2) {
                DB::delete("delete  from leki where id = '" . $zapytanie2->id_leku . "'");
                DB::delete("delete from przekierowanie_lekow where id_leku = '" . $zapytanie2->id_leku . "' ");
            }
            DB::delete("delete from nastroj where id = '$id'");
            print "<div class=\"col-md-2 col-xs-2\"></div><div class=\"col-md-4 col-xs-4 nastroj div10\"><span class=succes2>Pomyślnie usnięto nastrój</span></div>";
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
    
    public function dodaj_lek() {
        $data3 = new \App\Http\Controllers\data();
        //print Input::get('nazwa');
        $id_users = Auth::User()->id;
        //$rok = explode("-",Input::get("rok"));
        //$godzina = explode(":",Input::get("godzina"));
        //print Input::get("rok");
        $daty = $this->wyciagnij_id_wpisu_daty($id_users,Input::get("id"));
        $daty2  = explode(" ",$daty[0]);
        
        if (Input::get("rok") == "") $rok = $daty2[0];
        else $rok = Input::get("rok");
        $data1 = $rok . " " . Input::get("godzina");
        $wynik = $this->zbadaj_czy_godzina_znajduje_sie_danym_przedziale_czasowym($daty[0],$daty[1],$data1);
        if (Input::get("godzina") == "") print "<span class=blad>Uzupełnij dobrze godzinę</span><br>";
        if (Input::get("nazwa") == "") print "<span class=blad>Uzupełnij dobrze nazwę</span><br>";
        if (Input::get("dawka") == "") print "<span class=blad>Uzupełnij dobrze dawkę</span><br>";
        if (is_numeric(Input::get("dawka") )== false and Input::get("dawka") != "" ) print "<span class=blad>dawka musi być liczbą</span><br>";
        if ($wynik == false and Input::get("godzina") != "") print "<span class=blad>Podana data nie zawiera się w podanym przedziale czasowym</span>";
        else if ($wynik == true){
        
        //if ($wynik == 3) {
        
            $id2 = $data3->dodaj_pojedynczy_lek(Input::get("nazwa"),Input::get("dawka"),Input::get("rodzaj"),$data1);
            $data3->dodaj_przekierowanie_leku($id2,Input::get("id"));
            print ("<span class=succes>Pomyslnie dodano lek</span>");
        
        //}
        }
        //$daty[0] = 0;
        //$daty[1] = 1;
       // $wynik1 = $data3->sprawdz_czy_dany_lek_jest_w_danym_przedziale_czasowym($rok[0],$rok[1],$rok[2],$godzina[0],$godzina[1],$daty[0],$daty[1]);
      //  $wynik1 = $data3->sprawdz_date($daty[0],$daty[1],$daty[2],$daty[3],$daty[4]);
     //   $wynik2 = $data3->sprawdz_date($daty[5],$daty[6],$daty[7],$daty[8],$daty[9]);
        //if ($wynik1 == 0) print "bardzo dobrze";
        
        //print Input::get("dawka");
    }
    private function zbadaj_czy_godzina_znajduje_sie_danym_przedziale_czasowym($data1,$data2,$data3) {
        //print $data3;
        $data3 .= ":00";
        $wynik1 = strtotime($data1);
        $wynik2 = strtotime($data2);
        $wynik3 = strtotime($data3);
        //print $wynik3;
        if ($wynik3 > $wynik1 and $wynik3 < $wynik2) return true;
        else return false;
    }
    private function wyciagnij_id_wpisu_daty($id_user,$id) {
        //$id_users = Auth::User()->id;
        //$id = Input::get("id");
        $zapytanie = DB::select("select godzina_zaczecia,godzina_zakonczenia from nastroj where id = '$id' and id_users = '$id_user'");
        foreach ($zapytanie as $zapytanie2) {}
        $data1 = explode(" ",$zapytanie2->godzina_zaczecia);
        $data2 = explode("-",$data1[0]);
        $data3 = explode(":",$data1[1]);
        $data11 = explode(" ",$zapytanie2->godzina_zakonczenia);
        $data22 = explode("-",$data11[0]);
        $data33 = explode(":",$data11[1]);
        return array($zapytanie2->godzina_zaczecia,$zapytanie2->godzina_zakonczenia);
      //  return array($data2[0],$data2[1],$data2[2],$data3[0],$data3[1],$data22[0],$data22[1],$data22[2],$data33[0],$data33[1]);
        
        
    }   
    public function edytuj_opis() {
        $id = Input::get("id");
        $zapytanie = DB::select("select co_robilem from nastroj where id = '$id'");
        foreach ($zapytanie as $zapytanie2) {}
        print $zapytanie2->co_robilem;
        
    }
    public function dodaj_opis() {
        $id = Input::get("id");
        $text = Input::get("text");
        print $text;
        $id_users = Auth::User()->id;
        DB::table('nastroj')
            ->where('id_users', $id_users)->where('id',$id)
            ->update(['co_robilem' => $text]);
        print "dobrze";
        
    }
}
