import {ErrorData} from "@/domain/models/ErrorData";

export class ApiResponse<T> {
    public message?: string;
    public data: T;
    public errors: ErrorData[];

    constructor({message, data, errors}: { message?: string; data: T; errors: ErrorData[] }) {
        this.message = message;
        this.data = data;
        this.errors = errors;
    }

    static fromJson<U>(json: any, dataMapper: (data: any) => U): ApiResponse<U> {
        return new ApiResponse<U>({
            message: json.msg,
            data: dataMapper(json.data),
            errors: json.errors ?? [],
        });
    }

    public toDomain(): ApiResponse<T> {
        return new ApiResponse<T>({
                message: this.message,
                data: this.data,
                errors: this.errors,
            }
        )
    }
}
