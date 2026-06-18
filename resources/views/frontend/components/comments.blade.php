<div class="comment" id="comment-{{ $comment->id }}">
    <div class="row">
        <div class="col-auto">
            <img src="https://ui-avatars.com/api/?name={{ urlencode($comment->name) }}&color=7C3AED&background=FBBF24"
                alt="{{ $comment->name }}"
                class="comment-avatar">
        </div>
        <div class="col">
            <!-- Use responsive flex classes -->
            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start mb-2">
                <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center mb-2 mb-sm-0">
                    <h6 class="mb-0 mb-sm-0 me-sm-3">{{ $comment->name }}</h6>
                    <small class="text-muted">
                        <i class="fas fa-clock"></i>
                        {{ $comment->created_at->diffForHumans() }}
                    </small>
                </div>
                <!-- Your other content -->
            </div>
            <p class="mb-0">{{ $comment->comment }}</p>
        </div>
    </div>
</div>