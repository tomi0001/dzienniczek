<?php
namespace App\Http\Controllers;
   use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use DB;
use Auth;
class data extends BaseController
{

    public $data1;
    public $data2;
   public function ustaw_date($rok_a,$miesiac_a,$dzien_a,$godzina_a,$minuta_a,$status = false,$status2 = false) {

            if ($status == true) {
                $data11 = date("Y-m-d");
                $data2 = strtotime($data11) - 84600;
                $data1 = date("Y-m-d",$data2) .  " " . $godzina_a . ":" . $minuta_a . ":00";
            }
            elseif ($rok_a == "" and $miesiac_a == "" and $dzien_a == "") {
             $data1 = date("Y-m-d") .  " " . $godzina_a . ":" . $minuta_a . ":00";

            }
            else {
                $data1 = $rok_a . "-" . $miesiac_a . "-" .  $dzien_a  . " " . $godzina_a . ":" . $minuta_a . ":00";
            }
            if   ($status2 == false) {
            $this->data1 = strtotime($data1);
                }
                else {
                
                    $this->data2 = strtotime($data1);
                }
            
            return $data1;
        }
            public function rysuj_dla_godziny($godzina,$status) {
        if ($status == 1) {
            $aktualna_godzina = $godzina- 1;
            if ($aktualna_godzina < 0) {
                $aktualna_godzina = 23;
            }
        }
        else if ($status == 2) {
            $aktualna_godzina = $godzina- 8;
                if ($aktualna_godzina < 0) {
                    $aktualna_godzina = 24 + $aktualna_godzina;
                }

        }
        else if ($status == 3) {
            $aktualna_godzina = $godzina;
        }
        else {
            $aktualna_godzina = $godzina;
        }
        
        if ( strlen($aktualna_godzina) == 1) $aktualna_godzina = "0" . $aktualna_godzina;
        return $aktualna_godzina;
    }
    
        public function rysuj_dla_minuty($sprawdz = "") {
        if ($sprawdz != "") {
            $aktualna_minuta = $sprawdz;
        }
        else {
            $aktualna_minuta = date("i");
        }
        
        return $aktualna_minuta;
    }
    
    public function porownaj_dwie_daty2($godzina_a,$minuta_a,$godzina_b,$minuta_b,$bool) {
        //jeżeli bool jest true to znaczy, że 
        $wynik = $godzina_b - $godzina_a;
        if ($bool == true) {
            $godzina_b = date("H");
            $minuta_b = date("i");
        }
        if ($godzina_a > $godzina_b) return -1;
        else if ($godzina_a == $godzina_b) {
            if ($minuta_a > $minuta_b) return -1;
        }
        if ($wynik > 10) return -5;
        return 0;
    
    }
    
        public function rok_zaczecia($id_user)  {
        $tablica = array();
        $najmlodszy_rok = DB::select("select year(godzina_zaczecia) as godzina_zaczecia from nastroj where id_users = '$id_user' order by godzina_zaczecia limit 1");
        foreach ($najmlodszy_rok as $najmlodszy_rok2) {
            
        }
        if (empty($najmlodszy_rok2->godzina_zaczecia) ) $data_dodania = date("Y");
        else $data_dodania = $najmlodszy_rok2->godzina_zaczecia;
        $i = $data_dodania;
        $j = 0;
        while ($i <= date("Y")) {
            $tablica[$j] = $i;
            $i++;
            $j++;
        }
        
        return $tablica;
    }
    
        public function sprawdz_czy_cos_robilem($id_nastroj) {
        $sprawdz = DB::select("select co_robilem from nastroj where id = '$id_nastroj' ");
        foreach ($sprawdz as $sprawdz2) {
            
        }
        if ($sprawdz2->co_robilem == "") return false;
        else return true;
        
    }
    
