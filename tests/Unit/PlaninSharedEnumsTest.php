<?php

namespace Tests\Unit;

use App\Enums\BoardVisibility;
use App\Enums\WorkspaceRole;
use App\Enums\WorkspaceVisibility;
use App\Support\BoardBackground;
use Tests\TestCase;

class PlaninSharedEnumsTest extends TestCase
{
    public function test_workspace_role_khop_voi_migration_va_co_nhan_tieng_viet(): void
    {
        $this->assertSame(['admin', 'member', 'viewer'], WorkspaceRole::values());
        $this->assertSame('Người xem', WorkspaceRole::Viewer->label());
        $this->assertSame(WorkspaceRole::values(), array_keys(WorkspaceRole::options()));
    }

    public function test_workspace_role_ma_tran_quyen(): void
    {
        $this->assertTrue(WorkspaceRole::Viewer->canView());
        $this->assertFalse(WorkspaceRole::Viewer->canEditCards());
        $this->assertFalse(WorkspaceRole::Viewer->canManage());

        $this->assertTrue(WorkspaceRole::Member->canEditCards());
        $this->assertFalse(WorkspaceRole::Member->canManage());

        $this->assertTrue(WorkspaceRole::Admin->canManage());
        $this->assertTrue(WorkspaceRole::Admin->atLeast(WorkspaceRole::Member));
    }

    public function test_visibility_enum_khop_voi_migration(): void
    {
        $this->assertSame(['private', 'public'], WorkspaceVisibility::values());
        $this->assertSame(['private', 'workspace', 'public'], BoardVisibility::values());
        $this->assertSame(WorkspaceVisibility::Private, WorkspaceVisibility::default());
        $this->assertSame('Công khai', BoardVisibility::Public->label());
    }

    public function test_board_background_chi_nhan_preset_hoac_ma_mau_hex(): void
    {
        $this->assertTrue(BoardBackground::isValid(BoardBackground::default()));
        $this->assertTrue(BoardBackground::isValid('#0079BF'));
        $this->assertTrue(BoardBackground::isValid('#abc'));

        $this->assertFalse(BoardBackground::isValid(null));
        $this->assertFalse(BoardBackground::isValid('red'));
        $this->assertFalse(BoardBackground::isValid('#12345'));
        $this->assertFalse(BoardBackground::isValid('red; background-image: url(//evil.test/x.png)'));
    }

    public function test_board_background_css_thay_gia_tri_la_bang_mac_dinh(): void
    {
        $this->assertSame('#AA6ADA', BoardBackground::css('#AA6ADA'));
        $this->assertSame(BoardBackground::default(), BoardBackground::css('url(evil)'));
        $this->assertSame(BoardBackground::default(), BoardBackground::css(null));
    }

    public function test_board_background_rule_bao_loi_khi_khong_hop_le(): void
    {
        $validator = validator(
            ['background' => 'url(evil)'],
            ['background' => [BoardBackground::rule()]]
        );

        $this->assertTrue($validator->fails());
        $this->assertSame('Phông nền của bảng không hợp lệ.', $validator->errors()->first('background'));
    }
}
