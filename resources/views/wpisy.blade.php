@for ($i=0;$i < count($wpisy);$i++)
<div class="row">
    <div class="col-md-2 col-xs-2"></div>
    <div class="col-md-3 col-xs-3">
        {{$wpisy[$i][9]}}
    </div>
    <div class="col-md-3 col-xs-3">
        {{$wpisy[$i][10]}}
    </div>
</div>
@if ($wpisy[$i][5] == -21)



{{$wpisy[$i][4]}}


<div class="row">
    <div class="col-md-2 col-xs-2"></div>

</div>
<div class="row">
    <div class="col-md-2 col-xs-2"></div>
    <div class="col-md-8 col-xs-8">
        <div class="sen" style="width: {{$wpisy[$i][11]}}%;"}>&nbsp;</div>
    </div>
    
</div>


@else
<div class="row">
    <div class="col-md-2 col-xs-2"></div>
    <div class="col-md-2 col-xs-2">
        Poziom nastroju {{$wpisy[$i][1]}} 
    </div>
    <div class="col-md-2 col-xs-2">
        Poziom lęku {{$wpisy[$i][5]}}
    </div>
    <div class="col-md-2 col-xs-2">
        zdenerowania {{$wpisy[$i][6]}}
    </div>
    <div class="col-md-2 col-xs-2">
        pobudzenia {{$wpisy[$i][8]}}
    </div>
</div>
<div class="row">
    <div class="col-md-2 col-xs-2"></div>
    <div class="col-md-8 col-xs-8">
        <div class="nastroj {{$wpisy[$i][12]}}" style="width: {{$wpisy[$i][11]}}%;"}>&nbsp;</div>
    </div>
    
</div>
@endif
<br>
@endfor


