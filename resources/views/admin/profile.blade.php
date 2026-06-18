@extends('admin.app')

@section('title', 'My Profile')

@section('content')
<div class="min-vh-100 bg-light">
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-xxl-8 col-xl-10 col-lg-10">
                <div class="mb-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h1 class="h3 mb-0">My Profile</h1>
                            <p class="text-muted mb-0">Manage your account settings and password</p>
                        </div>
                        <div>
                            <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left me-2"></i> Back
                            </a>
                        </div>
                    </div>
                </div>

                <div class="row g-4">
                    <div class="col-lg-6">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-header bg-white border-0 pb-0 pt-4">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="icon-circle bg-primary rounded-circle px-1 text-white me-3">
                                        <i class="bi bi-person-fill"></i>
                                    </div>
                                    <div>
                                        <h5 class="card-title mb-0">Profile Information</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <form method="post" action="{{ route('profile.update') }}">
                                    @csrf
                                    @method('patch')

                                    <div class="mb-3">
                                        <label class="form-label">Name</label>
                                        <input type="text" name="name" value="{{ old('name', $user->name) }}"
                                            class="form-control form-control-lg"
                                            required>
                                        @error('name')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Email Address</label>
                                        <input type="email" name="email" value="{{ old('email', $user->email) }}"
                                            class="form-control form-control-lg"
                                            required>
                                        @error('email')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                        <i class="bi bi-exclamation-triangle me-2"></i>
                                        Your email address is unverified.
                                        <form id="send-verification" method="post" action="{{ route('verification.send') }}" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-link p-0 align-baseline">
                                                Click here to re-send the verification email.
                                            </button>
                                        </form>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                    </div>
                                    @endif

                                    <div class="mt-4 pt-2">
                                        <button type="submit" class="btn btn-primary btn-lg w-100">
                                            <i class="bi bi-save me-2"></i> Save Changes
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-header bg-white border-0 pb-0 pt-4">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="icon-circle bg-success  rounded-circle px-1  text-white me-3">
                                        <i class="bi bi-shield-lock"></i>
                                    </div>
                                    <div>
                                        <h5 class="card-title mb-0">Update Password</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <form method="post" action="{{ route('password.update') }}">
                                    @csrf
                                    @method('put')

                                    <div class="mb-3">
                                        <label class="form-label">Current Password</label>
                                        <div class="input-group">
                                            <input type="password" name="current_password" id="currentPassword"
                                                class="form-control form-control-lg">
                                            <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('currentPassword')">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                        </div>
                                        @error('current_password')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">New Password</label>
                                        <div class="input-group">
                                            <input type="password" name="password" id="newPassword"
                                                class="form-control form-control-lg">
                                            <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('newPassword')">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                        </div>
                                        @error('password')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                        <div class="form-text">
                                            <small class="text-muted">Minimum 8 characters with letters and numbers</small>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Confirm Password</label>
                                        <div class="input-group">
                                            <input type="password" name="password_confirmation" id="confirmPassword"
                                                class="form-control form-control-lg">
                                            <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('confirmPassword')">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="mt-4 pt-2">
                                        <button type="submit" class="btn btn-success btn-lg w-100">
                                            <i class="bi bi-key me-2"></i> Update Password
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<!-- Toast Notification -->
<div class="toast-container position-fixed top-0 end-0 p-3">
    <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <div class="icon-circle me-2" id="toastIcon">
                <i class="bi bi-check"></i>
            </div>
            <strong class="me-auto" id="toastTitle">Success</strong>
            <small>Just now</small>
            <button type="button" class="btn-close" data-bs-dismiss="toast"></button>
        </div>
        <div class="toast-body" id="toastMessage">
            Profile updated successfully!
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function togglePassword(inputId) {
        const input = document.getElementById(inputId);
        const button = input.nextElementSibling.querySelector('i');

        if (input.type === 'password') {
            input.type = 'text';
            button.classList.remove('bi-eye');
            button.classList.add('bi-eye-slash');
        } else {
            input.type = 'password';
            button.classList.remove('bi-eye-slash');
            button.classList.add('bi-eye');
        }
    }

    // Show toast notification
    function showToast(type, title, message) {
        const toastEl = document.getElementById('liveToast');
        const toastIcon = document.getElementById('toastIcon');
        const toastTitle = document.getElementById('toastTitle');
        const toastMessage = document.getElementById('toastMessage');

        // Set toast type and icon
        let iconClass = 'bi-check';
        let iconBg = 'bg-success';

        switch (type) {
            case 'success':
                iconClass = 'bi-check-circle';
                iconBg = 'bg-success';
                break;
            case 'error':
                iconClass = 'bi-x-circle';
                iconBg = 'bg-danger';
                break;
            case 'warning':
                iconClass = 'bi-exclamation-triangle';
                iconBg = 'bg-warning';
                break;
            case 'info':
                iconClass = 'bi-info-circle';
                iconBg = 'bg-info';
                break;
        }

        // Update toast content
        toastIcon.className = `icon-circle ${iconBg} text-white me-2`;
        toastIcon.innerHTML = `<i class="bi ${iconClass}"></i>`;
        toastTitle.textContent = title;
        toastMessage.textContent = message;

        // Show toast
        const toast = new bootstrap.Toast(toastEl);
        toast.show();
    }

    // Auto-hide alerts after 5 seconds
    document.addEventListener('DOMContentLoaded', function() {
        // Auto-hide alerts
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            setTimeout(() => {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }, 5000);
        });

        // Check for flash messages
        @if(session('status'))
        showToast('success', 'Success!', '{{ session("status") }}');
        @endif

        @if(session('error'))
        showToast('error', 'Error!', '{{ session("error") }}');
        @endif

        // Password strength indicator
        const newPassword = document.getElementById('newPassword');
        if (newPassword) {
            newPassword.addEventListener('input', function() {
                const strength = checkPasswordStrength(this.value);
                updatePasswordStrength(strength);
            });
        }
    });

    function checkPasswordStrength(password) {
        let strength = 0;

        if (password.length >= 8) strength++;
        if (/[a-z]/.test(password)) strength++;
        if (/[A-Z]/.test(password)) strength++;
        if (/[0-9]/.test(password)) strength++;
        if (/[^A-Za-z0-9]/.test(password)) strength++;

        return strength;
    }

    function updatePasswordStrength(strength) {
        const indicator = document.getElementById('passwordStrength');
        if (!indicator) return;

        const texts = ['Very Weak', 'Weak', 'Fair', 'Good', 'Strong'];
        const colors = ['danger', 'danger', 'warning', 'info', 'success'];
        const widths = ['20%', '40%', '60%', '80%', '100%'];

        indicator.textContent = texts[strength - 1] || '';
        indicator.className = `badge bg-${colors[strength - 1] || 'secondary'}`;

        const bar = document.getElementById('passwordStrengthBar');
        if (bar) {
            bar.style.width = widths[strength - 1] || '0%';
            bar.className = `progress-bar bg-${colors[strength - 1] || 'secondary'}`;
        }
    }
</script>

@endsection