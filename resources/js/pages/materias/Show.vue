<script setup lang="ts">
import { Head, Link, setLayoutProps } from '@inertiajs/vue3';
import DeleteMateria from '@/components/DeleteMateria.vue';
import Heading from '@/components/Heading.vue';
import { Button } from '@/components/ui/button';
import { edit, index, show } from '@/routes/materias';
import type { Materia } from '@/types';

const props = defineProps<{
    materia: Materia;
}>();

setLayoutProps({
    breadcrumbs: [
        { title: 'Materias', href: index() },
        { title: props.materia.nombre, href: show(props.materia) },
    ],
});

const formatDate = (date: string): string =>
    new Date(date).toLocaleString('es-MX', {
        dateStyle: 'medium',
        timeStyle: 'short',
    });
</script>

<template>
    <Head :title="materia.nombre" />

    <div class="flex max-w-xl flex-col gap-6 p-4">
        <Heading :title="materia.nombre" description="Detalle de la materia" />

        <dl class="divide-y rounded-xl border text-sm">
            <div class="grid grid-cols-3 gap-4 px-4 py-3">
                <dt class="text-muted-foreground">Nombre</dt>
                <dd class="col-span-2 font-medium">{{ materia.nombre }}</dd>
            </div>
            <div class="grid grid-cols-3 gap-4 px-4 py-3">
                <dt class="text-muted-foreground">Créditos</dt>
                <dd class="col-span-2">{{ materia.creditos }}</dd>
            </div>
            <div class="grid grid-cols-3 gap-4 px-4 py-3">
                <dt class="text-muted-foreground">Profesor</dt>
                <dd class="col-span-2">{{ materia.profesor }}</dd>
            </div>
            <div class="grid grid-cols-3 gap-4 px-4 py-3">
                <dt class="text-muted-foreground">Creada</dt>
                <dd class="col-span-2">{{ formatDate(materia.created_at) }}</dd>
            </div>
            <div class="grid grid-cols-3 gap-4 px-4 py-3">
                <dt class="text-muted-foreground">Actualizada</dt>
                <dd class="col-span-2">{{ formatDate(materia.updated_at) }}</dd>
            </div>
        </dl>

        <div class="flex flex-wrap items-center gap-2">
            <Button as-child>
                <Link :href="edit(materia)">Editar</Link>
            </Button>
            <DeleteMateria :materia="materia" />
            <Button variant="ghost" as-child>
                <Link :href="index()">Volver al listado</Link>
            </Button>
        </div>
    </div>
</template>
