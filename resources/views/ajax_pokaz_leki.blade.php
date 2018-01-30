
<div class="row" >
    <div class="col-md-2 col-xs-2"></div>
    <div class="col-md-8 col-xs-8">
        <div class=row>
         
          @for ($i=0;$i < count($leki);$i++)
         <div class="col-md-10 col-xs-10 obramowanie" id=usun_leki_{{$i}}>   
            Nazwa {{$leki[$i][0]}}
            dawka {{$leki[$i][1]}}
            @if($leki[$i][2] == 1)
                Mg
            @elseif($leki[$i][2] == 2)
                Mililitrów
            @endif
            {{$leki[$i][3]}}
            
            
          </div>  
          <div class="col-md-2 col-xs-2" >   
     
          <button  class="btn btn-danger" onclick=usun_lek('{{  url('/ajax/usun_lek') }}',{{$i}},{{$leki[$i][4]}}) type="button" id=usun_lek2{{$i}}>Usuń</button>
          </div>
          <div class="col-md-10 col-xs-10">  
            <div id="usun_leki_{{$i}}" class=usun_lek></div>
          </div>
          
          <div class=odstep>
          
          </div>
          
          @endfor
          
        </div>
    </div>
</div>

