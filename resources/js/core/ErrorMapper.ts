import {AxiosError} from "axios";
import {ErrorData} from "@/domain/models/ErrorData";
import {ApiErrorResponse} from "@/data/models/ApiErrorResponse";

export class ErrorMapper {
    static toErrorData(error: AxiosError<ApiErrorResponse>): ErrorData {
        const data = error.response?.data || {};

        return {
            message: data?.message || error.message,
            code: data?.code || "UNKNOWN_ERROR",
            status: data?.status,
            details: data || null,
        };
    }
}
