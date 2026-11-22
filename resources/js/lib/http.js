/**
 * Gọi backend bằng fetch, dùng chung session + CSRF của Laravel (KHÔNG token/API).
 *
 *   import { http } from '@/lib/http';
 *   await http.post('/boards/1/lists', { name: 'To Do' });
 *   await http.patch('/tasks/5/move', { to_list_id: 2, position: 3 });
 */
export class HttpError extends Error {
    constructor(status, data) {
        super(data?.message || `Yêu cầu thất bại (${status})`);
        this.name = 'HttpError';
        this.status = status;
        this.data = data;
    }
}

export function csrfToken() {
    return document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ?? '';
}

async function request(method, url, body) {
    const headers = {
        Accept: 'application/json',
        'X-Requested-With': 'XMLHttpRequest',
        'X-CSRF-TOKEN': csrfToken(),
    };

    const options = { method, headers, credentials: 'same-origin' };

    if (body !== undefined) {
        headers['Content-Type'] = 'application/json';
        options.body = JSON.stringify(body);
    }

    const response = await fetch(url, options);

    // 204 No Content (hoặc thân rỗng)
    const text = await response.text();
    const data = text ? JSON.parse(text) : null;

    if (!response.ok) {
        throw new HttpError(response.status, data);
    }

    return data;
}

export const http = {
    get: (url) => request('GET', url),
    post: (url, body = {}) => request('POST', url, body),
    put: (url, body = {}) => request('PUT', url, body),
    patch: (url, body = {}) => request('PATCH', url, body),
    delete: (url) => request('DELETE', url),
};