<div class="row">
  <form action={{ url('dodaj_wpis') }} method=post>
  <div class="col-md-1 col-xs-1"></div>
  <div class="col-md-3 col-xs-3"><span class="normalna2">Godziny zaczęcia</span></div>
  <div class="col-md-4 col-xs-4">
    <div class="row">
        <div class="col-md-4 col-xs-4">
            <select name="rok_a" class=form-control  value={{Input::old('rok_a')}}>
            <option value=""></option>
            @for ($i=0;$i < count($rok_zaczecia);$i++)
                <option value={{$rok_zaczecia[$i]}}>{{$rok_zaczecia[$i]}}</option>
            @endfor
            </select>
            </div>
              <div class="col-md-4 col-xs-4">
            <select name="miesiac_a" class=form-control>
            <option value=""></option>
            @for ($i=0;$i <= 12;$i++)
                <option value={{$i}}>{{$i}}</option>
            @endfor
            </select>
            
            </div>
            <div class="col-md-4 col-xs-4">
            <select name="dzien_a" class=form-control>
            <option value=""></option>
            @for ($i=0;$i <= 31;$i++)
                <option value={{$i}}>{{$i}}</option>
            @endfor
            </select>
            
            </div>
  </div>
    </div>
  <div class="col-md-3 col-xs-3">
     <div class="row">
     <div class="col-md-5 col-xs-5">
        <select name="godzina_a" class=form-control>
  @for($i=0;$i< count($tablica_godzin2);$i++)
    
    <option value {{$tablica_godzin2[$i]}}>{{$i}}</option>
  @endfor
  </select>
     </div>
     <div class="col-md-5 col-xs-5">
        <select name="minuta_a" class=form-control>
        @for($i=0;$i< count($tablica_minut2);$i++)
    
            <option value {{$tablica_minut2[$i]}}>{{$i}}</option>
        @endfor
    </select>
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
            <select name="rok_b" class=form-control>
            <option value=""></option>
            @for ($i=0;$i < count($rok_zaczecia);$i++)
                <option value={{$rok_zaczecia[$i]}}>{{$rok_zaczecia[$i]}}</option>
            @endfor
            </select>
            </div>
              <div class="col-md-4 col-xs-4">
            <select name="miesiac_b" class=form-control>
            <option value=""></option>
            @for ($i=0;$i <= 12;$i++)
                <option value={{$i}}>{{$i}}</option>
            @endfor
            </select>
            
            </div>
            <div class="col-md-4 col-xs-4">
            <select name="dzien_b" class=form-control>
            <option value=""></option>
            @for ($i=0;$i <= 31;$i++)
                <option value={{$i}}>{{$i}}</option>
            @endfor
            </select>
            
            </div>
  </div>
    </div>
  <div class="col-md-3 col-xs-3">
     <div class="row">
     <div class="col-md-5 col-xs-5">
  <select name="godzina_b" class=form-control>
  @for($i=0;$i< count($tablica_godzin3);$i++)
    
    <option value {{$tablica_godzin3[$i]}}>{{$i}}</option>
  @endfor
  </select>
  </div>
  <div class="col-md-5 col-xs-5">
      <select name="minuta_b" class=form-control>
        @for($i=0;$i< count($tablica_minut);$i++)
    
            <option value {{$tablica_minut[$i]}}>{{$i}}</option>
        @endfor
    </select>
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
        <input type=text  id=leki[]  name=leki[] class=form-control placeholder="nazwa" value={{Input::old('leki[]')}}>
    </div>
    <div class="col-md-2 col-xs-2">
        <input type=text name=leki2[] class=form-control placeholder="dawka">
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
            <select name="leki_rok[]" class=form-control>
            <option value=""></option>
            @for ($i=0;$i < count($rok_zaczecia);$i++)
                <option value={{$rok_zaczecia[$i]}}>{{$rok_zaczecia[$i]}}</option>
            @endfor
            </select>
        </div>
        <div class="col-md-4 col-xs-4">
            <select name="leki_miesiac[]" class=form-control>
            <option value=""></option>
            @for ($i=0;$i <= 12;$i++)
                <option value={{$i}}>{{$i}}</option>
            @endfor
            </select>
            
        </div>
        <div class="col-md-4 col-xs-4">
            <select name="leki_dzien[]" class=form-control>
            <option value=""></option>
            @for ($i=0;$i <= 31;$i++)
                <option value={{$i}}>{{$i}}</option>
            @endfor
            </select>
            
        </div>
      </div>
    </div>
  <div class="col-md-3 col-xs-3">
     <div class="row">
        <div class="col-md-5 col-xs-5">
            <select name="leki_godzina[]" class=form-control>
            @for($i=0;$i< count($tablica_godzin3);$i++)
    
                <option value {{$tablica_godzin3[$i]}}>{{$i}}</option>
            @endfor
            </select>
        </div>
        <div class="col-md-5 col-xs-5">
            <select name="leki_minuta[]" class=form-control>
                @for($i=0;$i< count($tablica_minut);$i++)
    
                    <option value {{$tablica_minut[$i]}}>{{$i}}</option>
                @endfor
            </select>
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
        <input type=text id=leki[] name=leki[] class=form-control placeholder="nazwa">
    </div>
    <div class="col-md-2 col-xs-2">
        <input type=text name=leki2[] class=form-control placeholder="dawka">
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
            <select name="leki_rok[]" class=form-control>
            <option value=""></option>
            @for ($i=0;$i < count($rok_zaczecia);$i++)
                <option value={{$rok_zaczecia[$i]}}>{{$rok_zaczecia[$i]}}</option>
            @endfor
            </select>
        </div>
        <div class="col-md-4 col-xs-4">
            <select name="leki_miesiac[]" class=form-control>
            <option value=""></option>
            @for ($i=0;$i <= 12;$i++)
                <option value={{$i}}>{{$i}}</option>
            @endfor
            </select>
            
        </div>
        <div class="col-md-4 col-xs-4">
            <select name="leki_dzien[]" class=form-control>
            <option value=""></option>
            @for ($i=0;$i <= 31;$i++)
                <option value={{$i}}>{{$i}}</option>
            @endfor
            </select>
            
        </div>
      </div>
    </div>
  <div class="col-md-3 col-xs-3">
     <div class="row">
        <div class="col-md-5 col-xs-5">
            <select name="leki_godzina[]" class=form-control>
            @for($i=0;$i< count($tablica_godzin3);$i++)
    
                <option value {{$tablica_godzin3[$i]}}>{{$i}}</option>
            @endfor
            </select>
        </div>
        <div class="col-md-5 col-xs-5">
            <select name="leki_minuta[]" class=form-control>
                @for($i=0;$i< count($tablica_minut);$i++)
    
                    <option value {{$tablica_minut[$i]}}>{{$i}}</option>
                @endfor
            </select>
        </div>
    </div>
  </div>
