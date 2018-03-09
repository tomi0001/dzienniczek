<body onload="ukryj_nastroje({{$ilosc_nastrojow}})">
@section('title', 'Strona główna')
@if ($wynik2[0][0] != 23)
<div class="row">
    <div class="col-md-4 col-xs-4">
    </div>
    <div class="col-md-5 col-xs-5">
        
       <div class="nastroj {{$wynik2[0][1]}}" style="width: 100%;">Wartość nastroju dla tego dnia to {{$wynik2[0][0]}}</div>
    
</div>
</div>
<div class="row">
    <div class="col-md-4 col-xs-4">
    </div>
    <div class="col-md-5 col-xs-5">
        
       <div class="nastroj {{$wynik3[0][1]}}" style="width: 100%;">Wartość lęku dla tego dnia to {{$wynik3[0][0]}}
        
    </div>
    
</div>
</div>
<div class="row">
    <div class="col-md-4 col-xs-4">
    </div>
    <div class="col-md-5 col-xs-5">
        
       <div class="nastroj {{$wynik4[0][1]}}" style="width: 100%;">Wartość zdenerwowania dla tego dnia to {{$wynik4[0][0]}}
        
    </div>
    
</div>
</div>
<div class="row">
    <div class="col-md-4 col-xs-4">
    </div>
    <div class="col-md-5 col-xs-5">
        
       <div class="nastroj {{$wynik5[0][1]}}" style="width: 100%;">Wartość pobudzenia dla tego dnia to {{$wynik5[0][0]}}
        
    </div>
    
</div>
</div>
@endif
<br><br>
@for ($i=0;$i < count($wpisy);$i++)

<div class="row nastroj2_{{$i}}" >
    <div class="col-md-2 col-xs-2"></div>
    <div class="col-md-3 col-xs-3">
        <div class="tlo">
        {{$wpisy[$i][10]}}
        </div>
    </div>
    <div class="col-md-3 col-xs-3">
        <div class="tlo">
        {{$wpisy[$i][11]}}
        </div>
    </div>
</div>
@if ($wpisy[$i][5] == -21)






<div class="row">
    <div class="col-md-2 col-xs-2"></div>

</div>
<div class="row">
    <div class="col-md-2 col-xs-2"></div>
    <div class="col-md-8 col-xs-8">
        <div class="sen" style="width: {{$wpisy[$i][14]}}%;"}>&nbsp;</div>
    </div>
    
</div>
<div class="row">
    <div class="col-md-2 col-xs-2"></div>
    <div class="col-md-4 col-xs-4">
        <div class="tlo">
         Łączny czas snu {{$wpisy[$i][4]}}
         {{$wpisy[$i][0]}}
         </div>
    </div>
    <div class="col-md-2 col-xs-2">
        <div class="tlo">
        ilość wybudzeń {{$wpisy[$i][1]}}
        </div>
    </div>
</div>
<div class="row">
     <div class="col-md-2 col-xs-2"></div>
     <div class="col-md-3 col-xs-3">
       
        <button  class="btn btn-danger" onclick=usun_nastroj('{{ url('/ajax/usun_sen')}}','{{$i}}','{{$wpisy[$i][3]}}') type="button">Usuń nastrój</button>

     
        </div>
        
</div>
@else
<div id=nastroj_{{$i}}>
<div class="row">
    <div class="col-md-2 col-xs-2"></div>
    <div class="col-md-2 col-xs-2">
        <div class="tlo">
        Poziom nastroju {{$wpisy[$i][1]}} 
        </div>
    </div>
    <div class="col-md-2 col-xs-2">
        <div class="tlo">
        Poziom lęku {{$wpisy[$i][5]}}
        </div>
    </div>
    <div class="col-md-2 col-xs-2">
        <div class="tlo">
        zdenerowania {{$wpisy[$i][6]}}
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
@if ($wpisy[$i][7] != 0)
<div class="row">
    <div class="col-md-2 col-xs-2"></div>
    <div class="col-md-8 col-xs-8">
        <div class=tlo3>
      <span class=psycho>Ilość epizodow psychotycznych {{$wpisy[$i][7]}}</span>
        </div>
    </div>
    
