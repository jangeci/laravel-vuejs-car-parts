<script setup lang="ts">

import {PaginatedResponseModel} from "@/data/models/PaginatedResponseModel";

const props = defineProps({
    data: {
        type: PaginatedResponseModel
    },
    fetchData: {
        type: Function,
        required: true
    },
});

</script>

<template>
    <nav v-if="data && (data.perPage < data.total)">
        <ul class="pagination">
            <li class="page-item" :class="{ 'disabled': !data.prevPageUrl }">
                <a class="page-link" href="#" @click.prevent="fetchData(data.currentPage
 - 1)">
                    Previous
                </a>
            </li>

            <li v-for="page in data.lastPage" :key="page" class="page-item"
                :class="{ 'active': page === data.currentPage
 }">
                <a class="page-link" href="#" @click.prevent="fetchData(page)">
                    {{ page }}
                </a>
            </li>

            <li class="page-item" :class="{ 'disabled': !data.nextPageUrl }">
                <a class="page-link" href="#" @click.prevent="fetchData(data.currentPage
 + 1)">
                    Next
                </a>
            </li>
        </ul>
    </nav>
</template>

<style scoped>

</style>
