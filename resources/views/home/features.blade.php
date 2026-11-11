<!-- ========================================== -->
<!-- 3. FEATURE GRID                            -->
<!-- ========================================== -->
@php
  $features = [
    [
      'title' => 'Quản lý bảng Kanban trực quan',
      'description' => 'Tổ chức công việc theo từng cột trạng thái, phân công và kiểm soát tiến độ trong vài giây.'
    ],
    [
      'title' => 'Truy cập nhanh',
      'description' => 'Thao tác kéo thả, cập nhật và đánh dấu hoàn thành nhiệm vụ tức thì từ màn hình chính.'
    ],
    [
      'title' => 'Chế độ tập trung',
      'description' => 'Ẩn hoặc hiện danh sách việc cần làm để bạn toàn tâm tập trung vào nhiệm vụ quan trọng nhất.'
    ],
    [
      'title' => 'Phím tắt thông minh',
      'description' => 'Sử dụng phím tắt cho mọi hành động, giúp bạn xử lý tác vụ với tốc độ gấp đôi.'
    ],
    [
      'title' => 'Tùy biến bảng & Màu sắc',
      'description' => 'Tùy chỉnh nhãn màu tím chủ đạo và bố cục theo phong cách làm việc của bạn.'
    ],
    [
      'title' => 'Theo dõi & Báo cáo tiến độ',
      'description' => 'Thống kê tình trạng công việc hoàn thành một cách rõ ràng, minh bạch cho cả nhóm.'
    ]
  ];
@endphp

<section class="py-20 bg-[#FAF5FF] border-b border-purple-100/60">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

    <div class="text-center max-w-2xl mx-auto mb-16">
      <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-[#091E42] leading-[1.25] mb-4">
        Mọi công cụ bạn cần để làm chủ kế hoạch
      </h2>
      <p class="text-base text-[#172B4D] leading-relaxed font-normal">
        Thiết kế tối giản, dễ hiểu và tập trung trực tiếp vào năng suất làm việc hằng ngày của bạn.
      </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
      @foreach ($features as $index => $feature)
        <div class="bg-white p-6 rounded-lg border border-gray-200">
          <div class="text-xs font-bold text-[#AA6ADA] uppercase tracking-wider mb-2">
            0{{ $index + 1 }}
          </div>
          <h3 class="text-base font-bold text-[#091E42] mb-2 leading-snug">
            {{ $feature['title'] }}
          </h3>
          <p class="text-sm text-[#172B4D] leading-relaxed font-normal">
            {{ $feature['description'] }}
          </p>
        </div>
      @endforeach
    </div>

  </div>
</section>

