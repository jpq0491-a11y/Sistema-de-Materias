<script setup lang="ts">
import { Form, Head, Link } from '@inertiajs/vue3';
import MateriaController from '@/actions/App/Http/Controllers/MateriaController';
import Heading from '@/components/Heading.vue';
import MateriaForm from '@/components/MateriaForm.vue';
import { Button } from '@/components/ui/button';
import { create, index } from '@/routes/materias';

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Materias',
                href: index(),
            },
            {
                title: 'Nueva materia',
                href: create(),
            },
        ],
    },
});
</script>

<template>
    <Head title="Nueva materia" />

    <div class="flex max-w-xl flex-col gap-6 p-4">
        <Heading
            title="Nueva materia"
            description="Registra una materia con su nombre, créditos y profesor"
        />

        <Form
            v-bind="MateriaController.store.form()"
            class="space-y-6"
            v-slot="{ errors, processing }"
        >
            <MateriaForm :errors="errors" />

            <div class="flex items-center gap-2">
                <Button type="submit" :disabled="processing">Guardar</Button>
                <Button variant="outline" as-child>
                    <Link :href="index()">Cancelar</Link>
                </Button>
            </div>
        </Form>
    </div>
</template>
