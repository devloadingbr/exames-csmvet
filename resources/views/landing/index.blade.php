<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VetExams - Exames Veterinários Digitais para sua Clínica</title>
    <meta name="description" content="Transforme sua clínica veterinária com nossa plataforma digital de exames. Entrega segura, acesso fácil para tutores e gestão completa em um só lugar.">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url('/') }}">
    <meta property="og:title" content="VetExams - Exames Veterinários Digitais para sua Clínica">
    <meta property="og:description" content="Transforme sua clínica veterinária com nossa plataforma digital de exames. Entrega segura, acesso fácil para tutores e gestão completa em um só lugar.">
    
    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url('/') }}">
    <meta property="twitter:title" content="VetExams - Exames Veterinários Digitais para sua Clínica">
    <meta property="twitter:description" content="Transforme sua clínica veterinária com nossa plataforma digital de exames. Entrega segura, acesso fácil para tutores e gestão completa em um só lugar.">
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Complete Functional CSS for Landing Page -->
    <style>
        /* Complete CSS Reset and Base */
        *, *::before, *::after {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        html {
            scroll-behavior: smooth;
            font-size: 16px;
        }
        
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            line-height: 1.6;
            color: #1F2937;
            background-color: #FFFFFF;
            overflow-x: hidden;
        }
        
        /* CSS Variables */
        :root {
            --primary: #3B82F6;
            --primary-dark: #2563EB;
            --secondary: #10B981;
            --accent: #F59E0B;
            --gray-900: #1F2937;
            --gray-800: #1F2937;
            --gray-700: #374151;
            --gray-600: #4B5563;
            --gray-500: #6B7280;
            --gray-400: #9CA3AF;
            --gray-300: #D1D5DB;
            --gray-200: #E5E7EB;
            --gray-100: #F3F4F6;
            --gray-50: #F9FAFB;
            --white: #FFFFFF;
            --blue-50: #EBF4FF;
            --blue-600: #2563EB;
            --indigo-100: #E0E7FF;
        }
        
        /* Enhanced Typography */
        h1, h2, h3, h4, h5, h6 {
            font-weight: 700;
            line-height: 1.2;
            margin-bottom: 1rem;
            color: var(--gray-900);
            letter-spacing: -0.025em;
        }
        
        h1 { 
            font-size: 3.5rem; 
            background: linear-gradient(135deg, #1F2937 0%, #3B82F6 50%, #10B981 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        
        h2 { 
            font-size: 2.5rem;
            color: var(--gray-900);
            position: relative;
        }
        
        h2::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 0;
            width: 60px;
            height: 4px;
            background: linear-gradient(90deg, #3B82F6, #10B981);
            border-radius: 2px;
        }
        
        h3 { 
            font-size: 2rem;
            color: var(--gray-800);
        }
        
        h4 { 
            font-size: 1.5rem;
            color: var(--gray-700);
        }
        
        p {
            margin-bottom: 1.25rem;
            font-size: 1.125rem;
            line-height: 1.75;
            color: var(--gray-600);
        }
        
        /* Enhanced Text Effects */
        .text-gradient {
            background: linear-gradient(135deg, #3B82F6 0%, #10B981 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .text-shadow {
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        
        .text-glow {
            text-shadow: 0 0 20px rgba(59, 130, 246, 0.3);
        }
        
        /* Utility Classes */
        .text-5xl { font-size: 3rem; }
        .text-4xl { font-size: 2.25rem; }
        .text-xl { font-size: 1.25rem; }
        .font-bold { font-weight: 700; }
        .leading-tight { line-height: 1.25; }
        .leading-relaxed { line-height: 1.625; }
        .text-gray-900 { color: var(--gray-900); }
        .text-gray-600 { color: var(--gray-600); }
        .text-blue-600 { color: var(--blue-600); }
        .text-center { text-align: center; }
        
        /* Layout */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
        }
        
        .max-w-7xl {
            max-width: 80rem;
        }
        
        .mx-auto {
            margin-left: auto;
            margin-right: auto;
        }
        
        .px-4 { padding-left: 1rem; padding-right: 1rem; }
        .py-4 { padding-top: 1rem; padding-bottom: 1rem; }
        
        /* Flexbox */
        .flex { display: flex; }
        .flex-col { flex-direction: column; }
        .items-center { align-items: center; }
        .justify-center { justify-content: center; }
        .justify-between { justify-content: space-between; }
        
        /* Grid */
        .grid { display: grid; }
        .gap-4 { gap: 1rem; }
        .gap-12 { gap: 3rem; }
        
        /* Spacing */
        .space-x-2 > * + * { margin-left: 0.5rem; }
        .space-x-3 > * + * { margin-left: 0.75rem; }
        .space-x-8 > * + * { margin-left: 2rem; }
        .space-y-4 > * + * { margin-top: 1rem; }
        .space-y-8 > * + * { margin-top: 2rem; }
        
        /* Header - Fixed and Visible */
        header {
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            right: 0 !important;
            z-index: 1000 !important;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            background-color: rgba(255, 255, 255, 0.95) !important;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            display: block !important;
            visibility: visible !important;
            opacity: 1 !important;
        }
        
        /* Navigation - Force Visibility */
        nav {
            display: flex !important;
            align-items: center !important;
            justify-content: space-between !important;
            padding: 1rem 0 !important;
            width: 100% !important;
        }
        
        .nav-link {
            color: var(--gray-700) !important;
            text-decoration: none !important;
            font-weight: 500 !important;
            transition: color 0.3s ease !important;
            display: inline-block !important;
        }
        
        .nav-link:hover {
            color: var(--primary) !important;
        }
        
        /* Force Desktop Menu Visibility */
        .lg\:flex {
            display: flex !important;
        }
        
        /* Navigation Items - Force All Visibility */
        nav > div {
            display: flex !important;
            align-items: center !important;
        }
        
        /* Logo Section */
        nav > div:first-child {
            display: flex !important;
            align-items: center !important;
        }
        
        nav > div:first-child a {
            display: flex !important;
            align-items: center !important;
            text-decoration: none !important;
        }
        
        /* Desktop Navigation Menu */
        nav > div:nth-child(2) {
            display: flex !important;
            align-items: center !important;
        }
        
        nav > div:nth-child(2) a {
            display: inline-block !important;
            margin: 0 1rem !important;
            color: var(--gray-700) !important;
            text-decoration: none !important;
            font-weight: 500 !important;
        }
        
        /* Action Buttons Section */
        nav > div:last-child {
            display: flex !important;
            align-items: center !important;
            gap: 0.75rem !important;
        }
        
        /* Dropdown Button */
        .group button {
            display: flex !important;
            align-items: center !important;
            padding: 0.5rem 0.75rem !important;
            color: var(--gray-700) !important;
            font-weight: 500 !important;
            border: none !important;
            background: transparent !important;
            cursor: pointer !important;
            border-radius: 0.5rem !important;
            transition: all 0.3s ease !important;
        }
        
        .group button:hover {
            background-color: var(--gray-50) !important;
            color: var(--blue-600) !important;
        }
        
        /* Teste Grátis Button */
        .btn-primary {
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%) !important;
            color: var(--white) !important;
            border: none !important;
            padding: 0.75rem 1.5rem !important;
            border-radius: 0.5rem !important;
            font-weight: 600 !important;
            text-decoration: none !important;
        }
        
        /* Hero Section - Enhanced */
        .section-hero {
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: 8rem 0 4rem;
            position: relative;
            overflow: hidden;
            background: linear-gradient(135deg, #EBF4FF 0%, #E0E7FF 30%, #F0FDF4 70%, #EBF8FF 100%);
        }
        
        .section-hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at 20% 80%, rgba(59, 130, 246, 0.1) 0%, transparent 50%),
                        radial-gradient(circle at 80% 20%, rgba(16, 185, 129, 0.1) 0%, transparent 50%);
            pointer-events: none;
        }
        
        .bg-gradient-to-br {
            background: linear-gradient(135deg, #EBF4FF 0%, #E0E7FF 30%, #F0FDF4 70%, #EBF8FF 100%);
        }
        
        /* Enhanced Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.875rem 2rem;
            font-size: 1rem;
            font-weight: 600;
            text-decoration: none;
            border-radius: 0.75rem;
            border: none;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            text-align: center;
            white-space: nowrap;
            position: relative;
            overflow: hidden;
        }
        
        .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }
        
        .btn:hover::before {
            left: 100%;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #3B82F6 0%, #2563EB 50%, #1D4ED8 100%);
            color: var(--white);
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
        }
        
        .btn-primary:hover {
            background: linear-gradient(135deg, #2563EB 0%, #1D4ED8 50%, #1E40AF 100%);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(59, 130, 246, 0.4);
        }
        
        .btn-secondary {
            background: rgba(255, 255, 255, 0.9);
            color: var(--primary);
            border: 2px solid var(--primary);
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.1);
        }
        
        .btn-secondary:hover {
            background: var(--primary);
            color: var(--white);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(59, 130, 246, 0.3);
        }
        
        .btn-lg {
            padding: 1.125rem 2.5rem;
            font-size: 1.125rem;
            border-radius: 1rem;
        }
        
        /* Logo */
        .w-10 { width: 2.5rem; }
        .h-10 { height: 2.5rem; }
        .w-6 { width: 1.5rem; }
        .h-6 { height: 1.5rem; }
        .rounded-lg { border-radius: 0.5rem; }
        .bg-gradient-to-br { 
            background: linear-gradient(to bottom right, #3B82F6, #2563EB);
        }
        
        /* Enhanced Cards */
        .card {
            background: linear-gradient(145deg, rgba(255, 255, 255, 0.9), rgba(255, 255, 255, 0.95));
            border-radius: 1.25rem;
            padding: 2.5rem;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08), 0 4px 16px rgba(0, 0, 0, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }
        
        .card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #3B82F6, #10B981, #F59E0B);
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        
        .card:hover::before {
            opacity: 1;
        }
        
        .card:hover {
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.12), 0 8px 24px rgba(0, 0, 0, 0.08);
            transform: translateY(-8px) scale(1.02);
            border-color: rgba(59, 130, 246, 0.2);
        }
        
        /* Feature Cards with Icons */
        .feature-card {
            background: linear-gradient(145deg, rgba(255, 255, 255, 0.95), rgba(255, 255, 255, 1));
            border-radius: 1rem;
            padding: 2rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
            border: 1px solid rgba(59, 130, 246, 0.1);
            transition: all 0.3s ease;
            position: relative;
        }
        
        .feature-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.1);
            border-color: rgba(59, 130, 246, 0.2);
        }
        
        /* Dashboard Mockup Cards */
        .dashboard-card {
            background: linear-gradient(145deg, #FFFFFF, #F8FAFC);
            border-radius: 1rem;
            padding: 1.5rem;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1), inset 0 1px 0 rgba(255, 255, 255, 0.6);
            border: 1px solid rgba(59, 130, 246, 0.15);
            position: relative;
            overflow: hidden;
        }
        
        .dashboard-card::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(59, 130, 246, 0.03) 0%, transparent 70%);
            animation: shimmer 3s ease-in-out infinite;
        }
        
        @keyframes shimmer {
            0%, 100% { transform: rotate(0deg); }
            50% { transform: rotate(180deg); }
        }
        
        /* Scroll Animations */
        .fade-in-up {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .fade-in-up.animate {
            opacity: 1;
            transform: translateY(0);
        }
        
        .fade-in-left {
            opacity: 0;
            transform: translateX(-30px);
            transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .fade-in-left.animate {
            opacity: 1;
            transform: translateX(0);
        }
        
        .fade-in-right {
            opacity: 0;
            transform: translateX(30px);
            transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .fade-in-right.animate {
            opacity: 1;
            transform: translateX(0);
        }
        
        /* Enhanced Footer */
        footer {
            background: linear-gradient(135deg, #1F2937 0%, #111827 100%);
            color: var(--gray-300);
            position: relative;
            overflow: hidden;
        }
        
        footer::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, #3B82F6, transparent);
        }
        
        footer a {
            color: var(--gray-400);
            text-decoration: none;
            transition: color 0.3s ease;
        }
        
        footer a:hover {
            color: #3B82F6;
        }
        
        /* Social Icons */
        .social-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background: rgba(59, 130, 246, 0.1);
            border-radius: 50%;
            color: var(--gray-400);
            transition: all 0.3s ease;
        }
        
        .social-icon:hover {
            background: #3B82F6;
            color: white;
            transform: translateY(-2px);
        }
        
        /* CTA Section Enhancement */
        .cta-section {
            background: linear-gradient(135deg, #3B82F6 0%, #2563EB 50%, #1D4ED8 100%);
            position: relative;
            overflow: hidden;
        }
        
        .cta-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="50" cy="50" r="1" fill="%23ffffff" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            opacity: 0.1;
        }
        
        /* Floating Elements */
        .floating {
            animation: float 6s ease-in-out infinite;
        }
        
        .floating:nth-child(2) {
            animation-delay: -2s;
        }
        
        .floating:nth-child(3) {
            animation-delay: -4s;
        }
        
        @keyframes float {
            0%, 100% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-20px);
            }
        }
        
        /* Responsive Design */
        @media (min-width: 1024px) {
            .lg\:grid-cols-2 {
                grid-template-columns: repeat(2, 1fr);
            }
            .lg\:flex {
                display: flex;
            }
            .lg\:px-8 {
                padding-left: 2rem;
                padding-right: 2rem;
            }
        }
        
        @media (min-width: 640px) {
            .sm\:flex-row {
                flex-direction: row;
            }
            .sm\:px-6 {
                padding-left: 1.5rem;
                padding-right: 1.5rem;
            }
        }
        
        @media (max-width: 1023px) {
            .lg\:grid-cols-2 {
                grid-template-columns: 1fr;
            }
            .section-hero {
                padding: 6rem 0 3rem;
                min-height: 80vh;
            }
        }
        
        @media (max-width: 768px) {
            .section-hero {
                padding: 5rem 0 2rem;
                min-height: 70vh;
            }
            
            h1, .text-5xl {
                font-size: 2rem;
                line-height: 1.1;
            }
            
            h2, .text-4xl {
                font-size: 1.75rem;
            }
            
            .text-xl {
                font-size: 1.125rem;
            }
            
            .btn {
                width: 100%;
                justify-content: center;
            }
            
            .flex-col {
                flex-direction: column;
            }
            
            .gap-12 {
                gap: 2rem;
            }
            
            .space-y-8 > * + * {
                margin-top: 1.5rem;
            }
        }
        
        /* Missing Navigation Classes */
        .fixed { position: fixed; }
        .top-0 { top: 0; }
        .left-0 { left: 0; }
        .right-0 { right: 0; }
        .bg-white { background-color: var(--white); }
        .shadow-sm { box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05); }
        .z-50 { z-index: 50; }
        .transition-all { transition: all 0.3s ease; }
        .duration-300 { transition-duration: 300ms; }
        
        /* Logo and Icon Classes */
        .text-xl { font-size: 1.25rem; }
        .text-white { color: var(--white); }
        .stroke-2 { stroke-width: 2; }
        .stroke-current { stroke: currentColor; }
        .fill-none { fill: none; }
        
        /* Complete Tailwind Utility Classes */
        .w-4 { width: 1rem; }
        .w-5 { width: 1.25rem; }
        .w-8 { width: 2rem; }
        .w-12 { width: 3rem; }
        .w-16 { width: 4rem; }
        .w-20 { width: 5rem; }
        .w-24 { width: 6rem; }
        .w-32 { width: 8rem; }
        .w-48 { width: 12rem; }
        .w-56 { width: 14rem; }
        .w-64 { width: 16rem; }
        .w-full { width: 100%; }
        .w-auto { width: auto; }
        
        .h-4 { height: 1rem; }
        .h-5 { height: 1.25rem; }
        .h-8 { height: 2rem; }
        .h-12 { height: 3rem; }
        .h-16 { height: 4rem; }
        .h-20 { height: 5rem; }
        .h-24 { height: 6rem; }
        .h-32 { height: 8rem; }
        .h-48 { height: 12rem; }
        .h-64 { height: 16rem; }
        .h-full { height: 100%; }
        .h-screen { height: 100vh; }
        .min-h-screen { min-height: 100vh; }
        
        /* Spacing - Margin */
        .m-0 { margin: 0; }
        .m-1 { margin: 0.25rem; }
        .m-2 { margin: 0.5rem; }
        .m-3 { margin: 0.75rem; }
        .m-4 { margin: 1rem; }
        .m-6 { margin: 1.5rem; }
        .m-8 { margin: 2rem; }
        .mx-1 { margin-left: 0.25rem; margin-right: 0.25rem; }
        .mx-2 { margin-left: 0.5rem; margin-right: 0.5rem; }
        .mx-3 { margin-left: 0.75rem; margin-right: 0.75rem; }
        .mx-4 { margin-left: 1rem; margin-right: 1rem; }
        .mx-6 { margin-left: 1.5rem; margin-right: 1.5rem; }
        .mx-8 { margin-left: 2rem; margin-right: 2rem; }
        .my-2 { margin-top: 0.5rem; margin-bottom: 0.5rem; }
        .my-4 { margin-top: 1rem; margin-bottom: 1rem; }
        .my-6 { margin-top: 1.5rem; margin-bottom: 1.5rem; }
        .my-8 { margin-top: 2rem; margin-bottom: 2rem; }
        .my-12 { margin-top: 3rem; margin-bottom: 3rem; }
        .my-16 { margin-top: 4rem; margin-bottom: 4rem; }
        .my-20 { margin-top: 5rem; margin-bottom: 5rem; }
        .mt-1 { margin-top: 0.25rem; }
        .mt-2 { margin-top: 0.5rem; }
        .mt-3 { margin-top: 0.75rem; }
        .mt-4 { margin-top: 1rem; }
        .mt-6 { margin-top: 1.5rem; }
        .mt-8 { margin-top: 2rem; }
        .mt-12 { margin-top: 3rem; }
        .mt-16 { margin-top: 4rem; }
        .mt-20 { margin-top: 5rem; }
        .mb-1 { margin-bottom: 0.25rem; }
        .mb-2 { margin-bottom: 0.5rem; }
        .mb-3 { margin-bottom: 0.75rem; }
        .mb-4 { margin-bottom: 1rem; }
        .mb-6 { margin-bottom: 1.5rem; }
        .mb-8 { margin-bottom: 2rem; }
        .mb-12 { margin-bottom: 3rem; }
        .mb-16 { margin-bottom: 4rem; }
        .mb-20 { margin-bottom: 5rem; }
        .ml-1 { margin-left: 0.25rem; }
        .ml-2 { margin-left: 0.5rem; }
        .ml-3 { margin-left: 0.75rem; }
        .ml-4 { margin-left: 1rem; }
        .ml-6 { margin-left: 1.5rem; }
        .ml-8 { margin-left: 2rem; }
        .mr-1 { margin-right: 0.25rem; }
        .mr-2 { margin-right: 0.5rem; }
        .mr-3 { margin-right: 0.75rem; }
        .mr-4 { margin-right: 1rem; }
        .mr-6 { margin-right: 1.5rem; }
        .mr-8 { margin-right: 2rem; }
        
        /* Spacing - Padding */
        .p-0 { padding: 0; }
        .p-1 { padding: 0.25rem; }
        .p-2 { padding: 0.5rem; }
        .p-3 { padding: 0.75rem; }
        .p-4 { padding: 1rem; }
        .p-5 { padding: 1.25rem; }
        .p-6 { padding: 1.5rem; }
        .p-8 { padding: 2rem; }
        .p-10 { padding: 2.5rem; }
        .p-12 { padding: 3rem; }
        .px-1 { padding-left: 0.25rem; padding-right: 0.25rem; }
        .px-2 { padding-left: 0.5rem; padding-right: 0.5rem; }
        .px-3 { padding-left: 0.75rem; padding-right: 0.75rem; }
        .px-4 { padding-left: 1rem; padding-right: 1rem; }
        .px-5 { padding-left: 1.25rem; padding-right: 1.25rem; }
        .px-6 { padding-left: 1.5rem; padding-right: 1.5rem; }
        .px-8 { padding-left: 2rem; padding-right: 2rem; }
        .px-10 { padding-left: 2.5rem; padding-right: 2.5rem; }
        .px-12 { padding-left: 3rem; padding-right: 3rem; }
        .py-1 { padding-top: 0.25rem; padding-bottom: 0.25rem; }
        .py-2 { padding-top: 0.5rem; padding-bottom: 0.5rem; }
        .py-3 { padding-top: 0.75rem; padding-bottom: 0.75rem; }
        .py-4 { padding-top: 1rem; padding-bottom: 1rem; }
        .py-5 { padding-top: 1.25rem; padding-bottom: 1.25rem; }
        .py-6 { padding-top: 1.5rem; padding-bottom: 1.5rem; }
        .py-8 { padding-top: 2rem; padding-bottom: 2rem; }
        .py-10 { padding-top: 2.5rem; padding-bottom: 2.5rem; }
        .py-12 { padding-top: 3rem; padding-bottom: 3rem; }
        .py-16 { padding-top: 4rem; padding-bottom: 4rem; }
        .py-20 { padding-top: 5rem; padding-bottom: 5rem; }
        .py-24 { padding-top: 6rem; padding-bottom: 6rem; }
        .pt-4 { padding-top: 1rem; }
        .pt-6 { padding-top: 1.5rem; }
        .pt-8 { padding-top: 2rem; }
        .pt-12 { padding-top: 3rem; }
        .pt-16 { padding-top: 4rem; }
        .pt-20 { padding-top: 5rem; }
        .pt-24 { padding-top: 6rem; }
        .pb-4 { padding-bottom: 1rem; }
        .pb-6 { padding-bottom: 1.5rem; }
        .pb-8 { padding-bottom: 2rem; }
        .pb-12 { padding-bottom: 3rem; }
        .pb-16 { padding-bottom: 4rem; }
        .pb-20 { padding-bottom: 5rem; }
        .pb-24 { padding-bottom: 6rem; }
        
        /* Colors - Text */
        .text-gray-50 { color: var(--gray-50); }
        .text-gray-100 { color: var(--gray-100); }
        .text-gray-200 { color: var(--gray-200); }
        .text-gray-300 { color: var(--gray-300); }
        .text-gray-400 { color: var(--gray-400); }
        .text-gray-500 { color: var(--gray-500); }
        .text-gray-600 { color: var(--gray-600); }
        .text-gray-700 { color: var(--gray-700); }
        .text-gray-800 { color: var(--gray-800); }
        .text-gray-900 { color: var(--gray-900); }
        .text-blue-50 { color: var(--blue-50); }
        .text-blue-600 { color: var(--blue-600); }
        .text-green-600 { color: var(--secondary); }
        .text-yellow-600 { color: var(--accent); }
        .text-red-600 { color: #DC2626; }
        
        /* Colors - Background */
        .bg-transparent { background-color: transparent; }
        .bg-white { background-color: var(--white); }
        .bg-gray-50 { background-color: var(--gray-50); }
        .bg-gray-100 { background-color: var(--gray-100); }
        .bg-gray-200 { background-color: var(--gray-200); }
        .bg-gray-800 { background-color: var(--gray-800); }
        .bg-gray-900 { background-color: var(--gray-900); }
        .bg-blue-50 { background-color: var(--blue-50); }
        .bg-blue-600 { background-color: var(--primary); }
        .bg-blue-700 { background-color: var(--primary-dark); }
        .bg-green-50 { background-color: #F0FDF4; }
        .bg-green-600 { background-color: var(--secondary); }
        .bg-indigo-50 { background-color: #EEF2FF; }
        .bg-indigo-100 { background-color: var(--indigo-100); }
        .bg-red-50 { background-color: #FEF2F2; }
        .bg-yellow-50 { background-color: #FFFBEB; }
        
        /* Gradients */
        .bg-gradient-to-r { background: linear-gradient(to right, var(--primary), var(--primary-dark)); }
        .bg-gradient-to-br { background: linear-gradient(to bottom right, var(--blue-50), var(--indigo-100)); }
        .from-blue-50 { --tw-gradient-from: var(--blue-50); }
        .to-indigo-100 { --tw-gradient-to: var(--indigo-100); }
        .from-blue-600 { --tw-gradient-from: var(--primary); }
        .to-blue-700 { --tw-gradient-to: var(--primary-dark); }
        
        /* Borders */
        .border { border-width: 1px; }
        .border-2 { border-width: 2px; }
        .border-4 { border-width: 4px; }
        .border-t { border-top-width: 1px; }
        .border-b { border-bottom-width: 1px; }
        .border-l { border-left-width: 1px; }
        .border-r { border-right-width: 1px; }
        .border-transparent { border-color: transparent; }
        .border-white { border-color: var(--white); }
        .border-gray-100 { border-color: var(--gray-100); }
        .border-gray-200 { border-color: var(--gray-200); }
        .border-gray-300 { border-color: var(--gray-300); }
        .border-blue-600 { border-color: var(--primary); }
        
        /* Border Radius */
        .rounded { border-radius: 0.25rem; }
        .rounded-sm { border-radius: 0.125rem; }
        .rounded-md { border-radius: 0.375rem; }
        .rounded-lg { border-radius: 0.5rem; }
        .rounded-xl { border-radius: 0.75rem; }
        .rounded-2xl { border-radius: 1rem; }
        .rounded-3xl { border-radius: 1.5rem; }
        .rounded-full { border-radius: 9999px; }
        .rounded-t-lg { border-top-left-radius: 0.5rem; border-top-right-radius: 0.5rem; }
        .rounded-b-lg { border-bottom-left-radius: 0.5rem; border-bottom-right-radius: 0.5rem; }
        
        /* Shadows */
        .shadow { box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06); }
        .shadow-sm { box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05); }
        .shadow-md { box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); }
        .shadow-lg { box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05); }
        .shadow-xl { box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04); }
        .shadow-2xl { box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); }
        .shadow-inner { box-shadow: inset 0 2px 4px 0 rgba(0, 0, 0, 0.06); }
        .shadow-none { box-shadow: none; }
        
        /* Effects */
        .opacity-0 { opacity: 0; }
        .opacity-25 { opacity: 0.25; }
        .opacity-50 { opacity: 0.5; }
        .opacity-75 { opacity: 0.75; }
        .opacity-100 { opacity: 1; }
        .blur { filter: blur(8px); }
        .backdrop-blur { backdrop-filter: blur(8px); }
        .backdrop-blur-sm { backdrop-filter: blur(4px); }
        .backdrop-blur-md { backdrop-filter: blur(12px); }
        .backdrop-blur-lg { backdrop-filter: blur(16px); }
        
        /* Positioning */
        .static { position: static; }
        .fixed { position: fixed; }
        .absolute { position: absolute; }
        .relative { position: relative; }
        .sticky { position: sticky; }
        .inset-0 { top: 0; right: 0; bottom: 0; left: 0; }
        .top-0 { top: 0; }
        .top-1 { top: 0.25rem; }
        .top-2 { top: 0.5rem; }
        .top-4 { top: 1rem; }
        .right-0 { right: 0; }
        .right-2 { right: 0.5rem; }
        .right-4 { right: 1rem; }
        .bottom-0 { bottom: 0; }
        .bottom-2 { bottom: 0.5rem; }
        .bottom-4 { bottom: 1rem; }
        .left-0 { left: 0; }
        .left-2 { left: 0.5rem; }
        .left-4 { left: 1rem; }
        
        /* Z-Index */
        .z-0 { z-index: 0; }
        .z-10 { z-index: 10; }
        .z-20 { z-index: 20; }
        .z-30 { z-index: 30; }
        .z-40 { z-index: 40; }
        .z-50 { z-index: 50; }
        .z-auto { z-index: auto; }
        
        /* Display */
        .block { display: block; }
        .inline-block { display: inline-block; }
        .inline { display: inline; }
        .flex { display: flex; }
        .inline-flex { display: inline-flex; }
        .table { display: table; }
        .grid { display: grid; }
        .hidden { display: none; }
        
        /* Visibility */
        .visible { visibility: visible; }
        .invisible { visibility: hidden; }
        
        /* Flexbox */
        .flex-row { flex-direction: row; }
        .flex-col { flex-direction: column; }
        .flex-wrap { flex-wrap: wrap; }
        .flex-nowrap { flex-wrap: nowrap; }
        .items-start { align-items: flex-start; }
        .items-end { align-items: flex-end; }
        .items-center { align-items: center; }
        .items-baseline { align-items: baseline; }
        .items-stretch { align-items: stretch; }
        .justify-start { justify-content: flex-start; }
        .justify-end { justify-content: flex-end; }
        .justify-center { justify-content: center; }
        .justify-between { justify-content: space-between; }
        .justify-around { justify-content: space-around; }
        .justify-evenly { justify-content: space-evenly; }
        .flex-1 { flex: 1 1 0%; }
        .flex-auto { flex: 1 1 auto; }
        .flex-initial { flex: 0 1 auto; }
        .flex-none { flex: none; }
        .flex-shrink-0 { flex-shrink: 0; }
        .flex-shrink { flex-shrink: 1; }
        .flex-grow-0 { flex-grow: 0; }
        .flex-grow { flex-grow: 1; }
        
        /* Grid */
        .grid-cols-1 { grid-template-columns: repeat(1, minmax(0, 1fr)); }
        .grid-cols-2 { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .grid-cols-3 { grid-template-columns: repeat(3, minmax(0, 1fr)); }
        .grid-cols-4 { grid-template-columns: repeat(4, minmax(0, 1fr)); }
        .grid-cols-6 { grid-template-columns: repeat(6, minmax(0, 1fr)); }
        .grid-cols-12 { grid-template-columns: repeat(12, minmax(0, 1fr)); }
        .col-span-1 { grid-column: span 1 / span 1; }
        .col-span-2 { grid-column: span 2 / span 2; }
        .col-span-3 { grid-column: span 3 / span 3; }
        .col-span-4 { grid-column: span 4 / span 4; }
        .col-span-6 { grid-column: span 6 / span 6; }
        .col-span-12 { grid-column: span 12 / span 12; }
        .gap-1 { gap: 0.25rem; }
        .gap-2 { gap: 0.5rem; }
        .gap-3 { gap: 0.75rem; }
        .gap-4 { gap: 1rem; }
        .gap-5 { gap: 1.25rem; }
        .gap-6 { gap: 1.5rem; }
        .gap-8 { gap: 2rem; }
        .gap-10 { gap: 2.5rem; }
        .gap-12 { gap: 3rem; }
        .gap-16 { gap: 4rem; }
        .gap-x-4 { column-gap: 1rem; }
        .gap-x-6 { column-gap: 1.5rem; }
        .gap-x-8 { column-gap: 2rem; }
        .gap-y-4 { row-gap: 1rem; }
        .gap-y-6 { row-gap: 1.5rem; }
        .gap-y-8 { row-gap: 2rem; }
        
        /* Typography */
        .text-xs { font-size: 0.75rem; }
        .text-sm { font-size: 0.875rem; }
        .text-base { font-size: 1rem; }
        .text-lg { font-size: 1.125rem; }
        .text-xl { font-size: 1.25rem; }
        .text-2xl { font-size: 1.5rem; }
        .text-3xl { font-size: 1.875rem; }
        .text-4xl { font-size: 2.25rem; }
        .text-5xl { font-size: 3rem; }
        .text-6xl { font-size: 3.75rem; }
        .font-thin { font-weight: 100; }
        .font-extralight { font-weight: 200; }
        .font-light { font-weight: 300; }
        .font-normal { font-weight: 400; }
        .font-medium { font-weight: 500; }
        .font-semibold { font-weight: 600; }
        .font-bold { font-weight: 700; }
        .font-extrabold { font-weight: 800; }
        .font-black { font-weight: 900; }
        .italic { font-style: italic; }
        .not-italic { font-style: normal; }
        .uppercase { text-transform: uppercase; }
        .lowercase { text-transform: lowercase; }
        .capitalize { text-transform: capitalize; }
        .normal-case { text-transform: none; }
        .underline { text-decoration: underline; }
        .no-underline { text-decoration: none; }
        .text-left { text-align: left; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .text-justify { text-align: justify; }
        .leading-none { line-height: 1; }
        .leading-tight { line-height: 1.25; }
        .leading-snug { line-height: 1.375; }
        .leading-normal { line-height: 1.5; }
        .leading-relaxed { line-height: 1.625; }
        .leading-loose { line-height: 2; }
        
        /* Transforms */
        .transform { transform: translateX(0) translateY(0) rotate(0) skewX(0) skewY(0) scaleX(1) scaleY(1); }
        .translate-x-0 { transform: translateX(0); }
        .translate-x-1 { transform: translateX(0.25rem); }
        .translate-x-2 { transform: translateX(0.5rem); }
        .translate-x-4 { transform: translateX(1rem); }
        .-translate-x-1 { transform: translateX(-0.25rem); }
        .-translate-x-2 { transform: translateX(-0.5rem); }
        .-translate-x-4 { transform: translateX(-1rem); }
        .translate-y-0 { transform: translateY(0); }
        .translate-y-1 { transform: translateY(0.25rem); }
        .translate-y-2 { transform: translateY(0.5rem); }
        .translate-y-4 { transform: translateY(1rem); }
        .-translate-y-1 { transform: translateY(-0.25rem); }
        .-translate-y-2 { transform: translateY(-0.5rem); }
        .-translate-y-4 { transform: translateY(-1rem); }
        .rotate-0 { transform: rotate(0deg); }
        .rotate-1 { transform: rotate(1deg); }
        .rotate-2 { transform: rotate(2deg); }
        .rotate-3 { transform: rotate(3deg); }
        .rotate-6 { transform: rotate(6deg); }
        .rotate-12 { transform: rotate(12deg); }
        .-rotate-1 { transform: rotate(-1deg); }
        .-rotate-2 { transform: rotate(-2deg); }
        .-rotate-3 { transform: rotate(-3deg); }
        .scale-0 { transform: scale(0); }
        .scale-50 { transform: scale(0.5); }
        .scale-75 { transform: scale(0.75); }
        .scale-90 { transform: scale(0.9); }
        .scale-95 { transform: scale(0.95); }
        .scale-100 { transform: scale(1); }
        .scale-105 { transform: scale(1.05); }
        .scale-110 { transform: scale(1.1); }
        .scale-125 { transform: scale(1.25); }
        
        /* Transitions */
        .transition { transition-property: color, background-color, border-color, text-decoration-color, fill, stroke, opacity, box-shadow, transform, filter, backdrop-filter; }
        .transition-none { transition-property: none; }
        .transition-all { transition-property: all; }
        .transition-colors { transition-property: color, background-color, border-color, text-decoration-color, fill, stroke; }
        .transition-opacity { transition-property: opacity; }
        .transition-shadow { transition-property: box-shadow; }
        .transition-transform { transition-property: transform; }
        .duration-75 { transition-duration: 75ms; }
        .duration-100 { transition-duration: 100ms; }
        .duration-150 { transition-duration: 150ms; }
        .duration-200 { transition-duration: 200ms; }
        .duration-300 { transition-duration: 300ms; }
        .duration-500 { transition-duration: 500ms; }
        .duration-700 { transition-duration: 700ms; }
        .duration-1000 { transition-duration: 1000ms; }
        .ease-linear { transition-timing-function: linear; }
        .ease-in { transition-timing-function: cubic-bezier(0.4, 0, 1, 1); }
        .ease-out { transition-timing-function: cubic-bezier(0, 0, 0.2, 1); }
        .ease-in-out { transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1); }
        
        /* Hover States */
        .hover\:bg-gray-50:hover { background-color: var(--gray-50); }
        .hover\:bg-gray-100:hover { background-color: var(--gray-100); }
        .hover\:bg-blue-50:hover { background-color: var(--blue-50); }
        .hover\:bg-blue-600:hover { background-color: var(--primary); }
        .hover\:bg-blue-700:hover { background-color: var(--primary-dark); }
        .hover\:bg-green-50:hover { background-color: #F0FDF4; }
        .hover\:bg-red-50:hover { background-color: #FEF2F2; }
        .hover\:text-blue-600:hover { color: var(--primary); }
        .hover\:text-blue-700:hover { color: var(--primary-dark); }
        .hover\:text-gray-900:hover { color: var(--gray-900); }
        .hover\:text-red-600:hover { color: #DC2626; }
        .hover\:text-white:hover { color: var(--white); }
        .hover\:shadow-md:hover { box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); }
        .hover\:shadow-lg:hover { box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05); }
        .hover\:shadow-xl:hover { box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04); }
        .hover\:-translate-y-1:hover { transform: translateY(-0.25rem); }
        .hover\:-translate-y-2:hover { transform: translateY(-0.5rem); }
        .hover\:scale-105:hover { transform: scale(1.05); }
        .hover\:scale-110:hover { transform: scale(1.1); }
        
        /* Group Hover States */
        .group:hover .group-hover\:opacity-100 { opacity: 1; }
        .group:hover .group-hover\:visible { visibility: visible; }
        .group:hover .group-hover\:translate-y-0 { transform: translateY(0); }
        .group:hover .group-hover\:scale-105 { transform: scale(1.05); }
        
        /* Focus States */
        .focus\:outline-none:focus { outline: 2px solid transparent; outline-offset: 2px; }
        .focus\:ring-2:focus { box-shadow: 0 0 0 2px var(--primary); }
        .focus\:ring-blue-500:focus { box-shadow: 0 0 0 2px var(--primary); }
        
        /* Navigation Menu Classes */
        .lg\:flex { display: none; }
        @media (min-width: 1024px) {
            .lg\:flex { display: flex; }
        }
        
        .text-gray-700 { color: var(--gray-700); }
        .hover\:text-blue-600:hover { color: var(--blue-600); }
        .font-medium { font-weight: 500; }
        .transition-colors { transition: color 0.3s ease; }
        
        /* Button Classes */
        .relative { position: relative; }
        .group { position: relative; }
        .px-3 { padding-left: 0.75rem; padding-right: 0.75rem; }
        .py-2 { padding-top: 0.5rem; padding-bottom: 0.5rem; }
        .rounded-lg { border-radius: 0.5rem; }
        .hover\:bg-gray-50:hover { background-color: var(--gray-50); }
        
        /* Dropdown Classes */
        .absolute { position: absolute; }
        .mt-2 { margin-top: 0.5rem; }
        .w-56 { width: 14rem; }
        .rounded-lg { border-radius: 0.5rem; }
        .shadow-lg { box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05); }
        .border { border-width: 1px; }
        .border-gray-200 { border-color: var(--gray-200); }
        .opacity-0 { opacity: 0; }
        .invisible { visibility: hidden; }
        .group:hover .group-hover\:opacity-100 { opacity: 1; }
        .group:hover .group-hover\:visible { visibility: visible; }
        .transform { transform: translateX(var(--tw-translate-x, 0)) translateY(var(--tw-translate-y, 0)) rotate(var(--tw-rotate, 0)) skewX(var(--tw-skew-x, 0)) skewY(var(--tw-skew-y, 0)) scaleX(var(--tw-scale-x, 1)) scaleY(var(--tw-scale-y, 1)); }
        .translate-y-2 { --tw-translate-y: 0.5rem; }
        .group:hover .group-hover\:translate-y-0 { --tw-translate-y: 0px; }
        
        /* Dropdown Items */
        .py-2 { padding-top: 0.5rem; padding-bottom: 0.5rem; }
        .px-4 { padding-left: 1rem; padding-right: 1rem; }
        .py-3 { padding-top: 0.75rem; padding-bottom: 0.75rem; }
        .text-sm { font-size: 0.875rem; }
        .hover\:bg-blue-50:hover { background-color: #EBF8FF; }
        .hover\:text-blue-600:hover { color: var(--blue-600); }
        .hover\:bg-red-50:hover { background-color: #FEF2F2; }
        .hover\:text-red-600:hover { color: #DC2626; }
        .text-blue-500 { color: #3B82F6; }
        .text-red-500 { color: #EF4444; }
        .mr-2 { margin-right: 0.5rem; }
        .mr-3 { margin-right: 0.75rem; }
        .ml-1 { margin-left: 0.25rem; }
        .w-4 { width: 1rem; }
        .h-4 { height: 1rem; }
        .text-xs { font-size: 0.75rem; }
        .text-gray-500 { color: var(--gray-500); }
        
        /* Hero Section Classes */
        .from-blue-50 { --tw-gradient-from: #EBF4FF; }
        .to-indigo-100 { --tw-gradient-to: #E0E7FF; }
        .bg-gradient-to-br { 
            background: linear-gradient(to bottom right, var(--tw-gradient-from, #EBF4FF), var(--tw-gradient-to, #E0E7FF));
        }
        
        /* Mobile Menu Classes */
        .lg\:hidden { display: block; }
        @media (min-width: 1024px) {
            .lg\:hidden { display: none; }
        }
        
        .pb-4 { padding-bottom: 1rem; }
        .border-t { border-top-width: 1px; }
        .border-gray-200 { border-color: var(--gray-200); }
        .mt-4 { margin-top: 1rem; }
        .pt-4 { padding-top: 1rem; }
        
        /* Hidden classes */
        .hidden { display: none; }
        
        /* Additional Missing Classes */
        .w-5 { width: 1.25rem; }
        .h-5 { height: 1.25rem; }
        .w-8 { width: 2rem; }
        .h-8 { height: 2rem; }
        .bg-blue-500 { background-color: #3B82F6; }
        .bg-green-500 { background-color: #10B981; }
        .bg-purple-500 { background-color: #8B5CF6; }
        .border-2 { border-width: 2px; }
        .border-white { border-color: var(--white); }
        .-space-x-2 > * + * { margin-left: -0.5rem; }
        .font-semibold { font-weight: 600; }
        
        /* Button and Link Styling */
        .btn, .btn-primary, .btn-secondary {
            text-decoration: none !important;
            color: inherit;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: var(--white) !important;
        }
        
        .btn-secondary {
            background: transparent;
            color: var(--primary) !important;
            border: 2px solid var(--primary);
        }
        
        .btn-secondary:hover {
            background: var(--primary);
            color: var(--white) !important;
        }
        
        /* SVG Icons */
        svg {
            display: inline-block;
            vertical-align: middle;
        }
        
        /* Logo Gradient Fix */
        .bg-gradient-to-br {
            background: linear-gradient(135deg, #3B82F6 0%, #2563EB 100%);
        }
        
        /* Hero Content Spacing */
        .space-y-4 > * + * { margin-top: 1rem; }
        .space-y-8 > * + * { margin-top: 2rem; }
        .gap-4 { gap: 1rem; }
        
        /* Text Colors */
        .text-gray-900 { color: #1F2937; }
        .text-gray-600 { color: #4B5563; }
        .text-blue-600 { color: #2563EB; }
        
        /* Responsive Grid for Hero */
        @media (min-width: 1024px) {
            .lg\:grid-cols-2 {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        
        /* Hero Section - Restored Beautiful Layout */
        .section-hero {
            background: linear-gradient(135deg, #EBF4FF 0%, #E0E7FF 50%, #F0FDF4 100%) !important;
            min-height: 100vh !important;
            display: flex !important;
            align-items: center !important;
            padding: 8rem 0 4rem !important;
            position: relative !important;
            overflow: hidden !important;
        }
        
        /* Hero Cards and Mockups */
        .hero-mockup {
            position: relative;
            transform: rotate(2deg);
            transition: transform 0.5s ease;
        }
        
        .hero-mockup:hover {
            transform: rotate(0deg);
        }
        
        .hero-card {
            background: white;
            border-radius: 1rem;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            padding: 1.5rem;
            margin-bottom: 1rem;
        }
        
        .hero-badge {
            position: absolute;
            top: -1rem;
            left: -1rem;
            width: 4rem;
            height: 4rem;
            background: linear-gradient(135deg, #10B981, #059669);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            animation: bounce 2s infinite;
        }
        
        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% {
                transform: translateY(0);
            }
            40% {
                transform: translateY(-10px);
            }
            60% {
                transform: translateY(-5px);
            }
        }
        
        /* Animations */
        .animate-on-scroll {
            opacity: 1;
            transform: translateY(0);
            transition: all 0.6s ease;
        }
        
        /* Fix for button hover states */
        .btn:hover {
            text-decoration: none;
        }
        
        /* Ensure proper z-index for header */
        header {
            z-index: 1000 !important;
        }
    </style>
    

</head>
<body>
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
    
    <!-- Success/Error Messages -->
    @if(session('success'))
        <div id="success-message" class="fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50">
            {{ session('success') }}
        </div>
    @endif
    
    @if($errors->any())
        <div id="error-message" class="fixed top-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg z-50">
            <ul class="list-none">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</body>
</html>
