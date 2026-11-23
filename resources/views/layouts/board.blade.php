{{--
    LAYOUT BẢNG KANBAN: toàn màn hình, nền theo phông của bảng, cột cuộn ngang.
    Nạp resources/js/app.js (Vue) + meta csrf-token (từ layouts.base).

    Trang con (vd: boards.show):
      - truyền biến $board để lấy phông nền (không bắt buộc)
      - @section('title'), @section('content')
      - phần tử mount Vue: <x-vue-mount id="board-app" :payload="[...]" />
--}}
@extends('layouts.base')

@section('body_class', 'h-screen overflow-hidden flex flex-col bg-white text-[#091E42] antialiased font-sans')

@section('body')
    @push('head')
        @vite(['resources/js/app.js'])
    @endpush

    @include('board.header')

    <main
        class="flex-1 min-h-0 overflow-hidden"
        style="background: {{ \App\Support\BoardBackground::css($board->background ?? null) }};"
    >
        @yield('content')
    </main>

    <x-flash />

    @push('scripts')
        @include('board.scripts')
    @endpush
@endsection
