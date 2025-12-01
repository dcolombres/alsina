<?php

namespace App\Http\Controllers;

use App\Models\BiYAnalitica;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BiYAnaliticaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index(Request $request)
    {
        $bi_y_analitica = BiYAnalitica::query()
            ->with('updatedByUser')
            ->when($request->input('search'), function ($query, $search) {
                $query->where('nombre', 'like', "%{$search}%");
            })
            ->when($request->input('sort'), function ($query, $sort) use ($request) {
                $direction = $request->input('direction', 'asc');
                $query->orderBy($sort, $direction);
            }, function ($query) {
                $query->latest();
            })
            ->paginate(25)
            ->withQueryString();

        return Inertia::render('BiYAnalitica/Index', [
            'bi_y_analitica' => $bi_y_analitica,
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
        return Inertia::render('BiYAnalitica/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
        ]);

        BiYAnalitica::create($validated);

        return redirect()->route('bi_y_analitica.index')->with('message', 'Entrada de BI y Analítica creada correctamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BiYAnalitica  $biYAnalitica
     * @return \Inertia\Response
     */
    public function show(BiYAnalitica $biYAnalitica)
    {
        return Inertia::render('BiYAnalitica/Show', [
            'bi_y_analitica' => $biYAnalitica,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BiYAnalitica  $biYAnalitica
     * @return \Inertia\Response
     */
    public function edit(BiYAnalitica $biYAnalitica)
    {
        return Inertia::render('BiYAnalitica/Edit', [
            'bi_y_analitica' => $biYAnalitica,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BiYAnalitica  $biYAnalitica
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, BiYAnalitica $biYAnalitica)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
        ]);

        $biYAnalitica->update($validated);

        return redirect()->route('bi_y_analitica.show', $biYAnalitica->id)->with('message', 'Entrada de BI y Analítica actualizada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BiYAnalitica  $biYAnalitica
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(BiYAnalitica $biYAnalitica)
    {
        $biYAnalitica->delete();

        return redirect()->route('bi_y_analitica.index')->with('message', 'Entrada de BI y Analítica eliminada correctamente.');
    }
}
