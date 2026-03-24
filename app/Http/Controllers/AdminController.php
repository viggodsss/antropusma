<?php

namespace App\Http\Controllers;

use App\Models\Queue;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class AdminController extends Controller
{
    public function index(): View
    {
        $pendingUsers = User::where('status', 'pending')->whereIn('role', ['patient', 'pasien'])->get();
        $waiting = Queue::where('status','waiting')->get();
        $served = Queue::where('status','served')->latest()->get();

        $userStats = [
            'total_users' => User::count(),
            'total_admins' => User::where('role', 'admin')->count(),
            'total_patients' => User::whereIn('role', ['patient', 'pasien'])->count(),
            'approved_patients' => User::whereIn('role', ['patient', 'pasien'])->where('status', 'approved')->count(),
            'pending_patients' => User::whereIn('role', ['patient', 'pasien'])->where('status', 'pending')->count(),
        ];

        $todayQueueCount = Queue::whereDate('created_at', now()->toDateString())->count();

        $clusterSummary = Queue::select('service_type')
            ->selectRaw('COUNT(*) as total')
            ->whereDate('created_at', now()->toDateString())
            ->groupBy('service_type')
            ->orderByDesc('total')
            ->get();

        $todayComplaints = Queue::whereDate('created_at', now()->toDateString())
            ->whereNotNull('complaint')
            ->where('complaint', '!=', '')
            ->latest()
            ->limit(10)
            ->get(['queue_number', 'patient_name', 'service_type', 'complaint', 'created_at']);

        $patientAccounts = User::whereIn('role', ['patient', 'pasien'])
            ->latest()
            ->get(['id', 'name', 'email', 'status', 'verified_at', 'created_at']);
        
        return view('admin.dashboard', compact(
            'pendingUsers',
            'waiting',
            'served',
            'userStats',
            'todayQueueCount',
            'clusterSummary',
            'todayComplaints',
            'patientAccounts'
        ));
    }

    /**
     * Approve user registration
     */
    public function approveUser(User $user): RedirectResponse
    {
        if ($user->status !== 'pending') {
            return redirect()->back()->with('error', 'User tidak dalam status pending.');
        }

        $user->update([
            'status' => 'approved',
            'verified_at' => now(),
        ]);

        return redirect()->route('admin.dashboard')->with('success', "Akun {$user->name} telah diverifikasi!");
    }

    /**
     * Reject user registration
     */
    public function rejectUser(User $user): RedirectResponse
    {
        if ($user->status !== 'pending') {
            return redirect()->back()->with('error', 'User tidak dalam status pending.');
        }

        $userName = $user->name;
        $user->delete();

        return redirect()->route('admin.dashboard')->with('success', "Akun {$userName} telah ditolak dan dihapus.");
    }

    public function callNext()
    {
        $queue = Queue::where('status','waiting')->first();
        if($queue){
            $queue->update([
                'status' => 'called',
                'called_at' => now()
            ]);
        }
        return redirect()->back();
    }

    public function markServed($id)
    {
        $queue = Queue::findOrFail($id);
        $queue->update(['status'=>'served']);
        return redirect()->back();
    }

    public function waiting()
    {
        $waiting = Queue::where('status','waiting')->get();
        return view('admin.waiting', compact('waiting'));
    }

    public function served()
    {
        $served = Queue::where('status','served')->latest()->get();
        return view('admin.served', compact('served'));
    }

    public function scanTicket(Request $request, Queue $queue): RedirectResponse
    {
        $request->validate([
            'token' => 'required|string',
        ]);

        if ($queue->token_scanned_at || !$queue->token) {
            return redirect()->route('admin.dashboard')->with('error', 'QR sudah digunakan.');
        }

        if ($request->token !== $queue->token) {
            return redirect()->route('admin.dashboard')->with('error', 'Token QR tidak valid.');
        }

        if ($queue->created_at && now()->greaterThan($queue->created_at->copy()->addHours(2))) {
            return redirect()->route('admin.dashboard')->with('error', 'QR sudah kedaluwarsa (lebih dari 2 jam).');
        }

        $queue->update([
            'token_scanned_at' => now(),
            'token' => null,
            'status' => 'called',
            'called_at' => now(),
        ]);

        if ($queue->qr_path) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($queue->qr_path);
            $queue->update(['qr_path' => null]);
        }

        return redirect()->route('admin.dashboard')->with('success', "Scan berhasil untuk antrian {$queue->queue_number}.");
    }
}