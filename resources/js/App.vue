<script setup>

import AppHeader from "./components/AppHeader.vue";
</script>

<template>
    <div>
        <app-header/>
        <div class="container">
            <div class="row justify-content-center">
                <router-view></router-view>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
