{{--
    Khung chung cho trang lỗi (403, 404, 419, 429, 500, 503).
    Trang lỗi con khai báo: code, title, message (và actions nếu cần).
--}}
@extends('layouts.base')

@section('title', trim($__env->yieldContent('title_text')) . ' - Planin')

@section('body')
    <main class="min-h-screen flex flex-col items-center justify-center px-6 py-12 text-center bg-white">
        <a href="{{ url('/') }}" class="mb-10">
            <img src="/logo/planin-logo-board-transparent.svg" alt="Planin" class="h-10 w-auto object-contain" />
        </a>

        <p class="text-7xl sm:text-8xl font-black text-[#AA6ADA] tracking-tight">@yield('code')</p>
        <h1 class="mt-4 text-xl sm:text-2xl font-bold text-[#091E42]">@yield('title_text')</h1>
        <p class="mt-2 max-w-md text-sm sm:text-base text-gray-500">@yield('message')</p>

        <div class="mt-8 flex flex-wrap items-center justify-center gap-3">
            @hasSection('actions')
                @yield('actions')
            @else
                <a
                    href="{{ url('/') }}"
                    class="px-4 py-2.5 rounded-md bg-[#AA6ADA] hover:bg-[#9252c4] text-white text-sm font-semibold transition"
                >Về trang chủ</a>
                <button
                    type="button"
                    onclick="history.length > 1 ? history.back() : (location.href = '{{ url('/') }}')"
                    class="px-4 py-2.5 rounded-md bg-gray-100 hover:bg-gray-200 text-gray-800 text-sm font-semibold transition"
                >Quay lại</button>
            @endif
        </div>
    </main>
@endsection
