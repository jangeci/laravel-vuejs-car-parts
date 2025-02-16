<script setup>
import {defineEmits} from 'vue';

const props = defineProps({
    show: Boolean,
    title: String,
    text: String
});

const emit = defineEmits(['close', 'confirm']);

const closeModal = () => {
    emit('close');
};

const confirm = () => {
    emit('confirm');
};
</script>

<template>
    <div v-if="show"
         class="modal fade show d-block"
         tabindex="-1"
         style="display: block !important"
         aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ title }}</h5>
                    <button type="button" class="btn-close" @click="closeModal"></button>
                </div>
                <div class="modal-body">
                    {{ text }}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" @click="closeModal">Cancel</button>
                    <button type="button" class="btn btn-danger" @click="confirm">Confirm</button>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.modal {
    display: block !important;
    background-color: rgba(0, 0, 0, 0.5);
}
</style>
