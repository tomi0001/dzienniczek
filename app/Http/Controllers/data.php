<?php
namespace App\Http\Controllers;
   use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class data extends BaseController
{
   public function ustaw_date($rok_a,$miesiac_a,$dzien_a,$godzina_a,$minuta_a) {
        print $godzina_a;
            if ($rok_a == "" and $miesiac_a == "" and $dzien_a == "") {
             $data1 = date("Y-m-d") .  " " . $godzina_a . ":" . $minuta_a . ":00";
            }
            else {
                $data1 = $rok_a . "-" . $miesiac_a . "-" .  $dzien_a  . " " . $godzina_a . ":" . $minuta_a . ":00";
            }
            
            return $data1;
        }
        
    public function porownaj_dwie_daty2($godzina_a,$minuta_a,$godzina_b,$minuta_b,$bool) {
        //jeżeli bool jest true to znaczy, że 
        if ($bool == true) {
            $godzina_b = date("H");
            $minuta_b = date("i");
        }
        if ($godzina_a > $godzina_b) return -1;
        else if ($godzina_a == $godzina_b) {
            if ($minuta_a > $minuta_b) return -1;
        }
        return 0;
    
    }
    public function oblicz_jaki_jest_dzien($godzina_a,$godzina_b) {
        $wynik = explode(" ",$godzina_a);
        $wynik2 = explode("-",$wynik[0]);
        //print $godzina_a;
        $wynik3 = explode(":",$wynik[1]);
        $wynik4 = explode(" ",$godzina_b);
        $wynik5 = explode("-",$wynik4[0]);
        $wynik6 = explode(":",$wynik4[1]);
        return array("Godzina " .  $wynik3[0] . " i minuta " . $wynik3[1],"Godzina " .  $wynik6[0] . " i minuta " . $wynik6[1]);
        
    }
    public function porownaj_dwie_daty($rok_a,$rok_b,$miesiac_a,$miesiac_b,$dzien_a,$dzien_b,$godzina_a,$godzina_b,$minuta_a,$minuta_b) {
       if ($rok_a == "" and $miesiac_a == "" and $dzien_a == "" and $rok_b == "" and $miesiac_b == "" and $dzien_b == "") {
        $data1 = $this->porownaj_dwie_daty2($godzina_a,$minuta_a,$godzina_b,$minuta_b,false);
        return $data1;
       }
       $cmp =  strtotime($rok_a . "-" . $miesiac_a . "-" . $dzien_a . " " . $godzina_a . ":" . $minuta_a . ":00");
       $cmp2 = strtotime($rok_b . "-" . $miesiac_b . "-" . $dzien_b . " " . $godzina_b . ":" . $minuta_b . ":00");
       if ($cmp2 < $cmp) return -1;
       else return 0;
        
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
    public function sprawdz_date($rok_a,$miesiac_a,$dzien_a,$godzina_a,$minuta_a,$status = true) {
        if ($rok_a != "" and $miesiac_a != "" and $dzien_a != "") {
            //print "kupa";
            $wynik = checkdate($miesiac_a,$dzien_a,$rok_a);
            if ($wynik == false) return -1;
            else {
                $cmp = strtotime($rok_a . "-" . $miesiac_a . "-" . $dzien_a . " " . $godzina_a . ":" . $minuta_a . ":00");
                //print $cmp;
                $cmp2 = strtotime(date("Y-m-d H:i:s"));
                //print $cmp2;
                if ($cmp > $cmp2) return -2;
                else {
                 return 0;
                }

            }
        }
        else if ($rok_a != "" or $miesiac_a != "" or $dzien_a != "") {
             return -3;   
        }
        else {
         $wynik = $this->porownaj_dwie_daty2($godzina_a,$minuta_a,'','',true);
         if ($wynik == -1 and $status == true) return -4;
         else if ($status == false and $wynik == -1) return 1;
         else return 0;
        }
        
        //else if (
        //print var_dump(Input::get('dzien_a'));
    }
}


?>
