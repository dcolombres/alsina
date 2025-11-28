<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    nombre: '',
    apellido: '',
    email: '',
    celular: '',
    area: '',
    dependencia: '',
});

const submit = () => {
    form.post(route('clientes.store'));
};
</script>

<template>
    <Head title="Añadir Cliente" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Añadir Nuevo Cliente</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <form @submit.prevent="submit">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <InputLabel for="nombre" value="Nombre" />
                                    <TextInput id="nombre" type="text" class="mt-1 block w-full" v-model="form.nombre" required autofocus />
                                    <InputError class="mt-2" :message="form.errors.nombre" />
                                </div>
                                <div>
                                    <InputLabel for="apellido" value="Apellido" />
                                    <TextInput id="apellido" type="text" class="mt-1 block w-full" v-model="form.apellido" required />
                                    <InputError class="mt-2" :message="form.errors.apellido" />
                                </div>
                                <div>
                                    <InputLabel for="email" value="Email" />
                                    <TextInput id="email" type="email" class="mt-1 block w-full" v-model="form.email" />
                                    <InputError class="mt-2" :message="form.errors.email" />
                                </div>
                                <div>
                                    <InputLabel for="celular" value="Celular" />
                                    <TextInput id="celular" type="text" class="mt-1 block w-full" v-model="form.celular" />
                                    <InputError class="mt-2" :message="form.errors.celular" />
                                </div>
                                <div>
                                    <InputLabel for="area" value="Área" />
                                    <TextInput id="area" type="text" class="mt-1 block w-full" v-model="form.area" />
                                    <InputError class="mt-2" :message="form.errors.area" />
                                </div>
                                <div>
                                    <InputLabel for="dependencia" value="Dependencia" />
                                    <TextInput id="dependencia" type="text" class="mt-1 block w-full" v-model="form.dependencia" />
                                    <InputError class="mt-2" :message="form.errors.dependencia" />
                                </div>
                            </div>

                            <div class="flex items-center justify-end mt-6 border-t pt-4">
                                <Link :href="route('clientes.index')" class="text-sm text-gray-600 hover:text-gray-900 mr-4">
                                    Cancelar
                                </Link>
                                <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                    Guardar Cliente
                                </PrimaryButton>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
