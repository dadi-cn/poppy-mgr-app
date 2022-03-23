@extends('py-mgr-page::tpl.develop')
@section('develop-main')
    @include('py-mgr-page::develop.inc.header')
    {!! phpinfo() !!}
@endsection