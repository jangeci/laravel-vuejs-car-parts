import {ErrorData} from "@/domain/models/ErrorData";

export class PaginatedResponseModel<T> {
    public message?: string;
    public data: T[];
    public errors: ErrorData[];
    public currentPage: number;
    public total: number;
    public perPage: number;
    public lastPage: number;
    public nextPageUrl?: string;
    public prevPageUrl?: string;

    constructor(
        {
            message,
            data,
            errors,
            currentPage,
            total,
            perPage,
            lastPage,
            nextPageUrl,
            prevPageUrl,
        }: {
            message?: string;
            data: T[];
            errors: ErrorData[];
            currentPage: number;
            total: number;
            perPage: number;
            lastPage: number;
            nextPageUrl?: string;
            prevPageUrl?: string;
        }) {
        this.message = message;
        this.data = data;
        this.errors = errors;
        this.currentPage = currentPage;
        this.total = total;
        this.perPage = perPage;
        this.lastPage = lastPage;
        this.nextPageUrl = nextPageUrl;
        this.prevPageUrl = prevPageUrl;
    }

    static fromJson<T>(json: any, dataMapper: (data: any) => T): PaginatedResponseModel<T> {
        return new PaginatedResponseModel<T>({
            message: json.msg,
            data: json.data.data.map(dataMapper),
            errors: json.errors ?? [],
            currentPage: json.data.current_page,
            total: json.data.total,
            perPage: json.data.per_page,
            lastPage: json.data.last_page,
            nextPageUrl: json.data.next_page_url,
            prevPageUrl: json.data.prev_page_url,
        });
    }
}
