<?php
namespace App\Http\Controllers;
   use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class data extends BaseController
{

    public $data1;
    public $data2;
   public function ustaw_date($rok_a,$miesiac_a,$dzien_a,$godzina_a,$minuta_a,$status = false,$status2 = false) {
        print $godzina_a;
            if ($status == true) {
                print "bardzo xle";
                $data11 = date("Y-m-d");
                $data2 = strtotime($data11) - 84600;
                $data1 = date("Y-m-d",$data2) .  " " . $godzina_a . ":" . $minuta_a . ":00";
            }
            elseif ($rok_a == "" and $miesiac_a == "" and $dzien_a == "") {
             $data1 = date("Y-m-d") .  " " . $godzina_a . ":" . $minuta_a . ":00";
             print "zle";
            }
            else {
                $data1 = $rok_a . "-" . $miesiac_a . "-" .  $dzien_a  . " " . $godzina_a . ":" . $minuta_a . ":00";
            }
            if   ($status2 == false) {
            //print "<font color=red>scdsa"   . "</font>";
            $this->data1 = strtotime($data1);
            //$this->data1 = $data1;
                }
                else {
                
                    $this->data2 = strtotime($data1);
                    //$this->data2 = $data1;
                }
            
            return $data1;
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
       $wynik = $cmp2 - $cmp;
       //if ($wynik > 57600) return -5;
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
    public function sprawdz_czy_dany_lek_jest_w_danym_przedziale_czasowym($rok,$miesiac,$dzien,$godzina,$minuta,$data1,$data2) {
    //$data3 = new \App\Http\Controllers\data();
    // print "<font color=red>tomi" . $godzina . "</font>";
     //print "dobrze_czy_xle";
     if ($rok != "" and $miesiac != "" and $dzien != "") {
        $wynik = strtotime($rok . "-" . $miesiac . "-" . $dzien . " " .  $godzina . ":" . $minuta . ":00");
     }
     else {
        $wynik = strtotime(date("Y-m-d") .  " " .  $godzina . ":" . $minuta . ":00");
     }
       // print "<font color=green>" . $wynik . "</font>";
        if ($wynik >= $data1 and $wynik <= $data2) {
         //   print "dobrze_czy_xle";
        return 0;
        
        }
        else{
            //print "dobrze_czy_xle";
        return -6;
        
        }
        
    }
    public function sprawdz_date($rok_a,$miesiac_a,$dzien_a,$godzina_a,$minuta_a,$status = true,$status2 = true) {
        if ($rok_a != "" and $miesiac_a != "" and $dzien_a != "") {
            //print "kupa";
            $wynik = checkdate($miesiac_a,$dzien_a,$rok_a);
            if ($wynik == false) return -1;
            else {
                $cmp = strtotime($rok_a . "-" . $miesiac_a . "-" . $dzien_a . " " . $godzina_a . ":" . $minuta_a . ":00");
                //print $cmp;
                $cmp2 = strtotime(date("Y-m-d H:i:s"));
           

                //print $cmp2;
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
        
        //else if (
        //print var_dump(Input::get('dzien_a'));
    }
     public function oblicz_ilosc_minut_i_godzin2($data1,$data2) {
        //$wynik  = explode(" ",$data);
        //$wynik2 = explode(":",$wynik[1]);
        //$wynik3 = "Godziana " . $wynik2[0]  . " i minuta " . $wynik2[1];
        //return $wynik3;
        $wynik = strtotime($data2) - strtotime($data1);
        //$godziny = 0;
        //$minuty = 0;
        print $wynik . "<br>";
        if ($wynik < 3600) $wynik4 = "Minut " . (int)($wynik / 60);
        //else if($wynik
        else {
            $wynik2 = $wynik / 3600;
            //print $wynik . "<br>";
            $wynik5 =  $wynik2 - (int) $wynik2;
            //print "<font color=red>" . $wynik2 . "</font><br>";
            if (($wynik5) == 0) {
                print "kupka";
                //$wynik3 = $wynik2 / 60;
                $wynik4 = "Godzin " . $wynik2;
               
            }
            else {
                 $wynik3 = explode(".",$wynik2);
                 //if ($wynik3
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
        //$wynik = strtotime($data2) - strtotime($data1);
        //$godziny = 0;
        //$minuty = 0;
        /*
        if ($wynik < 3600) $wynik2 = (int)($wynik / 60);
        //else if($wynik
        else {
            $wynik2 = $wynik / 3600;
        }
        return $wynik2;
        */
    }
}


?>
