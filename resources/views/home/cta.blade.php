<!-- ============================================================== -->
<!-- 5. PRE-FOOTER CTA                                              -->
<!-- ============================================================== -->
<section class="py-16 bg-[#FAF5FF]">
  <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 text-center">

    <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-[#091E42] leading-[1.25] mb-4">
      Bắt đầu cùng Planin ngay hôm nay
    </h2>

    <form action="{{ route('register') }}" method="GET" class="max-w-md mx-auto flex flex-col sm:flex-row gap-3 mb-4">
      <input
        type="email"
        name="email"
        placeholder="Nhập email của bạn..."
        required
        class="flex-1 px-4 py-2.5 rounded-md border border-gray-300 focus:outline-none focus:border-[#AA6ADA] text-sm bg-white"
      />
      <button
        type="submit"
        class="px-5 py-2.5 text-sm font-semibold text-white bg-[#AA6ADA] hover:bg-[#9252c4] rounded-md transition-colors whitespace-nowrap cursor-pointer"
      >
        Đăng ký miễn phí
      </button>
    </form>

    <p class="text-xs text-gray-500 font-normal">
      Bằng việc đăng ký, bạn đồng ý với
      <a href="#" class="text-[#AA6ADA] underline cursor-pointer">Chính sách quyền riêng tư</a> của Planin.
    </p>

  </div>
</section>

