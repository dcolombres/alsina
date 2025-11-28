<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Breadcrumbs from '@/Components/Breadcrumbs.vue';
import { Link } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
  cliente: Object,
});

const breadcrumbItems = ref([
  { label: 'Clientes', url: route('clientes.index') },
  { label: props.cliente.nombre, url: null },
]);

</script>

<template>
    <AuthenticatedLayout title="Detalle del Cliente">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Ficha del Cliente
            </h2>
        </template>

        <template #breadcrumbs>
            <Breadcrumbs :items="breadcrumbItems" />
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6 border-b border-gray-200">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="text-2xl font-bold text-gray-800">{{ cliente.nombre }} {{ cliente.apellido }}</h3>
                                <p class="mt-1 text-sm text-gray-600">{{ cliente.email }}</p>
                            </div>
                            <Link :href="route('clientes.edit', cliente.id)" class="ml-4 flex-shrink-0 bg-arg-azul hover:bg-arg-secundario text-white font-bold py-2 px-4 rounded">
                                Editar Cliente
                            </Link>
                        </div>
                    </div>

                    <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div><h4 class="font-semibold text-gray-600">Área</h4><p>{{ cliente.area || 'N/A' }}</p></div>
                        <div><h4 class="font-semibold text-gray-600">Dependencia</h4><p>{{ cliente.dependencia || 'N/A' }}</p></div>
                        <div><h4 class="font-semibold text-gray-600">Origen</h4><p>{{ cliente.origen || 'N/A' }}</p></div>
                        <div><h4 class="font-semibold text-gray-600">Celular</h4><p>{{ cliente.celular || 'N/A' }}</p></div>
                    </div>

                    <div class="p-6 border-t border-gray-200">
                        <h3 class="text-xl font-bold text-gray-800 mb-4">Proyectos donde es Cliente Principal</h3>
                        <ul v-if="cliente.proyectos_como_cliente_principal && cliente.proyectos_como_cliente_principal.length > 0">
                            <li v-for="proyecto in cliente.proyectos_como_cliente_principal" :key="proyecto.id">
                                <Link :href="route('proyectos.show', proyecto.id)" class="text-blue-600 hover:underline">{{ proyecto.nombre }}</Link>
                            </li>
                        </ul>
                        <p v-else class="text-gray-500">Este cliente no es el cliente principal de ningún proyecto.</p>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>