<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Display Antrian</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen text-white"
      style="background: linear-gradient(135deg, #1e1b4b 0%, #312e81 25%, #4338ca 50%, #3b82f6 75%, #06b6d4 100%);">

    <div class="max-w-6xl mx-auto px-6 py-10">
        <h1 class="text-4xl font-extrabold text-center mb-8">Display Antrian Puskesmas</h1>

        <div class="bg-white/10 backdrop-blur-sm border border-white/20 rounded-2xl p-8 text-center shadow-2xl mb-8">
            <p class="text-lg text-cyan-200 uppercase tracking-widest">Nomor Antrian Dipanggil</p>
            <div id="current-queue" class="text-7xl font-black mt-4 drop-shadow-lg">{{ $current?->queue_number ?? '---' }}</div>
            <p class="mt-4 text-xl text-white/90">
                Nama Pasien: <span id="current-name" class="font-bold">{{ $current?->patient_name ?? '-' }}</span>
            </p>
            <p class="mt-1 text-sm text-cyan-200">
                Poli: <span id="current-service" class="font-semibold">{{ $current?->service_type ?? '-' }}</span>
            </p>
        </div>

        <div class="bg-white/10 backdrop-blur-sm border border-white/20 rounded-2xl p-6 shadow-2xl">
            <h2 class="text-2xl font-bold mb-4">Antrian Menunggu</h2>
            <div id="waiting-list" class="flex flex-wrap gap-3">
                @if($waiting->count())
                    @foreach($waiting as $item)
                        <span class="inline-flex items-center px-4 py-2 rounded-xl bg-white/90 text-indigo-700 font-bold">
                            {{ $item->queue_number }}
                        </span>
                    @endforeach
                @else
                    <p class="text-white/80" id="waiting-empty">Tidak ada antrian menunggu.</p>
                @endif
            </div>
        </div>
    </div>

    <script>
        const currentQueueEl = document.getElementById('current-queue');
        const currentNameEl = document.getElementById('current-name');
        const currentServiceEl = document.getElementById('current-service');
        const waitingListEl = document.getElementById('waiting-list');

        let lastAnnouncedQueueId = localStorage.getItem('last_announced_queue_id');

        function speakCall(queueNumber, patientName, serviceType) {
            if (!('speechSynthesis' in window)) {
                return;
            }

            const text = `Perhatian. Nomor antrian ${queueNumber}. Atas nama ${patientName}. Silakan menuju loket ${serviceType}.`;
            const utterance = new SpeechSynthesisUtterance(text);
            utterance.lang = 'id-ID';
            utterance.rate = 0.9;
            utterance.pitch = 1;
            speechSynthesis.cancel();
            speechSynthesis.speak(utterance);
        }

        function renderWaiting(waitingItems) {
            waitingListEl.innerHTML = '';

            if (!waitingItems || waitingItems.length === 0) {
                waitingListEl.innerHTML = '<p class="text-white/80" id="waiting-empty">Tidak ada antrian menunggu.</p>';
                return;
            }

            waitingItems.forEach((item) => {
                const span = document.createElement('span');
                span.className = 'inline-flex items-center px-4 py-2 rounded-xl bg-white/90 text-indigo-700 font-bold';
                span.textContent = item.queue_number;
                waitingListEl.appendChild(span);
            });
        }

        async function refreshDisplay() {
            try {
                const response = await fetch('{{ route('queue.display.data') }}', { cache: 'no-store' });
                const data = await response.json();

                if (data.current) {
                    currentQueueEl.textContent = data.current.queue_number;
                    currentNameEl.textContent = data.current.patient_name || '-';
                    currentServiceEl.textContent = data.current.service_type || '-';

                    const currentId = String(data.current.id);
                    if (lastAnnouncedQueueId !== currentId) {
                        speakCall(data.current.queue_number, data.current.patient_name || 'Pasien', data.current.service_type || 'tujuan layanan');
                        lastAnnouncedQueueId = currentId;
                        localStorage.setItem('last_announced_queue_id', currentId);
                    }
                } else {
                    currentQueueEl.textContent = '---';
                    currentNameEl.textContent = '-';
                    currentServiceEl.textContent = '-';
                }

                renderWaiting(data.waiting || []);
            } catch (error) {
                console.error('Gagal memperbarui display antrian:', error);
            }
        }

        refreshDisplay();
        setInterval(refreshDisplay, 5000);
    </script>

</body>
</html>