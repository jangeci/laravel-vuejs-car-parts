<script setup lang="ts">
    import CarComposable from "@/presentation/features/car/composables/CarComposable";

    const {
        data,
        searchQuery,
        isLoading,
        form,
        addCarError,
        addCar,
        fetchCars,
    } = CarComposable()
</script>

<template>
    <h1 hidden>Home</h1>
    <div class="container pt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <form class="d-flex w-100" @submit.prevent="fetchCars()">
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
                                    :cars="data?.data"
                                    :fetchCars="fetchCars"
                                ></cars-list>
                                <pagination
                                    :data="data"
                                    :fetch-data="fetchCars"
                                ></pagination>
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
                        <form @submit.prevent="addCar">
                            <input type="hidden" name="is_registered" value="0">

                            <div class="form-group pb-3">
                                <label class="form-label" for="name">
                                    Car name
                                </label>
                                <input
                                    id="name"
                                    class="form-control"
                                    v-model="form.name"
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
                                    type="checkbox"
                                    id="is_registered"
                                    v-model="form.isRegistered"
                                    :checked="form.isRegistered"
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
                                    v-model="form.registrationNumber"
                                    type="text"
                                    :class="{'is-invalid': addCarError.registrationNumber}"
                                >
                                <div v-if="addCarError.registrationNumber" class="invalid-feedback">
                                    {{ addCarError.registrationNumber }}
                                </div>
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
