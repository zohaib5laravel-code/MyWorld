<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My World - Welcome to My Space</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('assets/css/frontend.css')}}">

</head>

<body>
    <div class="spiral-loader bg-dark" id="spiralLoader">
        <div class="spiral">
            <div class="spiral-inner"></div>
        </div>
        <div class="loader-text">Loading My World...</div>
    </div>

    @include('frontend.components.header')
    @yield('content')
    @include('frontend.components.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    @yield('scripts')

    <script>
        const themeToggle = document.createElement('button');
        themeToggle.className = 'theme-toggle';
        themeToggle.innerHTML = '<i class="fas fa-moon"></i>';
        themeToggle.title = 'Toggle Dark Mode';

        const navbarNav = document.querySelector('.navbar-nav');
        if (navbarNav) {
            const toggleContainer = document.createElement('li');
            toggleContainer.className = 'nav-item';
            toggleContainer.appendChild(themeToggle);
            navbarNav.appendChild(toggleContainer);
        }

        const currentTheme = localStorage.getItem('theme');
        if (currentTheme === 'dark') {
            document.documentElement.setAttribute('data-theme', 'dark');
            themeToggle.innerHTML = '<i class="fas fa-sun"></i>';
        }

        themeToggle.addEventListener('click', function() {
            const currentTheme = document.documentElement.getAttribute('data-theme');

            if (currentTheme === 'dark') {
                document.documentElement.removeAttribute('data-theme');
                localStorage.setItem('theme', 'light');
                themeToggle.innerHTML = '<i class="fas fa-moon"></i>';
            } else {
                document.documentElement.setAttribute('data-theme', 'dark');
                localStorage.setItem('theme', 'dark');
                themeToggle.innerHTML = '<i class="fas fa-sun"></i>';
            }
        });

        const prefersDarkScheme = window.matchMedia('(prefers-color-scheme: dark)');
        if (!localStorage.getItem('theme') && prefersDarkScheme.matches) {
            document.documentElement.setAttribute('data-theme', 'dark');
            themeToggle.innerHTML = '<i class="fas fa-sun"></i>';
        }


        document.addEventListener('DOMContentLoaded', function() {
            const spiralLoader = document.getElementById('spiralLoader');
            spiralLoader.classList.remove('hidden');
            window.addEventListener('load', function() {
                setTimeout(() => {
                    spiralLoader.classList.add('hidden');
                }, 500);
            });
            setTimeout(() => {
                spiralLoader.classList.add('hidden');
            }, 300);
        
            const navbar = document.querySelector('.navbar');

            window.addEventListener('scroll', function() {
                if (window.scrollY > 100) {
                    navbar.classList.add('navbar-scrolled');
                    navbar.classList.remove('navbar-dark');
                    navbar.classList.add('navbar-light');
                } else {
                    navbar.classList.remove('navbar-scrolled');
                    navbar.classList.remove('navbar-light');
                    navbar.classList.add('navbar-dark');
                }
            });

            document.querySelectorAll('.navbar .nav-link').forEach(link => {
                link.addEventListener('click', function(e) {
                    if (this.getAttribute('href').startsWith('#')) {
                        e.preventDefault();
                        const targetId = this.getAttribute('href');
                        const targetElement = document.querySelector(targetId);

                        if (targetElement) {
                            window.scrollTo({
                                top: targetElement.offsetTop - 70,
                                behavior: 'smooth'
                            });

                            // Close mobile menu if open
                            const navbarCollapse = document.querySelector('.navbar-collapse');
                            if (navbarCollapse.classList.contains('show')) {
                                const bsCollapse = new bootstrap.Collapse(navbarCollapse);
                                bsCollapse.hide();
                            }
                        }
                    }
                });
            });
        });
    </script>
</body>

</html>