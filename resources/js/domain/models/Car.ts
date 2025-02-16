export class Car {
    public id: number;
    public name: string;
    public registration_number: string | null;
    public is_registered: boolean;
    public created_at?: Date;

    constructor({
                    id,
                    name,
                    registration_number,
                    is_registered,
                    created_at,
                }: {
        id: number;
        name: string;
        registration_number: string | null;
        is_registered: boolean;
        created_at?: Date;
    }) {
        this.id = id;
        this.name = name;
        this.registration_number = registration_number;
        this.is_registered = is_registered;
        this.created_at = created_at;
    }

    static fromJson(json: any): Car {
        return new Car({
            id: json.id,
            name: json.name,
            registration_number: json.registration_number,
            is_registered: Boolean(json.is_registered === 1),
            created_at: json.created_at ? new Date(json.created_at) : undefined,
        });
    }
}
