{{-- Trang thử hạ tầng (chỉ route môi trường local): layout board + Vue + CSRF. --}}
@extends('layouts.board')

@section('title', 'Planin - Thử Vue')

@section('content')
    <x-vue-mount id="vue-mount-test" :payload="['message' => 'Hạ tầng Vue hoạt động bình thường']" />
@endsection
