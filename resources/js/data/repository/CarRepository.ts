import {ICarRepository} from "@/domain/repository/ICarRepository";
import {Car} from "@/domain/models/Car";
import axios from "axios";
import {PaginatedResponseModel} from "@/data/models/PaginatedResponseModel";
import {ApiResponse} from "@/data/models/ApiResponse";

export class CarRepository implements ICarRepository {
    baseUrl = '/cars';

    async getCar(id: number): Promise<ApiResponse<Car>> {
        try {
            return await axios.get(`${this.baseUrl}/${id}`);
        } catch (error) {
            throw new Error("Failed get car.");
        }
    }

    async getCars(page = 1, search = ""): Promise<PaginatedResponseModel<Car>> {
        try {
            const response = await axios.get(this.baseUrl, {
                params: {page, search},
            });

            const data = response.data;
            return PaginatedResponseModel.fromJson<Car>(data, Car.fromJson);
        } catch (error) {
            throw new Error("Failed to fetch cars.");
        }
    }

    async addCar(car: Car): Promise<ApiResponse<any>> {
        try {
            console.log(car)
            return await axios.post(`${this.baseUrl}/create`, car);
        } catch (error) {
            throw new Error("Failed to create car.");
        }
    }

    async deleteCar(id: number): Promise<ApiResponse<any>> {
        try {
            return await axios.delete(`${this.baseUrl}/${id}/delete`);
        } catch (error) {
            throw new Error("Failed to delete car.");
        }
    }

    async updateCar(car: Car): Promise<ApiResponse<any>> {
        try {
            return await axios.post(`${this.baseUrl}/${car.id}/update`);
        } catch (error) {
            throw new Error("Failed update car.");
        }
    }
}
