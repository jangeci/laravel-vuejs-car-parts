import CarsMainPage from "../features/car/pages/CarsMainPage.vue";
import {createRouter, createWebHistory} from "vue-router";
import CarDetailPage from "../features/car/pages/CarDetailPage.vue";
import CarEditPage from "../features/car/pages/CarEditPage.vue";
import NotFoundPage from "../features/NotFoundPage.vue";

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
        path: '/cars/:id/edit',
        name: 'CarEdit',
        component: CarEditPage
    },
    {
        path: '/cars/:carId/part/:partId/edit',
        name: 'CarPartEdit',
        component: CarEditPage
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
