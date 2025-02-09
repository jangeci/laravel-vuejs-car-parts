<script setup>
import {computed, inject, onMounted, ref} from 'vue';
import axios from 'axios';

const toast = inject("toast");

const cars = ref([]);
const searchQuery = ref('');
const paginationLinks = ref([]);
const addCarError = ref('');
const isRegistered = ref(false);

const fetchCars = async (url = '/cars') => {
    try {
        const response = await axios.get(url, {
            params: {
                search: searchQuery.value,
            }
        });
        cars.value = response.data.data.data;
        paginationLinks.value = response.data.data.links;
    } catch (error) {
        console.error("Error fetching cars:", error);
    }
};

onMounted(fetchCars);

const addCar = async (event) => {
    event.preventDefault();

    const formData = new FormData(event.target);
    const name = formData.get("name");
    const registration_number = formData.get("registration_number");
    const is_registered = isRegistered.value ? 1 : 0;

    const errors = {};
    if (!name) {
        errors.name = "Car name is required.";
    }
    if (!registration_number && is_registered === 1) {
        errors.registration_number = "Registration number is required.";
    }

    if (Object.keys(errors).length > 0) {
        addCarError.value = errors;
        return;
    }

    try {
        await axios.post('/car-create', {name, registration_number, is_registered});
        event.target.reset();
        addCarError.value = '';
        toast("Car added successfully!", "success");
        fetchCars();
    } catch (error) {
        if (error.response && error.response.status === 422) {
            addCarError.value = error.response.data.errors;
        } else {
            addCarError.value = error.message;
        }
        console.error("Error adding car:", error);
    }
};
</script>

<template>
    <h1 hidden>Home</h1>
    <div class="container pt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <form class="d-flex w-100" @submit.prevent="fetchCars('/cars')">
                            <input
                                class="form-control flex-grow-1"
                                v-model="searchQuery"
                                type="text"
                                placeholder="Search by name or reg number"
                            />
                            <button type="submit" class="btn">
                                <i class="bi bi-search"></i>
                            </button>
                        </form>
                    </div>

                    <div class="py-12">
                        <div class="container">
                            <div class="row">
                                <cars-list
                                    :cars="cars"
                                    :fetchCars="fetchCars"
                                ></cars-list>
                                <nav v-if="paginationLinks && paginationLinks.length > 3">
                                    <ul class="pagination">
                                        <li v-for="(link, index) in paginationLinks" :key="index" class="page-item"
                                            :class="{ 'active': link.active, 'disabled': !link.url }">
                                            <a v-if="link.url" class="page-link" href="#" @click.prevent="fetchCars(link.url)">
                                                <span v-html="link.label"></span>
                                            </a>
                                            <span v-else class="page-link" v-html="link.label"></span>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        Add new car
                    </div>
                    <div class="card-body">
                        <form @submit="addCar">
                            <input type="hidden" name="is_registered" value="0">

                            <div class="form-group pb-3">
                                <label class="form-label" for="name">
                                    Car name
                                </label>
                                <input
                                    id="name"
                                    class="form-control"
                                    name="name"
                                    type="text"
                                    :class="{'is-invalid': addCarError.name}"
                                >

                                <div v-if="addCarError.name" class="invalid-feedback">
                                    {{ addCarError.name }}
                                </div>
                            </div>

                            <div class="form-group pb-3 d-flex">
                                <input
                                    class="form-check-input me-2"
                                    name="is_registered"
                                    type="checkbox"
                                    id="is_registered"
                                    v-model="isRegistered"
                                    :checked="isRegistered"
                                >
                                <label class="form-label" for="is_registered">
                                    Is registered
                                </label>
                            </div>

                            <div class="form-group pb-3">
                                <label class="form-label col-12" for="registration_number">
                                    Registration number
                                </label>
                                <input
                                    id="registration_number"
                                    class="form-control"
                                    name="registration_number"
                                    type="text"
                                    :class="{'is-invalid': addCarError.registration_number}"
                                >
                            </div>

                            <div v-if="addCarError.registration_number" class="form-group pb-3 invalid-feedback">
                                {{ addCarError.registration_number }}
                            </div>

                            <button type="submit" class="btn btn-primary">Add Car</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
