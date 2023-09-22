import { createApp } from 'vue';
import { createRouter, createWebHistory } from 'vue-router';
import { Bootstrap5Pagination } from 'laravel-vue-pagination';

// Import components
import App from './components/App.vue';
import IssueList from './components/IssueList.vue';

const router = createRouter({
    history: createWebHistory(),
    routes: [
        { path: '/', component: IssueList }
    ]
});

const app = createApp(App);
app.component('Pagination', Bootstrap5Pagination);
app.use(router);
app.mount('#app');