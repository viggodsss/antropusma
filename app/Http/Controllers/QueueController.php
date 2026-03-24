<?php

namespace App\Http\Controllers;

use App\Models\Queue;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class QueueController extends Controller
{
    // Tampilkan antrian untuk publik
    public function display()
    {
        $current = Queue::where('status', 'called')->latest()->first();
        $waiting = Queue::where('status', 'waiting')->get();

        return view('queue.display', compact('current', 'waiting'));
    }

    public function displayData(): JsonResponse
    {
        $current = Queue::where('status', 'called')->latest('called_at')->latest('id')->first();
        $waiting = Queue::where('status', 'waiting')->orderBy('created_at')->get(['id', 'queue_number', 'patient_name']);

        return response()->json([
            'current' => $current ? [
                'id' => $current->id,
                'queue_number' => $current->queue_number,
                'patient_name' => $current->patient_name,
                'service_type' => $current->service_type,
                'called_at' => optional($current->called_at)->format('Y-m-d H:i:s'),
            ] : null,
            'waiting' => $waiting,
        ]);
    }

    // Form pendaftaran antrian untuk pasien
    public function register()
    {
        // daftar klaster harus sinkron dengan prefix di store()
        $klasters = [
            'Manajemen',
            'Ibu & Anak',
            'Dewasa & Lansia',
            'Apotek & Farmasi',
            'Laboratorium',
        ];

        return view('queue.register', compact('klasters'));
    }

    // Simpan antrian baru
    public function store(Request $request)
    {
        $request->validate([
            'patient_name' => 'required|string|max:255',
            'nik' => 'required|digits:16',
            'complaint' => 'nullable|string',
            'service_type' => 'required|string',
        ]);

        $prefixMap = [
            'Manajemen' => 'M',
            'Ibu & Anak' => 'I',
            'Dewasa & Lansia' => 'D',
            'Apotek & Farmasi' => 'A',
            'Laboratorium' => 'L',
        ];

        $prefix = $prefixMap[$request->service_type] ?? 'X';

        $last = Queue::where('service_type', $request->service_type)->count();
        $number = $prefix . str_pad($last + 1, 3, '0', STR_PAD_LEFT);

        // token unik untuk sekali pakai
        $token = (string) \Illuminate\Support\Str::uuid();

        $queue = Queue::create([
            'queue_number' => $number,
            'patient_name' => $request->patient_name,
            'nik' => $request->nik,
            'complaint' => $request->complaint,
            'service_type' => $request->service_type,
            'status' => 'waiting',
            'token' => $token,
        ]);

        // buat file QR secara lokal menggunakan endroid/qr-code
        // simpan di storage/app/public/qr_codes
        // path relatif ke storage/app/public
        $qrPath = 'app'.DIRECTORY_SEPARATOR.'public'.DIRECTORY_SEPARATOR.'qr_codes'.DIRECTORY_SEPARATOR.'qr_'.$queue->id.'.png';
        // gunakan disk public sehingga root = storage/app/public
        \Illuminate\Support\Facades\Storage::disk('public')->makeDirectory('qr_codes');
        $ticketUrl = route('admin.queue.scan', ['queue' => $queue, 'token' => $token]);
        
        $result = \Endroid\QrCode\Builder\Builder::create()
            ->writer(new \Endroid\QrCode\Writer\PngWriter())
            ->data($ticketUrl)
            ->size(200)
            ->margin(10)
            ->build();

        $result->saveToFile(storage_path($qrPath));
        $queue->update(['qr_path' => 'qr_codes/qr_'.$queue->id.'.png']);

        return redirect()->route('queue.show', ['queue' => $queue]);
    }

    // Lihat tiket (nomor + barcode)
    public function show(Queue $queue)
    {
        return view('queue.ticket', compact('queue'));
    }

    // Tampilan admin antrian
    public function admin()
    {
        $waiting = Queue::where('status', 'waiting')->get();
        $served = Queue::where('status', 'served')->latest()->get();

        return view('queue.admin', compact('waiting', 'served'));
    }

    // Panggil antrian berikutnya
    public function callNext()
    {
        $queue = Queue::where('status', 'waiting')->first();

        if ($queue) {
            $queue->update([
                'status' => 'called',
                'called_at' => now()
            ]);
        }

        return redirect()->back();
    }

    // Tandai antrian sudah selesai
    public function markServed($id)
    {
        $queue = Queue::findOrFail($id);
        $queue->update(['status' => 'served']);

        return redirect()->back();
    }
}