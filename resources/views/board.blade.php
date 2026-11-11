@extends('layouts.app')

@section('title', 'Planin - Không gian làm việc')

@section('content')
<div class="min-h-screen bg-white text-[#091E42] flex flex-col font-sans w-full">

    {{-- 1. Thanh Header --}}
    @include('board.header')

    {{-- 2. Nội dung chính (Sidebar trái + Body khu vực chính) --}}
    <div class="flex-1 flex w-full">
        @include('board.sidebar')
        @include('board.main')
    </div>

    {{-- 3. Các Popup Modal --}}
    @include('board.modal-workspace')
    @include('board.modal-board')

</div>

{{-- 4. JavaScript xử lý Modal và Dropdown --}}
@include('board.scripts')
@endsection
