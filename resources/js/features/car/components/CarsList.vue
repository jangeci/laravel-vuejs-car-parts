<script setup>
import {defineProps, inject, ref} from 'vue';
import ConfirmationModal from "../../../components/ConfirmationModal.vue";

const props = defineProps({
    cars: Array,
    fetchCars: Function,
});

const showModal = ref(false);
const carIdToDelete = ref(null);
const toast = inject("toast");

const openModal = (carId) => {
    carIdToDelete.value = carId;
    showModal.value = true;
};

const closeModal = () => {
    showModal.value = false;
};

const handleDelete = async () => {
    try {
        await axios.delete(`/cars/${carIdToDelete.value}/delete`);
        props.fetchCars();
        closeModal();
        toast("Car deleted!", "success");
    } catch (error) {
        console.error('Error deleting car:', error);
    }
};
</script>

<template>
    <div>
        <table class="table">
            <thead>
            <tr class="table-header-row">
                <th scope="col">ID</th>
                <th scope="col">Name</th>
                <th scope="col">Registration number</th>
                <th scope="col">Is registered</th>
                <th scope="col">Created at</th>
                <th scope="col"></th>
            </tr>
            </thead>
            <tbody>
            <tr v-if="!props.cars">
                <td colspan="6" class="text-center">No cars found.</td>
            </tr>
            <tr v-else v-for="(car) in props.cars" :key="car.id">
                <th scope="row">{{ car.id }}</th>
                <td>{{ car.name }}</td>
                <td>{{ car.registration_number ?? "-" }}</td>
                <td>{{ car.is_registered ? "true" : "false" }}</td>
                <td>{{ car.created_at ? new Date(car.created_at).toLocaleDateString() : '-' }}</td>
                <td>
                    <div class="d-flex align-items-center gap-2">
                        <a class="btn btn-primary" :href="`/cars/${car.id}`">
                            Detail
                        </a>
                        <button class="btn btn-danger" @click.prevent="openModal(car.id)">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
        <confirmation-modal
            :id="carIdToDelete"
            :title="'Delete car'"
            :text="'Are you sure ?'"
            :show="showModal"
            @close="closeModal"
            @confirm="handleDelete"
        ></confirmation-modal>
    </div>

</template>

<style scoped>
.table-header-row {
    vertical-align: top;
}
</style>
