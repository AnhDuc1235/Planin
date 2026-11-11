<!-- Header đơn giản hóa, không shadow, phông chữ Roboto, cursor pointer -->
<header class="sticky top-0 z-50 bg-white border-b border-gray-200">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex items-center justify-between h-16">
      
      <!-- Bên trái: Chỉ có Logo + 2 mục: Giới thiệu, Đi tới Board -->
      <div class="flex items-center space-x-8">
        <a href="/" class="flex items-center cursor-pointer">
          <img 
            src="/logo/planin-logo-board-transparent.svg" 
            alt="Planin Logo" 
            class="h-10 w-auto object-contain"
          />
        </a>

        <!-- Menu bên trái: chỉ có 2 mục theo yêu cầu -->
        <nav class="flex items-center space-x-6 text-sm font-medium text-[#172B4D]">
          <a 
            href="/#about" 
            class="hover:text-[#AA6ADA] transition-colors cursor-pointer"
          >
            Giới thiệu
          </a>
          <a 
            href="{{ route('board') }}"
            class="hover:text-[#AA6ADA] transition-colors font-medium text-sm text-[#172B4D] cursor-pointer"
          >
            Đi tới Board
          </a>
        </nav>
      </div>

      <!-- Bên phải: Đăng nhập/Đăng ký nếu chưa login, hoặc Vào Board nếu đã login -->
      <div class="flex items-center space-x-3">
        @guest
          <a 
            href="{{ route('login') }}"
            class="px-4 py-2 text-sm font-medium text-[#172B4D] hover:text-[#AA6ADA] transition-colors cursor-pointer"
          >
            Đăng nhập
          </a>

          <a 
            href="{{ route('register') }}"
            class="px-4 py-2 text-sm font-medium text-white bg-[#AA6ADA] hover:bg-[#9252c4] rounded-md transition-colors cursor-pointer"
          >
            Đăng ký
          </a>
        @else
          <a 
            href="{{ route('board') }}"
            class="px-4 py-2 text-sm font-medium text-white bg-[#AA6ADA] hover:bg-[#9252c4] rounded-md transition-colors cursor-pointer"
          >
            Vào Board
          </a>
        @endguest
      </div>

    </div>
  </div>
</header>

