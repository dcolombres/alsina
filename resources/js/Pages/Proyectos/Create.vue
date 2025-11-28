<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { useForm } from '@inertiajs/vue3';
import { defineProps, ref, computed, watch } from 'vue';

const props = defineProps({
  clientes: Array,
  staff: Array,
  opciones: Object,
});

const form = useForm({
    nombre: '',
    descripcion: '',
    cliente_id: null,
    responsable_id: null,
    estado: 'En Desarrollo',
    tier: 'T3',
    dependencia: null,
    origen: null,
    categoria: null,
    subcategoria: null,
    // New technical fields
    lenguaje_principal_backend: null,
    version_backend: '',
    framework_backend: '',
    otro_lenguaje_backend: '',
    librerias_backend: '',
    lenguaje_principal_frontend: null,
    version_frontend: '',
    framework_frontend: '',
    otro_lenguaje_frontend: '',
    librerias_frontend: '',
    tecnologia_bd: null,
    version_bd: '',
    bd_2: '',
    tamaño_bd: '',
    servidor_bd: '',
    backup_bd: false,
    alojamiento_productivo: '',
    alojamiento_hml: '',
    alojamiento_tst: '',
    nube: '',
    vms: '',
    contenedor: false,
    referente: '',
    notas_infraestructura: '',
    instrucciones_deploy: '',
    repositorio: '',
    url_repositorio: '',
    instrucciones_stack: false,
});

const submit = () => {
  form.post(route('proyectos.store'));
};

const activeTab = ref('general');
const setTab = (tab) => activeTab.value = tab;
const getTabClass = (tab) => activeTab.value === tab ? 'border-arg-azul text-arg-azul' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300';

// Lógica del Autocomplete para Responsable
const responsableSearch = ref('');
const showResponsableOptions = ref(false);

const filteredStaff = computed(() => {
    if (responsableSearch.value.length < 1) {
        return [];
    }
    return props.staff.filter(s => 
        s.nombre_apellido.toLowerCase().includes(responsableSearch.value.toLowerCase())
    );
});

function selectResponsable(staffMember) {
    form.responsable_id = staffMember.id;
    responsableSearch.value = staffMember.nombre_apellido;
    showResponsableOptions.value = false;
}

const handleResponsableBlur = () => {
    setTimeout(() => {
        showResponsableOptions.value = false;
    }, 200);
};

watch(responsableSearch, () => {
    showResponsableOptions.value = true;
});
</script>

