const CategoryList = () => import('./components/task/List.vue')
const CategoryCreate = () => import('./components/task/Add.vue')
const CategoryEdit = () => import('./components/task/Edit.vue')
export const routes = [
    {
        name: 'categoryList',
        path: '/category',
        component: CategoryList
    },
    {
        name: 'categoryEdit',
        path: '/category/:id/edit',
        component: CategoryEdit
    },
    {
        name: 'categoryAdd',
        path: '/category/add',
        component: CategoryCreate
    }
]