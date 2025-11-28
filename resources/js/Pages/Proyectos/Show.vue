<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Breadcrumbs from '@/Components/Breadcrumbs.vue';
import { Link } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

const props = defineProps({
  proyecto: Object,
});

const breadcrumbItems = ref([
  { label: 'Proyectos', url: route('proyectos.index') },
  { label: props.proyecto.nombre, url: null },
]);

const activeTab = ref('general');

const setTab = (tab) => {
  activeTab.value = tab;
};

const getTabClass = (tab) => {
    return activeTab.value === tab
        ? 'border-blue-500 text-blue-600'
        : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300';
};

const formatBoolean = (value) => {
    return value ? 'Sí' : 'No';
};

const formatArray = (value) => {
    if (Array.isArray(value)) {
        return value.join(', ');
    }
    return value || 'N/A';
};

</script>

<template>
    <AuthenticatedLayout title="Detalle del Proyecto">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Ficha del Proyecto
            </h2>
        </template>

        <template #breadcrumbs>
            <Breadcrumbs :items="breadcrumbItems" />
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <!-- Cabecera del Proyecto -->
                    <div class="p-6 border-b border-gray-200">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="text-2xl font-bold text-gray-800">{{ proyecto.nombre }}</h3>
                                <p class="mt-1 text-sm text-gray-600">{{ proyecto.descripcion || 'Sin descripción.' }}</p>
                            </div>
                            <div class="flex space-x-2">
                                <Link :href="route('proyectos.edit', proyecto.id)" class="bg-arg-azul hover:bg-arg-secundario text-white font-bold py-2 px-4 rounded">
                                    Editar Proyecto
                                </Link>
                                <a :href="route('proyectos.pdf', proyecto.id)" target="_blank" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">
                                    Exportar a PDF
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Pestañas de Navegación -->
                    <div class="border-b border-gray-200">
                        <nav class="-mb-px flex space-x-8 px-6" aria-label="Tabs">
                            <button @click="setTab('general')" :class="getTabClass('general')" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">General</button>
                            <button @click="setTab('gestion')" :class="getTabClass('gestion')" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">Gestión</button>
                            <button @click="setTab('tecnologia')" :class="getTabClass('tecnologia')" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">Tecnología</button>
                            <button @click="setTab('basedatos')" :class="getTabClass('basedatos')" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">Base de Datos</button>
                            <button @click="setTab('infraestructura')" :class="getTabClass('infraestructura')" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">Infraestructura</button>
                        </nav>
                    </div>

                    <!-- Contenido de las Pestañas -->
                    <div class="p-6">
                        <div v-if="activeTab === 'general'" class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div><h4 class="font-semibold text-gray-600">Cliente Principal</h4><p>{{ proyecto.cliente_principal?.nombre || 'N/A' }}</p></div>
                            <div><h4 class="font-semibold text-gray-600">Responsable</h4><p>{{ proyecto.responsable?.nombre_apellido || 'N/A' }}</p></div>
                            <div><h4 class="font-semibold text-gray-600">Estado</h4><p>{{ proyecto.estado || 'N/A' }}</p></div>
                            <div><h4 class="font-semibold text-gray-600">Tier</h4><p>{{ proyecto.tier || 'N/A' }}</p></div>
                            <div><h4 class="font-semibold text-gray-600">Dependencia</h4><p>{{ proyecto.dependencia || 'N/A' }}</p></div>
                            <div><h4 class="font-semibold text-gray-600">Origen</h4><p>{{ proyecto.origen || 'N/A' }}</p></div>
                            <div><h4 class="font-semibold text-gray-600">Categoría</h4><p>{{ proyecto.categoria || 'N/A' }}</p></div>
                            <div><h4 class="font-semibold text-gray-600">Subcategoría</h4><p>{{ proyecto.subcategoria || 'N/A' }}</p></div>
                            <div><h4 class="font-semibold text-gray-600">Año de Inicio</h4><p>{{ proyecto.ano || 'N/A' }}</p></div>
                            <div><h4 class="font-semibold text-gray-600">Usuarios Internos</h4><p>{{ proyecto.usuarios_internos || 'N/A' }}</p></div>
                            <div><h4 class="font-semibold text-gray-600">Usuarios Externos</h4><p>{{ proyecto.usuarios_externos || 'N/A' }}</p></div>
                            <div class="md:col-span-3"><h4 class="font-semibold text-gray-600">Observaciones</h4><p>{{ proyecto.observacion || 'N/A' }}</p></div>
                        </div>

                        <div v-if="activeTab === 'gestion'" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div><h4 class="font-semibold text-gray-600">URLs</h4><a v-if="proyecto.urls" :href="proyecto.urls[0]" target="_blank" class="text-blue-600 hover:underline">{{ proyecto.urls[0] }}</a><p v-else>N/A</p></div>
                            <div><h4 class="font-semibold text-gray-600">Ticketera Interna</h4><a v-if="proyecto.ticketera_interna" :href="proyecto.ticketera_interna" target="_blank" class="text-blue-600 hover:underline">{{ proyecto.ticketera_interna }}</a><p v-else>N/A</p></div>
                            <div><h4 class="font-semibold text-gray-600">Ticketera Externa</h4><a v-if="proyecto.ticketera_externa" :href="proyecto.ticketera_externa" target="_blank" class="text-blue-600 hover:underline">{{ proyecto.ticketera_externa }}</a><p v-else>N/A</p></div>
                            <div class="md:col-span-2"><h4 class="font-semibold text-gray-600">Changelog</h4><p class="whitespace-pre-wrap">{{ proyecto.changelog || 'N/A' }}</p></div>
                        </div>

                        <div v-if="activeTab === 'tecnologia'">
                            <h3 class="text-lg font-bold mb-4">Backend</h3>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                                <div><h4 class="font-semibold text-gray-600">Lenguaje Principal</h4><p>{{ proyecto.lenguaje_principal_backend || 'N/A' }}</p></div>
                                <div><h4 class="font-semibold text-gray-600">Versión</h4><p>{{ proyecto.version_backend || 'N/A' }}</p></div>
                                <div><h4 class="font-semibold text-gray-600">Framework</h4><p>{{ proyecto.framework_backend || 'N/A' }}</p></div>
                                <div class="md:col-span-3"><h4 class="font-semibold text-gray-600">Otros Lenguajes</h4><p>{{ proyecto.otro_lenguaje_backend || 'N/A' }}</p></div>
                                <div class="md:col-span-3"><h4 class="font-semibold text-gray-600">Librerías</h4><p>{{ proyecto.librerias_backend || 'N/A' }}</p></div>
                            </div>
                            <h3 class="text-lg font-bold mb-4">Frontend</h3>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div><h4 class="font-semibold text-gray-600">Lenguaje Principal</h4><p>{{ proyecto.lenguaje_principal_frontend || 'N/A' }}</p></div>
                                <div><h4 class="font-semibold text-gray-600">Versión</h4><p>{{ proyecto.version_frontend || 'N/A' }}</p></div>
                                <div><h4 class="font-semibold text-gray-600">Framework</h4><p>{{ proyecto.framework_frontend || 'N/A' }}</p></div>
                                <div class="md:col-span-3"><h4 class="font-semibold text-gray-600">Otros Lenguajes</h4><p>{{ proyecto.otro_lenguaje_frontend || 'N/A' }}</p></div>
                                <div class="md:col-span-3"><h4 class="font-semibold text-gray-600">Librerías</h4><p>{{ proyecto.librerias_frontend || 'N/A' }}</p></div>
                            </div>
                        </div>

                        <div v-if="activeTab === 'basedatos'" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div><h4 class="font-semibold text-gray-600">Tecnología BD</h4><p>{{ proyecto.tecnologia_bd || 'N/A' }}</p></div>
                            <div><h4 class="font-semibold text-gray-600">Versión</h4><p>{{ proyecto.version_bd || 'N/A' }}</p></div>
                            <div><h4 class="font-semibold text-gray-600">BD Secundaria</h4><p>{{ proyecto.bd_2 || 'N/A' }}</p></div>
                            <div><h4 class="font-semibold text-gray-600">Tamaño BD (GB)</h4><p>{{ proyecto.tamaño_bd || 'N/A' }}</p></div>
                            <div><h4 class="font-semibold text-gray-600">Servidor BD</h4><p>{{ proyecto.servidor_bd || 'N/A' }}</p></div>
                            <div><h4 class="font-semibold text-gray-600">Backup</h4><p>{{ formatBoolean(proyecto.backup_bd) }}</p></div>
                        </div>

                        <div v-if="activeTab === 'infraestructura'" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div><h4 class="font-semibold text-gray-600">Alojamiento Producción</h4><p>{{ proyecto.alojamiento_productivo || 'N/A' }}</p></div>
                            <div><h4 class="font-semibold text-gray-600">Alojamiento HML</h4><p>{{ proyecto.alojamiento_hml || 'N/A' }}</p></div>
                            <div><h4 class="font-semibold text-gray-600">Alojamiento TST</h4><p>{{ proyecto.alojamiento_tst || 'N/A' }}</p></div>
                            <div><h4 class="font-semibold text-gray-600">Nube</h4><p>{{ proyecto.nube || 'N/A' }}</p></div>
                            <div><h4 class="font-semibold text-gray-600">VMs</h4><p>{{ proyecto.vms || 'N/A' }}</p></div>
                            <div><h4 class="font-semibold text-gray-600">Usa Contenedor</h4><p>{{ formatBoolean(proyecto.contenedor) }}</p></div>
                            <div><h4 class="font-semibold text-gray-600">Referente de Infra.</h4><p>{{ proyecto.referente || 'N/A' }}</p></div>
                            <div class="md:col-span-2"><h4 class="font-semibold text-gray-600">Notas de Infraestructura</h4><p class="whitespace-pre-wrap">{{ proyecto.notas_infraestructura || 'N/A' }}</p></div>
                            <div class="md:col-span-2"><h4 class="font-semibold text-gray-600">Instrucciones de Deploy</h4><p class="whitespace-pre-wrap">{{ proyecto.instrucciones_deploy || 'N/A' }}</p></div>
                            <div><h4 class="font-semibold text-gray-600">Repositorio</h4><p>{{ proyecto.repositorio || 'N/A' }}</p></div>
                            <div><h4 class="font-semibold text-gray-600">URL Repositorio</h4><a v-if="proyecto.url_repositorio" :href="proyecto.url_repositorio" target="_blank" class="text-blue-600 hover:underline">{{ proyecto.url_repositorio }}</a><p v-else>N/A</p></div>
                            <div><h4 class="font-semibold text-gray-600">Instrucciones Stack</h4><p>{{ formatBoolean(proyecto.instrucciones_stack) }}</p></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>