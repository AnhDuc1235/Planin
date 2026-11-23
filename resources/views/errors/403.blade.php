@extends('errors.layout')

@php
    // Giữ lại thông báo tiếng Việt do Policy/abort() trả về; bỏ câu mặc định tiếng Anh của Laravel.
    $detail = trim((string) ($exception?->getMessage() ?? ''));
    if ($detail === '' || $detail === 'This action is unauthorized.') {
        $detail = 'Bạn không có quyền xem hoặc thực hiện thao tác này. Hãy liên hệ quản trị viên của không gian làm việc nếu cần.';
    }
@endphp

@section('code', '403')
@section('title_text', 'Bạn không có quyền truy cập')
@section('message', $detail)
