import {inject, onMounted, ref, reactive} from 'vue';
import {CarRepository} from "@/data/repository/CarRepository.js";
import {Car} from "@/domain/models/Car.js";
import {PaginatedResponseModel} from "@/data/models/PaginatedResponseModel";

export default function CarComposable() {

    const toast = inject<(message: string, type?: string) => void>("toast");

    if (!toast) {
        throw new Error("Toast function is not provided");
    }

    const data = ref<PaginatedResponseModel<Car> | null>(null);
    const carRepository = new CarRepository();

    const searchQuery = ref('');
    const isLoading = ref(false);

    const form = reactive({
        name: "",
        registrationNumber: "",
        isRegistered: false,
    });

    const addCarError = reactive<{ name?: string; registrationNumber?: string }>({});

    const fetchCars = async (page = 1) => {
        isLoading.value = true;
        try {
            data.value = await carRepository.getCars(page, searchQuery.value);
        } catch (error) {
            console.error(error);
        } finally {
            isLoading.value = false;
        }
    }

    onMounted(fetchCars);

    const validateForm = () => {
        addCarError.name = form.name ? "" : "Car name is required.";
        addCarError.registrationNumber = form.isRegistered && !form.registrationNumber ? "Registration number is required." : "";

        return !addCarError.name && !addCarError.registrationNumber;
    };

    const addCar = async () => {
        if (!validateForm()) return;

        try {
            await carRepository.addCar(new Car({
                id: 0,
                name: form.name,
                registration_number: form.registrationNumber,
                is_registered: !!form.isRegistered,
            }));

            form.name = "";
            form.registrationNumber = "";
            form.isRegistered = false;
            addCarError.name = "";
            addCarError.registrationNumber = "";

            toast("Car added successfully!", "success");
            fetchCars();
        } catch (error: any) {
            console.error("Error adding car:", error);
        }
    };

    return {
        data, searchQuery, isLoading, form, addCarError, addCar, fetchCars,
    }
}
