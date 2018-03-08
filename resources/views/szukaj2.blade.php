@extends('layout.index')
@section('content')
<body onload="ukryj_nastroje({{$ilosc_nastrojow}})">



@if (empty($wpisy))
<div class="row">
    <div class="col-md-2 col-xs-2"></div>
    <div class="col-md-6 col-xs-6">
    <span class=blad>Nie ma żadnych wpisów spełniających te kryteria</span>
    </div>
</div>
@else
@for ($i=0;$i < count($wpisy);$i++)




@if ($wpisy[$i][1] != 0)
<div class="row nastroj2_{{$i}}" >
        <div class="col-md-2 col-xs-2"></div>
        <div class="col-md-6 col-xs-6">
        <div class="tlo2">
        dzień {{$wpisy[$i][1]}}
        </div>
        </div>
</div>

@endif
<div id=nastroj_{{$i}}>
<div class="row nastroj2_{{$i}}" >

    <div class="col-md-2 col-xs-2"></div>
    <div class="col-md-3 col-xs-3">
        <div class="tlo">
        {{$wpisy[$i][2]}} 
        </div>
    </div>
    <div class="col-md-3 col-xs-3">
        <div class="tlo">
        {{$wpisy[$i][9]}}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-2 col-xs-2"></div>
    <div class="col-md-2 col-xs-2">
        <div class="tlo">
        Poziom nastroju {{$wpisy[$i][5]}}
        </div>
    </div>
    <div class="col-md-2 col-xs-2">
        <div class="tlo">
        Poziom lęku {{$wpisy[$i][6]}}
        </div>
    </div>
    <div class="col-md-2 col-xs-2">
        <div class="tlo">
        zdenerowania {{$wpisy[$i][7]}}
        </div>
    </div>
    <div class="col-md-2 col-xs-2">
        <div class="tlo">
        pobudzenia {{$wpisy[$i][8]}}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-2 col-xs-2"></div>
    <div class="col-md-8 col-xs-8">
      
        <div class="nastroj {{$wpisy[$i][12]}}" style="width: {{$wpisy[$i][14]}}%;"}>&nbsp;</div>
        
    </div>
    
</div>
</div>
<div class="row nastroj2_{{$i}}" >
    <div class="col-md-2 col-xs-2"></div>
    <div class="col-md-5 col-xs-5">
        <div class="row">
        <div class="col-md-3 col-xs-3">
        @if ($wpisy[$i][15] == true)
        <button  class="btn btn-primary" onclick=pokaz_leki('{{  url('/ajax/pokaz_leki') }}',{{$wpisy[$i][3]}},{{$i}}) type="button">pokaż leki</button>
        @else
        <button  class="btn btn-danger" onclick=pokaz_leki('{{  url('/ajax/pokaz_leki') }}',{{$wpisy[$i][3]}},{{$i}}) type="button" disabled>Nie było leków</button>
        @endif
        </div>
        <div class="col-md-3 col-xs-3">
        <a href={{ url('glowna')}}/{{$wpisy[$i][13]}} ><button  class="btn btn-primary"  type="button">idź do dnia</button></a>
        </div>


        </div>
    </div>
    <div class="col-md-2 col-xs-2">
        @if ($wpisy[$i][11] == true)
        <button  class="btn btn-primary" type="button" onclick=pokaz_opis('{{  url('/ajax/pokaz_opis') }}',{{$wpisy[$i][3]}},{{$i}})>pokaż co robiłem</button>
        @else
        <button  class="btn btn-danger" type="button" disabled>Nie nie robiłeś</button>        
        @endif
    </div>
    <div class="col-md-2 col-xs-2">
        <div class="tlo">
         {{$wpisy[$i][4]}}
         </div>
    </div>
    <div class="col-md-2 col-xs-2">
        
    </div>
</div>
<div class="row">
    <div class="col-md-2 col-xs-2"></div>
    <div class="col-md-8 col-xs-8">
        <div id=pokaz_leki_{{$i}}>
        
        </div>
        <div id=pokaz_opis_{{$i}}>
        
        </div>
        <div id=edytuj_opis_{{$i}}>
            <div class="row">
            <div class="col-md-3 col-xs-3">
            </div>
            
            <div class="col-md-5 col-xs-5">
            <textarea id="edit_opis_{{$i}}" class="form-control" rows="3" cols="20" ></textarea>
             <div align=center><button  class="btn btn-primary" onclick=dodaj_opis('{{url('/ajax/dodaj_opis')}}','{{$i}}','{{$wpisy[$i][3]}}') type="button">Zapisz</button></div>
            </div>
            <div class="col-md-4 col-xs-4">
                <div id=dodaj_opis_{{$i}}></div>
            </div>
            </div>
        </div>
        <div id=dodaj_lek_{{$i}}>
        <form>
        <div class="row">

        <div class="col-md-2 col-xs-2">
        <input type=text id=nazwa_{{$i}} class=form-control placeholder="nazwa">
        </div>
        <div class="col-md-2 col-xs-2">
        <input type=text id=dawka_{{$i}} class=form-control placeholder="dawka">
        </div>
        <div class="col-md-3 col-xs-3">
        <input type=date id=rok_{{$i}} class=form-control>
        </div>
        <div class="col-md-3 col-xs-3">
        <input type=time id=godzina_{{$i}} class=form-control>
        </div>
        <div class="col-md-2 col-xs-2">
        <select id=rodzaj_{{$i}} class="form-control">        <option value="1">Mg</option>
        <option value="2">ile litrow</option>
        <option value="3">ile sztuk</option></select>
        </div>
        </div>
        <div class="row">
        <div class="col-md-4 col-xs-4">
        
        
        </div>
        <div class="col-md-2 col-xs-2">
        
        <button  class="btn btn-primary" onclick=dodaj_lek3('{{url('/ajax/dodaj_lek')}}','{{$i}}','{{$wpisy[$i][3]}}') type="button">Dodaj lek</button>
        </div>
        
        </div>
        </form>
        <div align=center><div id=pokaz_pozycje_wyslania_leku_{{$i}}></div></div>
        </div>
    </div>
</div>

<br>

@endfor
<div class="row">
<div class="col-md-4 col-xs-4">
</div>
<div class="col-md-6 col-xs-6">

@for ($i=0;$i < count($tablica);$i++)

@if ($tablica[$i][1] == true)
<div class=strona_aktywna>
{{$tablica[$i][0]}}
</div>
@else
<div class=strona_nie_aktywna>
<a class=strona_hiper href={{ url('wyszukaj2')}}/{{$tablica[$i][0]}}?nastroj_od={{$nastroj_od}}&nastroj_do={{$nastroj_do}}&lek_od={{$lek_od}}&lek_do={{$lek_do}}&pobudzenie_od={{$pobudzenie_od}}&pobudzenie_do={{$pobudzenie_do}}&zdenerowania_od={{$zdenerowania_od}}&zdenerowania_do={{$zdenerowania_do}}&nastroj_rok={{$nastroj_rok}}&nastroj_rok2={{$nastroj_rok2}}&nastroj_miesiac={{$nastroj_miesiac}}&nastroj_miesiac2={{$nastroj_miesiac2}}&nastroj_dzien={{$nastroj_dzien}}&nastroj_dzien2={{$nastroj_dzien2}}&opis={{$opis}}&sortuj={{$sortuj}}&leki={{$leki}}>{{$tablica[$i][0]}} </a>
</div>

@endif
@endfor
@endif
</div>
</div>

@endsection
