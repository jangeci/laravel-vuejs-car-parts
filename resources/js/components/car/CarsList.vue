<script setup>
import {defineProps} from 'vue';

const props = defineProps({
  cars: Array
});

</script>

<template>
  <table class="table">
    <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Name</th>
      <th scope="col">Registration number</th>
      <th scope="col">Is registered</th>
      <th scope="col">Created at</th>
    </tr>
    </thead>
    <tbody>
    <tr v-if="!props.cars">
      <td colspan="6" class="text-center">No cars found.</td>
    </tr>
    <tr v-else v-for="(car, index) in props.cars" :key="car.id">
      <th scope="row">{{ index + 1 }}</th>
      <td>{{ car.name }}</td>
      <td>{{ car.registration_number ?? "-" }}</td>
      <td>{{ car.is_registered ? "true" : "false" }}</td>
      <td>{{ car.created_at ? new Date(car.created_at).toLocaleDateString() : '-' }}</td>
      <td>
        <a class="btn btn-primary" :href="`/cars/${car.id}`">
          Edit
        </a>
      </td>
    </tr>
    </tbody>
  </table>

</template>

<style scoped>

</style>
