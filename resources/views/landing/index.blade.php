@extends('layouts.landing')

@section('title', 'VetExams - Exames Veterinários Digitais para sua Clínica')

@section('description', 'Transforme sua clínica veterinária com nossa plataforma digital de exames. Entrega segura, acesso fácil para tutores e gestão completa em um só lugar.')

@section('content')
<main id="main-content">
    <!-- Header/Navigation -->
    @include('landing.partials.header')
    
    <!-- Hero Section -->
    @include('landing.partials.hero')
    
    <!-- Problem Section -->
    @include('landing.partials.problem')
    
    <!-- Solution Section -->
    @include('landing.partials.solution')
    
    <!-- How It Works Section -->
    @include('landing.partials.how-it-works')
    
    <!-- Features Section -->
    @include('landing.partials.features')
    
    <!-- Pricing Section -->
    @include('landing.partials.pricing')
    
    <!-- Testimonials Section -->
    @include('landing.partials.testimonials')
    
    <!-- FAQ Section -->
    @include('landing.partials.faq')
    
    <!-- Final CTA Section -->
    @include('landing.partials.cta')
    
    <!-- Footer -->
    @include('landing.partials.footer')
</main>
@endsection

@push('scripts')
<script>
    // Landing Page Interactive Features
    document.addEventListener('DOMContentLoaded', function() {
        // Demo button functionality
        const demoBtn = document.getElementById('demo-btn');
        if (demoBtn) {
            demoBtn.addEventListener('click', function() {
                // Add demo modal or redirect logic here
                alert('Demo em desenvolvimento! Por enquanto, teste nosso sistema gratuitamente.');
            });
        }

        // Track CTA clicks (you can integrate with your analytics)
        document.querySelectorAll('[data-track]').forEach(element => {
            element.addEventListener('click', function() {
                const trackingId = this.getAttribute('data-track');
                // Add your tracking logic here
                console.log('Tracked:', trackingId);
            });
        });

        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Mobile menu toggle
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');
        
        if (mobileMenuBtn && mobileMenu) {
            mobileMenuBtn.addEventListener('click', function() {
                mobileMenu.classList.toggle('hidden');
                
                // Toggle hamburger/close icons
                const hamburger = this.querySelector('.hamburger');
                const close = this.querySelector('.close');
                
                if (hamburger && close) {
                    hamburger.classList.toggle('hidden');
                    close.classList.toggle('hidden');
                }
            });
        }

        // Header scroll effect with text color management
        let lastScrollY = window.scrollY;
        const header = document.querySelector('header');
        
        const updateHeaderColors = (isScrolled) => {
            const navLinks = header.querySelectorAll('.nav-link');
            const logoText = header.querySelector('.logo-text');
            const logoSubtext = header.querySelector('.logo-subtext');
            const adminBtn = header.querySelector('.admin-dropdown-btn');
            const clientBtn = header.querySelector('.client-login-btn');
            const mobileBtn = header.querySelector('.mobile-menu-btn');
            
            if (isScrolled) {
                // Scrolled state - dark text on white background
                navLinks.forEach(link => {
                    link.classList.remove('text-white', 'hover:text-blue-300');
                    link.classList.add('text-gray-700', 'hover:text-blue-600');
                });
                
                if (logoText) {
                    logoText.classList.remove('text-white', 'group-hover:text-blue-400');
                    logoText.classList.add('text-gray-900', 'group-hover:text-blue-600');
                    logoText.querySelector('span').classList.remove('text-blue-400');
                    logoText.querySelector('span').classList.add('text-blue-600');
                }
                
                if (logoSubtext) {
                    logoSubtext.classList.remove('text-white/80');
                    logoSubtext.classList.add('text-gray-500');
                }
                
                if (adminBtn) {
                    adminBtn.classList.remove('text-white', 'hover:text-blue-300', 'hover:bg-white/10');
                    adminBtn.classList.add('text-gray-700', 'hover:text-blue-600', 'hover:bg-gray-50/80');
                }
                
                if (clientBtn) {
                    clientBtn.classList.remove('text-white', 'bg-white/10', 'border-white/30', 'hover:bg-white/20', 'hover:border-white/50');
                    clientBtn.classList.add('text-gray-700', 'bg-white/80', 'border-gray-300', 'hover:bg-gray-50/80', 'hover:border-gray-400');
                }
                
                if (mobileBtn) {
                    mobileBtn.classList.remove('text-white', 'hover:text-blue-300', 'hover:bg-white/10');
                    mobileBtn.classList.add('text-gray-700', 'hover:text-blue-600', 'hover:bg-gray-50/80');
                }
            } else {
                // Top state - white text on transparent background
                navLinks.forEach(link => {
                    link.classList.remove('text-gray-700', 'hover:text-blue-600');
                    link.classList.add('text-white', 'hover:text-blue-300');
                });
                
                if (logoText) {
                    logoText.classList.remove('text-gray-900', 'group-hover:text-blue-600');
                    logoText.classList.add('text-white', 'group-hover:text-blue-400');
                    logoText.querySelector('span').classList.remove('text-blue-600');
                    logoText.querySelector('span').classList.add('text-blue-400');
                }
                
                if (logoSubtext) {
                    logoSubtext.classList.remove('text-gray-500');
                    logoSubtext.classList.add('text-white/80');
                }
                
                if (adminBtn) {
                    adminBtn.classList.remove('text-gray-700', 'hover:text-blue-600', 'hover:bg-gray-50/80');
                    adminBtn.classList.add('text-white', 'hover:text-blue-300', 'hover:bg-white/10');
                }
                
                if (clientBtn) {
                    clientBtn.classList.remove('text-gray-700', 'bg-white/80', 'border-gray-300', 'hover:bg-gray-50/80', 'hover:border-gray-400');
                    clientBtn.classList.add('text-white', 'bg-white/10', 'border-white/30', 'hover:bg-white/20', 'hover:border-white/50');
                }
                
                if (mobileBtn) {
                    mobileBtn.classList.remove('text-gray-700', 'hover:text-blue-600', 'hover:bg-gray-50/80');
                    mobileBtn.classList.add('text-white', 'hover:text-blue-300', 'hover:bg-white/10');
                }
            }
        };
        
        window.addEventListener('scroll', () => {
            const currentScrollY = window.scrollY;
            
            if (header) {
                if (currentScrollY > 100) {
                    header.classList.add('backdrop-blur-md', 'bg-white/95', 'shadow-lg');
                    updateHeaderColors(true);
                } else {
                    header.classList.remove('backdrop-blur-md', 'bg-white/95', 'shadow-lg');
                    updateHeaderColors(false);
                }
            }
            
            lastScrollY = currentScrollY;
        });
        
        // Set initial colors based on current scroll position
        if (header) {
            updateHeaderColors(window.scrollY > 100);
        }
    });
</script>
@endpush