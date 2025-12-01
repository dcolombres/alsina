<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Pagination from '@/Components/Pagination.vue';
import Breadcrumbs from '@/Components/Breadcrumbs.vue';
import { Link, router } from '@inertiajs/vue3';
import { ref, watch } from 'vue';
import { throttle } from 'lodash';

const props = defineProps({
  bi_y_analitica: Object,
  filters: Object,
});

const breadcrumbItems = ref([
  { label: 'BI y Analítica', url: null },
]);


const search = ref(props.filters.search);

watch(search, throttle((value) => {
  router.get(route('bi_y_analitica.index'), { search: value }, {
    preserveState: true,
    replace: true,
  });
}, 300));

const sort = (column) => {
    const currentSort = props.filters.sort;
    const currentDirection = props.filters.direction;
    const newDirection = (currentSort === column && currentDirection === 'asc') ? 'desc' : 'asc';
    
    router.get(route('bi_y_analitica.index'), {
        search: props.filters.search,
        sort: column,
        direction: newDirection,
    }, {
        preserveState: true,
        replace: true,
    });
};

const formatDate = (dateString) => {
    if (!dateString) return 'N/A';
    const date = new Date(dateString);
    return date.toLocaleString('es-AR', { day: '2-digit', month: '2-digit', year: 'numeric', hour: '2-digit', minute: '2-digit' });
};
</script>

<template>
    <AuthenticatedLayout title="BI y Analítica">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                BI y Analítica
            </h2>
        </template>

        <template #breadcrumbs>
            <Breadcrumbs :items="breadcrumbItems" />
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex justify-between mb-4">
                            <input v-model="search" type="text" placeholder="Buscar..." class="border-gray-300 rounded-md shadow-sm">
                            <Link :href="route('bi_y_analitica.create')" class="bg-arg-azul hover:bg-arg-secundario text-white font-bold py-2 px-4 rounded">
                                Crear Entrada
                            </Link>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th @click="sort('nombre')" scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer">Nombre</th>
                                        <th @click="sort('updated_at')" scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer">Última Modificación</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Modificado por</th>
                                        <th scope="col" class="relative px-6 py-3">
                                            <span class="sr-only">Ver</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr v-for="item in bi_y_analitica.data" :key="item.id">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ item.nombre }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ formatDate(item.updated_at) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ item.updated_by_user ? item.updated_by_user.name : 'Sistema' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <Link :href="route('bi_y_analitica.show', item.id)" class="text-indigo-600 hover:text-indigo-900">Ver</Link>
                                        </td>
                                    </tr>
                                    <tr v-if="bi_y_analitica.data.length === 0">
                                        <td colspan="4" class="px-6 py-4 whitespace-nowrap text-center text-gray-500">
                                            No se encontraron entradas.
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4">
                            <Pagination :links="bi_y_analitica.links" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
