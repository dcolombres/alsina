<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { useForm } from '@inertiajs/vue3';

const form = useForm({
    nombre: '',
    descripcion: '',
});

const submit = () => {
  form.post(route('bi_y_analitica.store'));
};
</script>

<template>
    <AuthenticatedLayout title="Crear Entrada de BI y Analítica">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Crear Nueva Entrada de BI y Analítica
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

                    <div class="flex items-center justify-end px-6 py-4 bg-gray-50 text-right">
                        <button type="submit" :disabled="form.processing" class="bg-arg-azul hover:bg-arg-secundario text-white font-bold py-2 px-4 rounded">
                            Crear Entrada
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
