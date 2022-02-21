import {
    createRouter,
    createWebHistory
} from "vue-router";
import PhotoList from '../components/PhotoList.vue';
import PhotoDetail from '../components/PhotoDetail.vue';

const routes = [{
        path: '/',
        component: PhotoList,
        props: route => {
            const page = route.query.page
            return {
                page: /^[1-9][0-9]*$/.test(page) ? page * 1 : 1
            }
        }
    },
    {
        path: '/photos/:id',
        name: 'photo-detail',
        component: PhotoDetail,
        props: true
    }
]

const router = createRouter({
    history: createWebHistory(),
    scrollBehavior(to, from, savedPosition) {
        return {
            top: 0
        }
    },
    routes
})

export default router