</div>


@endif
<div class="row nastroj2_{{$i}}" >
    <div class="col-md-2 col-xs-2"></div>
    <div class="col-md-5 col-xs-5">
        <div class="row">
        <div class="col-md-3 col-xs-3">
        @if ($wpisy[$i][9] == true)
        <button  class="btn btn-primary" onclick=pokaz_leki('{{  url('/ajax/pokaz_leki') }}',{{$wpisy[$i][3]}},{{$i}}) type="button">pokaż leki</button>
        @else
        <button  class="btn btn-danger" onclick=pokaz_leki('{{  url('/ajax/pokaz_leki') }}',{{$wpisy[$i][3]}},{{$i}}) type="button" disabled>Nie było leków</button>
        @endif
        </div>
        <div class="col-md-3 col-xs-3">
       
        <button  class="btn btn-primary" onclick=dodaj_lek2('{{$i}}') type="button">Dodaj leki</button>

     
        </div>
        <div class="col-md-3 col-xs-3">
       
        <button  class="btn btn-danger" onclick=usun_nastroj('{{ url('/ajax/usun_nastroj')}}','{{$i}}','{{$wpisy[$i][3]}}') type="button">Usuń nastrój</button>

     
        </div>
        <div class="col-md-3 col-xs-3">
       
        <button  class="btn btn-primary" onclick=edytuj_opis({{$i}},'{{ url('/ajax/edytuj_opis') }}',{{$wpisy[$i][3]}}) type="button">Edytuj dodaj opis</button>

     
        </div>
        </div>
    </div>
    <div class="col-md-2 col-xs-2">
        @if ($wpisy[$i][13] == true)
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
@endif
<br>
@endfor
<div class="row">
<div class="col-md-5 col-xs-5">

</div>
<div class="col-md-4 col-xs-4">
<span class=wieksza>Dodaj nowy nastrój</span>
</div>

</div>
<br><br>
<div class="row">
  <form action={{ url('dodaj_wpis') }} method=post>
  <div class="col-md-1 col-xs-1"></div>
  <div class="col-md-3 col-xs-3"><span class="normalna2">Godziny zaczęcia</span> </div>
  <div class="col-md-4 col-xs-4">
    <div class="row">
        <div class="col-md-5 col-xs-5">
        
            <span class=pouczenie>Dzień zaczęcia jeżeli tworzyłeś nastroj w tym samym dniu pozostaw to pole puste</span>
            
            </div>
            <div class="col-md-5 col-xs-5">
        
            <input type=date name=rok_a class=form-control value={{Input::old('rok_a')}}>
            
            </div>
  
  </div>
    </div>
  <div class="col-md-3 col-xs-3">
     <div class="row">
     
     <div class="col-md-5 col-xs-5">
     @if (empty(Input::old('godzina_a')))
     <input type=time name=godzina_a class=form-control value={{$tablica_godzin2}}>
     @else
     <input type=time name=godzina_a class=form-control value={{Input::old('godzina_a')}}>
     @endif
       
     </div>

     </div>
  </div>

</div>
<div class="row">
  <div class="col-md-1 col-xs-1"></div>
  <div class="col-md-3 col-xs-3"><span class="normalna2">Godzina skończenia</span></div>
    <div class="col-md-4 col-xs-4">
    <div class="row">
    <div class="col-md-5 col-xs-5">
        
            
            </div>
        <div class="col-md-5 col-xs-5">
        <input type=date name=rok_b class=form-control value={{Input::old('rok_b')}}>
            
            </div>
   
  </div>
    </div>
  <div class="col-md-3 col-xs-3">
     <div class="row">
     <div class="col-md-5 col-xs-5">
     @if (empty(Input::old('godzina_a')))
     <input type=time name=godzina_b class=form-control value={{$tablica_godzin3}}>
     @else
     <input type=time name=godzina_b class=form-control value={{Input::old('godzina_b')}}>
     @endif
     
  
  </div>
  <div class="col-md-5 col-xs-5">
      
  </div>
  </div>
  </div>
  <div class="col-md-2 col-xs-2">
   <div class="row">
   <div class="col-md-7 col-xs-7">
  
    </div>
   </div>
  </div>
  