</div>


<br>

<div class="row">
    <div class="col-md-1 col-xs-1"></div>
    <div class="col-md-3 col-xs-3"></div>
    <div class="col-md-2 col-xs-2">
        <input type=text name=leki[] class=form-control placeholder="nazwa">
    </div>
    <div class="col-md-2 col-xs-2">
        <input type=text name=leki2[] class=form-control placeholder="dawka">
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
            <select name="leki_rok[]" class=form-control>
            <option value=""></option>
            @for ($i=0;$i < count($rok_zaczecia);$i++)
                <option value={{$rok_zaczecia[$i]}}>{{$rok_zaczecia[$i]}}</option>
            @endfor
            </select>
        </div>
        <div class="col-md-4 col-xs-4">
            <select name="leki_miesiac[]" class=form-control>
            <option value=""></option>
            @for ($i=0;$i <= 12;$i++)
                <option value={{$i}}>{{$i}}</option>
            @endfor
            </select>
            
        </div>
        <div class="col-md-4 col-xs-4">
            <select name="leki_dzien[]" class=form-control>
            <option value=""></option>
            @for ($i=0;$i <= 31;$i++)
                <option value={{$i}}>{{$i}}</option>
            @endfor
            </select>
            
        </div>
      </div>
    </div>
  <div class="col-md-3 col-xs-3">
     <div class="row">
        <div class="col-md-5 col-xs-5">
            <select name="leki_godzina[]" class=form-control>
            @for($i=0;$i< count($tablica_godzin3);$i++)
    
                <option value {{$tablica_godzin3[$i]}}>{{$i}}</option>
            @endfor
            </select>
        </div>
        <div class="col-md-5 col-xs-5">
            <select name="leki_minuta[]" class=form-control>
                @for($i=0;$i< count($tablica_minut);$i++)
    
                    <option value {{$tablica_minut[$i]}}>{{$i}}</option>
                @endfor
            </select>
        </div>
    </div>
  </div>
