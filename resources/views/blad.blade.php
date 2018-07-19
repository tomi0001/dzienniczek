@extends('layout.index')
@section('content')
<div align=center><span class=blad>{{Session::get('login_error')}}</span><br><a href=javascript:history.back()>Wstecz</a></div>
@endsection