        public function okres_kolor_dla_diva($wpisy,$status = true) {
        if ($status == false) {
            $j = 5;
        }
        else {
            $j = 1;
        }
        for($i=0;$i < count($wpisy);$i++) {
            if ($wpisy[$i][$j] >= -20 and $wpisy[$i][$j] <= -16) $wpisy[$i][12] = "div1";
            else if ($wpisy[$i][$j] > -16 and $wpisy[$i][$j] <= -12) $wpisy[$i][12] = "div2";
            else if ($wpisy[$i][$j] > -12 and $wpisy[$i][$j] <= -9) $wpisy[$i][12] = "div3";
            else if ($wpisy[$i][$j] > -9 and $wpisy[$i][$j] <= -6) $wpisy[$i][12] = "div4";
            else if ($wpisy[$i][$j] > -6 and $wpisy[$i][$j] <= -3) $wpisy[$i][12] = "div5";
            else if ($wpisy[$i][$j] > -3 and $wpisy[$i][$j] < 0) $wpisy[$i][12] = "div6";
            else if ($wpisy[$i][$j] == 0) $wpisy[$i][12] = "div7";
            else if ($wpisy[$i][$j] > 0 and $wpisy[$i][$j] <= 4) $wpisy[$i][12] = "div8";
            else if ($wpisy[$i][$j] > 4 and $wpisy[$i][$j] <= 7) $wpisy[$i][12] = "div9";
            else if ($wpisy[$i][$j] > 7 and $wpisy[$i][$j] <= 10) $wpisy[$i][12] = "div10";
            else if ($wpisy[$i][$j] > 10 and $wpisy[$i][$j] <= 14) $wpisy[$i][12] = "div11";
            else if ($wpisy[$i][$j] > 14 and $wpisy[$i][$j] <= 20) $wpisy[$i][12] = "div12";
            else $wpisy[$i][12] = "div13";
        }
        return $wpisy;
    }
    
    
        public function okresl_dlugosc_daty_w_procentach($wpisy,$status = true) {
  
            if ($status == false) {
                $j = 10;
                $j1 = 0;
                $j2 = 14;
            }
            else {
                $j = 2;
                $j1 = 0;
                $j2 = 14;
            }
                $wynik = array();
                    for ($i=0;$i < count($wpisy);$i++) {
                        $wynik[$i] = strtotime($wpisy[$i][$j]) - strtotime($wpisy[$i][$j1]);

                            
                    }
                    array_multisort($wynik,SORT_DESC);

                    $tymczasowa = 0;
                    for ($i=0;$i < count($wpisy);$i++) {
                        $tymczasowa = strtotime($wpisy[$i][$j]) - strtotime($wpisy[$i][$j1]);
                        $wpisy[$i][$j2] = round(($tymczasowa / $wynik[0]) * 100);
                        if ($wpisy[$i][$j2] == 0) $wpisy[$i][11] = 1;
                    
                    }

                    return $wpisy;
        
    }
    
        public function sprawdz_czy_bralem_leki_dla_danego_dnia($id_nastroj) {
        $sprawdz = DB::select("SELECT id_nastroj FROM `przekierowanie_lekow` WHERE id_nastroj = '$id_nastroj' ");
        foreach ($sprawdz as $sprawdz2) {
            if ( isset($sprawdz2->id_nastroj) ) return true;
            else return false;
        }
        
        
        
        
    }
    
    public function sprawdz_czy_dany_nastroj_sen_nie_nanosi_sie_na_poprzedni_nastroj($data_nastroju,$data_nastroju2) {

        $id_users = Auth::User()->id;
        $data_nastroju3 = DB::select(" select godzina_zakonczenia from nastroj where (godzina_zakonczenia > '$data_nastroju' and godzina_zaczecia < '$data_nastroju2')  and id_users = '$id_users' order by godzina_zaczecia DESC limit 1 ");
        foreach ($data_nastroju3 as $data_nastroju4) {
            
        }

        $data_snu2 = DB::select("  select data_zakonczenia from sen where data_zakonczenia > '$data_nastroju' and data_rozpoczecia < '$data_nastroju2'  and id_users = '$id_users' order by data_rozpoczecia DESC limit 1 ");
        foreach ($data_snu2 as $data_snu3) {
        
        }
        if (empty($data_nastroju4->godzina_zakonczenia) and empty($data_snu3->data_zakonczenia) ) return true;
        else return false;
    }
    
    public function oblicz_jaki_jest_dzien($godzina_a,$godzina_b) {
        $wynik = explode(" ",$godzina_a);
        $wynik2 = explode("-",$wynik[0]);

        $wynik3 = explode(":",$wynik[1]);
        $wynik4 = explode(" ",$godzina_b);
        $wynik5 = explode("-",$wynik4[0]);
        $wynik6 = explode(":",$wynik4[1]);
        return array("Godzina " .  $wynik3[0] . " i minuta " . $wynik3[1],"Godzina " .  $wynik6[0] . " i minuta " . $wynik6[1]);
        
    }
    public function porownaj_dwie_daty($rok_a,$rok_b,$miesiac_a,$miesiac_b,$dzien_a,$dzien_b,$godzina_a,$godzina_b,$minuta_a,$minuta_b,$status = true) {
       if ($rok_a == "" and $miesiac_a == "" and $dzien_a == "" and $rok_b == "" and $miesiac_b == "" and $dzien_b == "") {
        $data1 = $this->porownaj_dwie_daty2($godzina_a,$minuta_a,$godzina_b,$minuta_b,false);
        return $data1;
       }
       $cmp =  strtotime($rok_a . "-" . $miesiac_a . "-" . $dzien_a . " " . $godzina_a . ":" . $minuta_a . ":00");
       $cmp2 = strtotime($rok_b . "-" . $miesiac_b . "-" . $dzien_b . " " . $godzina_b . ":" . $minuta_b . ":00");
       if ($status == false) {
        $cmp -= 86400;
       }
       $wynik = $cmp2 - $cmp;

       if ($cmp2 < $cmp) return -1;
       else return 0;
        
    }
    
