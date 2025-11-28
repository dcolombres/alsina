<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Breadcrumbs from '@/Components/Breadcrumbs.vue';
import { Link } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
  bi_y_analitica: Object,
});

const breadcrumbItems = ref([
  { label: 'BI y Analítica', url: route('bi_y_analitica.index') },
  { label: props.bi_y_analitica.nombre, url: null },
]);

</script>

<template>
    <AuthenticatedLayout title="Detalle de BI y Analítica">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Ficha de BI y Analítica
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
                                <h3 class="text-2xl font-bold text-gray-800">{{ bi_y_analitica.nombre }}</h3>
                                <p class="mt-1 text-sm text-gray-600">{{ bi_y_analitica.descripcion || 'Sin descripción.' }}</p>
                            </div>
                            <Link :href="route('bi_y_analitica.edit', bi_y_analitica.id)" class="ml-4 flex-shrink-0 bg-arg-azul hover:bg-arg-secundario text-white font-bold py-2 px-4 rounded">
                                Editar
                            </Link>
                        </div>
                    </div>

                    <div class="p-6">
                        <!-- Details for BiYAnalitica -->
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
