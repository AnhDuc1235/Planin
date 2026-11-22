{{--
    LAYOUT ỨNG DỤNG: các trang sau đăng nhập có header + sidebar
    (vd: danh sách workspace/bảng). Có nạp Vue (app.js) để mount từng phần.

    Trang con dùng các section:
      title    : tiêu đề tab
      sidebar  : thanh bên trái (tùy chọn)
      content  : nội dung chính
      modals   : các popup modal (tùy chọn)
    và @push('scripts') cho JavaScript riêng của trang.
--}}
@extends('layouts.base')

@section('body')
    @push('head')
        @vite(['resources/js/app.js'])
    @endpush

    <div class="min-h-screen bg-white text-[#091E42] flex flex-col font-sans w-full">

        {{-- 1. Thanh header --}}
        @include('board.header')

        {{-- 2. Sidebar trái + nội dung chính --}}
        <div class="flex-1 flex w-full">
            @yield('sidebar')
            @yield('content')
        </div>

        {{-- 3. Popup modal --}}
        @yield('modals')
    </div>

    <x-flash />
@endsection
