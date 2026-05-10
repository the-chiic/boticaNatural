@extends('app')

@section('navbar')
    @include('components.navbar')
@endsection

@section('content')
    @yield('main_content')
@endsection