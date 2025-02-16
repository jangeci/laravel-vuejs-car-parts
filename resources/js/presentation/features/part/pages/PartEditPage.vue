<script setup>

import {useRoute} from "vue-router";
import {inject, onMounted, ref} from "vue";
import axios from "axios";

const route = useRoute();
const carId = route.params.carId;
const partId = route.params.partId;
const toast = inject("toast");

const partData = ref({
        name: '',
        serial_number: ''
    }
);

const updatePartError = ref('');

const fetchPart = async () => {
    try {
        const response = await axios.get(`/cars/${carId}/parts/${partId}`, {});
        partData.value = response.data.data;
    } catch (error) {
        console.error("Error fetching part:", error);
    }
};

onMounted(() => {
    fetchPart();
});

const updateCarPart = async (event) => {
    event.preventDefault();

    const formData = new FormData(event.target);
    const name = formData.get("name");
    const serial_number = formData.get("serial_number");

    const errors = {};
    if (!name) {
        errors.name = "Part name is required.";
    }
    if (!serial_number) {
        errors.registration_number = "Serial number is required.";
    }

    if (Object.keys(errors).length > 0) {
        updatePartError.value = errors;
        return;
    }

    try {
        await axios.post(`cars/${carId}/parts/${partId}/update`, {name, serial_number});
        toast("Part updated successfully!", "success");
        updatePartError.value = '';
    } catch (error) {
        if (error.response && error.response.status === 422) {
            updatePartError.value = error.response.data.errors;
        } else {
            updatePartError.value = error.message;
        }
        console.error("Error updating part:", error);
    }
};
</script>

<template>
    <h1 class="pt-4">Part edit</h1>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 pb-3">
                <a :href="`/cars/${carId}`">
                    <i class="bi bi-arrow-left"></i> Back
                </a>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        Update car part
                    </div>
                    <div class="card-body">
                        <form @submit="updateCarPart">
                            <div class="form-group pb-3">
                                <label class="form-label" for="part-name">Part name</label>
                                <input
                                    id="part-name"
                                    class="form-control"
                                    name="name"
                                    type="text"
                                    v-model="partData.name"
                                    :class="{'is-invalid': updatePartError.name}"
                                >

                                <div v-if="updatePartError.name" class="invalid-feedback">
                                    {{ updatePartError.name }}
                                </div>
                            </div>

                            <div class="form-group pb-3">
                                <label class="form-label col-12" for="serial-number">
                                    Serial number
                                </label>
                                <input
                                    id="serial-number"
                                    class="form-control"
                                    name="serial_number"
                                    type="text"
                                    v-model="partData.serial_number"
                                    :class="{'is-invalid': updatePartError.serial_number}"
                                >
                                <div v-if="updatePartError.serial_number" class="invalid-feedback">
                                    {{ updatePartError.serial_number }}
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">Update Car Part</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>


<style scoped>

</style>
