<div class="col-md-4 mb-4">
    <a href="{{ route('events.show', $event->id) }}" class="text-decoration-none text-dark">
        <div class="card shadow-sm h-100">
            <img src="{{ asset('storage/' . $event->image) }}" class="card-img-top" alt="Event Image">

            <div class="card-body">
                <h5 class="fw-bold">{{ $event->name }}</h5>
                <p class="text-muted small mb-1">{{ $event->location }}</p>
                <p class="text-muted small">{{ $event->date }}</p>
            </div>
        </div>
    </a>
</div>
