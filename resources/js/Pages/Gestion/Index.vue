<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { onMounted, ref } from 'vue';
import { Chart, registerables } from 'chart.js';

Chart.register(...registerables);

const props = defineProps({
  chartData: Object,
});

// State for drill-down details
const detailsTitle = ref('');
const detailsData = ref([]);
const detailsHeaders = ref([]);
const isLoading = ref(false);

const fetchData = async (type, label) => {
    if (!label) return;
    isLoading.value = true;
    detailsData.value = [];
    let url = '';
    if (type === 'tier') {
        detailsTitle.value = `Proyectos con Tier: ${label}`;
        detailsHeaders.value = ['ID', 'Nombre', 'Estado'];
        url = route('api.gestion.proyectos-por-tier', { tier: label });
    } else if (type === 'rol') {
        detailsTitle.value = `Personal con Rol: ${label}`;
        detailsHeaders.value = ['ID', 'Nombres', 'Apellidos', 'Email'];
        url = route('api.gestion.staff-por-rol', { rol: label });
    }

    if (url) {
        try {
            const response = await fetch(url);
            if (!response.ok) {
                throw new Error(`Network response was not ok: ${response.statusText}`);
            }
            const data = await response.json();
            detailsData.value = data;
        } catch (error) {
            console.error('Error fetching details:', error);
        } finally {
            isLoading.value = false;
        }
    } else {
        isLoading.value = false;
    }
};

const createChartOnClickHandler = (type) => (event) => {
    const chart = event.chart;
    const points = chart.getElementsAtEventForMode(event, 'nearest', { intersect: true }, true);
    if (points.length) {
        const firstPoint = points[0];
        const label = chart.data.labels[firstPoint.index];
        fetchData(type, label);
    }
};

onMounted(() => {
  // Chart 1: Proyectos por Tier
  new Chart(document.getElementById('proyectosPorTierChart'), {
    type: 'doughnut',
    data: {
      labels: props.chartData.proyectosPorTier.labels,
      datasets: [{ data: props.chartData.proyectosPorTier.data, backgroundColor: ['#232D4F', '#3E5A7E', '#5A7290', '#E7BA61', '#2E7D33', '#C62828'] }]
    },
    options: {
        responsive: true,
        plugins: { legend: { position: 'top' }, title: { display: true, text: 'Proyectos por Tier' } },
        onClick: createChartOnClickHandler('tier'),
    }
  });

  // Chart 2: Staff por Rol
  new Chart(document.getElementById('staffPorRolChart'), {
    type: 'pie',
    data: {
      labels: props.chartData.staffPorRol.labels,
      datasets: [{ data: props.chartData.staffPorRol.data, backgroundColor: ['#2E7D33', '#C62828', '#5A7290', '#E7BA61', '#3E5A7E', '#232D4F'] }]
    },
    options: {
        responsive: true,
        plugins: { legend: { position: 'top' }, title: { display: true, text: 'Miembros de Staff por Rol' } },
        onClick: createChartOnClickHandler('rol'),
    }
  });

  // Chart 3: Proyectos por Responsable
  new Chart(document.getElementById('proyectosPorResponsableChart'), {
    type: 'bar',
    data: {
      labels: props.chartData.proyectosPorResponsable.labels,
      datasets: [{ label: 'Nº de Proyectos a Cargo', data: props.chartData.proyectosPorResponsable.data, backgroundColor: '#232D4F' }]
    },
    options: {
        indexAxis: 'y',
        responsive: true,
        plugins: { legend: { display: false }, title: { display: true, text: 'Top 10 Staff con Más Proyectos a Cargo' } },
        scales: { x: { beginAtZero: true } }
    }
  });
});
</script>

<template>
    <AuthenticatedLayout title="Gestión y Estadísticas">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Gestión y Estadísticas
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6"><canvas id="proyectosPorTierChart"></canvas></div>
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6"><canvas id="staffPorRolChart"></canvas></div>
                    <div class="lg:col-span-2 bg-white overflow-hidden shadow-xl sm:rounded-lg p-6"><canvas id="proyectosPorResponsableChart"></canvas></div>
                </div>

                <!-- Details Section -->
                <div v-if="isLoading || detailsData.length > 0" class="mt-8 bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex justify-between items-center">
                            <h3 class="text-xl font-bold">{{ detailsTitle }}</h3>
                            <button @click="detailsData = []" class="text-gray-500 hover:text-gray-800">&times; Cerrar</button>
                        </div>
                        <div v-if="isLoading" class="mt-4 text-center">Cargando...</div>
                        <div v-else class="mt-4 overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th v-for="header in detailsHeaders" :key="header" scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ header }}</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr v-for="item in detailsData" :key="item.id">
                                        <td v-for="(value, key) in item" :key="key" class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">{{ value }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
