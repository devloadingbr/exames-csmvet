<!DOCTYPE html>
<html lang="pt-BR" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'VetExams - Exames Veterinários Digitais para sua Clínica')</title>
    
    <!-- SEO Meta Tags -->
    <meta name="description" content="@yield('description', 'Transforme sua clínica veterinária com nossa plataforma digital de exames. Entrega segura, acesso fácil para tutores e gestão completa em um só lugar.')">
    <meta name="keywords" content="exames veterinários, clínica digital, veterinário, pets, exames animais">
    <meta name="author" content="VetExams">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url('/') }}">
    <meta property="og:title" content="@yield('og_title', 'VetExams - Exames Veterinários Digitais')">
    <meta property="og:description" content="@yield('og_description', 'Transforme sua clínica veterinária com nossa plataforma digital de exames.')">
    <meta property="og:image" content="{{ asset('images/og-image.jpg') }}">
    
    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url('/') }}">
    <meta property="twitter:title" content="@yield('twitter_title', 'VetExams - Exames Veterinários Digitais')">
    <meta property="twitter:description" content="@yield('twitter_description', 'Transforme sua clínica veterinária com nossa plataforma digital de exames.')">
    <meta property="twitter:image" content="{{ asset('images/twitter-image.jpg') }}">
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    
    <!-- Preload Critical Resources -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Critical CSS for Landing Page -->
    <style>
        /* Critical above-the-fold styles */
        .hero-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .text-gradient {
            background: linear-gradient(to right, #2563eb, #9333ea, #1e40af);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        /* Glass morphism effect */
        .glass {
            backdrop-filter: blur(12px);
            background: rgba(255, 255, 255, 0.9);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        /* Fallback para garantir visibilidade */
        .animate-on-scroll {
            opacity: 1 !important;
            transform: translateY(0) !important;
        }
        
        /* Só aplicar animação se o CSS principal carregar */
        .animate-on-scroll.opacity-0 {
            opacity: 0 !important;
            transform: translateY(2rem) !important;
        }
        
        /* Smooth scroll behavior */
        @media (prefers-reduced-motion: no-preference) {
            * {
                scroll-behavior: smooth;
            }
        }
    </style>
    
    @stack('styles')
</head>
<body class="font-sans antialiased text-gray-900 overflow-x-hidden">
    <!-- Skip to main content for accessibility -->
    <a href="#main-content" class="sr-only focus:not-sr-only focus:absolute focus:top-4 focus:left-4 bg-blue-600 text-white px-4 py-2 rounded-md z-50">
        Pular para o conteúdo principal
    </a>

    @yield('content')

    <!-- Success/Error Messages -->
    @if(session('success'))
        <div id="success-message" class="fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 transform translate-x-0 transition-transform duration-300">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div id="error-message" class="fixed top-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 transform translate-x-0 transition-transform duration-300">
            {{ session('error') }}
        </div>
    @endif

    <!-- JavaScript -->
    <script>
        // Auto-hide messages
        document.addEventListener('DOMContentLoaded', function() {
            const messages = document.querySelectorAll('#success-message, #error-message');
            messages.forEach(message => {
                if (message) {
                    setTimeout(() => {
                        message.style.transform = 'translateX(100%)';
                        setTimeout(() => message.remove(), 300);
                    }, 5000);
                }
            });
        });

        // Intersection Observer for animations - CORRIGIDO
        const observeElements = () => {
            // Verificar se as animações devem ser aplicadas
            const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
            
            if (prefersReducedMotion) {
                // Se o usuário prefere sem animação, não fazer nada
                return;
            }
            
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        // Garantir que o elemento fica visível
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                        entry.target.classList.add('animate-fade-in');
                        entry.target.classList.remove('opacity-0', 'translate-y-8');
                        
                        // Parar de observar após animar
                        observer.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            });

            document.querySelectorAll('.animate-on-scroll').forEach(el => {
                // Adicionar classes apenas se o CSS estiver carregado
                if (document.styleSheets.length > 0) {
                    el.classList.add('opacity-0', 'translate-y-8', 'transition-all', 'duration-700');
                    observer.observe(el);
                } else {
                    // Fallback: tornar visível se CSS não carregar
                    el.style.opacity = '1';
                }
            });
        };

        // Initialize animations when DOM is loaded
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', observeElements);
        } else {
            observeElements();
        }
    </script>
    
    @stack('scripts')
</body>
</html>