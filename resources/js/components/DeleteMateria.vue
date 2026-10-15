<script setup lang="ts">
import { Form } from '@inertiajs/vue3';
import MateriaController from '@/actions/App/Http/Controllers/MateriaController';
import { Button } from '@/components/ui/button';
import {
    Dialog,
    DialogClose,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from '@/components/ui/dialog';
import type { Materia } from '@/types';

withDefaults(
    defineProps<{
        materia: Materia;
        size?: 'default' | 'sm';
    }>(),
    { size: 'default' },
);
</script>

<template>
    <Dialog>
        <DialogTrigger as-child>
            <Button variant="destructive" :size="size">Eliminar</Button>
        </DialogTrigger>
        <DialogContent>
            <Form
                v-bind="MateriaController.destroy.form(materia)"
                class="space-y-6"
                v-slot="{ processing }"
            >
                <DialogHeader class="space-y-3">
                    <DialogTitle>¿Eliminar la materia?</DialogTitle>
                    <DialogDescription>
                        Se eliminará "{{ materia.nombre }}" de forma permanente.
                        Esta acción no se puede deshacer.
                    </DialogDescription>
                </DialogHeader>

                <DialogFooter class="gap-2">
                    <DialogClose as-child>
                        <Button variant="secondary">Cancelar</Button>
                    </DialogClose>

                    <Button
                        type="submit"
                        variant="destructive"
                        :disabled="processing"
                    >
                        Eliminar
                    </Button>
                </DialogFooter>
            </Form>
        </DialogContent>
    </Dialog>
</template>
