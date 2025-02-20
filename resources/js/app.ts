/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap';
import 'bootstrap/dist/css/bootstrap.min.css';
import "bootstrap-icons/font/bootstrap-icons.css";
import 'bootstrap';

import {createApp} from 'vue';

/**
 * Next, we will create a fresh Vue application instance. You may then begin
 * registering components with the application instance so they are ready
 * to use in your application's views. An example is included for you.
 */

axios.defaults.baseURL = "http://localhost/api";

const app = createApp(App);

import App from "./App.vue";
import router from "./core/AppRouter.js";
import CarsList from "./presentation/features/car/components/CarsList.vue";
import PartsList from "./presentation/features/car/components/PartsList.vue";
import ConfirmationModal from "./presentation/components/ConfirmationModal.vue";
import AppHeader from "./presentation/components/AppHeader.vue";
import appToast from "./core/AppToast.js";
import axios from "axios";
import Pagination from "@/presentation/components/Pagination.vue";

app.component('app-header', AppHeader);
app.component('pagination', Pagination);
app.component('cars-list', CarsList);
app.component('parts-list', PartsList);
app.component('confirmation-modal', ConfirmationModal);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// Object.entries(import.meta.glob('./**/*.vue', { eager: true })).forEach(([path, definition]) => {
//     app.component(path.split('/').pop().replace(/\.\w+$/, ''), definition.default);
// });

/**
 * Finally, we will attach the application instance to a HTML element with
 * an "id" attribute of "app". This element is included with the "auth"
 * scaffolding. Otherwise, you will need to add an element yourself.
 */
app.use(router);
app.use(appToast);
app.mount('#app');
