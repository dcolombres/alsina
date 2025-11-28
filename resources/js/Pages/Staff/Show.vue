<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Breadcrumbs from '@/Components/Breadcrumbs.vue';
import { Link } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
  miembro: Object,
});

const breadcrumbItems = ref([
  { label: 'Personal', url: route('staff.index') },
  { label: props.miembro.nombre_apellido, url: null },
]);

const formatBoolean = (value) => value ? 'Sí' : 'No';

</script>

<template>
    <AuthenticatedLayout title="Detalle del Personal">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Ficha de Personal
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
                                <h3 class="text-2xl font-bold text-gray-800">{{ miembro.nombre_apellido }}</h3>
                                <p class="mt-1 text-sm text-gray-600">{{ miembro.rol }} - {{ miembro.seniority }}</p>
                            </div>
                            <div class="flex space-x-2">
                                <Link :href="route('staff.edit', miembro.id)" class="bg-arg-azul hover:bg-arg-secundario text-white font-bold py-2 px-4 rounded">
                                    Editar
                                </Link>
                                <a :href="route('staff.pdf', miembro.id)" target="_blank" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">
                                    Exportar a PDF
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div><h4 class="font-semibold text-gray-600">Email</h4><p>{{ miembro.email }}</p></div>
                        <div><h4 class="font-semibold text-gray-600">Celular</h4><p>{{ miembro.celular || 'N/A' }}</p></div>
                        <div><h4 class="font-semibold text-gray-600">Rol</h4><p>{{ miembro.rol || 'N/A' }}</p></div>
                        <div><h4 class="font-semibold text-gray-600">Tipo</h4><p>{{ miembro.tipo || 'N/A' }}</p></div>
                        <div><h4 class="font-semibold text-gray-600">Seniority</h4><p>{{ miembro.seniority || 'N/A' }}</p></div>
                        <div><h4 class="font-semibold text-gray-600">Tecnología Principal</h4><p>{{ miembro.tecnologia || 'N/A' }}</p></div>
                        <div><h4 class="font-semibold text-gray-600">Contrato</h4><p>{{ miembro.contrato || 'N/A' }}</p></div>
                        <div><h4 class="font-semibold text-gray-600">Remuneración (Categoría)</h4><p>{{ miembro.remuneracion || 'N/A' }}</p></div>
                        <div><h4 class="font-semibold text-gray-600">Modalidad</h4><p>{{ miembro.modalidad || 'N/A' }}</p></div>
                        <div><h4 class="font-semibold text-gray-600">Días Presencial</h4><p>{{ miembro.dias_presencial }}</p></div>
                        <div><h4 class="font-semibold text-gray-600">Días Remoto</h4><p>{{ miembro.dias_remoto }}</p></div>
                        <div><h4 class="font-semibold text-gray-600">UR</h4><p>{{ formatBoolean(miembro.ur) }}</p></div>
                        <div><h4 class="font-semibold text-gray-600">Horas Extras</h4><p>{{ formatBoolean(miembro.extras) }}</p></div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>