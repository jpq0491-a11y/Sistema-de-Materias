<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import type { Materia } from '@/types';

defineProps<{
    materia?: Materia;
    errors: Partial<Record<string, string>>;
}>();
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
    </div>
</template>
