import { mountPages } from './mount';

/*
 | Đăng ký các điểm mount Vue: '#id-phần-tử' => component (nạp khi cần).
 | Mỗi trang Blade đặt <x-vue-mount id="..." :payload="[...]" /> tương ứng.
 | Làm tới bước nào thì thêm dòng ở bước đó, ví dụ:
 |   '#board-app': () => import('./pages/BoardPage.vue'),
 */
mountPages({
    '#vue-mount-test': () => import('./pages/MountTest.vue'),
});