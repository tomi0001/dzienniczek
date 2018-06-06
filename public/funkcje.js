  $( function() {
    
    $( "#date2" ).datepicker({dateFormat: "yy-mm-dd"});
    
  } );
  

$(document).ready(function(){
     $('#czas').timepicker({});
     jQuery("time.timeago").timeago();
     alert("dobrze");
});

//alert("dobrze");
$('#menu3').click(function() {
    
  $('.menu3').slideToggle();
    
});
$('.menu3').hide();
$(document).ready(function() {
	$('.klasa1').css('background-color', 'green');
	$('#klasa2').css('background-color', 'green');
});

function dodaj_lek() {
    
    $('.lek2').show();
    
}

$('.lek2').hide();

function pokaz_leki(adres,id,i) {
 
    if (!$('#pokaz_leki_'+i).is( ':visible' ) ) 
    {

        $('#pokaz_leki_' + i).show(120);
        $('#pokaz_leki_' + i).load(adres + "?id=" + id);

    }
    else {

        $('#pokaz_leki_' + i).hide(120);

        
        
    }
    

    
}
function usun_lek(adres,i,id) {
    
    var bool = confirm("Czy na pewno usunąć");
    if (bool == true) {
        
        
        $('#usun_leki_'+i).load(adres + "?id=" + id);
        $('#usun_leki'+i).hide(100);
        $('#usun_lek2'+i).hide(100);
        
    }
    
 
}
var status = 12;
function wstaw_ta_date(rok,miesiac,dzien) {
 
    var rok2 = "<option value=></option><option value=" + rok +  " selected> " + rok + "</option>";
    $('#rok_a').html(rok2);
    var miesiac2 = "<option value=></option><option value=" + miesiac +  " selected> " + miesiac + "</option>";
    $('#miesiac_a').html(miesiac2);
    var dzien2 = "<option value=></option><option value=" + dzien +  " selected> " + dzien + "</option>";
    $('#dzien_a').html(dzien2);
    
    $('#rok_b').html(rok2);
    $('#miesiac_b').html(miesiac2);
    $('#dzien_b').html(dzien2);

    
}
function pokaz_opis(adres,id,i) {

     if ( !$('#pokaz_opis_'+i).is( ':visible') ) {
   
        $('#pokaz_opis_' + i).show(120);
        $('#pokaz_opis_' + i).load(adres + "?id=" + id);
     }
     else {
            $('#pokaz_opis_' + i).hide(120);
         
     }

}


function ukryj_nastroje(ilosc) {
    
 for (i=0;i < ilosc;i++) {
     $('#pokaz_leki_' + i).hide();
     $('#dodaj_lek_'+i).hide();
     $('#edytuj_opis_'+i).hide();
     $('#pokaz_opis_'+i).hide();
    
 }
    
}
function dodaj_lek2(i) {
    
 var wynik = $('#dodaj_lek_'+i).is( ':visible');
 if (wynik == true) $('#dodaj_lek_'+i).hide(120);   
 else $('#dodaj_lek_'+i).show(120);   
    
}


function dodaj_lek3(url,i,id) {

    var nazwa = $('#nazwa_'+i).val();
    var dawka = $('#dawka_'+i).val();
    var rok = $('#rok_'+i).val();
    var godzina = $('#godzina_'+i).val();
    var rodzaj = $('#rodzaj_'+i).val();
   
    $('#pokaz_pozycje_wyslania_leku_'+i).load(url+"?nazwa="+nazwa+"&dawka="+dawka+"&rok="+rok+"&godzina="+godzina+"&rodzaj="+rodzaj+"&id="+id);
    
}

function edytuj_opis(i,url,id) {
    
    
    $("#edytuj_opis_"+i).toggle(120);
    var d = $("#edit_opis_"+i).load(url+ "?id="+id);
    
}

function dodaj_opis(url,i,id) {
    var text = $("#edit_opis_"+i).val();
    
   $("#dodaj_opis_"+i).load(url+"?id="+id+"&text="+text);
    
}
function usun_nastroj(url,i,id) {

    var bool = confirm("Czy na pewno usunąć");
    if (bool == true) {
    $.ajax({
  url: url + "?id="+id,
}).done((msg) => {
  let wiadomosc = msg;
    $(".nastroj2_"+i).hide(50);
    $("#nastroj_"+i).html("<div class=row>"  +  wiadomosc +  "</div>");
    $("#nastroj_"+i).animate({height: "20px",opacity: 0}, 1500)
});

    }
    
}



  window.fbAsyncInit = function() {
    FB.init({
      appId      : '552776771770520',
      cookie     : true,
      xfbml      : true,
      version    : '3'
    });
      
    FB.AppEvents.logPageView();   
      
  };

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "https://connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));


