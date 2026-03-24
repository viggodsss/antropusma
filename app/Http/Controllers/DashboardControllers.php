<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Queue;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        $totalPatients = Patient::whereDate('created_at', $today)->count();

        $totalQueues = Queue::whereDate('created_at', $today)->count();

        $waiting = Queue::whereDate('created_at', $today)
                        ->where('status', 'waiting')
                        ->count();

        $done = Queue::whereDate('created_at', $today)
                     ->where('status', 'done')
                     ->count();

        return view('dashboard', compact(
            'totalPatients',
            'totalQueues',
            'waiting',
            'done'
        ));
    }
}