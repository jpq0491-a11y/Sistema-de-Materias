import type { Horario } from '@/types';

/**
 * Day numbers (ISO-8601, Monday = 1) mapped to their names.
 * Keep in sync with Horario::DIAS on the backend.
 */
export const dias: Record<number, string> = {
    1: 'Lunes',
    2: 'Martes',
    3: 'Miércoles',
    4: 'Jueves',
    5: 'Viernes',
    6: 'Sábado',
    7: 'Domingo',
};

export const formatHorario = (horario: Horario): string =>
    `${dias[horario.dia]} ${horario.hora_inicio} – ${horario.hora_fin}`;