</div>

<div class="row">
    <div class="col-md-1 col-xs-1"></div>
    <div class="col-md-3 col-xs-3"><span class="normalna2">Nastroj w skali od -20 do +20</span></div>
    <div class="col-md-2 col-xs-2">
        <input type=text name=nastroj class=form-control value={{Input::old('nastroj')}}>
    </div>
</div>
<div class="row">
    <div class="col-md-1 col-xs-1"></div>
    <div class="col-md-3 col-xs-3"><span class="normalna2">Poziom lęku w skali od -20 do +20</span></div>
    <div class="col-md-2 col-xs-2">
        <input type=text name=lek class=form-control id=lek value={{Input::old('lek')}}>
        
    </div>
</div>
<div class="row">
    <div class="col-md-1 col-xs-1"></div>
    <div class="col-md-3 col-xs-3"><span class="normalna2">Poziom zdenerowania w skali od -20 do +20</span></div>
    <div class="col-md-2 col-xs-2">
        <input type=text name=zdenerowanie class=form-control value={{Input::old('zdenerowanie')}}>
    </div>
</div>
<div class="row">
    <div class="col-md-1 col-xs-1"></div>
    <div class="col-md-3 col-xs-3"><span class="normalna2">Poziom pobudzenia w skali od -20 do +20</span></div>
    <div class="col-md-2 col-xs-2">
        <input type=text name=pobudzenie class=form-control value={{Input::old('pobudzenie')}}>
    </div>
</div>
<div class="row">
    <div class="col-md-1 col-xs-1"></div>
    <div class="col-md-3 col-xs-3"><span class="normalna2">Ile było epizodow psychotycznych</span></div>
    <div class="col-md-2 col-xs-2">
        <input type=text name=psychotyczne class=form-control value={{Input::old('psychotyczne')}}>
    </div>
</div>
<div class="row">
    <div class="col-md-1 col-xs-1"></div>
    <div class="col-md-3 col-xs-3"><span class="normalna2">Jakie leki spożywałem</span></div>
    <div class="col-md-2 col-xs-2">
        <input type=text  id=leki[]  name=leki[] class=form-control placeholder="nazwa" value={{Input::old('leki')[0]}}>
    </div>
    <div class="col-md-2 col-xs-2">
        <input type=text name=leki2[] class=form-control placeholder="dawka" value={{Input::old('leki2')[0]}}>
    </div>
    <div class="col-md-2 col-xs-2">
        <select name=leki3[]  class=form-control>
        <option value="1">Mg</option>
        <option value="2">ile litrow</option>
        <option value="3">ile sztuk</option>
        </select>
    </div>
</div>


<div class="row">
  <div class="col-md-1 col-xs-1"></div>
  <div class="col-md-3 col-xs-3"></div>
    <div class="col-md-4 col-xs-4">
      <div class="row">
        <div class="col-md-4 col-xs-4">
        <input type=date name=leki_rok[] class=form-control value={{Input::old('leki_rok')[0]}}>
           
        </div>
 
       
      </div>
    </div>
  <div class="col-md-3 col-xs-3">
     <div class="row">
        <div class="col-md-5 col-xs-5">
         @if (empty(Input::old('leki_godzina')[0]))
         <input type=time name=leki_godzina[] class=form-control  value={{$tablica_godzin3}}>
         @else
         <input type=time name=leki_godzina[] class=form-control value={{Input::old('leki_godzina')[0]}}>
         @endif
        
           
        </div>
       
    </div>
  </div>
</div>

