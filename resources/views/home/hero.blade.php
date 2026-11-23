<!-- ========================================== -->
<!-- 1. HERO SECTION                            -->
<!-- ========================================== -->
<section class="py-16 md:py-24 bg-[#FAF5FF] border-b border-purple-100/60">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">

      <!-- Bên trái: Khối để trống để sau này chèn ảnh sản phẩm vào -->
      <div class="lg:col-span-7 flex justify-center">
        <div class="w-full max-w-lg aspect-[4/3] min-h-[340px] rounded-2xl border-2 border-dashed border-purple-200/90 bg-white/60 flex flex-col items-center justify-center p-6 text-center">
          <div class="w-12 h-12 rounded-full bg-purple-100/60 text-[#AA6ADA] flex items-center justify-center mb-2">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
          </div>
          <p class="text-xs text-purple-400 font-medium">Khu vực để trống (Chèn hình ảnh sau)</p>
        </div>
      </div>

      <!-- Bên phải: Tiêu đề & Mô tả -->
      <div class="lg:col-span-5 text-left">
        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-[#091E42] leading-[1.2] mb-6">
          Lên kế hoạch, sắp xếp và hoàn thành mọi việc ở bất kỳ đâu.
        </h1>

        <p class="text-base sm:text-lg text-[#172B4D] leading-relaxed mb-8 font-normal">
          Loại bỏ hoàn toàn sự lộn xộn và hỗn độn — khai phóng tối đa hiệu suất làm việc của bạn cùng Planin.
        </p>

        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4">
          <a
            href="{{ route('register') }}"
            class="px-6 py-3 text-sm font-semibold text-white bg-[#AA6ADA] hover:bg-[#9252c4] rounded-md transition-colors cursor-pointer"
          >
            Dùng thử miễn phí
          </a>

          <a
            href="{{ route('workspaces.index') }}"
            class="text-sm font-semibold text-[#AA6ADA] hover:text-[#9252c4] py-3 transition-colors cursor-pointer"
          >
            Đi tới Board &rarr;
          </a>
        </div>
      </div>

    </div>
  </div>
</section>

