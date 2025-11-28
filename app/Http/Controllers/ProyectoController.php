<?php

namespace App\Http\Controllers;

use App\Models\Proyecto;
use App\Models\Cliente;
use App\Models\Staff;
use Illuminate\Http\Request;
use Inertia\Inertia;
use PDF;

class ProyectoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index(Request $request)
    {
        $proyectos = Proyecto::query()
            ->with('responsable')
            ->when($request->input('search'), function ($query, $search) {
                $query->where('nombre', 'like', "%{$search}%")
                      ->orWhere('categoria', 'like', "%{$search}%");
            })
            ->when($request->input('sort'), function ($query, $sort) use ($request) {
                $direction = $request->input('direction', 'asc');
                $query->orderBy($sort, $direction);
            }, function ($query) {
                $query->latest();
            })
            ->paginate(25)
            ->withQueryString();

        return Inertia::render('Proyectos/Index', [
            'proyectos' => $proyectos,
            'filters' => $request->only(['search', 'sort', 'direction']),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Inertia\Response
     */
    public function create()
    {
        return Inertia::render('Proyectos/Create', [
            'clientes' => Cliente::all(['id', 'nombre']),
            'staff' => Staff::where('activo', true)->get(),
            'opciones' => $this->getOpciones(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate($this->getValidationRules());
        Proyecto::create($validated);
        return redirect()->route('proyectos.index')->with('message', 'Proyecto creado correctamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Proyecto  $proyecto
     * @return \Inertia\Response
     */
    public function show(Proyecto $proyecto)
    {
        $proyecto->load(['clientePrincipal', 'responsable', 'clientes', 'staff']);

        return Inertia::render('Proyectos/Show', [
            'proyecto' => $proyecto
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Proyecto  $proyecto
     * @return \Inertia\Response
     */
    public function edit(Proyecto $proyecto)
    {
        return Inertia::render('Proyectos/Edit', [
            'proyecto' => $proyecto,
            'clientes' => Cliente::all(['id', 'nombre']),
            'staff' => Staff::where('activo', true)->get(),
            'opciones' => $this->getOpciones(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Proyecto  $proyecto
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Proyecto $proyecto)
    {
        $validated = $request->validate($this->getValidationRules($proyecto->id));
        $proyecto->update($validated);
        return redirect()->route('proyectos.show', $proyecto->id)->with('message', 'Proyecto actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Proyecto  $proyecto
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Proyecto $proyecto)
    {
        $proyecto->delete();
        return redirect()->route('proyectos.index')->with('message', 'Proyecto eliminado correctamente.');
    }

    public function pdf(Proyecto $proyecto)
    {
        $proyectoData = collect($proyecto->toArray())->filter(function ($value) {
            return !is_null($value) && $value !== '';
        })->all();

        $pdf = PDF::loadView('pdf.proyecto_pdf', ['proyecto' => $proyectoData]);
        return $pdf->stream('ficha-proyecto-' . $proyecto->id . '.pdf');
    }

    private function getOpciones()
    {
        return [
            'origenes' => ['Industria', 'Comercio', 'Pyme', 'Emprendedores', 'Economia del Conocimiento', 'Consumidor', 'Desconcentrado', 'Descentralizado', 'Agricultura', 'Ganaderia', 'Pesca', 'Forestal', 'Externo', 'Interno', 'Otro'],
            'dependencias' => ['Produccion', 'MAGYP', 'Mecon', 'Descentralizado', 'Otro'],
            'tiers' => ['T1', 'T2', 'T3', 'T4', 'T5', 'T6'],
            'estados' => ['Operativo', 'En Desarrollo', 'En Mantenimiento', 'A Relevar', 'En Relevamiento', 'A definir', 'A Transferir', 'Inestable', 'Refactorizar', 'Otro'],
            'categorias' => ['SISTEMA', 'MOBILE', 'PLATAFORMA', 'MACROSISTEMA', 'PORTAL WEB', 'FORMULARIO WEB', 'APLICATIVO', 'TABLERO', 'API', 'Servicio', 'Microservicio'],
            'subcategorias' => ['Web', 'Mobile', 'Servicio', 'Proceso', 'Datos', 'CMS', 'Asesoramiento'],
            'lenguajes' => ['PHP', '.NET', 'C', 'C++', 'JAVA', 'Javascript', 'Python', 'Go', 'Otro'],
            'lenguajes_frontend' => ['React', 'Angular', 'VUE js', 'Otro'],
            'repositorios' => ['git.produccion.gob.ar', 'Otro Gitlab', 'Github', 'BitBucket', 'Subversion', 'Otro'],
            'tecnologias_bd' => ['MySQL', 'SQL Server', 'SQLite', 'Postgre SQL', 'Mogo DB', 'Maria DB', 'Duck DB', 'Otro'],
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @param  int|null  $projectId
     * @return array
     */
    protected function getValidationRules($projectId = null)
    {
        return [
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'cliente_id' => 'nullable|exists:clientes,id',
            'responsable_id' => 'nullable|exists:staff,id',
            'estado' => 'nullable|string|max:255',
            'tier' => 'nullable|string|max:255',
            'dependencia' => 'nullable|string|max:255',
            'origen' => 'nullable|string|max:255',
            'categoria' => 'nullable|string|max:255',
            'subcategoria' => 'nullable|string|max:255',
            'ano' => 'nullable|integer',
            'usuarios_internos' => 'nullable|integer',
            'usuarios_externos' => 'nullable|integer',
            'observacion' => 'nullable|string',
            'urls' => 'nullable|array',
            'ticketera_interna' => 'nullable|string|max:255',
            'ticketera_externa' => 'nullable|string|max:255',
            'changelog' => 'nullable|string',
            'lenguaje_principal_backend' => 'nullable|string|max:255',
            'version_backend' => 'nullable|string|max:255',
            'framework_backend' => 'nullable|string|max:255',
            'otro_lenguaje_backend' => 'nullable|string|max:255',
            'librerias_backend' => 'nullable|string',
            'lenguaje_principal_frontend' => 'nullable|string|max:255',
            'version_frontend' => 'nullable|string|max:255',
            'framework_frontend' => 'nullable|string|max:255',
            'otro_lenguaje_frontend' => 'nullable|string|max:255',
            'librerias_frontend' => 'nullable|string',
            'tecnologia_bd' => 'nullable|string|max:255',
            'version_bd' => 'nullable|string|max:255',
            'bd_2' => 'nullable|string|max:255',
            'tamaño_bd' => 'nullable|string|max:255',
            'servidor_bd' => 'nullable|string|max:255',
            'backup_bd' => 'nullable|boolean',
            'alojamiento_productivo' => 'nullable|string|max:255',
            'alojamiento_hml' => 'nullable|string|max:255',
            'alojamiento_tst' => 'nullable|string|max:255',
            'nube' => 'nullable|string|max:255',
            'vms' => 'nullable|string|max:255',
            'contenedor' => 'nullable|boolean',
            'referente' => 'nullable|string|max:255',
            'notas_infraestructura' => 'nullable|string',
            'instrucciones_deploy' => 'nullable|string',
            'repositorio' => 'nullable|string|max:255',
            'url_repositorio' => 'nullable|string|max:255',
            'instrucciones_stack' => 'nullable|boolean',
        ];
    }
}
