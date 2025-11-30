<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Breadcrumbs from '@/Components/Breadcrumbs.vue';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
  user: Object,
  roles: Array,
  errors: Object,
});

const form = useForm({
    _method: 'PUT',
    name: props.user.name,
    email: props.user.email,
    password: '',
    password_confirmation: '',
    role: props.user.roles[0]?.name || 'user',
});

const submit = () => {
  form.post(route('users.update', props.user.id), {
    onFinish: () => form.reset('password', 'password_confirmation'),
  });
};

const breadcrumbItems = ref([
  { label: 'Administración', url: '#' },
  { label: 'Usuarios', url: route('users.index') },
  { label: 'Editar', url: null },
]);

</script>

<template>
    <AuthenticatedLayout title="Editar Usuario">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Editar Usuario
            </h2>
        </template>

        <template #breadcrumbs>
            <Breadcrumbs :items="breadcrumbItems" />
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <form @submit.prevent="submit">
                        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                            
                            <div>
                                <label for="name" class="block font-medium text-sm text-gray-700">Nombre</label>
                                <input id="name" type="text" v-model="form.name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required autofocus>
                                <div v-if="errors.name" class="text-red-500 text-sm mt-1">{{ errors.name }}</div>
                            </div>
                            
                            <div>
                                <label for="email" class="block font-medium text-sm text-gray-700">Email</label>
                                <input id="email" type="email" v-model="form.email" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                <div v-if="errors.email" class="text-red-500 text-sm mt-1">{{ errors.email }}</div>
                            </div>

                            <div>
                                <label for="password" class="block font-medium text-sm text-gray-700">Contraseña (dejar en blanco para no cambiar)</label>
                                <input id="password" type="password" v-model="form.password" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                <div v-if="errors.password" class="text-red-500 text-sm mt-1">{{ errors.password }}</div>
                            </div>

                            <div>
                                <label for="password_confirmation" class="block font-medium text-sm text-gray-700">Confirmar Contraseña</label>
                                <input id="password_confirmation" type="password" v-model="form.password_confirmation" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            </div>

                            <div>
                                <label for="role" class="block font-medium text-sm text-gray-700">Rol</label>
                                <select id="role" v-model="form.role" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                    <option v-for="role in roles" :key="role" :value="role">{{ role }}</option>
                                </select>
                                <div v-if="errors.role" class="text-red-500 text-sm mt-1">{{ errors.role }}</div>
                            </div>

                        </div>

                        <div class="flex items-center justify-end px-6 py-4 bg-gray-50 text-right">
                            <button type="submit" :disabled="form.processing" class="bg-arg-azul hover:bg-arg-secundario text-white font-bold py-2 px-4 rounded">
                                Actualizar Usuario
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
