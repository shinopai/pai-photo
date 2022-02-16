import {
    createRouter,
    createWebHistory
} from "vue-router";
import PhotoList from '../components/PhotoList.vue';
import PhotoDetail from '../components/PhotoDetail.vue';

const routes = [{
        path: '/',
        component: PhotoList
    },
    {
        path: '/photos/:id',
        component: PhotoDetail,
        props: true
    }
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

export default router
