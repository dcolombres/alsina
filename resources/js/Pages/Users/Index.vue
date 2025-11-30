<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Pagination from '@/Components/Pagination.vue';
import Breadcrumbs from '@/Components/Breadcrumbs.vue';
import { Link, router, usePage } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

const props = defineProps({
  users: Object,
});

const page = usePage();
const successMessage = computed(() => page.props.flash?.success);
const errorMessage = computed(() => page.props.flash?.error);


const breadcrumbItems = ref([
  { label: 'Administración', url: '#' },
  { label: 'Usuarios', url: null },
]);

const deleteUser = (userId) => {
    if (confirm('¿Estás seguro de que quieres eliminar a este usuario?')) {
        router.delete(route('users.destroy', userId), {
            preserveScroll: true,
        });
    }
};

const getRoleClass = (role) => {
    if (role === 'admin') return 'bg-red-100 text-red-800';
    return 'bg-blue-100 text-blue-800';
};

</script>

<template>
    <AuthenticatedLayout title="Usuarios">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Gestión de Usuarios
            </h2>
        </template>

        <template #breadcrumbs>
            <Breadcrumbs :items="breadcrumbItems" />
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                 <div v-if="successMessage" class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ successMessage }}</span>
                </div>
                <div v-if="errorMessage" class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ errorMessage }}</span>
                </div>
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex justify-between mb-4">
                            <div></div>
                            <Link :href="route('users.create')" class="bg-arg-azul hover:bg-arg-secundario text-white font-bold py-2 px-4 rounded">
                                Crear Usuario
                            </Link>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rol</th>
                                        <th scope="col" class="relative px-6 py-3">
                                            <span class="sr-only">Acciones</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr v-for="user in users.data" :key="user.id">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ user.name }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ user.email }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span v-if="user.roles.length > 0" 
                                                  class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full" 
                                                  :class="getRoleClass(user.roles[0].name)">
                                                {{ user.roles[0].name }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <Link :href="route('users.edit', user.id)" class="text-indigo-600 hover:text-indigo-900 mr-4">Editar</Link>
                                            <button @click="deleteUser(user.id)" class="text-red-600 hover:text-red-900">Eliminar</button>
                                        </td>
                                    </tr>
                                    <tr v-if="users.data.length === 0">
                                        <td colspan="4" class="px-6 py-4 whitespace-nowrap text-center text-gray-500">
                                            No se encontraron usuarios.
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4">
                            <Pagination :links="users.links" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
