<script setup lang="ts">
import { Plus, Trash2 } from '@lucide/vue';
import { ref } from 'vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select';
import { dias } from '@/lib/horarios';
import type { Materia } from '@/types';

const props = defineProps<{
    materia?: Materia;
    errors: Partial<Record<string, string>>;
}>();

type HorarioRow = {
    key: number;
    dia: string;
    hora_inicio: string;
    hora_fin: string;
};

let nextKey = 0;

const horarios = ref<HorarioRow[]>(
    (props.materia?.horarios ?? []).map((horario) => ({
        key: nextKey++,
        dia: String(horario.dia),
        hora_inicio: horario.hora_inicio,
        hora_fin: horario.hora_fin,
    })),
);

const addHorario = (): void => {
    horarios.value.push({
        key: nextKey++,
        dia: '1',
        hora_inicio: '',
        hora_fin: '',
    });
};

const removeHorario = (index: number): void => {
    horarios.value.splice(index, 1);
};
</script>

<template>
    <div class="space-y-6">
        <div class="grid gap-2">
            <Label for="nombre">Nombre</Label>
            <Input
                id="nombre"
                name="nombre"
                :default-value="materia?.nombre"
                required
                placeholder="Ej. Programación Web"
            />
            <InputError :message="errors.nombre" />
        </div>

        <div class="grid gap-2">
            <Label for="creditos">Créditos</Label>
            <Input
                id="creditos"
                name="creditos"
                type="number"
                min="1"
                max="20"
                :default-value="materia?.creditos"
                required
                placeholder="Ej. 8"
            />
            <InputError :message="errors.creditos" />
        </div>

        <div class="grid gap-2">
            <Label for="profesor">Profesor</Label>
            <Input
                id="profesor"
                name="profesor"
                :default-value="materia?.profesor"
                required
                placeholder="Nombre del profesor"
            />
            <InputError :message="errors.profesor" />
        </div>

        <fieldset class="grid gap-3">
            <legend class="mb-2 text-sm font-medium">Horario de clase</legend>

            <p
                v-if="horarios.length === 0"
                class="text-sm text-muted-foreground"
            >
                Sin horario registrado.
            </p>

            <div
                v-for="(horario, index) in horarios"
                :key="horario.key"
                class="grid gap-2 rounded-lg border p-3"
            >
                <div class="flex flex-wrap items-end gap-2">
                    <div class="grid gap-1">
                        <Label :for="`horarios-${index}-dia`" class="text-xs">
                            Día
                        </Label>
                        <Select
                            v-model="horario.dia"
                            :name="`horarios[${index}][dia]`"
                        >
                            <SelectTrigger
                                :id="`horarios-${index}-dia`"
                                class="w-36"
                            >
                                <SelectValue />
                            </SelectTrigger>
                            <SelectContent>
                                <SelectItem
                                    v-for="(nombre, numero) in dias"
                                    :key="numero"
                                    :value="String(numero)"
                                >
                                    {{ nombre }}
                                </SelectItem>
                            </SelectContent>
                        </Select>
                    </div>

                    <div class="grid gap-1">
                        <Label
                            :for="`horarios-${index}-hora_inicio`"
                            class="text-xs"
                        >
                            Inicio
                        </Label>
                        <Input
                            :id="`horarios-${index}-hora_inicio`"
                            v-model="horario.hora_inicio"
                            :name="`horarios[${index}][hora_inicio]`"
                            type="time"
                            required
                            class="w-32"
                        />
                    </div>

                    <div class="grid gap-1">
                        <Label
                            :for="`horarios-${index}-hora_fin`"
                            class="text-xs"
                        >
                            Fin
                        </Label>
                        <Input
                            :id="`horarios-${index}-hora_fin`"
                            v-model="horario.hora_fin"
                            :name="`horarios[${index}][hora_fin]`"
                            type="time"
                            required
                            class="w-32"
                        />
                    </div>

                    <Button
                        type="button"
                        variant="ghost"
                        size="icon"
                        aria-label="Quitar horario"
                        @click="removeHorario(index)"
                    >
                        <Trash2 />
                    </Button>
                </div>

                <InputError :message="errors[`horarios.${index}.dia`]" />
                <InputError
                    :message="errors[`horarios.${index}.hora_inicio`]"
                />
                <InputError :message="errors[`horarios.${index}.hora_fin`]" />
            </div>

            <div>
                <Button
                    type="button"
                    variant="outline"
                    size="sm"
                    @click="addHorario"
                >
                    <Plus />
                    Agregar horario
                </Button>
            </div>

            <InputError :message="errors.horarios" />
        </fieldset>
    </div>
</template>
