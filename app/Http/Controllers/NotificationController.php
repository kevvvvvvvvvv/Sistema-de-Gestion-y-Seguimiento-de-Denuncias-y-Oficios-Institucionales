<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index(){
        return response()->json(Auth::user()->notifications()->latest()->limit(20)->get());
    }
}
