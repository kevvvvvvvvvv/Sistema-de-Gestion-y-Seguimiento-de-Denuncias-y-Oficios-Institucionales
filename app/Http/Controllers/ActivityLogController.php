<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Inertia\Inertia;
use Spatie\Activitylog\Models\Activity;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $query = Activity::query()
            ->with([
                'causer', 
                'subject' => function ($query) {
                    $query->withTrashed();
                }
            ])
            ->latest(); 

        $query->when($request->user_id, function ($q, $user_id) {
            $q->where('causer_id', $user_id);
        });

        $query->when($request->log_name, function ($q, $log_name) {
            $q->where('log_name', $log_name);
        });

        $logs = $query->paginate(50)->withQueryString();

        $users = \App\Models\User::orderBy('nombre')->get();

        return Inertia::render('Historial/Index', [
            'logs' => $logs,
            'users' => $users, 
            'filters' => $request->only(['user_id', 'log_name']), 
        ]);
    }
}
