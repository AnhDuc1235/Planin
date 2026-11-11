<!-- ============================================================== -->
<!-- POPUP MODAL TẠO KHÔNG GIAN LÀM VIỆC                            -->
<!-- ============================================================== -->
<div
  id="createWorkspaceModal"
  class="hidden fixed inset-0 bg-black/50 backdrop-blur-2xs flex items-center justify-center p-4 z-50 overflow-y-auto"
  onclick="if(event.target === this) closeModal('createWorkspaceModal')"
>
  <div class="bg-white rounded-2xl border border-gray-200 w-full max-w-4xl shadow-2xl relative overflow-hidden flex flex-col md:flex-row my-auto">

    <!-- Nút đóng (X) -->
    <button
      type="button"
      onclick="closeModal('createWorkspaceModal')"
      class="absolute top-4 right-4 w-9 h-9 rounded-full bg-gray-100 hover:bg-gray-200 text-gray-500 hover:text-gray-800 flex items-center justify-center transition cursor-pointer z-20"
      title="Đóng"
    >
      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
      </svg>
    </button>

    <!-- CỘT TRÁI: FORM NHẬP THÔNG TIN -->
    <div class="w-full md:w-[56%] p-7 sm:p-10 flex flex-col justify-between">
      <div>
        <h2 class="text-2xl font-bold text-[#091E42] mb-2 leading-tight">
          Hãy xây dựng một Không gian làm việc
        </h2>

        <p class="text-sm text-gray-600 mb-6 leading-relaxed">
          Tăng năng suất của bạn bằng cách giúp mọi người dễ dàng truy cập bảng ở một vị trí.
        </p>

        <form method="POST" action="{{ route('workspaces.store') }}" class="space-y-4">
          @csrf

          <!-- 1. Tên Không gian làm việc -->
          <div>
            <label class="block text-xs font-bold text-[#091E42] mb-1.5">
              Tên Không gian làm việc
            </label>
            <input
              name="name"
              id="workspaceNameInput"
              type="text"
              placeholder="Công ty của Taco"
              oninput="updateWorkspaceSubmitButton()"
              class="w-full px-3.5 py-2.5 text-xs rounded-md border border-gray-300 focus:outline-none focus:border-[#AA6ADA] focus:ring-1 focus:ring-[#AA6ADA] bg-white transition text-gray-800"
              required
            />
            <p class="text-[11px] text-gray-500 mt-1">
              Đây là tên của công ty, nhóm hoặc tổ chức của bạn.
            </p>
          </div>

          <!-- 2. Loại Không gian làm việc -->
          <div>
            <label class="block text-xs font-bold text-[#091E42] mb-1.5">
              Loại Không gian làm việc
            </label>
            <div class="relative">
              <select
                name="type"
                class="w-full px-3.5 py-2.5 text-xs rounded-md border border-gray-300 focus:outline-none focus:border-[#AA6ADA] focus:ring-1 focus:ring-[#AA6ADA] bg-white transition cursor-pointer text-gray-700 appearance-none pr-8"
              >
                <option value="" disabled selected>Chọn...</option>
                <option value="small-business">Doanh nghiệp nhỏ</option>
                <option value="engineering">Kỹ thuật - CNTT</option>
                <option value="marketing">Marketing</option>
                <option value="education">Giáo dục</option>
                <option value="hr">Nhân sự</option>
                <option value="operations">Hoạt động</option>
                <option value="other">Khác</option>
              </select>
              <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-gray-400">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
              </div>
            </div>
          </div>

          <!-- 3. Mô tả Không gian làm việc (Tùy chọn) -->
          <div>
            <label class="block text-xs font-bold text-[#091E42] mb-1.5">
              Mô tả Không gian làm việc <span class="text-xs font-normal text-gray-400 ml-1">Tùy chọn</span>
            </label>
            <textarea
              name="description"
              rows="3"
              placeholder="Nhóm của chúng tôi tổ chức mọi thứ ở đây."
              class="w-full px-3.5 py-2 text-xs rounded-md border border-gray-300 focus:outline-none focus:border-[#AA6ADA] focus:ring-1 focus:ring-[#AA6ADA] bg-white transition resize-none text-gray-800"
            ></textarea>
            <p class="text-[11px] text-gray-500 mt-1">
              Đưa các thành viên của bạn vào bảng với mô tả ngắn về Không gian làm việc của bạn.
            </p>
          </div>

          <!-- Nút Tiếp tục -->
          <div class="pt-2">
            <button
              type="submit"
              id="workspaceSubmitBtn"
              disabled
              class="w-full py-2.5 rounded-md text-xs font-semibold transition bg-gray-100 text-gray-400 cursor-not-allowed"
            >
              Tiếp tục
            </button>
          </div>

        </form>
      </div>
    </div>

    <!-- CỘT PHẢI: HÌNH MINH HỌA -->
    <div class="hidden md:flex w-full md:w-[44%] bg-gradient-to-br from-purple-50/50 via-indigo-50/30 to-purple-100/40 p-6 items-center justify-center relative overflow-hidden select-none">

      <!-- Đường cong lượn sóng phân tách -->
      <div class="absolute inset-y-0 -left-6 w-12 bg-white rounded-r-full z-10"></div>

      <!-- Ảnh kanban method-amico.svg -->
      <div class="relative z-10 w-full max-w-[320px] flex items-center justify-center p-2">
        <img
          src="/asset/kanban method-amico.svg"
          alt="Kanban Method"
          class="w-full h-auto max-h-[300px] object-contain drop-shadow-xs"
        />
      </div>

    </div>

  </div>
</div>

