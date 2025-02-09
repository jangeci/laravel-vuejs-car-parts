import CarsMainPage from "../features/car/pages/CarsMainPage.vue";
import {createRouter, createWebHistory} from "vue-router";
import CarDetailPage from "../features/car/pages/CarDetailPage.vue";
import NotFoundPage from "../features/NotFoundPage.vue";
import PartEditPage from "../features/part/pages/PartEditPage.vue";

const routes = [
    {
        path: '/',
        name: 'Home',
        component: CarsMainPage
    },
    {
        path: '/cars/:id',
        name: 'CarDetail',
        component: CarDetailPage
    },
    {
        path: '/cars/:carId/parts/:partId/edit',
        name: 'CarPartEdit',
        component: PartEditPage
    },
    {
        path: "/:pathMatch(.*)*",
        name: "NotFound",
        component: NotFoundPage}
]

const router = createRouter({
    history: createWebHistory(),
    routes
});

export default router;
