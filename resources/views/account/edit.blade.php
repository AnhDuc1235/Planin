@extends('layouts.app')

@section('title', 'Hồ sơ cá nhân - Planin')

@section('content')
<div class="flex-1 min-w-0 px-4 sm:px-8 py-8">
  <div class="max-w-2xl mx-auto space-y-8">

    <h1 class="text-xl font-bold text-[#091E42]">Hồ sơ cá nhân</h1>

    {{-- ===================== 1. THÔNG TIN CÁ NHÂN ===================== --}}
    <section class="border border-gray-200 rounded-xl p-6">
      <h2 class="text-sm font-bold text-[#172B4D] mb-4">Thông tin cá nhân</h2>

      @if ($errors->any())
        <div class="mb-4 p-2.5 bg-red-50 border border-red-200 text-red-600 rounded-md text-xs font-normal">
          <ul class="list-disc pl-4 space-y-0.5">
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <form method="POST" action="{{ route('account.update') }}" enctype="multipart/form-data" class="space-y-5">
        @csrf
        @method('PUT')

        {{-- Avatar --}}
        <div class="flex items-center space-x-4">
          <div class="w-16 h-16 rounded-full overflow-hidden bg-[#AA6ADA] text-white text-lg font-bold flex items-center justify-center shrink-0 uppercase">
            <img
              id="avatarPreview"
              @if ($user->avatar_url) src="{{ $user->avatar_url }}" @endif
              alt="{{ $user->name }}"
              class="w-full h-full object-cover {{ $user->avatar_url ? '' : 'hidden' }}"
            />
            <span id="avatarInitials" class="{{ $user->avatar_url ? 'hidden' : '' }}">{{ $user->initials }}</span>
          </div>

          <div class="space-y-1.5 min-w-0">
            <input
              id="avatarInput"
              type="file"
              name="avatar"
              accept="image/png,image/jpeg,image/webp"
              class="block w-full text-xs text-gray-600 file:mr-3 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:bg-gray-100 file:text-gray-700 file:font-semibold hover:file:bg-gray-200 file:cursor-pointer"
            />
            <p class="text-[11px] text-gray-400">JPG, PNG hoặc WEBP, tối đa 2 MB.</p>

            @if ($user->avatar)
              <label class="inline-flex items-center space-x-2 text-xs text-gray-600 cursor-pointer">
                <input type="checkbox" name="remove_avatar" value="1" class="rounded border-gray-300 accent-[#AA6ADA]" />
                <span>Xóa ảnh đại diện hiện tại</span>
              </label>
            @endif
          </div>
        </div>

        <div>
          <label class="block text-xs font-semibold text-[#172B4D] mb-1">
            Họ và tên <span class="text-red-500">*</span>
          </label>
          <input
            type="text"
            name="name"
            value="{{ old('name', $user->name) }}"
            required
            maxlength="100"
            class="w-full px-3 py-2 text-sm rounded-md border border-gray-300 focus:outline-none focus:border-[#AA6ADA] bg-white transition"
          />
        </div>

        <div>
          <label class="block text-xs font-semibold text-[#172B4D] mb-1">Email</label>
          <input
            type="email"
            value="{{ $user->email }}"
            disabled
            class="w-full px-3 py-2 text-sm rounded-md border border-gray-200 bg-gray-50 text-gray-500 cursor-not-allowed"
          />
        </div>

        <button
          type="submit"
          class="py-2.5 px-5 bg-[#AA6ADA] hover:bg-[#9252c4] text-white text-sm font-semibold rounded-md transition cursor-pointer"
        >
          Lưu thay đổi
        </button>
      </form>
    </section>

    {{-- ===================== 2. ĐỔI MẬT KHẨU ===================== --}}
    <section class="border border-gray-200 rounded-xl p-6">
      <h2 class="text-sm font-bold text-[#172B4D] mb-4">Đổi mật khẩu</h2>

      @if ($errors->updatePassword->any())
        <div class="mb-4 p-2.5 bg-red-50 border border-red-200 text-red-600 rounded-md text-xs font-normal">
          <ul class="list-disc pl-4 space-y-0.5">
            @foreach ($errors->updatePassword->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <form method="POST" action="{{ route('account.password.update') }}" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
          <label class="block text-xs font-semibold text-[#172B4D] mb-1">
            Mật khẩu hiện tại <span class="text-red-500">*</span>
          </label>
          <input
            type="password"
            name="current_password"
            required
            autocomplete="current-password"
            class="w-full px-3 py-2 text-sm rounded-md border border-gray-300 focus:outline-none focus:border-[#AA6ADA] bg-white transition"
          />
        </div>

        <div>
          <label class="block text-xs font-semibold text-[#172B4D] mb-1">
            Mật khẩu mới <span class="text-red-500">*</span>
          </label>
          <input
            type="password"
            name="password"
            required
            minlength="8"
            autocomplete="new-password"
            placeholder="Tối thiểu 8 ký tự"
            class="w-full px-3 py-2 text-sm rounded-md border border-gray-300 focus:outline-none focus:border-[#AA6ADA] bg-white transition"
          />
        </div>

        <div>
          <label class="block text-xs font-semibold text-[#172B4D] mb-1">
            Nhập lại mật khẩu mới <span class="text-red-500">*</span>
          </label>
          <input
            type="password"
            name="password_confirmation"
            required
            minlength="8"
            autocomplete="new-password"
            class="w-full px-3 py-2 text-sm rounded-md border border-gray-300 focus:outline-none focus:border-[#AA6ADA] bg-white transition"
          />
        </div>

        <button
          type="submit"
          class="py-2.5 px-5 bg-[#AA6ADA] hover:bg-[#9252c4] text-white text-sm font-semibold rounded-md transition cursor-pointer"
        >
          Đổi mật khẩu
        </button>
      </form>
    </section>

  </div>
</div>
@endsection

@push('scripts')
  {{-- toggleElement() cho menu tài khoản ở header --}}
  @include('board.scripts')
  <script>
    // Xem trước ảnh đại diện ngay khi chọn tệp (chưa upload).
    (function () {
      var input = document.getElementById('avatarInput');
      var img = document.getElementById('avatarPreview');
      var initials = document.getElementById('avatarInitials');
      if (!input) return;
      input.addEventListener('change', function () {
        var file = input.files && input.files[0];
        if (!file) return;
        img.src = URL.createObjectURL(file);
        img.classList.remove('hidden');
        initials.classList.add('hidden');
      });
    })();
  </script>
@endpush
