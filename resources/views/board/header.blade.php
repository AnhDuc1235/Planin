<!-- ============================================================== -->
<!-- HEADER THANH ĐIỀU HƯỚNG WORKSPACE                              -->
<!-- ============================================================== -->
<header class="bg-white px-6 h-16 flex items-center justify-between sticky top-0 z-40 w-full">

  <!-- Bên trái: Logo Planin to rõ ràng -->
  <div class="flex items-center shrink-0">
    <a href="/" class="flex items-center cursor-pointer">
      <img
        src="/logo/planin-logo-board-transparent.svg"
        alt="Planin Logo"
        class="h-10 sm:h-11 w-auto object-contain"
      />
    </a>
  </div>

  <!-- Ở GIỮA: Thanh tìm kiếm căn giữa Header -->
  <div class="flex-1 max-w-md mx-auto px-4 hidden md:block">
    <div class="relative w-full">
      <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
        <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
        </svg>
      </span>
      <input
        type="text"
        placeholder="Tìm kiếm"
        class="w-full pl-10 pr-3.5 py-2 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:border-[#AA6ADA] focus:bg-white transition"
      />
    </div>
  </div>

  <!-- Bên phải: Chuông thông báo to rõ & Avatar người dùng -->
  <div class="flex items-center space-x-3 shrink-0">
    <!-- Chuông thông báo to rõ -->
    <button class="p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-full transition cursor-pointer" title="Thông báo">
      <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
      </svg>
    </button>

    <!-- Avatar người dùng & Menu dropdown đăng xuất -->
    <div class="relative">
      @php
        $initials = 'PL';
        if (Auth::user() && Auth::user()->name) {
            $words = preg_split('/\s+/u', trim(Auth::user()->name));
            if (count($words) > 1) {
                $initials = mb_substr($words[0], 0, 1, 'UTF-8') . mb_substr(end($words), 0, 1, 'UTF-8');
            } else {
                $initials = mb_substr(Auth::user()->name, 0, 2, 'UTF-8');
            }
        }
      @endphp
      <button
        type="button"
        onclick="toggleElement('userMenuDropdown')"
        class="w-9 h-9 rounded-full bg-[#AA6ADA] text-white text-sm font-bold flex items-center justify-center cursor-pointer uppercase hover:opacity-90 transition shadow-2xs"
      >
        {{ mb_strtoupper($initials, 'UTF-8') }}
      </button>

      <!-- Dropdown tài khoản -->
      <div
        id="userMenuDropdown"
        class="hidden absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-md shadow-lg py-1 z-50 text-xs"
      >
        <div class="px-3 py-2 border-b border-gray-100">
          <p class="font-semibold text-gray-800 truncate">{{ Auth::user()->name ?? 'Thành viên' }}</p>
          <p class="text-gray-400 text-[11px] truncate">{{ Auth::user()->email ?? 'user@example.com' }}</p>
        </div>

        <a href="/" class="block px-3 py-2 text-gray-700 hover:bg-purple-50 hover:text-[#AA6ADA] transition cursor-pointer">
          Về Trang chủ
        </a>

        <!-- Form Đăng xuất thuần Session Laravel -->
        <form method="POST" action="{{ route('logout') }}" class="block border-t border-gray-100">
          @csrf
          <button
            type="submit"
            class="w-full text-left px-3 py-2 text-red-600 hover:bg-red-50 transition cursor-pointer font-medium"
          >
            Đăng xuất
          </button>
        </form>
      </div>
    </div>
  </div>

</header>

