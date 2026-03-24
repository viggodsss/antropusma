<h2>Admin Panel</h2>

<form method="POST" action="/call-next">
    @csrf
    <button>Panggil Berikutnya</button>
</form>

<h3>Menunggu:</h3>
@foreach($waiting as $q)
    <p>
        {{ $q->queue_number ?: '---' }} - {{ $q->patient_name }}
        <form method="POST" action="/served/{{ $q->id }}">
            @csrf
            <button>Selesai</button>
        </form>
    </p>
@endforeach