<div class=lek2>
<br>
<div class="row">
    <div class="col-md-1 col-xs-1"></div>
    <div class="col-md-3 col-xs-3"></div>
    <div class="col-md-2 col-xs-2">
        <input type=text id=leki[] name=leki[] class=form-control placeholder="nazwa" value={{Input::old('leki')[1]}}>
    </div>
    <div class="col-md-2 col-xs-2">
        <input type=text name=leki2[] class=form-control placeholder="dawka" value={{Input::old('leki2')[1]}}>
    </div>
    <div class="col-md-2 col-xs-2">
        <select name=leki3[]  class=form-control>
        <option value="1">Mg</option>
        <option value="2">ile litrow</option>
        <option value="3">ile sztuk</option>
        </select>
    </div>
</div>
<div class="row">
  <div class="col-md-1 col-xs-1"></div>
  <div class="col-md-3 col-xs-3"></div>
    <div class="col-md-4 col-xs-4">
      <div class="row">
        <div class="col-md-4 col-xs-4">
        <input type=date name=leki_rok[] class=form-control value={{Input::old('leki_rok')[1]}}>

        </div>
      

      </div>
    </div>
  <div class="col-md-3 col-xs-3">
     <div class="row">
        <div class="col-md-5 col-xs-5">
         @if (empty(Input::old('leki_godzina')[1]))
         <input type=time name=leki_godzina[] class=form-control  value={{$tablica_godzin3}}>
         @else
         <input type=time name=leki_godzina[] class=form-control value={{Input::old('leki_godzina')[1]}}>
         @endif
           
        </div>
 
    </div>
  </div>
</div>


<br>

<div class="row">
    <div class="col-md-1 col-xs-1"></div>
    <div class="col-md-3 col-xs-3"></div>
    <div class="col-md-2 col-xs-2">
        <input type=text name=leki[] class=form-control placeholder="nazwa" value={{Input::old('leki')[2]}}>
    </div>
    <div class="col-md-2 col-xs-2">
        <input type=text name=leki2[] class=form-control placeholder="dawka" value={{Input::old('leki2')[2]}}>
    </div>
    <div class="col-md-2 col-xs-2">
        <select name=leki3[]  class=form-control>
         <option value="1">Mg</option>
        <option value="2">ile litrow</option>
        <option value="3">ile sztuk</option>
        </select>
    </div>
</div>


<div class="row">
  <div class="col-md-1 col-xs-1"></div>
  <div class="col-md-3 col-xs-3"></div>
    <div class="col-md-4 col-xs-4">
      <div class="row">
        <div class="col-md-4 col-xs-4">
        <input type=date name=leki_rok[] class=form-control value={{Input::old('leki_rok')[2]}}>
          
        </div>
 

      </div>
    </div>
  <div class="col-md-3 col-xs-3">
     <div class="row">
        <div class="col-md-5 col-xs-5">
         @if (empty(Input::old('leki_godzina')[2]))
         <input type=time name=leki_godzina[] class=form-control  value={{$tablica_godzin3}}>
         @else
         <input type=time name=leki_godzina[] class=form-control value={{Input::old('leki_godzina')[2]}}>
         @endif
          
        </div>
       
    </div>
  </div>
</div>
<br>
<div class="row">
    <div class="col-md-1 col-xs-1"></div>
    <div class="col-md-3 col-xs-3"></div>
    <div class="col-md-2 col-xs-2">
        <input type=text name=leki[] class=form-control placeholder="nazwa" value={{Input::old('leki')[3]}}>
    </div>
    <div class="col-md-2 col-xs-2">
        <input type=text name=leki2[] class=form-control placeholder="dawka" value={{Input::old('leki2')[3]}}>
    </div>
    <div class="col-md-2 col-xs-2">
        <select name=leki3[]  class=form-control>
        <option value="1">Mg</option>
        <option value="2">ile litrow</option>
        <option value="3">ile sztuk</option>
        </select>
    </div>
</div>

<div class="row">
  <div class="col-md-1 col-xs-1"></div>
  <div class="col-md-3 col-xs-3"></div>
    <div class="col-md-4 col-xs-4">
      <div class="row">
        <div class="col-md-4 col-xs-4">
        <input type=date name=leki_rok[] class=form-control value={{Input::old('leki_rok')[3]}}>
            
        </div>
       
   
      </div>
    </div>
  <div class="col-md-3 col-xs-3">
     <div class="row">
        <div class="col-md-5 col-xs-5">
         @if (empty(Input::old('leki_godzina')[3]))
         <input type=time name=leki_godzina[] class=form-control  value={{$tablica_godzin3}}>
         @else
         <input type=time name=leki_godzina[] class=form-control value={{Input::old('leki_godzina')[3]}}>
         @endif
          
        </div>
       
    </div>
  </div>
  
