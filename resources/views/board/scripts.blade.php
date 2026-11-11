<!-- ============================================================== -->
<!-- JAVASCRIPT CƠ BẢN XỬ LÝ MODAL VÀ DROPDOWN                      -->
<!-- ============================================================== -->
<script>
  // 1. Mở / Đóng Modal
  function openModal(modalId) {
    var el = document.getElementById(modalId);
    if (el) el.classList.remove('hidden');
  }

  function closeModal(modalId) {
    var el = document.getElementById(modalId);
    if (el) el.classList.add('hidden');
  }

  // 2. Bật / Tắt Menu Dropdown
  function toggleElement(elementId) {
    var el = document.getElementById(elementId);
    if (el) el.classList.toggle('hidden');
  }

  // 3. Kiểm tra nút Submit khi nhập tên Workspace hoặc tên Bảng
  function updateWorkspaceSubmitButton() {
    var input = document.getElementById('workspaceNameInput');
    var btn = document.getElementById('workspaceSubmitBtn');
    if (input.value.trim() !== '') {
      btn.disabled = false;
      btn.className = 'w-full py-2.5 rounded-md text-xs font-semibold transition cursor-pointer bg-[#AA6ADA] hover:bg-[#9252c4] text-white shadow-xs';
    } else {
      btn.disabled = true;
      btn.className = 'w-full py-2.5 rounded-md text-xs font-semibold transition bg-gray-100 text-gray-400 cursor-not-allowed';
    }
  }

  function updateBoardSubmitButton() {
    var input = document.getElementById('boardNameInput');
    var btn = document.getElementById('boardSubmitBtn');
    var msg = document.getElementById('boardNameRequiredMsg');
    if (input.value.trim() !== '') {
      btn.disabled = false;
      btn.className = 'w-full py-2.5 rounded text-xs font-semibold transition cursor-pointer bg-[#AA6ADA] hover:bg-[#9252c4] text-white shadow-xs';
      input.classList.remove('border-red-500', 'focus:border-red-500');
      input.classList.add('border-gray-300', 'focus:border-[#AA6ADA]');
      if (msg) msg.classList.add('hidden');
    } else {
      btn.disabled = true;
      btn.className = 'w-full py-2.5 rounded text-xs font-semibold transition bg-gray-100 text-gray-400 cursor-not-allowed';
      input.classList.remove('border-gray-300', 'focus:border-[#AA6ADA]');
      input.classList.add('border-red-500', 'focus:border-red-500');
      if (msg) msg.classList.remove('hidden');
    }
  }

  // 4. Chọn phông nền cho Bảng mới
  function selectBoardBackground(clickedElement, bgStyle) {
    document.getElementById('boardBackgroundInput').value = bgStyle;
    document.getElementById('boardPreviewBox').style.background = bgStyle;

    var allOptions = document.querySelectorAll('.bg-picker-opt');
    allOptions.forEach(function(opt) {
      opt.classList.remove('border-gray-900', 'ring-2', 'ring-purple-400');
      opt.classList.add('border-transparent');
      var check = opt.querySelector('.check-icon');
      if (check) check.classList.add('hidden');
    });

    clickedElement.classList.remove('border-transparent');
    clickedElement.classList.add('border-gray-900', 'ring-2', 'ring-purple-400');
    var currentCheck = clickedElement.querySelector('.check-icon');
    if (currentCheck) currentCheck.classList.remove('hidden');
  }

  // 5. Chọn quyền xem bảng (Riêng tư / Không gian làm việc / Công khai)
  function selectBoardVisibility(visibilityValue, visibilityLabel, clickedOption) {
    document.getElementById('boardVisibilityInput').value = visibilityValue;
    document.getElementById('currentVisibilityText').innerText = visibilityLabel;

    ['private', 'workspace', 'public'].forEach(function(type) {
      var iconEl = document.getElementById('visibilityIcon_' + type);
      if (iconEl) iconEl.classList.add('hidden');
    });
    var activeIcon = document.getElementById('visibilityIcon_' + visibilityValue);
    if (activeIcon) activeIcon.classList.remove('hidden');

    document.querySelectorAll('.vis-option').forEach(function(opt) {
      opt.classList.remove('bg-purple-50', 'text-[#AA6ADA]');
      opt.classList.add('text-gray-800');
      var svg = opt.querySelector('.vis-svg');
      if (svg) {
        svg.classList.remove('text-[#AA6ADA]');
        svg.classList.add('text-gray-700');
      }
    });
    if (clickedOption) {
      clickedOption.classList.remove('text-gray-800');
      clickedOption.classList.add('bg-purple-50', 'text-[#AA6ADA]');
      var activeSvg = clickedOption.querySelector('.vis-svg');
      if (activeSvg) {
        activeSvg.classList.remove('text-gray-700');
        activeSvg.classList.add('text-[#AA6ADA]');
      }
    }

    closeModal('boardVisibilityDropdown');
  }

  // 6. Đóng dropdown khi click ra ngoài màn hình
  document.addEventListener('click', function(e) {
    var userMenu = document.getElementById('userMenuDropdown');
    var wsSelect = document.getElementById('workspaceSelectDropdown');
    var visSelect = document.getElementById('boardVisibilityDropdown');

    if (userMenu && !userMenu.contains(e.target) && !e.target.closest('[onclick*="userMenuDropdown"]')) {
      userMenu.classList.add('hidden');
    }
    if (wsSelect && !wsSelect.contains(e.target) && !e.target.closest('[onclick*="workspaceSelectDropdown"]')) {
      wsSelect.classList.add('hidden');
    }
    if (visSelect && !visSelect.contains(e.target) && !e.target.closest('[onclick*="boardVisibilityDropdown"]')) {
      visSelect.classList.add('hidden');
    }
  });
</script>