</div>
<br>
<div class="row">
    <div class="col-md-1 col-xs-1"></div>
    <div class="col-md-3 col-xs-3"></div>
    <div class="col-md-2 col-xs-2">
        <input type=text name=leki[] class=form-control placeholder="nazwa">
    </div>
    <div class="col-md-2 col-xs-2">
        <input type=text name=leki2[] class=form-control placeholder="dawka">
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
            <select name="leki_rok[]" class=form-control>
            <option value=""></option>
            @for ($i=0;$i < count($rok_zaczecia);$i++)
                <option value={{$rok_zaczecia[$i]}}>{{$rok_zaczecia[$i]}}</option>
            @endfor
            </select>
        </div>
        <div class="col-md-4 col-xs-4">
            <select name="leki_miesiac[]" class=form-control>
            <option value=""></option>
            @for ($i=0;$i <= 12;$i++)
                <option value={{$i}}>{{$i}}</option>
            @endfor
            </select>
            
        </div>
        <div class="col-md-4 col-xs-4">
            <select name="leki_dzien[]" class=form-control>
            <option value=""></option>
            @for ($i=0;$i <= 31;$i++)
                <option value={{$i}}>{{$i}}</option>
            @endfor
            </select>
            
        </div>
      </div>
    </div>
  <div class="col-md-3 col-xs-3">
     <div class="row">
        <div class="col-md-5 col-xs-5">
            <select name="leki_godzina[]" class=form-control>
            @for($i=0;$i< count($tablica_godzin3);$i++)
    
                <option value {{$tablica_godzin3[$i]}}>{{$i}}</option>
            @endfor
            </select>
        </div>
        <div class="col-md-5 col-xs-5">
            <select name="leki_minuta[]" class=form-control>
                @for($i=0;$i< count($tablica_minut);$i++)
    
                    <option value {{$tablica_minut[$i]}}>{{$i}}</option>
                @endfor
            </select>
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
        
        <input type=button class="btn btn-danger" onclick=zapisz_nastroj('{{ url('/ajax/dodaj_nastroj')}}')  value="dodaj"></div>
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
  <form action={{ url('dodaj_sen') }} method=post>
  <div class="col-md-1 col-xs-1"></div>
  <div class="col-md-3 col-xs-3"><span class="normalna2">Godziny zaczęcia</span></div>
  <div class="col-md-4 col-xs-4">
  
      <div class="row">
        <div class="col-md-4 col-xs-4">
            <select name="rok_a" class=form-control  value={{Input::old('rok_a')}}>
            <option value=""></option>
            @for ($i=0;$i < count($rok_zaczecia);$i++)
                <option value={{$rok_zaczecia[$i]}}>{{$rok_zaczecia[$i]}}</option>
            @endfor
            </select>
            </div>
              <div class="col-md-4 col-xs-4">
            <select name="miesiac_a" class=form-control>
            <option value=""></option>
            @for ($i=0;$i <= 12;$i++)
                <option value={{$i}}>{{$i}}</option>
            @endfor
            </select>
            
            </div>
            <div class="col-md-4 col-xs-4">
            <select name="dzien_a" class=form-control>
            <option value=""></option>
            @for ($i=0;$i <= 31;$i++)
                <option value={{$i}}>{{$i}}</option>
            @endfor
            </select>
            
            </div>
  </div>
    </div>
  <div class="col-md-3 col-xs-3">
     <div class="row">
     <div class="col-md-5 col-xs-5">
        <select name="godzina_a" class=form-control>
  @for($i=0;$i< count($tablica_godzin4);$i++)
    
    <option value {{$tablica_godzin4[$i]}}>{{$i}}</option>
  @endfor
  </select>
     </div>
     <div class="col-md-5 col-xs-5">
        <select name="minuta_a" class=form-control>
        @for($i=0;$i< count($tablica_minut);$i++)
    
            <option value {{$tablica_minut[$i]}}>{{$i}}</option>
        @endfor
    </select>
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
            <select name="rok_b" class=form-control>
            <option value=""></option>
            @for ($i=0;$i < count($rok_zaczecia);$i++)
                <option value={{$rok_zaczecia[$i]}}>{{$rok_zaczecia[$i]}}</option>
            @endfor
            </select>
            </div>
              <div class="col-md-4 col-xs-4">
            <select name="miesiac_b" class=form-control>
            <option value=""></option>
            @for ($i=0;$i <= 12;$i++)
                <option value={{$i}}>{{$i}}</option>
            @endfor
            </select>
            
            </div>
            <div class="col-md-4 col-xs-4">
            <select name="dzien_b" class=form-control>
            <option value=""></option>
            @for ($i=0;$i <= 31;$i++)
                <option value={{$i}}>{{$i}}</option>
            @endfor
            </select>
            
            </div>
  </div>
    </div>
  <div class="col-md-3 col-xs-3">
     <div class="row">
     <div class="col-md-5 col-xs-5">
  <select name="godzina_b" class=form-control>
  @for($i=0;$i< count($tablica_godzin3);$i++)
    
    <option value {{$tablica_godzin3[$i]}}>{{$i}}</option>
  @endfor
  </select>
  </div>
  <div class="col-md-5 col-xs-5">
      <select name="minuta_b" class=form-control>
        @for($i=0;$i< count($tablica_minut);$i++)
    
            <option value {{$tablica_minut[$i]}}>{{$i}}</option>
        @endfor
    </select>
  </div>
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
</form>
<script language="javascript">


</script>
