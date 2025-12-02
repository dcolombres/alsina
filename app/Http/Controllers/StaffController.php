<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use Illuminate\Http\Request;
use Inertia\Inertia;
use PDF;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index(Request $request)
    {
        $staff = Staff::query()
            ->where('activo', true)
            ->when($request->input('search'), function ($query, $search) {
                $query->where('nombres', 'like', "%{$search}%")
                      ->orWhere('apellidos', 'like', "%{$search}%")
                      ->orWhere('rol', 'like', "%{$search}%")
                      ->orWhere('tecnologia', 'like', "%{$search}%");
            })
            ->when($request->input('sort'), function ($query, $sort) use ($request) {
                $direction = $request->input('direction', 'asc');
                $query->orderBy($sort, $direction);
            }, function ($query) {
                $query->latest();
            })
            ->paginate(25)
            ->withQueryString();

        return Inertia::render('Staff/Index', [
            'staff' => $staff,
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
        return Inertia::render('Staff/Create', [
            'opciones' => $this->getOpciones()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate($this->getValidationRules());
        Staff::create($validated);
        return redirect()->route('staff.index')->with('message', 'Miembro del personal creado correctamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Staff  $staff
     * @return \Inertia\Response
     */
    public function show(Staff $staff)
    {
        $staff->load('proyectos', 'updater');

        return Inertia::render('Staff/Show', [
            'miembro' => $staff,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Staff  $staff
     * @return \Inertia\Response
     */
    public function edit(Staff $staff)
    {
        return Inertia::render('Staff/Edit', [
            'miembro' => $staff,
            'opciones' => $this->getOpciones()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Staff  $staff
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Staff $staff)
    {
        $validated = $request->validate($this->getValidationRules($staff->id));
        $staff->update($validated);
        return redirect()->route('staff.show', $staff->id)->with('message', 'Datos del personal actualizados correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Staff  $staff
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Staff $staff)
    {
        $staff->delete();
        return redirect()->route('staff.index')->with('message', 'Miembro del personal eliminado correctamente.');
    }

    public function pdf(Staff $staff)
    {
        $staffData = collect($staff->toArray())->filter(function ($value) {
            return !is_null($value) && $value !== '';
        })->all();

        $pdf = PDF::loadView('pdf.staff_pdf', ['staff' => $staffData]);
        return $pdf->stream('ficha-staff-' . $staff->id . '.pdf');
    }

    private function getOpciones()
    {
        return [
            'roles' => ['Desarrollador', 'Analista', 'Coordinador', 'Director', 'Project Manager', 'Lider de equipo'],
            'tipos' => ['Backend', 'Frontend', 'Fullstack', 'Mobile', 'QA', 'Sistemas', 'Negocio'],
            'seniorities' => ['Sr', 'SemiSr', 'Jr', 'SemiJr'],
            'contratos' => ['CTO 1109', 'Ley Marco', 'Designacion', 'Planta Permanente', 'FI', 'otra'],
            'remuneraciones' => ['A', 'B', 'C', 'D', 'E', 'F'],
            'modalidades' => ['Remoto', 'Hibrido', 'Full time'],
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @param  int|null  $staffId
     * @return array
     */
    protected function getValidationRules($staffId = null)
    {
        return [
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:staff,email,' . $staffId,
            'celular' => 'nullable|string|max:255',
            'rol' => 'nullable|string|max:255',
            'tipo' => 'nullable|string|max:255',
            'seniority' => 'nullable|string|max:255',
            'tecnologia' => 'nullable|string|max:255',
            'contrato' => 'nullable|string|max:255',
            'remuneracion' => 'nullable|string|max:255',
            'ur' => 'nullable|boolean',
            'extras' => 'nullable|boolean',
            'activo' => 'required|boolean',
            'modalidad' => 'nullable|string|max:255',
            'dias_presencial' => 'nullable|integer|min:0|max:5',
            'dias_remoto' => 'nullable|integer|min:0|max:5',
        ];
    }
}