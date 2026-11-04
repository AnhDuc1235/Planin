import '../css/app.css';
import { createApp } from 'vue';
import App from './App.vue';

// Khởi tạo ứng dụng Vue 3 nếu phần tử #app tồn tại trên trang
const mountEl = document.getElementById('app');
if (mountEl) {
    createApp(App).mount('#app');
}
