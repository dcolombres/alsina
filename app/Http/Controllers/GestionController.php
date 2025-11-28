<?php

namespace App\Http\Controllers;

use App\Models\Proyecto;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class GestionController extends Controller
{
    public function index()
    {
        // Gráfico 1: Proyectos por Tier
        $proyectosPorTier = Proyecto::query()
            ->select('tier', DB::raw('count(*) as total'))
            ->groupBy('tier')
            ->pluck('total', 'tier');

        // Gráfico 2: Staff por Rol
        $staffPorRol = Staff::query()
            ->where('activo', true)
            ->select('rol', DB::raw('count(*) as total'))
            ->groupBy('rol')
            ->pluck('total', 'rol');

        // Gráfico 3: Top 10 Staff con más proyectos a cargo
        $proyectosPorResponsable = Proyecto::query()
            ->join('staff', 'proyectos.responsable_id', '=', 'staff.id')
            ->where('staff.activo', true)
            ->select('staff.nombres', 'staff.apellidos', DB::raw('count(proyectos.id) as total'))
            ->groupBy('staff.id', 'staff.nombres', 'staff.apellidos')
            ->orderBy('total', 'desc')
            ->limit(10)
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->nombres . ' ' . $item->apellidos => $item->total];
            });

        return Inertia::render('Gestion/Index', [
            'chartData' => [
                'proyectosPorTier' => [
                    'labels' => $proyectosPorTier->keys(),
                    'data' => $proyectosPorTier->values(),
                ],
                'staffPorRol' => [
                    'labels' => $staffPorRol->keys(),
                    'data' => $staffPorRol->values(),
                ],
                'proyectosPorResponsable' => [
                    'labels' => $proyectosPorResponsable->keys(),
                    'data' => $proyectosPorResponsable->values(),
                ],
            ]
        ]);
    }

    public function getProyectosPorTier(string $tier)
    {
        $proyectos = Proyecto::where('tier', $tier)
            ->select('id', 'nombre', 'estado')
            ->get();
            
        return response()->json($proyectos);
    }

    public function getStaffPorRol(string $rol)
    {
        $staff = Staff::where('rol', $rol)
            ->where('activo', true)
            ->select('id', 'nombres', 'apellidos', 'email')
            ->get();

        return response()->json($staff);
    }
}