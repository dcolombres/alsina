<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Proyecto;
use App\Models\Cliente;
use App\Models\Staff;
use App\Models\BiYAnalitica;

class DashboardController extends Controller
{
    /**
     * Muestra el dashboard con datos agregados.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        return Inertia::render('Dashboard', [
            'totalProyectos' => Proyecto::count(),
            'totalClientes' => Cliente::count(),
            'totalStaff' => Staff::count(),
            'totalBiYAnalitica' => BiYAnalitica::count(),
        ]);
    }
}