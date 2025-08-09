// VetExams Landing Page JavaScript

document.addEventListener('DOMContentLoaded', function() {
    // Header dropdown functionality
    const dropdownButton = document.querySelector('.group button');
    const dropdownMenu = document.querySelector('.group .absolute');
    
    if (dropdownButton && dropdownMenu) {
        // Toggle dropdown on click
        dropdownButton.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const isVisible = dropdownMenu.classList.contains('opacity-100');
            
            if (isVisible) {
                dropdownMenu.classList.remove('opacity-100', 'visible');
                dropdownMenu.classList.add('opacity-0', 'invisible');
            } else {
                dropdownMenu.classList.remove('opacity-0', 'invisible');
                dropdownMenu.classList.add('opacity-100', 'visible');
            }
        });
        
        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (!dropdownButton.contains(e.target) && !dropdownMenu.contains(e.target)) {
                dropdownMenu.classList.remove('opacity-100', 'visible');
                dropdownMenu.classList.add('opacity-0', 'invisible');
            }
        });
        
        // Close dropdown on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                dropdownMenu.classList.remove('opacity-100', 'visible');
                dropdownMenu.classList.add('opacity-0', 'invisible');
            }
        });
    }

    // Mobile menu toggle
    const mobileMenuBtn = document.getElementById('mobile-menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');
    
    if (mobileMenuBtn && mobileMenu) {
        mobileMenuBtn.addEventListener('click', function() {
            mobileMenu.classList.toggle('hidden');
            
            // Toggle hamburger icon
            const hamburger = mobileMenuBtn.querySelector('.hamburger');
            const close = mobileMenuBtn.querySelector('.close');
            
            if (hamburger && close) {
                hamburger.classList.toggle('hidden');
                close.classList.toggle('hidden');
            }
        });
    }

    // Smooth scroll for navigation links
    const navLinks = document.querySelectorAll('a[href^="#"]');
    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            
            const targetId = this.getAttribute('href');
            const targetSection = document.querySelector(targetId);
            
            if (targetSection) {
                const headerHeight = document.querySelector('header').offsetHeight;
                const targetPosition = targetSection.offsetTop - headerHeight - 20;
                
                window.scrollTo({
                    top: targetPosition,
                    behavior: 'smooth'
                });
                
                // Close mobile menu if open
                if (mobileMenu && !mobileMenu.classList.contains('hidden')) {
                    mobileMenu.classList.add('hidden');
                }
            }
        });
    });

    // Header scroll effect
    const header = document.querySelector('header');
    let lastScrollY = window.scrollY;

    window.addEventListener('scroll', function() {
        const currentScrollY = window.scrollY;
        
        if (header) {
            if (currentScrollY > 100) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        }
        
        lastScrollY = currentScrollY;
    });

    // FAQ accordion functionality
    initFAQ();

    // Form validation and submission
    const trialForm = document.getElementById('trial-form');
    if (trialForm) {
        trialForm.addEventListener('submit', function(e) {
            const submitBtn = this.querySelector('button[type="submit"]');
            
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = 'Processando...';
                
                // Re-enable button after 3 seconds in case of error
                setTimeout(() => {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = 'Começar Teste Grátis Agora';
                }, 3000);
            }
        });
    }

    // Pricing plan selection
    const pricingCards = document.querySelectorAll('.pricing-card');
    pricingCards.forEach(card => {
        card.addEventListener('click', function() {
            // Remove active class from all cards
            pricingCards.forEach(c => c.classList.remove('selected'));
            
            // Add active class to clicked card
            this.classList.add('selected');
            
            // Update hidden input if exists
            const planInput = document.getElementById('selected-plan');
            if (planInput) {
                planInput.value = this.dataset.plan;
            }
        });
    });

    // Intersection Observer for animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('fade-in');
                
                // Add staggered animation for child elements
                const children = entry.target.querySelectorAll('.animate-child');
                children.forEach((child, index) => {
                    setTimeout(() => {
                        child.classList.add('fade-in');
                    }, index * 100);
                });
            }
        });
    }, observerOptions);

    // Observe sections for animations
    const animatedSections = document.querySelectorAll('.animate-on-scroll');
    animatedSections.forEach(section => {
        observer.observe(section);
    });

    // Back to top button functionality
    initBackToTop();

    // Initialize other functions
    initTestimonialCarousel();
});

