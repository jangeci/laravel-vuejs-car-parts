import {Part} from "@/domain/models/Part";

export interface IPartRepository {
    addPart(part: Part): Promise<void>;

    updatePart(part: Part): Promise<void>;

    deletePart(id: number): Promise<void>;

    getAllParts(search: string): Promise<Part[]>;
}
