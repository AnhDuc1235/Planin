<!-- ============================================================== -->
<!-- POPUP MODAL TẠO BẢNG                                           -->
<!-- ============================================================== -->
@php
  $gradientBackgrounds = [
    'linear-gradient(135deg, #0079BF, #5067C5)',
    'linear-gradient(135deg, #1d1135, #4b1d7d, #aa6ada)',
    'linear-gradient(135deg, #d68541, #7a349c)',
    'linear-gradient(135deg, #0f2027, #203a43, #2c5364)',
  ];
  $colorBackgrounds = ['#F0E5FC', '#AA6ADA', '#7F42BC', '#0079BF'];
@endphp

<div
  id="createBoardModal"
  class="hidden fixed inset-0 bg-black/40 backdrop-blur-2xs flex items-center justify-center p-4 z-50 overflow-y-auto"
  onclick="if(event.target === this) closeModal('createBoardModal')"
>
  <div class="bg-white rounded-xl border border-gray-200 w-full max-w-[330px] p-4 shadow-2xl relative">

    <!-- Header của Popup -->
    <div class="flex items-center justify-between pb-3 mb-3 border-b border-gray-100">
      <button
        type="button"
        onclick="closeModal('createBoardModal')"
        class="text-gray-500 hover:text-gray-800 p-1 rounded transition cursor-pointer"
      >
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>
      </button>

      <h3 class="text-sm font-bold text-[#091E42] text-center">
        Tạo bảng
      </h3>

      <button
        type="button"
        onclick="closeModal('createBoardModal')"
        class="text-gray-400 hover:text-gray-700 p-1 rounded transition cursor-pointer text-sm font-bold"
      >
        ✕
      </button>
    </div>

    <form method="POST" action="{{ route('boards.store') }}" class="space-y-4">
      @csrf
      <input type="hidden" name="workspace_id" value="{{ $currentWorkspace->id ?? '' }}" />
      <input type="hidden" name="background" id="boardBackgroundInput" value="linear-gradient(135deg, #0079BF, #5067C5)" />
      <input type="hidden" name="visibility" id="boardVisibilityInput" value="workspace" />

      <!-- HỘP XEM TRƯỚC BẢNG -->
      <div
        id="boardPreviewBox"
        class="w-full h-32 rounded-lg p-2.5 flex flex-col justify-between transition-all duration-300 relative overflow-hidden"
        style="background: linear-gradient(135deg, #0079BF, #5067C5);"
      >
        <div class="flex justify-center">
          <div class="bg-white/20 backdrop-blur-xs px-2 py-0.5 rounded flex items-center gap-1">
            <img
              src="/logo/planin-logo-board-transparent.svg"
              alt="Planin"
              class="h-3 w-auto brightness-0 invert"
            />
          </div>
        </div>

        <div class="grid grid-cols-3 gap-1.5 h-20 items-end">
          <div class="bg-white/90 rounded p-1 h-full flex flex-col gap-1 shadow-2xs">
            <div class="h-1.5 bg-gray-300 rounded w-8"></div>
            <div class="h-2.5 bg-gray-200 rounded w-full"></div>
            <div class="h-2.5 bg-gray-200 rounded w-full"></div>
          </div>
          <div class="bg-white/90 rounded p-1 h-full flex flex-col gap-1 shadow-2xs">
            <div class="h-1.5 bg-gray-300 rounded w-8"></div>
            <div class="h-2.5 bg-gray-200 rounded w-full"></div>
            <div class="h-2 bg-gray-200 rounded w-3/4"></div>
          </div>
          <div class="bg-white/90 rounded p-1 h-full flex flex-col gap-1 shadow-2xs">
            <div class="h-1.5 bg-gray-300 rounded w-8"></div>
            <div class="h-3 bg-gray-200 rounded w-full"></div>
          </div>
        </div>
      </div>

      <!-- MỤC CHỌN PHÔNG NỀN -->
      <div>
        <label class="block text-xs font-semibold text-gray-700 mb-1.5">
          Phông nền
        </label>

        <!-- Hàng 1: 4 phông nền gradient -->
        <div class="grid grid-cols-4 gap-1.5 mb-2">
          @foreach ($gradientBackgrounds as $index => $bg)
            <div
              onclick="selectBoardBackground(this, '{{ $bg }}')"
              class="bg-picker-opt h-10 rounded cursor-pointer relative overflow-hidden transition hover:opacity-90 flex items-center justify-center border {{ $index === 0 ? 'border-gray-900 ring-2 ring-purple-400' : 'border-transparent' }}"
              style="background: {{ $bg }};"
            >
              <div class="check-icon {{ $index === 0 ? '' : 'hidden ' }}w-4 h-4 rounded-full bg-white text-gray-900 flex items-center justify-center text-[10px] font-bold shadow-xs">
                ✓
              </div>
            </div>
          @endforeach
        </div>

        <!-- Hàng 2: 4 màu sắc -->
        <div class="grid grid-cols-4 gap-1.5">
          @foreach ($colorBackgrounds as $color)
            <div
              onclick="selectBoardBackground(this, '{{ $color }}')"
              class="bg-picker-opt h-8 rounded cursor-pointer relative overflow-hidden transition hover:opacity-90 flex items-center justify-center border border-transparent"
              style="background-color: {{ $color }};"
            >
              <div class="check-icon hidden w-3.5 h-3.5 rounded-full bg-white text-gray-900 flex items-center justify-center text-[9px] font-bold">
                ✓
              </div>
            </div>
          @endforeach
        </div>
      </div>

      <!-- MỤC TIÊU ĐỀ BẢNG * -->
      <div>
        <label class="block text-xs font-semibold text-gray-700 mb-1">
          Tiêu đề bảng <span class="text-red-500">*</span>
        </label>
        <input
          name="name"
          id="boardNameInput"
          type="text"
          placeholder=""
          oninput="updateBoardSubmitButton()"
          class="w-full px-3 py-1.5 text-xs rounded border border-red-500 focus:outline-none focus:border-red-500 transition bg-white"
          required
        />
        <p id="boardNameRequiredMsg" class="text-[11px] text-red-500 mt-1 font-medium">
          Tiêu đề bảng là bắt buộc
        </p>
      </div>

      <!-- MỤC QUYỀN XEM -->
      <div class="relative">
        <label class="block text-xs font-semibold text-gray-700 mb-1">
          Quyền xem
        </label>

        <button
          type="button"
          onclick="toggleElement('boardVisibilityDropdown')"
          class="w-full px-3 py-2 text-xs rounded border border-gray-300 bg-white hover:bg-gray-50 flex items-center justify-between text-[#091E42] cursor-pointer transition"
        >
          <div class="flex items-center space-x-2" id="currentVisibilityDisplay">
            <svg id="visibilityIcon_private" class="hidden w-4 h-4 text-gray-700 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <rect x="5" y="11" width="14" height="10" rx="2" />
              <path d="M12 15v2" />
              <path d="M8 11V7a4 4 0 018 0v4" />
            </svg>
            <svg id="visibilityIcon_workspace" class="w-4 h-4 text-gray-700 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M16 21v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2" />
              <circle cx="9" cy="7" r="4" />
              <path d="M22 21v-2a4 4 0 00-3-3.87" />
              <path d="M16 3.13a4 4 0 010 7.75" />
            </svg>
            <svg id="visibilityIcon_public" class="hidden w-4 h-4 text-gray-700 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <circle cx="12" cy="12" r="10" />
              <path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20" />
              <path d="M2 12h20" />
            </svg>
            <span id="currentVisibilityText" class="font-medium">Không gian làm việc</span>
          </div>
          <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
          </svg>
        </button>

        <!-- Menu xổ xuống -->
        <div
          id="boardVisibilityDropdown"
          class="hidden absolute left-0 right-0 mt-1 bg-white border border-gray-200 rounded-lg shadow-xl z-50 py-1 text-xs max-h-60 overflow-y-auto"
        >
          <div
            onclick="selectBoardVisibility('private', 'Riêng tư', this)"
            class="vis-option p-2.5 hover:bg-gray-100 cursor-pointer transition flex items-start space-x-2.5 text-gray-800"
          >
            <svg class="vis-svg w-5 h-5 shrink-0 mt-0.5 text-gray-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <rect x="5" y="11" width="14" height="10" rx="2" />
              <path d="M12 15v2" />
              <path d="M8 11V7a4 4 0 018 0v4" />
            </svg>
            <div>
              <p class="font-semibold text-xs">Riêng tư</p>
              <p class="text-[10px] text-gray-500 leading-tight mt-0.5">
                Chỉ thành viên bảng mới có thể xem bảng này.
              </p>
            </div>
          </div>

          <div
            onclick="selectBoardVisibility('workspace', 'Không gian làm việc', this)"
            class="vis-option p-2.5 hover:bg-gray-100 cursor-pointer transition flex items-start space-x-2.5 border-t border-gray-100 bg-purple-50 text-[#AA6ADA]"
          >
            <svg class="vis-svg w-5 h-5 shrink-0 mt-0.5 text-[#AA6ADA]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M16 21v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2" />
              <circle cx="9" cy="7" r="4" />
              <path d="M22 21v-2a4 4 0 00-3-3.87" />
              <path d="M16 3.13a4 4 0 010 7.75" />
            </svg>
            <div>
              <p class="font-semibold text-xs">Không gian làm việc</p>
              <p class="text-[10px] text-gray-500 leading-tight mt-0.5">
                Tất cả thành viên của Không gian làm việc có thể xem và sửa bảng này.
              </p>
            </div>
          </div>

          <div
            onclick="selectBoardVisibility('public', 'Công khai', this)"
            class="vis-option p-2.5 hover:bg-gray-100 cursor-pointer transition flex items-start space-x-2.5 border-t border-gray-100 text-gray-800"
          >
            <svg class="vis-svg w-5 h-5 shrink-0 mt-0.5 text-gray-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <circle cx="12" cy="12" r="10" />
              <path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20" />
              <path d="M2 12h20" />
            </svg>
            <div>
              <p class="font-semibold text-xs">Công khai</p>
              <p class="text-[10px] text-gray-500 leading-tight mt-0.5">
                Bất kỳ ai trên mạng internet đều có thể xem bảng này (chỉ đọc).
              </p>
            </div>
          </div>
        </div>
      </div>

      <!-- NÚT TẠO MỚI -->
      <div class="pt-2">
        <button
          type="submit"
          id="boardSubmitBtn"
          class="w-full py-2.5 rounded text-xs font-semibold transition cursor-pointer bg-gray-100 text-gray-400 cursor-not-allowed"
          disabled
        >
          Tạo mới
        </button>
      </div>

    </form>

  </div>
</div>

