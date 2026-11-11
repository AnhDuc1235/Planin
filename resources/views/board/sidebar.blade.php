<!-- ========================================== -->
<!-- SIDEBAR TRÁI (KHÔNG CÓ VIỀN KẺ border-r)   -->
<!-- ========================================== -->
<aside class="w-68 shrink-0 bg-white p-5 select-none">

  <!-- Menu trên: Bảng, Mẫu, Trang chủ -->
  <nav class="space-y-1.5 mb-6 text-sm">
    <a
      href="#"
      class="flex items-center space-x-3 px-3.5 py-2.5 rounded-lg hover:bg-gray-100 transition cursor-pointer font-semibold text-gray-800"
    >
      <svg class="w-5 h-5 text-gray-600 shrink-0" fill="currentColor" viewBox="0 0 20 20">
        <path d="M2 4a1 1 0 011-1h14a1 1 0 011 1v12a1 1 0 01-1 1H3a1 1 0 01-1-1V4zm2 2v8h4V6H4zm6 0v8h6V6h-6z" />
      </svg>
      <span class="text-sm font-semibold">Bảng</span>
    </a>

    <a
      href="#"
      class="flex items-center space-x-3 px-3.5 py-2.5 rounded-lg text-gray-700 hover:bg-gray-100 transition cursor-pointer font-semibold"
    >
      <svg class="w-5 h-5 text-gray-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z" />
      </svg>
      <span class="text-sm font-semibold">Mẫu</span>
    </a>

    <a
      href="/"
      class="flex items-center space-x-3 px-3.5 py-2.5 rounded-lg text-gray-700 hover:bg-gray-100 transition cursor-pointer font-semibold"
    >
      <svg class="w-5 h-5 text-gray-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
      </svg>
      <span class="text-sm font-semibold">Trang chủ</span>
    </a>
  </nav>

  <!-- TRƯỜNG HỢP 1: CHƯA CÓ WORKSPACE NÀO -->
  @if ($workspaces->isEmpty())
    <div class="pt-2">
      <button
        type="button"
        onclick="openModal('createWorkspaceModal')"
        class="w-full flex items-center space-x-2.5 px-3.5 py-2.5 rounded-lg bg-gray-100 hover:bg-gray-200/90 text-gray-800 font-semibold text-sm transition cursor-pointer shadow-2xs"
      >
        <svg class="w-4 h-4 text-gray-700 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <rect x="3" y="4" width="18" height="16" rx="2" />
          <line x1="9" y1="4" x2="9" y2="20" />
          <line x1="15" y1="4" x2="15" y2="20" />
        </svg>
        <span>Tạo Không gian làm việc</span>
      </button>
    </div>
  @else
    <!-- TRƯỜNG HỢP 2: ĐÃ CÓ WORKSPACE -->
    <div class="space-y-4">

      <div class="px-1 text-xs font-bold text-gray-500 uppercase tracking-wider">
        Các Không gian làm việc
      </div>

      <!-- NÚT CHỌN ĐỔI SANG WORKSPACE KHÁC -->
      <div class="relative">
        <button
          type="button"
          onclick="toggleElement('workspaceSelectDropdown')"
          class="w-full flex items-center justify-between px-3.5 py-2.5 rounded-lg hover:bg-gray-100 cursor-pointer transition text-sm font-bold text-gray-800 border border-gray-200 shadow-2xs"
          title="Bấm để đổi sang Không gian làm việc khác"
        >
          <div class="flex items-center space-x-2.5 truncate">
            <div class="w-7 h-7 rounded-md bg-[#AA6ADA] text-white flex items-center justify-center text-xs font-bold shrink-0">
              {{ mb_strtoupper(mb_substr($currentWorkspace->name ?? 'W', 0, 1, 'UTF-8'), 'UTF-8') }}
            </div>
            <span class="truncate">{{ $currentWorkspace->name ?? 'Không gian làm việc' }}</span>
          </div>
          <svg
            class="w-4 h-4 text-gray-400 transition-transform shrink-0 ml-1"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
          >
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
          </svg>
        </button>

        <!-- MENU XỔ XUỐNG: DANH SÁCH TẤT CẢ WORKSPACE -->
        <div
          id="workspaceSelectDropdown"
          class="hidden absolute left-0 right-0 mt-1 bg-white border border-gray-200 rounded-lg shadow-xl z-50 py-1.5 text-xs max-h-64 overflow-y-auto"
        >
          <div class="px-3 py-1.5 text-[11px] font-bold text-gray-400 uppercase tracking-wider">
            Chọn Không gian làm việc
          </div>

          @foreach ($workspaces as $ws)
            <a
              href="{{ route('board', ['workspace_id' => $ws->id]) }}"
              class="flex items-center space-x-2.5 px-3 py-2.5 hover:bg-purple-50 cursor-pointer transition text-sm {{ ($currentWorkspace && $currentWorkspace->id === $ws->id) ? 'bg-purple-50 text-[#AA6ADA] font-bold' : 'text-gray-700' }}"
            >
              <div class="w-6 h-6 rounded bg-[#AA6ADA] text-white flex items-center justify-center text-xs font-bold shrink-0">
                {{ mb_strtoupper(mb_substr($ws->name ?? 'W', 0, 1, 'UTF-8'), 'UTF-8') }}
              </div>
              <span class="truncate flex-1 font-medium">{{ $ws->name }}</span>
              @if ($currentWorkspace && $currentWorkspace->id === $ws->id)
                <span class="text-xs text-[#AA6ADA] font-bold">✓</span>
              @endif
            </a>
          @endforeach

          <div class="border-t border-gray-100 mt-1 pt-1">
            <button
              type="button"
              onclick="toggleElement('workspaceSelectDropdown'); openModal('createWorkspaceModal')"
              class="w-full text-left px-3 py-2 text-[#AA6ADA] hover:bg-purple-50 font-semibold flex items-center space-x-2 cursor-pointer transition text-sm"
            >
              <svg class="w-4 h-4 text-[#AA6ADA] shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="4" width="18" height="16" rx="2" />
                <line x1="9" y1="4" x2="9" y2="20" />
                <line x1="15" y1="4" x2="15" y2="20" />
              </svg>
              <span>Tạo Không gian làm việc</span>
            </button>
          </div>
        </div>
      </div>

      <!-- Menu con của Workspace hiện tại -->
      <div class="space-y-1 pl-1 pt-1">
        <a
          href="#"
          class="flex items-center space-x-3 py-2.5 px-3.5 rounded-lg text-[#AA6ADA] font-semibold bg-purple-50 cursor-pointer text-sm"
        >
          <svg class="w-4 h-4 text-[#AA6ADA] shrink-0" fill="currentColor" viewBox="0 0 20 20">
            <path d="M2 4a1 1 0 011-1h14a1 1 0 011 1v12a1 1 0 01-1 1H3a1 1 0 01-1-1V4zm2 2v8h4V6H4zm6 0v8h6V6h-6z" />
          </svg>
          <span>Bảng</span>
        </a>

        <div class="flex items-center space-x-3 py-2.5 px-3.5 rounded-lg text-gray-700 hover:bg-gray-100 transition cursor-pointer text-sm font-semibold">
          <svg class="w-4 h-4 text-gray-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
          </svg>
          <span>Thành viên</span>
        </div>

        <a
          href="#"
          class="flex items-center space-x-3 py-2.5 px-3.5 rounded-lg text-gray-700 hover:bg-gray-100 transition cursor-pointer text-sm font-semibold"
        >
          <svg class="w-4 h-4 text-gray-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
          </svg>
          <span>Cài đặt</span>
        </a>
      </div>

      <!-- Nút Tạo Không gian làm việc dạng pill -->
      <div class="pt-4">
        <button
          type="button"
          onclick="openModal('createWorkspaceModal')"
          class="w-full flex items-center space-x-2.5 px-3.5 py-2.5 rounded-lg bg-gray-100 hover:bg-gray-200/90 text-gray-800 font-semibold text-sm transition cursor-pointer shadow-2xs"
        >
          <svg class="w-4 h-4 text-gray-700 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <rect x="3" y="4" width="18" height="16" rx="2" />
            <line x1="9" y1="4" x2="9" y2="20" />
            <line x1="15" y1="4" x2="15" y2="20" />
          </svg>
          <span>Tạo Không gian làm việc</span>
        </button>
      </div>

    </div>
  @endif

</aside>

