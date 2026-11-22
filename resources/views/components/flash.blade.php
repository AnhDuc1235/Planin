{{--
    Thông báo flash. Dùng: <x-flash />
    Controller: return back()->with('success', 'Đã lưu.');
    Khóa hỗ trợ: success | error | warning | info | status (coi như success).
--}}
@php
    $styles = [
        'success' => 'bg-green-50 border-green-300 text-green-800',
        'error' => 'bg-red-50 border-red-300 text-red-800',
        'warning' => 'bg-yellow-50 border-yellow-300 text-yellow-800',
        'info' => 'bg-blue-50 border-blue-300 text-blue-800',
    ];

    $flashes = [];
    foreach (['success', 'error', 'warning', 'info', 'status'] as $key) {
        $message = session($key);
        if (is_string($message) && $message !== '') {
            $flashes[] = [
                'type' => $key === 'status' ? 'success' : $key,
                'message' => $message,
            ];
        }
    }
@endphp

@if (count($flashes) > 0)
    <div
        id="flash-container"
        class="fixed top-4 right-4 z-[100] flex flex-col gap-2 w-80 max-w-[calc(100vw-2rem)]"
        aria-live="polite"
    >
        @foreach ($flashes as $flash)
            <div
                data-flash
                role="alert"
                class="flex items-start gap-2 px-4 py-3 rounded-lg border text-sm shadow-md {{ $styles[$flash['type']] }}"
            >
                <p class="flex-1 leading-snug">{{ $flash['message'] }}</p>
                <button
                    type="button"
                    data-flash-close
                    class="shrink-0 -mr-1 text-lg leading-none opacity-60 hover:opacity-100"
                    aria-label="Đóng thông báo"
                >&times;</button>
            </div>
        @endforeach
    </div>

    <script>
        (function () {
            document.querySelectorAll('[data-flash]').forEach(function (el) {
                var close = el.querySelector('[data-flash-close]');
                if (close) close.addEventListener('click', function () { el.remove(); });
                setTimeout(function () { el.remove(); }, 5000);
            });
        })();
    </script>
@endif
