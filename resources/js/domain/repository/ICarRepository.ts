import {Car} from "@/domain/models/Car";
import {PaginatedResponseModel} from "@/data/models/PaginatedResponseModel";
import {ApiResponse} from "@/data/models/ApiResponse";

export interface ICarRepository {
    getCar(id: number): Promise<ApiResponse<Car>>;

    getCars(page: number, search?: string): Promise<PaginatedResponseModel<Car>>;

    addCar(car: Car): Promise<ApiResponse<any>>;

    updateCar(car: Car): Promise<ApiResponse<any>>;

    deleteCar(id: number): Promise<ApiResponse<any>>;
}
