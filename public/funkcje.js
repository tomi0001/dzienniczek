
$('#menu3').click(function() {
    
  $('.menu3').slideToggle();
    
});
$('.menu3').hide();
$(document).ready(function() {
	$('.klasa1').css('background-color', 'green');
	$('#klasa2').css('background-color', 'green');
});

function dodaj_lek() {
    //$( ".lek" ).append( "<div class=\"row\"><div class=\"col-md-5 col-xs-5\"></div><div class=\"col-md-2 col-xs-2\"><input type=text name=leki[] class=form-control placeholder=\"nazwa\"></div>    <div class=\"col-md-2 col-xs-2\"><input type=text name=leki2[] class=form-control placeholder=\"dawka\"></div><div class=\"col-md-2 col-xs-2\"><select name=leki3[]  class=form-control><option value=\"mg\">Mg</option><option value=\"litry\">ile litrow</option><option value=\"sztuki\">ile sztuk</option></select></div>" );
    $('.lek2').show();
    //$( ".lek" ).append($('.lek2'));
}

$('.lek2').hide();

/*
function zapisz_nastroj(adres) {
  /*var rok1 = "#rok_a";
  rokk1 = $(rok1).val();
  var leki = "#leki";
  leki2 = $(leki).val();
  /*
  var jeden = new Array($("#leki"));
    //if (wybor == "Programowanie") {
    var dlugosc = jeden.length-1;
    
    var ajax_json = JSON.stringify($("#lek"));
        $('#dodaj_lek').click(function() {
        $.ajax({
            type: 'POST',
            url: 'ajax.php',
            data: 'id=testdata',
            dataType: 'json',
            cache: false,
            success: function(result) {
                $('#opis_a').html(result[0]);
            },
        });
    });
    //var obj = { "name":"John", "age":30, "city":"New York"};
    //var ajax_json = JSON.stringify(ajax_json);
/*
  var miesiac1 = "#miesiac_a";
  miesiacc1 = $(miesiac1).val();

  var dzien1 = "#dzien_a";
  dzienn1 = $(dzien1).val();

  var rok2 = "#rok_b";
  rokk2 = $(rok2).val();

  var miesiac2 = "#miesiac_b";
  miesiacc2 = $(miesiac2).val();

  var dzien2 = "#dzien_b";
  dzienn2 = $(dzien2).val();

  var godzina1 = "#godzina_a";
  godzina1 = $(godzina1).val();
  var godzina2 = "#godzina_b";
  godzina2 = $(godzina2).val();
  var nazwa = "#nazwa2";
  nazwa2 = $(nazwa).val();
  //alert(dzienn1);
  */
//JSON.parse({"balance":0,"count":0,"time":1323973673061,"firstname":"howard","userId":5383,"localid":1,"freeExpiration":0,"status":false});
//  var adres2 = adres + "?rok_a=" + rokk1 + "&miesiac_a=" + miesiacc1 + "&dzien_a=" + dzienn1 + "&rok_b=" + rokk2 + "&miesiac_b=" + miesiacc2 +  "&dzien_b=" + dzienn2 +  "&nazwa=" + nazwa2;
//var adres2 = adres + "?ajax=" + leki2;

  //var opis_a = '#opis_a';
  //var d = fetch('/json')
   //.then(response => response.json())
   //.then(result => console.log(result.name));
  //fetch('/json')
   //.then(response => response.json())
   //.then(result => console.log(result.name));
   /*

var myList = document.querySelector('#leki');

var myRequest = new Request('products.json');

fetch(myRequest)
  .then(function(response) { return response.json(); })
  .then(function(data) {
    for (var i = 0; i < data.products.length; i++) {
      var listItem = document.createElement('li');
      listItem.innerHTML = '<strong>' + data.products[i].Name + '</strong> can be found in ' +
                           data.products[i].Location +
                           '. Cost: <strong>£' + data.products[i].Price + '</strong>';
      myList.appendChild(listItem);
    }
  });
   alert(s);
  //var_dump(d);
  //$(opis_a).load(adres2);
*//*
   alert(adres);
   
   new Ajax.Request(adres,   {metod:   post, parameters: 'tomi'; onComplete: MyFunc});
   function napis(adres) {
//var zm="Ala ma kota";
//pars = "zmienna=" + zm;
       alert(adres);
//new Ajax.Request(adres,{metod: GET, parameters: pars; onComplete: MyFunc});
}

function MyFunc(Request) {
  //  var b = innerHTML = Request.ResponseText;;
//alert(b);
} 
}
*/
//alert('myImage');


           //$('form').clikc(function(){
   
