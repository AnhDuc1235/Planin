<?php

namespace Database\Factories\Concerns;

use Faker\Factory as FakerFactory;
use Faker\Generator;

/**
 * Ép factory dùng Faker locale vi_VN (tên người, địa chỉ...).
 * Văn bản tiếng Việt (tiêu đề, mô tả...) lấy từ danh sách mẫu trong từng factory
 * vì Faker không có bộ sinh văn bản tiếng Việt.
 */
trait UsesVietnameseFaker
{
    protected function withFaker(): Generator
    {
        return FakerFactory::create('vi_VN');
    }
}
