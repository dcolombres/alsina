<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Link } from '@inertiajs/vue3';

defineProps({
  totalProyectos: Number,
  totalClientes: Number,
  totalStaff: Number,
  totalBiYAnalitica: Number,
});
</script>

<template>
    <AuthenticatedLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Panel Principal
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                    <!-- Card Proyectos -->
                    <Link :href="route('proyectos.index')" class="block p-6 bg-white rounded-lg border border-gray-200 shadow-md hover:bg-gray-100 transition-colors duration-200">
                        <div class="flex justify-between items-start">
                            <div>
                                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900">Proyectos</h5>
                                <p class="font-normal text-gray-700">Gestionar los proyectos activos y pasados.</p>
                            </div>
                            <span class="bg-blue-100 text-blue-800 text-sm font-semibold ml-3 px-2.5 py-0.5 rounded-full">{{ totalProyectos }}</span>
                        </div>
                    </Link>

                    <!-- Card Staff -->
                    <Link :href="route('staff.index')" class="block p-6 bg-white rounded-lg border border-gray-200 shadow-md hover:bg-gray-100 transition-colors duration-200">
                        <div class="flex justify-between items-start">
                            <div>
                                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900">Staff</h5>
                                <p class="font-normal text-gray-700">Administrar el personal y sus asignaciones.</p>
                            </div>
                            <span class="bg-green-100 text-green-800 text-sm font-semibold ml-3 px-2.5 py-0.5 rounded-full">{{ totalStaff }}</span>
                        </div>
                    </Link>

                    <!-- Card Clientes -->
                    <Link :href="route('clientes.index')" class="block p-6 bg-white rounded-lg border border-gray-200 shadow-md hover:bg-gray-100 transition-colors duration-200">
                        <div class="flex justify-between items-start">
                            <div>
                                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900">Clientes</h5>
                                <p class="font-normal text-gray-700">Consultar y gestionar la información de los clientes.</p>
                            </div>
                            <span class="bg-purple-100 text-purple-800 text-sm font-semibold ml-3 px-2.5 py-0.5 rounded-full">{{ totalClientes }}</span>
                        </div>
                    </Link>

                    <!-- Card BI y Analítica -->
                    <Link :href="route('bi_y_analitica.index')" class="block p-6 bg-white rounded-lg border border-gray-200 shadow-md hover:bg-gray-100 transition-colors duration-200">
                        <div class="flex justify-between items-start">
                            <div>
                                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900">BI y Analítica</h5>
                                <p class="font-normal text-gray-700">Gestionar datos de BI y Analítica.</p>
                            </div>
                            <span class="bg-yellow-100 text-yellow-800 text-sm font-semibold ml-3 px-2.5 py-0.5 rounded-full">{{ totalBiYAnalitica }}</span>
                        </div>
                    </Link>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