    public function ustaw_dzien_miesiaca($data_dodania) {
        $data = explode(" ",$data_dodania);
        //$data2 = explode("-",$data[0]);
        $data2 = str_replace("-","/",$data[0]);
        return $data2;
        
    }
    public function ustaw_date_1($rok_a,$miesiac_a,$dzien_a,$godzina_a,$minuta_a) {
        $rok_a = date("Y");
        $miesiac_a = date("m");
        $dzien_a = date("d");
        $data = strtotime($rok_a . "-" . $miesiac_a . "-" . $dzien_a . " " . $godzina_a . ":" . $minuta_a . ":00");
        $data2 = $data - 86400;
        $data3 = date("Y-m-d H:i:s",$data2);
        return $data3;
    }
    public function sprawdz_czy_dany_lek_jest_w_danym_przedziale_czasowym($rok,$miesiac,$dzien,$godzina,$minuta,$data1,$data2) {
    
     if ($rok != "" and $miesiac != "" and $dzien != "") {
        $wynik = strtotime($rok . "-" . $miesiac . "-" . $dzien . " " .  $godzina . ":" . $minuta . ":00");
     }
     else {
        $wynik = strtotime(date("Y-m-d") .  " " .  $godzina . ":" . $minuta . ":00");
     }
    
        if ($wynik >= $data1 and $wynik <= $data2) {
    
        return 0;
        
        }
        else{
    
        return -6;
        
        }
        
    }
    public function sprawdz_date($rok_a,$miesiac_a,$dzien_a,$godzina_a,$minuta_a,$status = true,$status2 = true) {
        if ($rok_a != "" and $miesiac_a != "" and $dzien_a != "") {
    
            $wynik = checkdate($miesiac_a,$dzien_a,$rok_a);
            if ($wynik == false) return -1;
            else {
                $cmp = strtotime($rok_a . "-" . $miesiac_a . "-" . $dzien_a . " " . $godzina_a . ":" . $minuta_a . ":00");
    
                $cmp2 = strtotime(date("Y-m-d H:i:s"));
           
                if ($cmp > $cmp2 and $status != false) return -2;
                else {
                 return 0;
                }

            }
        }
        else {
            $cmp = strtotime($rok_a . "-" . $miesiac_a . "-" . $dzien_a . " " . $godzina_a . ":" . $minuta_a . ":00");

        
        }
        if ($rok_a != "" or $miesiac_a != "" or $dzien_a != "") {
             return -3;   
        }
        else {
         $wynik = $this->porownaj_dwie_daty2($godzina_a,$minuta_a,'','',true);
         if ($wynik == -1 and $status == true) return -4;
         //if ($wynik == -5) return -5;
         else if ($status == false and $wynik == -1) return 1;
         else return 0;
        }
        
    }
    
        public function dodaj_pojedynczy_lek($leki,$leki2,$leki3,$data) {
        $id_users = Auth::User()->id;
        
        DB::insert("insert into leki  (nazwa,data_spozycia,id_users,dawka,porcja) values('$leki','$data','$id_users','$leki2','$leki3')");
        $id_ostatniego_leku = DB::select("select id from leki where id_users = '$id_users' order by id DESC limit 1");
        foreach ($id_ostatniego_leku as $id_ostatniego_leku2) {
            
        }
        return $id_ostatniego_leku2->id;
        
        
    }
    
        public function dodaj_przekierowanie_leku($id_leku,$id_nastroju) {
        DB::insert("insert into przekierowanie_lekow  (id_leku,id_nastroj) values('$id_leku','$id_nastroju')");
    }
    
     public function oblicz_ilosc_minut_i_godzin2($data1,$data2) {
        
        $wynik = strtotime($data2) - strtotime($data1);
        if ($wynik < 3600) $wynik4 = "Minut " . (int)($wynik / 60);
        else {
            $wynik2 = $wynik / 3600;
            
            $wynik5 =  $wynik2 - (int) $wynik2;
            if (($wynik5) == 0) {
                $wynik4 = "Godzin " . $wynik2;
               
            }
            else {
                 $wynik3 = explode(".",$wynik2);
                 $wynik6 = "0." . $wynik3[1];
                 $wynik6 *= 60;
                $wynik4 = "Godzin " . $wynik3[0] . " i minut " . (int)$wynik6;
               
            }
            
        }
        return $wynik4;
        
    }
    public function oblicz_ilosc_minut_i_godzin($data) {
        $wynik  = explode(" ",$data);
        $wynik2 = explode(":",$wynik[1]);
        $wynik3 = "Godziana " . $wynik2[0]  . " i minuta " . $wynik2[1];
        return $wynik3;
        
    }
}


?>
