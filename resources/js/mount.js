import { createApp } from 'vue';

/**
 * Đọc props từ thuộc tính data-props (JSON) của phần tử mount.
 * Blade: <x-vue-mount id="..." :payload="[...]" />
 */
function readProps(el) {
    const raw = el.dataset.props;
    if (!raw) return {};

    try {
        return JSON.parse(raw);
    } catch (error) {
        console.error('[Planin] data-props không phải JSON hợp lệ:', error);
        return {};
    }
}

/**
 * Mount có điều kiện: chỉ nạp và mount component khi trang có phần tử tương ứng.
 * Nhờ import() động, trang nào dùng component nào thì mới tải code của component đó.
 *
 * @param {Record<string, () => Promise<{ default: object }>>} registry  { '#id': () => import('./X.vue') }
 */
export function mountPages(registry) {
    Object.entries(registry).forEach(async ([selector, loader]) => {
        const el = document.querySelector(selector);
        if (!el) return;

        try {
            const { default: Component } = await loader();
            createApp(Component, readProps(el)).mount(el);
        } catch (error) {
            console.error(`[Planin] Không mount được ${selector}:`, error);
        }
    });
}
