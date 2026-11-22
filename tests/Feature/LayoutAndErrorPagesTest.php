<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class LayoutAndErrorPagesTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // Không cần build Vite khi chạy test.
        $this->withoutVite();
    }

    public function test_layout_guest_co_meta_csrf_va_hien_thi_flash(): void
    {
        $this->withSession(['success' => 'Đã lưu thành công.'])
            ->get('/login')
            ->assertOk()
            ->assertSee('name="csrf-token"', false)
            ->assertSee('Đã lưu thành công.');
    }

    public function test_layout_board_co_diem_mount_vue(): void
    {
        $html = view('dev.vue-test')->render();

        $this->assertStringContainsString('name="csrf-token"', $html);
        $this->assertStringContainsString('id="vue-mount-test"', $html);
        $this->assertStringContainsString('data-props=', $html);
    }

    public function test_trang_loi_404_tieng_viet(): void
    {
        $this->get('/duong-dan-khong-ton-tai')
            ->assertNotFound()
            ->assertSee('Không tìm thấy trang');
    }

    public function test_trang_loi_403_419_500_tieng_viet(): void
    {
        Route::get('/_test/abort/{code}', fn (int $code) => abort($code));

        $this->get('/_test/abort/403')->assertForbidden()->assertSee('Bạn không có quyền truy cập');
        $this->get('/_test/abort/419')->assertStatus(419)->assertSee('Phiên làm việc đã hết hạn');
        $this->get('/_test/abort/500')->assertStatus(500)->assertSee('Đã xảy ra lỗi hệ thống');
    }

    public function test_trang_loi_403_giu_thong_bao_tieng_viet_cua_abort(): void
    {
        Route::get('/_test/forbidden', fn () => abort(403, 'Chỉ quản trị viên mới được xóa bảng.'));

        $this->get('/_test/forbidden')
            ->assertForbidden()
            ->assertSee('Chỉ quản trị viên mới được xóa bảng.');
    }
}
