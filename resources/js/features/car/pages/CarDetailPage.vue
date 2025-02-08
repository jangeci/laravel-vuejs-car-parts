<script setup>
import {computed, inject, onMounted, ref} from 'vue';
import axios from 'axios';
import {useRoute} from "vue-router";

const route = useRoute();
const carId = route.params.id;
const toast = inject("toast");

const carData = ref({
        name: '',
        registration_number: '',
        is_registered: false
    }
);

const parts = ref([]);

const searchQuery = ref('');
const addPartError = ref('');
const updateCarError = ref('');

const isRegistered = computed({
    get: () => Boolean(carData.value.is_registered),
    set: (value) => (carData.value.is_registered = value ? 1 : 0),
});

const fetchCarDetail = async () => {
    try {
        const response = await axios.get(`/cars/${carId}`);
        carData.value = response.data.data;
    } catch (error) {
        console.error("Error fetching car:", error);
    }
};
const fetchParts = async (url = `/cars/${carId}/parts`) => {
    try {
        const response = await axios.get(url, {
            params: {
                search: searchQuery.value,
            }
        });
        parts.value = response.data.data.data;
    } catch (error) {
        console.error("Error fetching parts:", error);
    }
};

onMounted(() => {
    fetchCarDetail();
    fetchParts();
});

const updateCar = async (event) => {
    event.preventDefault();

    const formData = new FormData(event.target);
    const name = formData.get("name");
    const registration_number = formData.get("registration_number");
    const is_registered = formData.get("is_registered") ? 1 : 0;

    const errors = {};
    if (!name) {
        errors.name = "Car name is required.";
    }
    if (!registration_number && is_registered === 1) {
        errors.registration_number = "Registration number is required.";
    }

    if (Object.keys(errors).length > 0) {
        updateCarError.value = errors;
        return;
    }

    try {
        await axios.post(`cars/${carId}/update`, {name, registration_number, is_registered});
        toast("Car updated successfully!", "success");
        updateCarError.value = '';
    } catch (error) {
        if (error.response && error.response.status === 422) {
            updateCarError.value = error.response.data.errors;
        } else {
            updateCarError.value = error.message;
        }
        console.error("Error updating car:", error);
    }
};
//TODO add part

</script>

<template>
    <h1 class="pt-4">Car detail</h1>
    <div class="container pt-4">
        <div class="row justify-content-center">
            <div class="col-md-12 pb-4">
                <div class="card">
                    <div class="card-header flex-wrap">
                        <form @submit="updateCar">
                            <div class="row">
                                <div class="form-group pb-3 col-md-6">
                                    <input
                                        class="form-control"
                                        name="name"
                                        placeholder="Name"
                                        type="text"
                                        v-model="carData.name"
                                        :class="{'is-invalid': updateCarError.name}"
                                    >

                                    <div v-if="updateCarError.name" class="invalid-feedback">
                                        {{ updateCarError.name }}
                                    </div>
                                </div>

                                <div class="form-group pb-3  col-md-6">
                                    <input
                                        class="form-control"
                                        name="registration_number"
                                        placeholder="Registration number"
                                        type="text"
                                        v-model="carData.registration_number"
                                        :class="{'is-invalid': updateCarError.registration_number}"
                                    >


                                    <div v-if="updateCarError.registration_number" class="form-group pb-3">
                                        <p class="alert-danger">{{ updateCarError.registration_number }}</p>
                                    </div>
                                </div>
                                <div class="form-group pb-2 d-flex col-md-12">
                                    <input
                                        class="form-check-input me-2"
                                        name="is_registered"
                                        type="checkbox"
                                        id="is_registered"
                                        v-model="isRegistered"
                                    >
                                    <label class="form-label" for="is_registered">Is registered</label>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Update Car</button>
                        </form>

                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h2>Parts</h2>
                        <form class="d-flex w-100" @submit.prevent="fetchParts">
                            <input
                                class="form-control flex-grow-1"
                                v-model="searchQuery"
                                type="text"
                                placeholder="Search by name or serial number"
                            />
                            <button type="submit" class="btn">
                                <i class="bi bi-search"></i>
                            </button>
                        </form>
                    </div>

                    <div class="py-12">
                        <div class="container">
                            <div class="row">
                                <parts-list
                                    :parts="parts"
                                    :fetchParts="fetchParts"
                                ></parts-list>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        Add new part
                    </div>
                    <div class="card-body">
                        <form @submit="addPart">
                            <input type="hidden" name="is_registered" value="0">

                            <div class="form-group pb-3">
                                <label class="form-label" for="name"></label>
                                Car name
                                <input
                                    class="form-control"
                                    name="name"
                                    type="text"
                                    :class="{'is-invalid': addPartError.name}"
                                >

                                <div v-if="addPartError.name" class="invalid-feedback">
                                    {{ addPartError.name }}
                                </div>
                            </div>

                            <div class="form-group pb-3 d-flex">
                                <input
                                    class="form-check-input me-2"
                                    name="is_registered"
                                    type="checkbox"
                                    id="is_registered"
                                    value="1"
                                >
                                <label class="form-label" for="is_registered">Is registered</label>
                            </div>

                            <div class="form-group pb-3">
                                <label class="form-label col-12">
                                    Registration number
                                    <input
                                        class="form-control"
                                        name="registration_number"
                                        type="text"
                                        :class="{'is-invalid': addPartError.registration_number}"
                                    >
                                </label>
                            </div>

                            <div v-if="addPartError.registration_number" class="form-group pb-3">
                                <p class="alert-danger">{{ addPartError.registration_number }}</p>
                            </div>

                            <button type="submit" class="btn btn-primary">Add Car Part</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
