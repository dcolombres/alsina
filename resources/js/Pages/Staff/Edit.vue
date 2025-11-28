<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Breadcrumbs from '@/Components/Breadcrumbs.vue';
import { useForm, router } from '@inertiajs/vue3';
import { defineProps, ref } from 'vue';

const props = defineProps({
  miembro: Object,
  opciones: Object,
});

const breadcrumbItems = ref([
  { label: 'Personal', url: route('staff.index') },
  { label: props.miembro.nombre_apellido, url: route('staff.show', props.miembro.id) },
  { label: 'Editar', url: null },
]);

const form = useForm({
    nombres: props.miembro.nombres,
    apellidos: props.miembro.apellidos,
    email: props.miembro.email,
    celular: props.miembro.celular,
    rol: props.miembro.rol,
    tipo: props.miembro.tipo,
    seniority: props.miembro.seniority,
    tecnologia: props.miembro.tecnologia,
    contrato: props.miembro.contrato,
    remuneracion: props.miembro.remuneracion,
    ur: props.miembro.ur,
    extras: props.miembro.extras,
    modalidad: props.miembro.modalidad,
    dias_presencial: props.miembro.dias_presencial,
    dias_remoto: props.miembro.dias_remoto,
    activo: props.miembro.activo,
});

const submit = () => {
  form.put(route('staff.update', props.miembro.id));
};

const destroy = () => {
    if (confirm('¿Estás seguro de que deseas eliminar a este miembro del personal?')) {
        router.delete(route('staff.destroy', props.miembro.id));
    }
};
</script>

<template>
    <AuthenticatedLayout title="Editar Personal">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Editando a: {{ miembro.nombre_apellido }}
            </h2>
        </template>

        <template #breadcrumbs>
            <Breadcrumbs :items="breadcrumbItems" />
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <form @submit.prevent="submit" class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Nombres -->
                        <div><label class="block font-medium text-sm text-gray-700">Nombres</label><input type="text" v-model="form.nombres" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"></div>
                        <!-- Apellidos -->
                        <div><label class="block font-medium text-sm text-gray-700">Apellidos</label><input type="text" v-model="form.apellidos" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"></div>
                        <!-- Email -->
                        <div><label class="block font-medium text-sm text-gray-700">Email</label><input type="email" v-model="form.email" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"></div>
                        <!-- Celular -->
                        <div><label class="block font-medium text-sm text-gray-700">Celular</label><input type="text" v-model="form.celular" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"></div>
                        
                        <!-- Rol -->
                        <div><label class="block font-medium text-sm text-gray-700">Rol</label><select v-model="form.rol" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"><option v-for="opt in opciones.roles" :key="opt" :value="opt">{{ opt }}</option></select></div>
                        <!-- Tipo -->
                        <div><label class="block font-medium text-sm text-gray-700">Tipo</label><select v-model="form.tipo" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"><option v-for="opt in opciones.tipos" :key="opt" :value="opt">{{ opt }}</option></select></div>
                        <!-- Seniority -->
                        <div><label class="block font-medium text-sm text-gray-700">Seniority</label><select v-model="form.seniority" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"><option v-for="opt in opciones.seniorities" :key="opt" :value="opt">{{ opt }}</option></select></div>
                        <!-- Tecnologia -->
                        <div><label class="block font-medium text-sm text-gray-700">Tecnología Principal</label><input type="text" v-model="form.tecnologia" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"></div>
                        <!-- Contrato -->
                        <div><label class="block font-medium text-sm text-gray-700">Contrato</label><select v-model="form.contrato" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"><option v-for="opt in opciones.contratos" :key="opt" :value="opt">{{ opt }}</option></select></div>
                        <!-- Remuneracion -->
                        <div><label class="block font-medium text-sm text-gray-700">Remuneración (Categoría)</label><select v-model="form.remuneracion" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"><option v-for="opt in opciones.remuneraciones" :key="opt" :value="opt">{{ opt }}</option></select></div>
                        <!-- Modalidad -->
                        <div><label class="block font-medium text-sm text-gray-700">Modalidad</label><select v-model="form.modalidad" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"><option v-for="opt in opciones.modalidades" :key="opt" :value="opt">{{ opt }}</option></select></div>
                        <!-- Dias Presencial -->
                        <div><label class="block font-medium text-sm text-gray-700">Días Presencial</label><input type="number" v-model="form.dias_presencial" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"></div>
                        <!-- Dias Remoto -->
                        <div><label class="block font-medium text-sm text-gray-700">Días Remoto</label><input type="number" v-model="form.dias_remoto" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"></div>
                        <!-- UR -->
                        <div class="flex items-center"><input type="checkbox" v-model="form.ur" class="rounded mr-2 border-gray-300 shadow-sm"><label>UR</label></div>
                        <!-- Extras -->
                        <div class="flex items-center"><input type="checkbox" v-model="form.extras" class="rounded mr-2 border-gray-300 shadow-sm"><label>Horas Extras</label></div>
                        <!-- Activo -->
                        <div class="flex items-center"><input type="checkbox" v-model="form.activo" class="rounded mr-2 border-gray-300 shadow-sm"><label>Activo</label></div>
                    </div>
                    <div class="flex items-center justify-between px-6 py-4 bg-gray-50 text-right">
                        <button type="button" @click="destroy" class="text-red-600 hover:underline">
                            Eliminar Personal
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