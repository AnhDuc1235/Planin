{{--
    Điểm mount cho Vue. Dùng:
        <x-vue-mount id="board-app" :payload="['board' => $board]" />
    Dữ liệu truyền xuống Vue dưới dạng props (JSON, đã escape an toàn trong thuộc tính).
    Phần tử #id phải được đăng ký trong resources/js/app.js.
--}}
@props(['id', 'payload' => []])

<div id="{{ $id }}" data-props="{{ json_encode($payload, JSON_UNESCAPED_UNICODE) }}" {{ $attributes }}></div>
