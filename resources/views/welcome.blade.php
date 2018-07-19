
<link href="{{ asset('./bootstrap-3/css/bootstrap.min.css') }}" rel="stylesheet"> 

<div class="row">

  @for($i=0;$i< count($tablica);$i++)
   @if ($tablica[$i][9] != null)
   <div class="col-md-12">
       <span color="black">Dzień {{$tablica[$i][9]}}
    poziom nastroju dla tego dnia {{$tablica[$i][10]}}</span>
   </div>
   @endif
   <div class="col-md-12">
   <div class="row">
   
    <div class="col-md-12">Data startu {{$tablica[$i][0]}} - data endu {{$tablica[$i][1]}}</div>
   </div>
   <div class="row">
    <div class="col-md-12">nastroj {{$tablica[$i][2]}} lęk {{$tablica[$i][3]}} zdenerwowanie {{$tablica[$i][4]}} pobudzenie {{$tablica[$i][6]}} 
    @if ($tablica[$i][5] != 0)
    epizody psychotyczne {{$tablica[$i][5]}}
    @endif
    </div>
   </div>
   
   <div class="row">
    <div class="col-md-12">
      @if ($tablica[$i][7] != null)
      {{$tablica[$i][7]}}
      @endif
    </div>
   </div>
   
   </div>
    <br>
	

  @endfor

</div>