</div>

</div>




<div class="row">
    <div class="col-md-4 col-xs-4"></div>
    <div class="col-md-2 col-xs-2">
    <button  class="btn btn-primary" onclick=dodaj_lek() type="button">Dodaj więcej lekow</button>
</div>
</div>

<div class="lek">

</div>

<div class="row">
  <div class="col-md-1 col-xs-1"></div>
  <div class="col-md-3 col-xs-3"><span class="normalna2">Co robiłem</span></div>
  <div class="col-md-5 col-xs-5">
    <div class="form-group">
        <textarea class="form-control" rows="3" col="20" id="comment" name="co_robilem" >{{Input::old('co_robilem')}}</textarea>
    </div>
  </div>
</div>
<div class="row">
    <div class="col-md-5 col-xs-5"></div>
        <div class="col-md-3 col-xs-3"><button  class="btn btn-primary" >dodaj</button>
        
        
    </div>
    <div class="row">
        <div class="col-md-2 col-xs-2"></div>
        <div class="col-md-3 col-xs-3"></div>
        <div class="col-md-5 col-xs-5">
 


        </div>
    </div>
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    </form>
    <div class="row">
<div class="col-md-5 col-xs-5">

</div>
<div class="col-md-4 col-xs-4">
<span class=wieksza>Dodaj nowy sen</span>
</div>

</div>
<div class="row">
  <form action={{ url('dodaj_sen') }} method=post>
  <div class="col-md-1 col-xs-1"></div>
  <div class="col-md-3 col-xs-3"><span class="normalna2">Godziny zaczęcia</span></div>
  <div class="col-md-4 col-xs-4">
  
      <div class="row">
        <div class="col-md-4 col-xs-4">
        <input type=date name=rok_a class=form-control>
           
            </div>
                 <div class="col-md-5 col-xs-5">
     
     <input type=time name=godzina_a class=form-control value="{{$tablica_godzin4}}">
        
     </div> 
     
  </div>
    </div>

  </div>
  
  <div class="row">
  <div class="col-md-1 col-xs-1"></div>
  <div class="col-md-3 col-xs-3"><span class="normalna2">Godzina skończenia</span></div>
    <div class="col-md-4 col-xs-4">
    <div class="row">
        <div class="col-md-4 col-xs-4">
        <input type=date name=rok_b class=form-control>
            
            </div>
                 <div class="col-md-5 col-xs-5">
     <input type=time name=godzina_b class=form-control value={{$tablica_godzin3}}>
  
  </div> 
            
  </div>
    </div>
  <div class="col-md-3 col-xs-3">
     <div class="row">

 
  </div>
  </div>
  

</div>
  <div class="row">
    <div class="col-md-1 col-xs-1"></div>
    <div class="col-md-3 col-xs-3"><span class="normalna2">Ilość wybuzeń</span></div>
    <div class="col-md-2 col-xs-2">
        <input type=text name=wybudzenia class=form-control value={{Input::old('wybudzenia')}}>
    </div>
</div>
<div class="row">
    <div class="col-md-5 col-xs-5"></div>
    <div class="col-md-6 col-xs-6">
   @php
    $bledy = $errors->all(':message');
   @endphp
      @foreach ($bledy as $bledy2)
         <span class=blad> {{$bledy2 }} <br></span>
      @endforeach
    </div>
</div>
</div>
<div id=opis_a>

</div>

<input type="hidden" name="_token" value="{{ csrf_token() }}">
<div class="row">
    <div class="col-md-5 col-xs-5"></div>
        <div class="col-md-3 col-xs-3"><button  class="btn btn-primary" >dodaj</button>
        
        
    </div>
</form>
<script language="javascript">


</script>
