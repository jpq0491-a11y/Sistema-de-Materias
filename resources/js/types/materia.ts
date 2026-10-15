export type Horario = {
    id: number;
    materia_id: number;
    dia: number;
    hora_inicio: string;
    hora_fin: string;
};

export type Materia = {
    id: number;
    nombre: string;
    creditos: number;
    profesor: string;
    horarios?: Horario[];
    created_at: string;
    updated_at: string;
};
