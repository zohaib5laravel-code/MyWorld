<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3a0ca3;
            --dark-color: #2b2d42;
            --light-color: #f8f9fa;
            --danger-color: #e63946;
            --success-color: #4cc9f0;
        }
        
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .login-container {
            max-width: 420px;
            width: 100%;
            animation: fadeIn 0.5s ease-in-out;
        }
        
        .login-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            border: none;
        }
        
        .login-header {
            background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 2rem;
            text-align: center;
        }
        
        .login-header h1 {
            font-weight: 700;
            margin-bottom: 0.5rem;
            font-size: 2rem;
        }
        
        .login-header p {
            opacity: 0.9;
            font-size: 0.9rem;
        }
        
        .login-body {
            padding: 2rem;
        }
        
        .input-group {
            margin-bottom: 1.5rem;
            transition: all 0.3s ease;
        }
        
        .input-group:focus-within {
            transform: translateY(-2px);
        }
        
        .form-control {
            border: 2px solid #e9ecef;
            border-right: none;
            padding: 0.75rem 1rem;
            font-size: 1rem;
            transition: all 0.3s ease;
            height: 52px;
        }
        
        .form-control:focus {
            box-shadow: none;
            border-color: var(--primary-color);
        }
        
        .input-group-text {
            background-color: white;
            border: 2px solid #e9ecef;
            border-left: none;
            color: #6c757d;
            padding: 0.75rem 1rem;
            height: 52px;
        }
        
        .form-check-input:checked {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-login {
            background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
            border: none;
            color: white;
            padding: 0.75rem;
            font-weight: 600;
            font-size: 1rem;
            border-radius: 10px;
            transition: all 0.3s ease;
            height: 52px;
        }
        
        .btn-login:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(67, 97, 238, 0.3);
        }
        
        .btn-login:active {
            transform: translateY(-1px);
        }
        
        .forgot-password {
            color: var(--primary-color);
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.3s ease;
        }
        
        .forgot-password:hover {
            color: var(--secondary-color);
            text-decoration: underline;
        }
        
        .alert {
            border-radius: 10px;
            border: none;
            padding: 0.75rem 1rem;
        }
        
        .password-toggle {
            cursor: pointer;
            color: #6c757d;
            transition: color 0.3s ease;
        }
        
        .password-toggle:hover {
            color: var(--primary-color);
        }
        
        .loading {
            display: none;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
            20%, 40%, 60%, 80% { transform: translateX(5px); }
        }
        
        .shake {
            animation: shake 0.5s ease-in-out;
        }
        
        .footer-links {
            text-align: center;
            margin-top: 1.5rem;
            font-size: 0.85rem;
            color: #6c757d;
        }
        
        .footer-links a {
            color: var(--primary-color);
            text-decoration: none;
            margin: 0 0.5rem;
        }
        
        .footer-links a:hover {
            text-decoration: underline;
        }
        
        @media (max-width: 576px) {
            .login-container {
                padding: 1rem;
            }
            
            .login-header, .login-body {
                padding: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <h1><i class="bi bi-shield-lock"></i> Admin Portal</h1>
                <p>Secure access to administration panel</p>
            </div>
            
            <div class="login-body">
                   
                <form id="loginForm" action="{{ route('login') }}" method="post">
                    @csrf                    
                    <div class="input-group mb-4">
                        <input type="email" 
                               class="form-control @error('email') is-invalid @enderror" 
                               name="email" 
                               id="email"
                               placeholder="Admin Email" 
                               value="{{ old('email') }}"
                               required
                               autocomplete="email"
                               autofocus>
                        <div class="input-group-text">
                            <span class="bi bi-person-badge"></span>
                        </div>
                        @error('email')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                    <div class="input-group mb-3">
                        <input type="password" 
                               class="form-control @error('password') is-invalid @enderror" 
                               name="password" 
                               id="password"
                               placeholder="Password" 
                               required
                               autocomplete="current-password">
                        <div class="input-group-text">
                            <span class="bi bi-lock-fill"></span>
                        </div>
                        <div class="input-group-text password-toggle" id="togglePassword">
                            <span class="bi bi-eye"></span>
                        </div>
                        @error('password')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="form-check">
                            <input class="form-check-input" 
                                   type="checkbox" 
                                   name="remember" 
                                   id="remember"
                                   {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">
                                Remember me
                            </label>
                        </div>
                    
                    </div>
                    
                    <div class="d-grid gap-2 mb-3">
                        <button type="submit" class="btn btn-login" id="loginButton">
                            <span class="button-text">Login</span>
                            <span class="loading d-none">
                                <span class="spinner-border text-white spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                                Authenticating...
                            </span>
                        </button>
                    </div>
                                 
                </form>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const togglePassword = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('password');
            const toggleIcon = togglePassword.querySelector('.bi');
            
            togglePassword.addEventListener('click', function() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                toggleIcon.classList.toggle('bi-eye');
                toggleIcon.classList.toggle('bi-eye-slash');
            });
            
            const loginForm = document.getElementById('loginForm');
            const loginButton = document.getElementById('loginButton');
            const buttonText = loginButton.querySelector('.button-text');
            const loadingText = loginButton.querySelector('.loading');
            
            loginForm.addEventListener('submit', function(e) {
                const email = document.getElementById('email').value;
                const password = document.getElementById('password').value;
                
                if (!email || !password) {
                    e.preventDefault();
                    loginForm.classList.add('shake');
                    setTimeout(() => loginForm.classList.remove('shake'), 500);
                    
                    if (!email) {
                        showError(document.getElementById('email'), 'Email is required');
                    }
                    if (!password) {
                        showError(document.getElementById('password'), 'Password is required');
                    }
                    return;
                }
                
                buttonText.classList.add('d-none');
                loadingText.classList.remove('d-none');
                loginButton.disabled = true;
            });
            
            function showError(inputElement, message) {
                const existingError = inputElement.parentElement.querySelector('.text-danger');
                if (existingError) existingError.remove();
                
                const errorDiv = document.createElement('div');
                errorDiv.className = 'text-danger small mt-1';
                errorDiv.innerHTML = `<i class="bi bi-exclamation-circle me-1"></i> ${message}`;
                inputElement.parentElement.appendChild(errorDiv);
                
                inputElement.classList.add('is-invalid');
                
                inputElement.addEventListener('input', function() {
                    errorDiv.remove();
                    inputElement.classList.remove('is-invalid');
                }, { once: true });
            }
          
            
            if (!document.getElementById('email').value) {
                document.getElementById('email').focus();
            }
        });
    </script>
</body>
</html>