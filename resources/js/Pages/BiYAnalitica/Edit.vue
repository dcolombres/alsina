<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { useForm, router } from '@inertiajs/vue3';
import { defineProps } from 'vue';

const props = defineProps({
  bi_y_analitica: Object,
});

const form = useForm({
    nombre: props.bi_y_analitica.nombre,
    descripcion: props.bi_y_analitica.descripcion,
});

const submit = () => {
  form.put(route('bi_y_analitica.update', props.bi_y_analitica.id));
};

const destroy = () => {
    if (confirm('¿Estás seguro de que deseas eliminar esta entrada?')) {
        router.delete(route('bi_y_analitica.destroy', props.bi_y_analitica.id));
    }
};
</script>

<template>
    <AuthenticatedLayout title="Editar Entrada de BI y Analítica">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Editando Entrada: {{ form.nombre }}
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <form @submit.prevent="submit" class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="nombre" class="block font-medium text-sm text-gray-700">Nombre</label>
                                <input id="nombre" type="text" v-model="form.nombre" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            </div>
                            <div class="md:col-span-2">
                                <label for="descripcion" class="block font-medium text-sm text-gray-700">Descripción</label>
                                <textarea id="descripcion" v-model="form.descripcion" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-between px-6 py-4 bg-gray-50 text-right">
                        <button type="button" @click="destroy" class="text-red-600 hover:underline">Eliminar Entrada</button>
                        <button type="submit" :disabled="form.processing" class="bg-arg-azul hover:bg-arg-secundario text-white font-bold py-2 px-4 rounded">Guardar Cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
