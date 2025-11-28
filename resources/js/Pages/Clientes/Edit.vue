<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Breadcrumbs from '@/Components/Breadcrumbs.vue';
import { useForm, router } from '@inertiajs/vue3';
import { defineProps, ref } from 'vue';

const props = defineProps({
  cliente: Object,
});

const breadcrumbItems = ref([
  { label: 'Clientes', url: route('clientes.index') },
  { label: props.cliente.nombre, url: route('clientes.show', props.cliente.id) },
  { label: 'Editar', url: null },
]);

const form = useForm({
    nombre: props.cliente.nombre,
    apellido: props.cliente.apellido,
    email: props.cliente.email,
    celular: props.cliente.celular,
    area: props.cliente.area,
    dependencia: props.cliente.dependencia,
    origen: props.cliente.origen,
});

const submit = () => {
  form.put(route('clientes.update', props.cliente.id));
};

const destroy = () => {
    if (confirm('¿Estás seguro de que deseas eliminar este cliente?')) {
        router.delete(route('clientes.destroy', props.cliente.id));
    }
};
</script>

<template>
    <AuthenticatedLayout title="Editar Cliente">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Editando a: {{ cliente.nombre }} {{ cliente.apellido }}
            </h2>
        </template>

        <template #breadcrumbs>
            <Breadcrumbs :items="breadcrumbItems" />
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <form @submit.prevent="submit" class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                        
                        <div><label class="block font-medium text-sm text-gray-700">Nombre</label><input type="text" v-model="form.nombre" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"></div>
                        <div><label class="block font-medium text-sm text-gray-700">Apellido</label><input type="text" v-model="form.apellido" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"></div>
                        <div><label class="block font-medium text-sm text-gray-700">Email</label><input type="email" v-model="form.email" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"></div>
                        <div><label class="block font-medium text-sm text-gray-700">Celular</label><input type="text" v-model="form.celular" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"></div>
                        <div><label class="block font-medium text-sm text-gray-700">Área</label><input type="text" v-model="form.area" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"></div>
                        <div><label class="block font-medium text-sm text-gray-700">Dependencia</label><input type="text" v-model="form.dependencia" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"></div>
                        <div><label class="block font-medium text-sm text-gray-700">Origen</label><input type="text" v-model="form.origen" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"></div>

                    </div>
                    <div class="flex items-center justify-between px-6 py-4 bg-gray-50 text-right">
                        <button type="button" @click="destroy" class="text-red-600 hover:underline">
                            Eliminar Cliente
                        </button>
                        <button type="submit" :disabled="form.processing" class="bg-arg-azul hover:bg-arg-secundario text-white font-bold py-2 px-4 rounded">
                            Guardar Cambios
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>