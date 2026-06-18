@extends('frontend.app')
@section('content')

<style>
    .post-header {
        background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.5)),
        url('{{ asset($post->featured_image ? "assets/posts/{$post->featured_image}" : "https://images.unsplash.com/photo-1506905925346-21bda4d32df4") }}');
        background-size: cover;
        background-position: center;
        color: white;
        padding: 120px 0 60px;
        margin-bottom: 40px;
    }
</style>

<!-- Post Header -->
<section class="post-header">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center">
                @if($post->category)
                <span class="badge bg-warning text-dark mb-3 px-3 py-2">{{ $post->category->name }}</span>
                @endif
                <h1 class="display-4 mb-4">{{ $post->title }}</h1>
                <div class="post-meta mb-4 ">
                    <!-- <i class="fas fa-user"></i> By {{ $post->user->name ?? 'Admin' }} -->
                     <span class="transparentBg">
                         <i class="fas fa-calendar ms-3"></i> {{ date('M j, Y', strtotime($post->created_at)) }}
                     </span>
                       <span class="transparentBg">
                    <i class="fas fa-eye ms-3"></i> {{ $post->views?? '2' }} 
                     </span>
                      <span class="transparentBg">
                    <i class="fas fa-comments ms-3"></i> {{ $post->approvedComments()->count() }} 
                     </span>
                </div>
                @if($post->excerpt)
                <p class="lead">{{ $post->excerpt }}</p>
                @endif
            </div>
        </div>
    </div>
</section>

<!-- Post Content -->
<section class="post-content-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <article class="post-content mb-5">
                    {!! $post->content !!}
                </article>

                <!-- Comments Section -->
                <div class="comment-section">
                    <h3 class="mb-4">
                        <i class="fas fa-comments me-2"></i>
                        Comments ({{ $post->approvedComments()->count() }})
                    </h3>

                    <!-- Comment Form -->
                    <div class="comment-form mb-5">
                        <h4 class="mb-3">Leave a Comment</h4>

                        @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                        @endif

                        @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                        @endif

                        <form action="{{ route('frontend.comment.store', $post) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="comment" class="form-label">Comment *</label>
                                <textarea class="form-control" id="comment" name="comment" rows="4"
                                    placeholder="Share your thoughts..." required>{{ old('comment') }}</textarea>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label">Name *</label>
                                    <input type="text" class="form-control" id="name" placeholder="Your Name" name="name"
                                        value="{{ old('name') }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">Email </label>
                                    <input type="email" class="form-control" id="email" placeholder="Your Email (Optional)" name="email"
                                        value="{{ old('email') }}">
                                </div>
                            </div>

                            <div class="mb-3">
                                <small class="text-muted">Your comment will be visible after approval.</small>
                            </div>

                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-paper-plane me-2"></i>Post Comment
                            </button>
                        </form>
                    </div>

                    <!-- Comments List -->
                    <div class="comments-list">

                        @if($post->approvedComments->isEmpty())
                        <div class="text-center py-4">
                            <i class="fas fa-comments fa-3x text-muted mb-3"></i>
                            <p class="text-muted">No comments yet. Be the first to share your thoughts!</p>
                        </div>
                        @else
                        @foreach($post->approvedComments as $comment)
                        @include('frontend.components.comments', ['comment' => $comment])
                        @endforeach
                        @endif

                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">

                <div class="card mb-4 shadow-sm">
                    <div class="card-body text-center">
                        <h5 class="card-title">{{ $post->user->name ?? 'Admin' }}</h5>
                        <p class="card-text text-muted">Writer & Explorer</p>
                        <p class="card-text">Sharing stories from my journey through life, nature, and everything in between.</p>
                    </div>
                </div>

                @include('frontend.components.related_posts')
                
                @include('frontend.components.categories')

                @include('frontend.components.newsletter')
            </div>
        </div>
    </div>
</section>


@endsection
@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.reply-btn').forEach(button => {
            button.addEventListener('click', function() {
                const commentId = this.getAttribute('data-comment-id');
                const replyForm = document.getElementById(`reply-form-${commentId}`);

                // Toggle reply form visibility
                if (replyForm.style.display === 'none') {
                    replyForm.style.display = 'block';
                    replyForm.scrollIntoView({
                        behavior: 'smooth',
                        block: 'nearest'
                    });
                } else {
                    replyForm.style.display = 'none';
                }
            });
        });
    });
</script>
@endsection