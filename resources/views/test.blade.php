

	<table width=700 height=400 align=center class='tabela'>
	  <tr height=50>
	    <td colspan=7><div align=center><span class=pogrubiona>{{$miesiac2}} {{$rok}}</span></div></td>
	  </tr>
	  <tr height=50>
	  </tr>
	    <td width='14%'><div align=center><span class=normalna2>Pon</span></div></td>
	    <td width='14%'><div align=center><span class=normalna2>Wto</span></div></td>
	    <td width='14%'><div align=center><span class=normalna2>śro</span></div></td>
	    <td width='14%'><div align=center><span class=normalna2>Czwa</span></div></td>
	    <td width='14%'><div align=center><span class=normalna2>Pią</span></div></td>
	    <td width='14%'><div align=center><span class=normalna2>Sob</span></div></td>
	    <td width='14%'><div align=center><span class=normalna2>Nie</span></div></td>
	  </tr>
	  <tbody>
@php
$a = 0;
$i = 0;
@endphp

  @for ($wiersze=0;$wiersze < 7 and $dzien2 <= $jaki_dzien_miesiaca;$wiersze++) 

    <tr height=70>
    
    @for ($kolumny=0;$kolumny < 7;$kolumny++) 

      @if ($dzien2 <= $jaki_dzien_miesiaca ) 
      
        @if ($dzien2 == 10)
            
      
        @else
      
        
        @endif
	
	
        @if ($dzien1 >= $dzien_tygodnia )
            @if ( $dzien2 == $dzien3 or $dzien2 == $dzien )
            <td class="komorka1">
            @else
            <td class="{{$wynik[$dzien2][1]}}">
            @endif
            @if ( $dzien2 == $dzien3 ) 
                <div align=center><span class=wieksza>{{$dzien2}}</span></div>

            @elseif ( $dzien2 == $dzien ) 
                <div align=center><span class=wieksza>{{$dzien2}}</span></div>
	  

            @else
                <div align=center><a class=kalendarz href={{   url('glowna')}}/{{$rok}}/{{$miesiac}}/{{$dzien2}}  }}>{{$dzien2}}</a></div>
            @endif
        </td>
        @php
            $dzien2++;
        @endphp
        @else
        <td>
       
        @endif
	@php 
        $dzien1++;
	@endphp
	
    @endif
        @php
        $i++
        @endphp
    @endfor
    </tr>

  @endfor
  <tr>

</table>
<div class="row">
  <div class="col-md-2 col-xs-2"></div>
  <div class="col-md-4 col-xs-4"><a class=przycisk href={{ url('glowna')}}/{{$poprzedni[0]}}/{{$poprzedni[1]}}/1/wstecz>Wstecz</a></div>
  <div class="col-md-4 col-xs-4"><div align=right><a class=przycisk href={{ url('glowna')}}/{{$nastepny[0]}}/{{$nastepny[1]}}/1/dalej>dalej</a></div></div>
  
</div>


    
