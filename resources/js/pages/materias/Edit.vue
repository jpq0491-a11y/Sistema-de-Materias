<script setup lang="ts">
import { Form, Head, Link, setLayoutProps } from '@inertiajs/vue3';
import MateriaController from '@/actions/App/Http/Controllers/MateriaController';
import Heading from '@/components/Heading.vue';
import MateriaForm from '@/components/MateriaForm.vue';
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
        { title: 'Editar', href: edit(props.materia) },
    ],
});
</script>

<template>
    <Head :title="`Editar ${materia.nombre}`" />

    <div class="flex max-w-xl flex-col gap-6 p-4">
        <Heading
            title="Editar materia"
            :description="`Modifica los datos de ${materia.nombre}`"
        />

        <Form
            v-bind="MateriaController.update.form(materia)"
            class="space-y-6"
            v-slot="{ errors, processing }"
        >
            <MateriaForm :materia="materia" :errors="errors" />

            <div class="flex flex-wrap items-center gap-2">
                <Button type="submit" :disabled="processing">
                    Guardar cambios
                </Button>
                <Button variant="outline" as-child>
                    <Link :href="show(materia)">Ver detalle</Link>
                </Button>
                <Button variant="ghost" as-child>
                    <Link :href="index()">Volver al listado</Link>
                </Button>
            </div>
        </Form>
    </div>
</template>
