<script setup>
import {defineProps, inject, ref} from "vue";
import ConfirmationModal from "../../../components/ConfirmationModal.vue";
import {useRoute} from "vue-router";

const props = defineProps({
    parts: Array,
    fetchParts: Function,
});

const route = useRoute();
const carId = route.params.id;
const toast = inject("toast");

const showModal = ref(false);
const partIdToDelete = ref(null);

const openModal = (partId) => {
    partIdToDelete.value = partId;
    showModal.value = true;
};

const closeModal = () => {
    showModal.value = false;
};

const handleDelete = async () => {
    console.log(partIdToDelete)

    try {
        await axios.delete(`/cars/${carId}/parts/${partIdToDelete.value}/delete`);
        props.fetchParts();
        closeModal();
        toast("Part deleted!", "success");
    } catch (error) {
        console.error('Error deleting part:', error);
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
                <th scope="col">Serial number</th>
                <th scope="col">Created at</th>
                <th scope="col"></th>
            </tr>
            </thead>
            <tbody>
            <tr v-if="!props.parts">
                <td colspan="5" class="text-center">No parts found.</td>
            </tr>
            <tr v-else v-for="(part) in props.parts" :key="part.id">
                <th scope="row">{{ part.id }}</th>
                <td>{{ part.name }}</td>
                <td>{{ part.serial_number }}</td>
                <td>{{ new Date(part.created_at).toLocaleDateString() }}</td>
                <td>
                    <div class="d-flex align-items-center gap-2">
                        <a class="btn btn-primary" :href="`/cars/${carId}/parts/${part.id}/edit`">
                            Edit
                        </a>
                        <button class="btn btn-danger" @click.prevent="openModal(part.id)">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
        <confirmation-modal
            :id="partIdToDelete"
            :title="'Delete part'"
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
