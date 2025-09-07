<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Users;
use App\Models\Folio;
use Inertia\Inertia;

class ViajeroController extends Controller
{
    public function create()
    {
        return inertia::render('Viajeros/Create');
    }
}
