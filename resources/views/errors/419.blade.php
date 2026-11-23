@extends('errors.layout')

@section('code', '419')
@section('title_text', 'Phiên làm việc đã hết hạn')
@section('message', 'Vì lý do bảo mật, phiên làm việc của bạn đã hết hạn. Vui lòng tải lại trang rồi thử lại.')

@section('actions')
    <button
        type="button"
        onclick="location.reload()"
        class="px-4 py-2.5 rounded-md bg-[#AA6ADA] hover:bg-[#9252c4] text-white text-sm font-semibold transition"
    >Tải lại trang</button>
    <a
        href="{{ route('login') }}"
        class="px-4 py-2.5 rounded-md bg-gray-100 hover:bg-gray-200 text-gray-800 text-sm font-semibold transition"
    >Đăng nhập lại</a>
@endsection
