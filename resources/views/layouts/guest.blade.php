{{--
    LAYOUT KHÁCH: trang chủ, đăng nhập, đăng ký (chưa cần đăng nhập).
    Chỉ nạp CSS, không nạp Vue.
    Trang con: @extends('layouts.guest') + @section('content').
--}}
@extends('layouts.base')

@section('body')
    @yield('content')
    <x-flash />
@endsection
