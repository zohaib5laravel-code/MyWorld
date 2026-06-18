<nav class="app-header navbar navbar-expand bg-body">
  <div class="container-fluid">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
          <i class="bi bi-list"></i>
        </a>
      </li>
    </ul>

    <ul class="navbar-nav ms-auto">
      <!-- Notifications Dropdown -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-bs-toggle="dropdown" href="#" id="notificationDropdown">
          <i class="bi bi-bell-fill"></i>
          @php
          $unreadMessagesCount = App\Models\ContactMessage::where('status', 'unread')->count();
          $pendingCommentsCount = App\Models\Comment::where('status', 0)->count();
          $totalNotifications = $unreadMessagesCount + $pendingCommentsCount;
          @endphp
          @if($totalNotifications > 0)
          <span class="navbar-badge badge text-bg-danger">{{ $totalNotifications }}</span>
          @endif
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
          <span class="dropdown-item dropdown-header">
            {{ $totalNotifications }} Notifications
          </span>
          <div class="dropdown-divider"></div>

          <!-- Unread Messages -->
          @if($unreadMessagesCount > 0)
          <a href="{{ route('messages.index') }}" class="dropdown-item text-primary">
            <div class="d-flex align-items-center">
              <div class="me-3">
                <i class="bi bi-envelope-fill fs-5"></i>
              </div>
              <div class="flex-grow-1">
                <div class="fw-semibold">{{ $unreadMessagesCount }} New Message{{ $unreadMessagesCount > 1 ? 's' : '' }}</div>
                <small class="text-muted">Contact form submissions</small>
              </div>
              <div>
                <span class="badge bg-primary rounded-pill">{{ $unreadMessagesCount }}</span>
              </div>
            </div>
          </a>
          <div class="dropdown-divider"></div>
          @endif

          <!-- Pending Comments -->
          @if($pendingCommentsCount > 0)
          <a href="{{ route('comments.index') }}" class="dropdown-item text-info">
            <div class="d-flex align-items-center">
              <div class="me-3">
                <i class="bi bi-chat-left-text-fill fs-5"></i>
              </div>
              <div class="flex-grow-1">
                <div class="fw-semibold">{{ $pendingCommentsCount }} Pending Comment{{ $pendingCommentsCount > 1 ? 's' : '' }}</div>
                <small class="text-muted">Awaiting approval</small>
              </div>
              <div>
                <span class="badge bg-info rounded-pill">{{ $pendingCommentsCount }}</span>
              </div>
            </div>
          </a>
          <div class="dropdown-divider"></div>
          @endif

          <!-- Recent Unread Messages (Last 3) -->
          @php
          $recentMessages = App\Models\ContactMessage::where('status', 'unread')
          ->latest()
          ->limit(3)
          ->get();
          @endphp

          @if($recentMessages->count() > 0)
          <div class="px-3 py-2">
            <small class="text-muted fw-semibold">RECENT MESSAGES</small>
          </div>

          @foreach($recentMessages as $message)
          <a href="{{ route('messages.index') }}?view={{ $message->id }}" class="dropdown-item">
            <div class="d-flex">
              <div class="flex-shrink-0 me-3">
                <div class="avatar-sm bg-light rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-person text-primary"></i>
                </div>
              </div>
              <div class="flex-grow-1 overflow-hidden">
                <div class="fw-semibold text-truncate">{{ $message->name }}</div>
                <div class="text-muted text-truncate small">{{ Str::limit($message->subject, 30) }}</div>
                <div class="text-muted extra-small">{{ $message->created_at->diffForHumans() }}</div>
              </div>
            </div>
          </a>
          @endforeach
          <div class="dropdown-divider"></div>
          @endif

          <!-- Recent Pending Comments (Last 3) -->
          @php
          $recentComments = App\Models\Comment::where('status', 0)
          ->with('post')
          ->latest()
          ->limit(3)
          ->get();
          @endphp

          @if($recentComments->count() > 0)
          <div class="px-3 py-2">
            <small class="text-muted fw-semibold">RECENT COMMENTS</small>
          </div>

          @foreach($recentComments as $comment)
          <a href="{{ route('comments.index') }}?view={{ $comment->id }}" class="dropdown-item">
            <div class="d-flex">
              <div class="flex-shrink-0 me-3">
                <div class="avatar-sm bg-light rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-chat-left-text text-info"></i>
                </div>
              </div>
              <div class="flex-grow-1 overflow-hidden">
                <div class="fw-semibold text-truncate">{{ $comment->name }}</div>
                <div class="text-muted text-truncate small">
                  on "{{ $comment->post->title ?? 'Post' }}"
                </div>
                <div class="text-muted extra-small">{{ Str::limit(strip_tags($comment->comment), 40) }}</div>
                <div class="text-muted extra-small">{{ $comment->created_at->diffForHumans() }}</div>
              </div>
            </div>
          </a>
          @endforeach
          <div class="dropdown-divider"></div>
          @endif

          <!-- If no notifications -->
          @if($totalNotifications == 0)
          <div class="text-center py-4">
            <i class="bi bi-check-circle display-6 text-success mb-3"></i>
            <p class="text-muted mb-0">All caught up!</p>
            <small class="text-muted">No new notifications</small>
          </div>
          <div class="dropdown-divider"></div>
          @endif

          <!-- View All Buttons -->
          <div class="d-flex px-3 py-2">
            <a href="{{ route('messages.index') }}" class="btn btn-outline-primary btn-sm flex-fill me-2">
              <i class="bi bi-envelope me-1"></i> View Messages
            </a>
            <a href="{{ route('comments.index') }}" class="btn btn-outline-info btn-sm flex-fill">
              <i class="bi bi-chat-left-text me-1"></i> View Comments
            </a>
          </div>

        </div>
      </li>

      <!-- Fullscreen Toggle -->
      <li class="nav-item">
        <a class="nav-link" href="#" data-lte-toggle="fullscreen">
          <i data-lte-icon="maximize" class="bi bi-arrows-fullscreen"></i>
          <i data-lte-icon="minimize" class="bi bi-fullscreen-exit" style="display: none"></i>
        </a>
      </li>

      <!-- User Profile Dropdown -->
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" data-bs-toggle="dropdown">
          <div class="avatar-sm d-flex bg-primary rounded-circle align-items-center justify-content-center me-2" style="width: 23px;">
            <i class="bi bi-person-fill text-white "></i>
          </div>
          <span class="d-none d-md-inline">{{ auth()->user()->name ?? 'Admin' }}</span>
        </a>
        <div class="dropdown-menu dropdown-menu-end">
          <div class="dropdown-header text-center">
            <div class="avatar-lg bg-primary rounded-circle d-flex align-items-center justify-content-center mx-auto mb-2" style="width: 40px;">
              <i class="bi bi-person-fill text-white fs-4"></i>
            </div>
            <h6 class="mb-0">{{ auth()->user()->name ?? 'Administrator' }}</h6>
            <small class="text-muted">{{ auth()->user()->email ?? 'admin@example.com' }}</small>
          </div>
          <div class="dropdown-divider"></div>
          <a href="{{ route('profile.edit') }}" class="dropdown-item">
            <i class="bi bi-person me-2"></i> My Profile
          </a>
        
          
          <div class="dropdown-divider"></div>

          <!-- Logout Form -->
          <form action="{{ route('logout') }}" method="post" class="dropdown-item">
            @csrf
            <button type="submit" class="btn btn-link text-decoration-none p-0 border-0 w-100 text-start">
              <i class="bi bi-box-arrow-right me-2 text-danger"></i>
              <span class="text-danger">Logout</span>
            </button>
          </form>
        </div>
      </li>
    </ul>
  </div>
</nav>