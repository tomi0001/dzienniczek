@extends('layout.index')
@section('content')
<form action={{ url('zarejestruj') }} method=post>
<div class="row">
    <div class="col-md-4 col-xs-4"></div>
    <div class="col-md-2 col-xs-2"><span class=normalna2>Twoj login</span></div>
    <div class="col-md-2 col-xs-2"><input type=text id=login2 size=5  class=form-control name=name value={{Input::old('name')}}></div>
</div>
<div class="row">
    <div class="col-md-4 col-xs-4"></div>
    <div class="col-md-2 col-xs-2"><span class=normalna2>Twoje has  ło</span></div>
    <div class="col-md-2 col-xs-2"><input type=password id=haslo size=5  class=form-control name=haslo></div>
</div>
<div class="row">
    <div class="col-md-4 col-xs-4"></div>
    <div class="col-md-2 col-xs-2"><span class=normalna2>Wpisz jeszcze Twoje hasł  o</span></div>
    <div class="col-md-2 col-xs-2"><input type=password id=haslo2 size=5  class=form-control name=haslo2></div>
</div>
<div class="row">
    <div class="col-md-4 col-xs-4"></div>
    <div class="col-md-2 col-xs-2"><span class=normalna2>Twoj email</span></div>
    <div class="col-md-2 col-xs-2"><input type=text id=email size=5  class=form-control name=email  value={{Input::old('email')}}></div>
</div>
<div class="row">
    <div class="col-md-4 col-xs-4"></div>
    <div class="col-md-2 col-xs-2"><span class=normalna2>Początek dnia</span></div>
    <div class="col-md-2 col-xs-2"><input type=text id=email size=5  class=form-control name=dzien value={{Input::old('dzien')}}></div>
</div>
<input type="hidden" name="_token" value="{{ csrf_token() }}">
<div class="row">
    <div class="col-md-3 col-xs-3"></div>
    <div class="col-md-6 col-xs-6"><div align=center><button  class="btn btn-primary">Zarejestroj</button></div></div>
    
</div>
<div class="row">
    <div class="col-md-4 col-xs-4"></div>
    <div class="col-md-3 col-xs-3">
    <div align=center>
 <?php $messages = $errors->all(':message') ?>
      <?php foreach ($messages as $msg): ?>
         <span class=blad><?= $msg ?> <br></span>
      <?php endforeach; ?>
      <span class=blad>{{Session::get('ile')}}</span>
</form>

    </div>
    </div>
@endsection