<template>
    <AuthenticatedLayout title="Crear Proyecto">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Crear Nuevo Proyecto
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <form @submit.prevent="submit" class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="border-b border-gray-200">
                        <nav class="-mb-px flex space-x-8 px-6" aria-label="Tabs">
                            <button type="button" @click="setTab('general')" :class="getTabClass('general')" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">General</button>
                            <button type="button" @click="setTab('tecnico')" :class="getTabClass('tecnico')" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">Técnico</button>
                        </nav>
                    </div>

                    <div class="p-6">
                        <!-- Pestaña General -->
                        <div v-show="activeTab === 'general'" class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div class="md:col-span-2"><label class="block font-medium text-sm text-gray-700">Nombre</label><input type="text" v-model="form.nombre" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"></div>
                            <div><label class="block font-medium text-sm text-gray-700">Estado</label><select v-model="form.estado" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"><option v-for="opt in opciones.estados" :key="opt" :value="opt">{{ opt }}</option></select></div>
                            <div><label class="block font-medium text-sm text-gray-700">Cliente</label><select v-model="form.cliente_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"><option :value="null">-- Sin cliente --</option><option v-for="c in clientes" :key="c.id" :value="c.id">{{c.nombre}}</option></select></div>
                            
                            <div class="relative">
                                <label class="block font-medium text-sm text-gray-700">Responsable</label>
                                <input 
                                    type="text" 
                                    v-model="responsableSearch" 
                                    @blur="handleResponsableBlur" 
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" 
                                    placeholder="Buscar personal..."
                                >
                                <ul v-if="showResponsableOptions && filteredStaff.length > 0" class="absolute z-10 w-full bg-white border border-gray-300 rounded-md mt-1 max-h-60 overflow-y-auto shadow-lg">
                                    <li v-for="s in filteredStaff" :key="s.id" @click="selectResponsable(s)" class="px-4 py-2 cursor-pointer hover:bg-gray-100">{{ s.nombre_apellido }}</li>
                                </ul>
                            </div>

                            <div><label class="block font-medium text-sm text-gray-700">Tier</label><select v-model="form.tier" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"><option v-for="opt in opciones.tiers" :key="opt" :value="opt">{{ opt }}</option></select></div>
                            <div><label class="block font-medium text-sm text-gray-700">Dependencia</label><select v-model="form.dependencia" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"><option v-for="opt in opciones.dependencias" :key="opt" :value="opt">{{ opt }}</option></select></div>
                            <div><label class="block font-medium text-sm text-gray-700">Origen</label><select v-model="form.origen" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"><option v-for="opt in opciones.origenes" :key="opt" :value="opt">{{ opt }}</option></select></div>
                            <div><label class="block font-medium text-sm text-gray-700">Categoría</label><select v-model="form.categoria" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"><option v-for="opt in opciones.categorias" :key="opt" :value="opt">{{ opt }}</option></select></div>
                            <div><label class="block font-medium text-sm text-gray-700">Subcategoría</label><select v-model="form.subcategoria" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"><option v-for="opt in opciones.subcategorias" :key="opt" :value="opt">{{ opt }}</option></select></div>
                            <div class="md:col-span-3"><label class="block font-medium text-sm text-gray-700">Descripción</label><textarea v-model="form.descripcion" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"></textarea></div>
                        </div>
                        <!-- Pestaña Técnico -->
                        <div v-show="activeTab === 'tecnico'" class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <h3 class="text-lg font-semibold md:col-span-3">Backend</h3>
                            <div><label class="block font-medium text-sm text-gray-700">Lenguaje Principal</label><select v-model="form.lenguaje_principal_backend" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"><option v-for="opt in opciones.lenguajes" :key="opt" :value="opt">{{ opt }}</option></select></div>
                            <div><label class="block font-medium text-sm text-gray-700">Versión</label><input type="text" v-model="form.version_backend" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"></div>
                            <div><label class="block font-medium text-sm text-gray-700">Framework</label><input type="text" v-model="form.framework_backend" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"></div>
                            <div><label class="block font-medium text-sm text-gray-700">Otro Lenguaje</label><input type="text" v-model="form.otro_lenguaje_backend" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"></div>
                            <div class="md:col-span-2"><label class="block font-medium text-sm text-gray-700">Librerías</label><input type="text" v-model="form.librerias_backend" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"></div>

                            <h3 class="text-lg font-semibold md:col-span-3 mt-6">Frontend</h3>
                            <div><label class="block font-medium text-sm text-gray-700">Lenguaje Principal</label><select v-model="form.lenguaje_principal_frontend" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"><option v-for="opt in opciones.lenguajes_frontend" :key="opt" :value="opt">{{ opt }}</option></select></div>
                            <div><label class="block font-medium text-sm text-gray-700">Versión</label><input type="text" v-model="form.version_frontend" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"></div>
                            <div><label class="block font-medium text-sm text-gray-700">Framework</label><input type="text" v-model="form.framework_frontend" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"></div>
                            <div><label class="block font-medium text-sm text-gray-700">Otro Lenguaje</label><input type="text" v-model="form.otro_lenguaje_frontend" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"></div>
                            <div class="md:col-span-2"><label class="block font-medium text-sm text-gray-700">Librerías</label><input type="text" v-model="form.librerias_frontend" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"></div>

                            <h3 class="text-lg font-semibold md:col-span-3 mt-6">Base de Datos</h3>
                            <div><label class="block font-medium text-sm text-gray-700">Tecnología</label><select v-model="form.tecnologia_bd" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"><option v-for="opt in opciones.tecnologias_bd" :key="opt" :value="opt">{{ opt }}</option></select></div>
                            <div><label class="block font-medium text-sm text-gray-700">Versión</label><input type="text" v-model="form.version_bd" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"></div>
                            <div><label class="block font-medium text-sm text-gray-700">BD 2</label><input type="text" v-model="form.bd_2" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"></div>
                            <div><label class="block font-medium text-sm text-gray-700">Tamaño</label><input type="text" v-model="form.tamaño_bd" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"></div>
                            <div><label class="block font-medium text-sm text-gray-700">Servidor</label><input type="text" v-model="form.servidor_bd" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"></div>
                            <div class="flex items-center"><input type="checkbox" v-model="form.backup_bd" class="rounded border-gray-300 text-arg-azul shadow-sm focus:border-arg-azul focus:ring focus:ring-arg-azul focus:ring-opacity-50"><span class="ml-2 text-sm text-gray-600">Backup</span></div>

                            <h3 class="text-lg font-semibold md:col-span-3 mt-6">Infraestructura</h3>
                            <div><label class="block font-medium text-sm text-gray-700">Alojamiento Productivo</label><input type="text" v-model="form.alojamiento_productivo" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"></div>
                            <div><label class="block font-medium text-sm text-gray-700">Alojamiento HML</label><input type="text" v-model="form.alojamiento_hml" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"></div>
                            <div><label class="block font-medium text-sm text-gray-700">Alojamiento TST</label><input type="text" v-model="form.alojamiento_tst" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"></div>
                            <div><label class="block font-medium text-sm text-gray-700">Nube</label><input type="text" v-model="form.nube" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"></div>
                            <div><label class="block font-medium text-sm text-gray-700">VMs</label><input type="text" v-model="form.vms" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"></div>
                            <div class="flex items-center"><input type="checkbox" v-model="form.contenedor" class="rounded border-gray-300 text-arg-azul shadow-sm focus:border-arg-azul focus:ring focus:ring-arg-azul focus:ring-opacity-50"><span class="ml-2 text-sm text-gray-600">Contenedor</span></div>
                            <div><label class="block font-medium text-sm text-gray-700">Referente</label><input type="text" v-model="form.referente" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"></div>
                            <div class="md:col-span-2"><label class="block font-medium text-sm text-gray-700">Notas Infraestructura</label><textarea v-model="form.notas_infraestructura" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"></textarea></div>
                            <div class="md:col-span-3"><label class="block font-medium text-sm text-gray-700">Instrucciones Deploy</label><textarea v-model="form.instrucciones_deploy" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"></textarea></div>
                            <div><label class="block font-medium text-sm text-gray-700">Repositorio</label><select v-model="form.repositorio" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"><option v-for="opt in opciones.repositorios" :key="opt" :value="opt">{{ opt }}</option></select></div>
                            <div><label class="block font-medium text-sm text-gray-700">URL Repositorio</label><input type="text" v-model="form.url_repositorio" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"></div>
                            <div class="flex items-center"><input type="checkbox" v-model="form.instrucciones_stack" class="rounded border-gray-300 text-arg-azul shadow-sm focus:border-arg-azul focus:ring focus:ring-arg-azul focus:ring-opacity-50"><span class="ml-2 text-sm text-gray-600">Instrucciones Stack</span></div>
                        </div>
                    </div>

                    <div class="flex items-center justify-end px-6 py-4 bg-gray-50 text-right">
                        <button type="submit" :disabled="form.processing" class="bg-arg-azul hover:bg-arg-secundario text-white font-bold py-2 px-4 rounded">
                            Crear Proyecto
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>