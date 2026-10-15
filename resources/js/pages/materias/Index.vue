<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import DeleteMateria from '@/components/DeleteMateria.vue';
import Heading from '@/components/Heading.vue';
import { Button } from '@/components/ui/button';
import { create, edit, index, show } from '@/routes/materias';
import type { Materia } from '@/types';

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Materias',
                href: index(),
            },
        ],
    },
});

defineProps<{
    materias: Materia[];
}>();
</script>

<template>
    <Head title="Materias" />

    <div class="flex flex-col gap-6 p-4">
        <div class="flex flex-wrap items-start justify-between gap-4">
            <Heading
                title="Materias"
                description="Listado de todas las materias registradas"
            />
            <Button as-child>
                <Link :href="create()">Nueva materia</Link>
            </Button>
        </div>

        <div
            v-if="materias.length === 0"
            class="rounded-xl border border-dashed p-8 text-center text-sm text-muted-foreground"
        >
            Aún no hay materias.
            <Link :href="create()" class="underline">Crea la primera</Link>.
        </div>

        <div v-else class="overflow-x-auto rounded-xl border">
            <table class="w-full text-sm">
                <thead class="bg-muted/50 text-left">
                    <tr>
                        <th class="px-4 py-3 font-medium">Nombre</th>
                        <th class="px-4 py-3 font-medium">Créditos</th>
                        <th class="px-4 py-3 font-medium">Profesor</th>
                        <th class="px-4 py-3 text-right font-medium">
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="materia in materias"
                        :key="materia.id"
                        class="border-t"
                    >
                        <td class="px-4 py-3">
                            <Link
                                :href="show(materia)"
                                class="font-medium hover:underline"
                            >
                                {{ materia.nombre }}
                            </Link>
                        </td>
                        <td class="px-4 py-3">{{ materia.creditos }}</td>
                        <td class="px-4 py-3">{{ materia.profesor }}</td>
                        <td class="px-4 py-3">
                            <div class="flex justify-end gap-2">
                                <Button variant="outline" size="sm" as-child>
                                    <Link :href="show(materia)">Ver</Link>
                                </Button>
                                <Button variant="outline" size="sm" as-child>
                                    <Link :href="edit(materia)">Editar</Link>
                                </Button>
                                <DeleteMateria :materia="materia" size="sm" />
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
