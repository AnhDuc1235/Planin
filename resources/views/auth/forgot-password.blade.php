@extends('layouts.guest')

@section('title', 'Quên mật khẩu - Planin')

@section('content')
<div class="min-h-screen flex flex-col font-sans bg-white text-gray-800">

    @include('layouts.navbar')

    <main class="flex-1">
        <div
          class="min-h-[calc(100vh-64px)] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 bg-cover bg-center bg-no-repeat"
          style="background-image: url('/asset/bg-auth.jpg');"
        >
          <div class="max-w-sm w-full bg-white p-8 rounded-xl border border-gray-200">

            <div class="flex justify-center mb-5">
              <a href="/" class="cursor-pointer">
                <img src="/logo/planin-logo-board-transparent.svg" alt="Planin Logo" class="h-10 w-auto object-contain" />
              </a>
            </div>

            <h2 class="text-base sm:text-lg font-bold text-[#091E42] text-center mb-2 leading-normal">
              Quên mật khẩu
            </h2>
            <p class="text-xs text-gray-500 text-center mb-6 font-normal">
              Nhập email đã đăng ký, chúng tôi sẽ gửi liên kết để bạn đặt lại mật khẩu.
            </p>

            @if ($errors->any())
              <div class="mb-4 p-2.5 bg-red-50 border border-red-200 text-red-600 rounded-md text-xs font-normal">
                {{ $errors->first() }}
              </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
              @csrf

              <div>
                <label class="block text-xs font-semibold text-[#172B4D] mb-1">
                  Email <span class="text-red-500">*</span>
                </label>
                <input
                  type="email"
                  name="email"
                  value="{{ old('email') }}"
                  required
                  autofocus
                  placeholder="Nhập địa chỉ email"
                  class="w-full px-3 py-2 text-sm rounded-md border border-gray-300 focus:outline-none focus:border-[#AA6ADA] bg-white transition"
                />
              </div>

              <button
                type="submit"
                class="w-full mt-2 py-2.5 px-4 bg-[#AA6ADA] hover:bg-[#9252c4] text-white text-sm font-semibold rounded-md transition duration-150 cursor-pointer"
              >
                Gửi liên kết đặt lại mật khẩu
              </button>
            </form>

            <div class="mt-6 text-center text-xs text-gray-500 border-t border-gray-100 pt-4 font-normal">
              <a href="{{ route('login') }}" class="text-gray-400 hover:text-gray-600 transition cursor-pointer">
                &larr; Quay lại Đăng nhập
              </a>
            </div>

          </div>
        </div>
    </main>

</div>
@endsection
