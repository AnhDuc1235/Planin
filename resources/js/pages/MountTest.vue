<script setup>
import { ref } from 'vue';
import { csrfToken } from '@/lib/http';

defineProps({
    message: { type: String, default: 'Vue đã được mount thành công.' },
});

const count = ref(0);
const hasCsrf = csrfToken() !== '';
</script>

<template>
    <div class="max-w-md mx-auto mt-10 p-6 rounded-xl bg-white/95 border border-gray-200 text-center space-y-3">
        <h2 class="text-lg font-bold text-[#091E42]">{{ message }}</h2>
        <p class="text-sm text-gray-600">
            Meta CSRF token:
            <span :class="hasCsrf ? 'text-green-600 font-semibold' : 'text-red-600 font-semibold'">
                {{ hasCsrf ? 'có' : 'không có' }}
            </span>
        </p>
        <button
            type="button"
            class="px-4 py-2 rounded-md bg-[#AA6ADA] hover:bg-[#9252c4] text-white text-sm font-semibold transition"
            @click="count++"
        >
            Đã bấm {{ count }} lần
        </button>
    </div>
</template>