// FAQ Accordion functionality
function initFAQ() {
    console.log('FAQ: Starting initialization...');
    const faqItems = document.querySelectorAll('.faq-item');
    console.log('FAQ: Found items:', faqItems.length);
    
    if (faqItems.length === 0) {
        console.log('FAQ: No FAQ items found!');
        return;
    }
    
    faqItems.forEach((item, index) => {
        const question = item.querySelector('.faq-question');
        const answer = item.querySelector('.faq-answer');
        const icon = item.querySelector('.faq-icon');
        
        console.log(`FAQ ${index}:`, { question: !!question, answer: !!answer, icon: !!icon });
        
        if (question && answer && icon) {
            question.addEventListener('click', (e) => {
                e.preventDefault();
                console.log(`FAQ ${index}: Clicked!`);
                
                const isOpen = answer.classList.contains('open');
                console.log(`FAQ ${index}: Currently open:`, isOpen);
                
                // Close all other FAQ items
                faqItems.forEach(otherItem => {
                    if (otherItem !== item) {
                        const otherAnswer = otherItem.querySelector('.faq-answer');
                        const otherIcon = otherItem.querySelector('.faq-icon');
                        if (otherAnswer && otherIcon) {
                            otherAnswer.classList.remove('open');
                            otherIcon.style.transform = 'rotate(0deg)';
                        }
                    }
                });
                
                // Toggle current item
                if (isOpen) {
                    answer.classList.remove('open');
                    icon.style.transform = 'rotate(0deg)';
                    console.log(`FAQ ${index}: Closed`);
                } else {
                    answer.classList.add('open');
                    icon.style.transform = 'rotate(180deg)';
                    console.log(`FAQ ${index}: Opened`);
                }
            });
            console.log(`FAQ ${index}: Event listener added`);
        } else {
            console.log(`FAQ ${index}: Missing elements!`);
        }
    });
}

// Back to top button functionality
function initBackToTop() {
    const backToTopBtn = document.getElementById('back-to-top');
    
    if (backToTopBtn) {
        // Show/hide button based on scroll position
        window.addEventListener('scroll', () => {
            if (window.pageYOffset > 300) {
                backToTopBtn.classList.add('show');
            } else {
                backToTopBtn.classList.remove('show');
            }
        });
        
        // Smooth scroll to top
        backToTopBtn.addEventListener('click', () => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }
}

// Testimonials carousel
function initTestimonialCarousel() {
    const testimonialCarousel = document.querySelector('.testimonials-carousel');
    if (testimonialCarousel) {
        let currentSlide = 0;
        const slides = testimonialCarousel.querySelectorAll('.testimonial-slide');
        const totalSlides = slides.length;
        
        function showSlide(index) {
            slides.forEach((slide, i) => {
                slide.style.display = i === index ? 'block' : 'none';
            });
        }
        
        function nextSlide() {
            currentSlide = (currentSlide + 1) % totalSlides;
            showSlide(currentSlide);
        }
        
        // Auto-advance testimonials every 5 seconds
        if (totalSlides > 1) {
            showSlide(0);
            setInterval(nextSlide, 5000);
        }
    }
}

// Phone number formatting
function formatPhoneNumber(input) {
    let value = input.value.replace(/\D/g, '');
    
    if (value.length <= 11) {
        value = value.replace(/(\d{2})(\d{5})(\d{4})/, '($1) $2-$3');
        if (value.length < 14) {
            value = value.replace(/(\d{2})(\d{4})(\d{4})/, '($1) $2-$3');
        }
    }
    
    input.value = value;
}

// Track events (placeholder for analytics)
function trackEvent(eventName, properties) {
    console.log('Event tracked:', eventName, properties);
    
    // Google Analytics 4
    if (typeof gtag !== 'undefined') {
        gtag('event', eventName, properties);
    }
    
    // Facebook Pixel
    if (typeof fbq !== 'undefined') {
        fbq('track', eventName, properties);
    }
}
