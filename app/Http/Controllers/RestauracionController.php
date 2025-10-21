<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class RestauracionController extends Controller
{
    public function showView()
    {
        return Inertia::render('BaseDeDatos/Restauracion');
    }
}
