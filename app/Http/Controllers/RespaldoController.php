<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class RespaldoController extends Controller
{
    public function showView()
    {
        return Inertia::render('BaseDeDatos/Respaldo');
    }
}
