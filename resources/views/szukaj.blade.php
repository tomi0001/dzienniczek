@extends('layout.index')
@section('content')
    
    
    <div class=szukaj>
    
        <form action = "{{ url('wyszukaj2') }}" method=get>
    
    <div class="row">
            <div class="col-md-1 col-xs-1">
            
            </div>
            <div class="col-md-2 col-xs-2">
                <span class=normalna2>Nastrój od</span>
            </div>
            <div class="col-md-3 col-xs-3">
         
                <div class="row">
                    <div class="col-md-4 col-xs-4">
                        <input type=text name=nastroj_od class=form-control>
                    </div>
                    <div class="col-md-2 col-xs-2">
                        <span class=normalna2>do</span>
                    </div>
                    <div class="col-md-4 col-xs-4">
                        <input type=text name=nastroj_do class=form-control>
                    </div>
     
                </div>
            </div>

    </div>
    <div class="row">
            <div class="col-md-1 col-xs-1">
            
            </div>
            <div class="col-md-2 col-xs-2">
                <span class=normalna2>poziom lęku od</span>
            </div>
            <div class="col-md-3 col-xs-3">
         
                <div class="row">
                    <div class="col-md-4 col-xs-4">
                        <input type=text name=lek_od class=form-control>
                    </div>
                    <div class="col-md-2 col-xs-2">
                        <span class=normalna2>do</span>
                    </div>
                    <div class="col-md-4 col-xs-4">
                        <input type=text name=lek_do class=form-control>
                    </div>
     
                </div>
            </div>

    </div>
    <div class="row">
            <div class="col-md-1 col-xs-1">
            
            </div>
            <div class="col-md-2 col-xs-2">
                <span class=normalna2>poziom pobudzenia od</span>
            </div>
            <div class="col-md-3 col-xs-3">
         
                <div class="row">
                    <div class="col-md-4 col-xs-4">
                        <input type=text name=pobudzenie_od class=form-control>
                    </div>
                    <div class="col-md-2 col-xs-2">
                        <span class=normalna2>do</span>
                    </div>
                    <div class="col-md-4 col-xs-4">
                        <input type=text name=pobudzenie_do class=form-control>
                    </div>
     
                </div>
            </div>
  
    </div>
    <div class="row">
            <div class="col-md-1 col-xs-1">
            
            </div>
            <div class="col-md-2 col-xs-2">
                <span class=normalna2>poziom zdenerowania od</span>
            </div>
            <div class="col-md-3 col-xs-3">
         
                <div class="row">
                    <div class="col-md-4 col-xs-4">
                        <input type=text name=zdenerowania_od class=form-control>
                    </div>
                    <div class="col-md-2 col-xs-2">
                        <span class=normalna2>do</span>
                    </div>
                    <div class="col-md-4 col-xs-4">
                        <input type=text name=zdenerowania_do class=form-control>
                    </div>
     
                </div>
            </div>

    </div>
    <div class="row">
            <div class="col-md-1 col-xs-1">
            
            </div>
            <div class="col-md-2 col-xs-2">
                <span class=normalna2>data od</span>
            </div>
            <div class="col-md-5 col-xs-5">
         
                <div class="row">
                    <div class="col-md-5 col-xs-5">
                         <select name="nastroj_rok" class=form-control>
            <option value=""></option>
            @for ($i=0;$i < count($rok_zaczecia);$i++)
                <option value={{$rok_zaczecia[$i]}}>{{$rok_zaczecia[$i]}}</option>
            @endfor
            </select>
                    </div>
                    <div class="col-md-3 col-xs-3">
                                    <select name="nastroj_miesiac" class=form-control>
            <option value=""></option>
            @for ($i=0;$i <= 12;$i++)
                <option value={{$i}}>{{$i}}</option>
                @endfor
                </select>
                    </div>
                     <div class="col-md-3 col-xs-3">
                                    <select name="nastroj_dzien" class=form-control>
            <option value=""></option>
            @for ($i=0;$i <= 31;$i++)
                <option value={{$i}}>{{$i}}</option>
                @endfor
                </select>
                    </div>               
     
                </div>
            </div>

    </div>
    
        <div class="row">
            <div class="col-md-1 col-xs-1">
            
            </div>
            <div class="col-md-2 col-xs-2">
                <span class=normalna2>data od</span>
            </div>
            <div class="col-md-5 col-xs-5">
         
                <div class="row">
                    <div class="col-md-5 col-xs-5">
                         <select name="nastroj_rok2" class=form-control>
            <option value=""></option>
            @for ($i=0;$i < count($rok_zaczecia);$i++)
                <option value={{$rok_zaczecia[$i]}}>{{$rok_zaczecia[$i]}}</option>
            @endfor
            </select>
                    </div>
                    <div class="col-md-3 col-xs-3">
                                    <select name="nastroj_miesiac2" class=form-control>
            <option value=""></option>
            @for ($i=0;$i <= 12;$i++)
                <option value={{$i}}>{{$i}}</option>
                @endfor
                </select>
                    </div>
                     <div class="col-md-3 col-xs-3">
                                    <select name="nastroj_dzien2" class=form-control>
            <option value=""></option>
            @for ($i=0;$i <= 31;$i++)
                <option value={{$i}}>{{$i}}</option>
                @endfor
                </select>
                    </div>               
     
                </div>
            </div>

    </div>
    <div class="row">
            <div class="col-md-1 col-xs-1">
            
            </div>
            <div class="col-md-2 col-xs-2">
            <span class=normalna2>Słowa kluczowe co robiłem</span>
            </div>
            <div class="col-md-5 col-xs-5">
                <div align=center><input type=text class=form-control name=opis></div>
            </div>
            
        </div>
            <div class="row">
            <div class="col-md-1 col-xs-1">
            
            </div>
            <div class="col-md-2 col-xs-2">
            <span class=normalna2>Wyszukaj następujące leki</span>
            </div>
            <div class="col-md-5 col-xs-5">
                <div align=center><input type=text class=form-control name=leki></div>
            </div>
            
        </div>
        
            <div class="row">
            <div class="col-md-1 col-xs-1">
            
            </div>
            <div class="col-md-2 col-xs-2">
            <span class=normalna2>Sortuj według</span>
            </div>
            <div class="col-md-5 col-xs-5">
                <div align=center><select class=form-control name=sortuj>
                <option value=godzina_zaczecia>Według daty</option>
                <option value=poziom_nastroju>Według nastroju</option>
                <option value=poziom_leku>Według poziomu lęku</option>
                <option value=poziom_zdenerwania>Według poziomu zdenerwowania</option>
                <option value=pobudzenie>Według poziomu pobudzenia</option>
                <option value=czas>Sotruj według długości trwania nastroju</option>
                </select>
                </div>
            </div>
            
        </div>

        
        <div class="row">
            <div class="col-md-12 col-xs-12">
                <div align=center><button class="btn btn-primary">szukaj</button></div>
            </div>
            
        </div>
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        </form>
    </div>

  
    </div>
    
@endsection
