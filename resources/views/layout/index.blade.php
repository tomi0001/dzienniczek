<body>
<script src="{{asset('./jquery.js')}}"></script>
   <script src="https://cdn.socket.io/socket.io-1.2.0.js"></script>
        <script src="http://code.jquery.com/jquery-1.11.1.js"></script>
        
<link href="{{ asset('./style.css') }}" rel="stylesheet"> 
<link href="{{ asset('./bootstrap-3/css/bootstrap.min.css') }}" rel="stylesheet"> 


</bodY>
<div id="center">

  <div id="menu">
    <div class="row">
      <div class="col-md-12"><div align=center><span class=menu2>DZIENNIECZEK NASTROJOW</span></div></div>
    </div>

  </div>
  <div id="center2">
  
  &nbsp;
  </div>
  <div id="page">

    <div id=menu3><div align=center>MENU</div></div>
    <div class=menu4>
    <div class=menu3>Twoj profil</div>
    @if (empty(Auth::User()->id) )
    <div class=menu3><a class=menu href={{ url('/rejestracja') }}>Zarejestruj się </a></div>
    <div class=menu3><a class=menu href={{ url('/zaloguj') }}>Zaloguj się </a></div>
    @endif
    @if (!empty(Auth::User()->id) )
    <div class=menu3><a class=menu href={{ url('/wyloguj') }}>Wyloguj {{Auth::User()->login}} </a></div>
    <div class=menu3><a class=menu href={{ url('/glowna') }}>Głowna strona </a></div>
    @endif
    <div class=menu3>Wyloguj</div>
    </div>

    @yield('content')
  </div>

</div>
<script src="{{asset('./funkcje.js')}}"></script>

