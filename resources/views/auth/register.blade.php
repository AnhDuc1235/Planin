@extends('layouts.app')

@section('content')
<div class="min-h-screen flex flex-col font-sans bg-white text-gray-800">
    
    @include('layouts.navbar')

    <main class="flex-1">
        <!-- Giao diện Đăng ký chuẩn tiếng Việt, nền ảnh /asset/bg-auth.jpg -->
        <div 
          class="min-h-[calc(100vh-64px)] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 bg-cover bg-center bg-no-repeat"
          style="background-image: url('/asset/bg-auth.jpg');"
        >
          <div class="max-w-sm w-full bg-white p-8 rounded-xl border border-gray-200">
            
            <!-- 1. Logo Planin căn giữa -->
            <div class="flex justify-center mb-5">
              <a href="/" class="cursor-pointer">
                <img 
                  src="/logo/planin-logo-board-transparent.svg" 
                  alt="Planin Logo" 
                  class="h-10 w-auto object-contain"
                />
              </a>
            </div>

            <!-- 2. Tiêu đề tiếng Việt: "Đăng ký tài khoản" -->
            <h2 class="text-base sm:text-lg font-bold text-[#091E42] text-center mb-6 leading-normal">
              Đăng ký tài khoản
            </h2>

            <!-- Thông báo lỗi từ Session Laravel -->
            @if ($errors->any())
              <div class="mb-4 p-2.5 bg-red-50 border border-red-200 text-red-600 rounded-md text-xs font-normal">
                {{ $errors->first() }}
              </div>
            @endif

            <!-- 3. Form Đăng ký gửi trực tiếp qua POST /register (Session thuần) -->
            <form method="POST" action="{{ route('register.post') }}" class="space-y-4">
              @csrf

              <!-- Họ và tên -->
              <div>
                <label class="block text-xs font-semibold text-[#172B4D] mb-1">
                  Họ và tên <span class="text-red-500">*</span>
                </label>
                <input 
                  type="text" 
                  name="name"
                  value="{{ old('name') }}"
                  required
                  placeholder="Nhập họ và tên của bạn"
                  class="w-full px-3 py-2 text-sm rounded-md border border-gray-300 focus:outline-none focus:border-[#AA6ADA] bg-white transition"
                />
              </div>

              <!-- Email -->
              <div>
                <label class="block text-xs font-semibold text-[#172B4D] mb-1">
                  Email <span class="text-red-500">*</span>
                </label>
                <input 
                  type="email" 
                  name="email"
                  value="{{ old('email', request('email')) }}"
                  required
                  placeholder="Nhập địa chỉ email"
                  class="w-full px-3 py-2 text-sm rounded-md border border-gray-300 focus:outline-none focus:border-[#AA6ADA] bg-white transition"
                />
              </div>

              <!-- Mật khẩu -->
              <div>
                <label class="block text-xs font-semibold text-[#172B4D] mb-1">
                  Mật khẩu <span class="text-red-500">*</span>
                </label>
                <input 
                  type="password" 
                  name="password"
                  required
                  placeholder="Nhập mật khẩu (tối thiểu 6 ký tự)"
                  class="w-full px-3 py-2 text-sm rounded-md border border-gray-300 focus:outline-none focus:border-[#AA6ADA] bg-white transition"
                />
              </div>

              <!-- Nút Đăng ký màu tím #AA6ADA -->
              <button 
                type="submit" 
                class="w-full mt-2 py-2.5 px-4 bg-[#AA6ADA] hover:bg-[#9252c4] text-white text-sm font-semibold rounded-md transition duration-150 cursor-pointer"
              >
                Đăng ký
              </button>
            </form>

            <!-- 4. Chuyển sang Đăng nhập & Quay về trang chủ -->
            <div class="mt-6 text-center text-xs text-gray-500 space-y-2 border-t border-gray-100 pt-4 font-normal">
              <p>
                Đã có tài khoản? 
                <a 
                  href="{{ route('login') }}" 
                  class="font-semibold text-[#AA6ADA] hover:underline ml-1 cursor-pointer"
                >
                  Đăng nhập
                </a>
              </p>

              <div>
                <a 
                  href="/" 
                  class="text-gray-400 hover:text-gray-600 transition cursor-pointer"
                >
                  &larr; Quay lại Trang chủ
                </a>
              </div>
            </div>

          </div>
        </div>
    </main>

</div>
@endsection
