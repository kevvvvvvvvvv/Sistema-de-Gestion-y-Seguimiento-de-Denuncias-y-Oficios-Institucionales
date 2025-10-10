<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class GeneracionOficioController extends Controller
{
    public function showEditor()
    {
        return Inertia::render('Modulos/GeneracionOficio/Editor');
    }
}
