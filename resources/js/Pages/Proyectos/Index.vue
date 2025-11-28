<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Pagination from '@/Components/Pagination.vue';
import Breadcrumbs from '@/Components/Breadcrumbs.vue';
import { Link, router } from '@inertiajs/vue3';
import { ref, watch } from 'vue';
import { throttle } from 'lodash';

const props = defineProps({
  proyectos: Object,
  filters: Object,
});

const breadcrumbItems = ref([
  { label: 'Proyectos', url: null },
]);


const search = ref(props.filters.search);

watch(search, throttle((value) => {
  router.get(route('proyectos.index'), { search: value }, {
    preserveState: true,
    replace: true,
  });
}, 300));

const sort = (column) => {
    const currentSort = props.filters.sort;
    const currentDirection = props.filters.direction;
    const newDirection = (currentSort === column && currentDirection === 'asc') ? 'desc' : 'asc';
    
    router.get(route('proyectos.index'), {
        search: props.filters.search,
        sort: column,
        direction: newDirection,
    }, {
        preserveState: true,
        replace: true,
    });
};

const getTierClass = (tier) => {
    if (!tier) return 'bg-gray-100 text-gray-800';
    const tierNum = parseInt(tier.replace('T', ''));
    if (tierNum <= 2) return 'bg-red-100 text-red-800';
    if (tierNum <= 4) return 'bg-yellow-100 text-yellow-800';
    return 'bg-green-100 text-green-800';
};

</script>

<template>
    <AuthenticatedLayout title="Proyectos">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Proyectos
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
                            <Link :href="route('proyectos.create')" class="bg-arg-azul hover:bg-arg-secundario text-white font-bold py-2 px-4 rounded">
                                Crear Proyecto
                            </Link>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th @click="sort('nombre')" scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer">Nombre</th>
                                        <th @click="sort('tier')" scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer">Tier</th>
                                        <th @click="sort('categoria')" scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer">Categoría</th>
                                        <th @click="sort('responsable_id')" scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer">Responsable</th>
                                        <th @click="sort('estado')" scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer">Estado</th>
                                        <th scope="col" class="relative px-6 py-3">
                                            <span class="sr-only">Ver</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr v-for="proyecto in proyectos.data" :key="proyecto.id">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ proyecto.nombre }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full" :class="getTierClass(proyecto.tier)">
                                                {{ proyecto.tier || 'N/A' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ proyecto.categoria || 'N/A' }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900" v-if="proyecto.responsable">
                                                {{ proyecto.responsable.nombre_apellido }}
                                            </div>
                                            <div class="text-sm text-gray-500" v-else>No asignado</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full"
                                                  :class="{
                                                    'bg-green-100 text-green-800': proyecto.estado === 'activo' || proyecto.estado === 'operativo',
                                                    'bg-red-100 text-red-800': proyecto.estado === 'inactivo',
                                                    'bg-yellow-100 text-yellow-800': proyecto.estado.includes('desarrollo'),
                                                    'bg-gray-100 text-gray-800': !['activo', 'operativo', 'inactivo'].includes(proyecto.estado) && !proyecto.estado.includes('desarrollo')
                                                  }">
                                                {{ proyecto.estado }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <Link :href="route('proyectos.show', proyecto.id)" class="text-indigo-600 hover:text-indigo-900">Ver</Link>
                                        </td>
                                    </tr>
                                    <tr v-if="proyectos.data.length === 0">
                                        <td colspan="6" class="px-6 py-4 whitespace-nowrap text-center text-gray-500">
                                            No se encontraron proyectos.
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4">
                            <Pagination :links="proyectos.links" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
