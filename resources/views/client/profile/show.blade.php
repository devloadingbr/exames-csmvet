@extends('layouts.client')

@section('title', 'Meu Perfil')

@section('content')
<div class="container-app py-8" x-data="profileHandler">
    <!-- Hero Profile Header -->
    <div class="glass-card p-8 mb-8 bg-gradient-to-r from-client-50/50 via-client-100/30 to-blue-50/50 overflow-hidden relative animate-fade-in-up">
        <div class="flex flex-col md:flex-row md:items-center gap-6">
            <!-- Avatar com gradiente -->
            <div class="flex-shrink-0">
                <div class="w-20 h-20 rounded-full bg-gradient-primary flex items-center justify-center shadow-2xl shadow-client-500/20 ring-4 ring-white/50 backdrop-blur-sm">
                    <span class="text-2xl font-bold text-white">
                        {{ strtoupper(substr($client->name, 0, 1)) }}
                    </span>
                </div>
            </div>
            
            <!-- Info -->
            <div class="flex-1">
                <h1 class="text-4xl font-bold text-gradient mb-2">{{ $client->name }}</h1>
                <p class="text-client-600 mb-1 font-medium">
                    <svg class="w-4 h-4 inline mr-2 text-client-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                    </svg>
                    Cliente desde {{ $stats['member_since']->format('d/m/Y') }}
                </p>
                @if($stats['last_login'])
                <small class="text-gray-500 flex items-center">
                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                    </svg>
                    Último acesso: {{ $stats['last_login']->format('d/m/Y H:i') }}
                </small>
                @endif
            </div>
            
            <!-- Action -->
            <div class="flex-shrink-0">
                <a href="{{ route('client.profile.edit') }}" class="btn btn-primary hover-lift">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Editar Perfil
                </a>
            </div>
        </div>
        
        <!-- Background decorative elements -->
        <div class="absolute -top-4 -right-4 w-24 h-24 bg-gradient-to-br from-client-400/20 to-blue-400/20 rounded-full blur-xl"></div>
        <div class="absolute -bottom-4 -left-4 w-32 h-32 bg-gradient-to-tr from-purple-400/10 to-client-400/10 rounded-full blur-2xl"></div>
    </div>

    <!-- Information Grid -->
    <div class="grid lg:grid-cols-2 xl:grid-cols-3 gap-8 mb-8">
        <!-- Personal Information -->
        <div class="glass-card p-6 animate-fade-in-up animation-delay-100 hover-lift">
            <h3 class="title-card mb-6 flex items-center text-client-700">
                <div class="w-10 h-10 bg-gradient-primary rounded-xl flex items-center justify-center mr-3 shadow-lg">
                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                Informações Pessoais
            </h3>
            
            <div class="space-y-4">
                @foreach([
                    ['Nome completo', $client->name],
                    ['CPF', $client->cpf],
                    ['Data de Nascimento', $client->birth_date->format('d/m/Y')],
                    ['Email', $client->email ?: 'Não informado'],
                    ['Telefone', $client->phone ?: 'Não informado']
                ] as $info)
                <div class="flex justify-between items-center py-3 border-b border-gray-100 dark:border-gray-700 last:border-0">
                    <span class="text-sm font-medium text-gray-600 dark:text-gray-400">{{ $info[0] }}:</span>
                    <span class="text-sm text-gray-900 dark:text-gray-100 font-semibold text-right max-w-xs truncate">{{ $info[1] }}</span>
                </div>
                @endforeach
            </div>
        </div>
        
        <!-- Address Information -->
        <div class="glass-card p-6 animate-fade-in-up animation-delay-200 hover-lift">
            <h3 class="title-card mb-6 flex items-center text-client-700">
                <div class="w-10 h-10 bg-gradient-secondary rounded-xl flex items-center justify-center mr-3 shadow-lg">
                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                Endereço
            </h3>
            
            <div class="space-y-4">
                @foreach([
                    ['Endereço', $client->address ?: 'Não informado'],
                    ['Cidade', $client->city ?: 'Não informado'],
                    ['Estado', $client->state ?: 'Não informado'],
                    ['CEP', $client->zip_code ?: 'Não informado']
                ] as $info)
                <div class="flex justify-between items-center py-3 border-b border-gray-100 dark:border-gray-700 last:border-0">
                    <span class="text-sm font-medium text-gray-600 dark:text-gray-400">{{ $info[0] }}:</span>
                    <span class="text-sm text-gray-900 dark:text-gray-100 font-semibold text-right max-w-xs truncate">{{ $info[1] }}</span>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Statistics -->
        <div class="glass-card p-6 animate-fade-in-up animation-delay-300 hover-lift">
            <h3 class="title-card mb-6 flex items-center text-client-700">
                <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center mr-3 shadow-lg">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
                Estatísticas
            </h3>
            
            <div class="grid grid-cols-2 gap-4">
                @foreach([
                    [$stats['total_pets'], 'Pets', 'text-green-600', 'from-green-500', 'to-green-600'],
                    [$stats['total_exams'], 'Exames', 'text-blue-600', 'from-blue-500', 'to-blue-600'],
                    [$stats['download_stats']['total_downloads'], 'Downloads', 'text-purple-600', 'from-purple-500', 'to-purple-600'],
                    [$stats['download_stats']['downloads_this_month'], 'Este mês', 'text-orange-600', 'from-orange-500', 'to-orange-600']
                ] as $stat)
                <div class="text-center p-4 bg-gradient-to-br {{ $stat[3] }}/10 {{ $stat[4] }}/20 rounded-2xl backdrop-blur-sm">
                    <div class="text-2xl font-bold {{ $stat[2] }} mb-1" x-data="{ count: 0 }" x-init="setInterval(() => count < {{ $stat[0] }} && count++, 50)" x-text="count">0</div>
                    <div class="text-xs font-medium text-gray-600 dark:text-gray-400">{{ $stat[1] }}</div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    
    <!-- Notifications Settings -->
    <div class="glass-card p-6 mb-8 animate-fade-in-up animation-delay-400" x-data="notificationSettings">
        <h3 class="title-card mb-6 flex items-center text-client-700">
            <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-xl flex items-center justify-center mr-3 shadow-lg">
                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"></path>
                </svg>
            </div>
            Preferências de Notificação
        </h3>
        
        <div class="space-y-4">
            <label class="flex items-center justify-between p-4 bg-white/50 dark:bg-gray-800/50 rounded-xl border border-gray-100 dark:border-gray-700 cursor-pointer hover:bg-white/70 dark:hover:bg-gray-800/70 transition-all duration-300">
                <div class="flex items-center space-x-3">
                    <svg class="w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                    </svg>
                    <span class="font-medium text-gray-700 dark:text-gray-300">Receber notificações por email</span>
                </div>
                <input type="checkbox" 
                       x-model="emailNotifications"
                       @change="updateNotification('email', $event.target.checked)"
                       {{ $client->receive_email_notifications ? 'checked' : '' }}
                       class="w-5 h-5 text-client-600 bg-gray-100 border-gray-300 rounded focus:ring-client-500 focus:ring-2">
            </label>
            
            <label class="flex items-center justify-between p-4 bg-white/50 dark:bg-gray-800/50 rounded-xl border border-gray-100 dark:border-gray-700 cursor-pointer hover:bg-white/70 dark:hover:bg-gray-800/70 transition-all duration-300">
                <div class="flex items-center space-x-3">
                    <svg class="w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"></path>
                    </svg>
                    <span class="font-medium text-gray-700 dark:text-gray-300">Receber notificações por SMS</span>
                </div>
                <input type="checkbox" 
                       x-model="smsNotifications"
                       @change="updateNotification('sms', $event.target.checked)"
                       {{ $client->receive_sms_notifications ? 'checked' : '' }}
                       class="w-5 h-5 text-client-600 bg-gray-100 border-gray-300 rounded focus:ring-client-500 focus:ring-2">
            </label>
        </div>
        
        <!-- Status feedback -->
        <div x-show="updating" x-transition class="mt-4 p-3 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg">
            <div class="flex items-center">
                <svg class="animate-spin h-4 w-4 text-blue-600 mr-2" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span class="text-sm text-blue-700 dark:text-blue-300">Atualizando preferências...</span>
            </div>
        </div>
    </div>

    <!-- Recent Downloads -->
    @if(count($stats['recent_downloads']) > 0)
    <div class="glass-card p-6 mb-8 animate-fade-in-up animation-delay-500">
        <h3 class="title-card mb-6 flex items-center text-client-700">
            <div class="w-10 h-10 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl flex items-center justify-center mr-3 shadow-lg">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
            </div>
            Downloads Recentes
        </h3>
        
        <div class="space-y-3">
            @foreach($stats['recent_downloads'] as $download)
            <div class="flex items-center justify-between p-4 bg-white/50 dark:bg-gray-800/50 rounded-xl border border-gray-100 dark:border-gray-700 hover:bg-white/70 dark:hover:bg-gray-800/70 transition-all duration-300">
                <div class="flex-1">
                    <div class="font-semibold text-client-600 mb-1">{{ $download['exam_code'] }}</div>
                    <div class="text-sm text-gray-600 dark:text-gray-400">
                        {{ $download['exam_type'] }} - {{ $download['pet_name'] }}
                    </div>
                </div>
                <div class="text-right">
                    <div class="text-sm text-gray-500 dark:text-gray-400">
                        {{ $download['downloaded_at']->format('d/m/Y') }}
                    </div>
                    <div class="text-xs text-gray-400 dark:text-gray-500">
                        {{ $download['downloaded_at']->format('H:i') }}
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <div class="text-center mt-6">
            <a href="{{ route('client.profile.activity') }}" class="btn btn-secondary hover-lift">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Ver histórico completo
            </a>
        </div>
    </div>
    @endif

    <!-- Exams by Type Chart -->
    @if(count($examsByType) > 0)
    <div class="glass-card p-6 mb-8 animate-fade-in-up animation-delay-600">
        <h3 class="title-card mb-6 flex items-center text-client-700">
            <div class="w-10 h-10 bg-gradient-to-br from-pink-500 to-pink-600 rounded-xl flex items-center justify-center mr-3 shadow-lg">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
            </div>
            Exames por Tipo
        </h3>
        
        <div class="space-y-4" x-data="chartAnimation" x-init="animateCharts()">
            @php $total = array_sum($examsByType); @endphp
            @foreach($examsByType as $type => $count)
                @php $percentage = $total > 0 ? ($count / $total) * 100 : 0; @endphp
                <div class="space-y-2">
                    <div class="flex justify-between items-center">
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ $type }}</span>
                        <span class="text-sm font-bold text-client-600">{{ $count }}</span>
                    </div>
                    <div class="h-3 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden">
                        <div class="h-full bg-gradient-to-r from-client-500 to-client-600 rounded-full transition-all duration-1000 ease-out animate-shimmer"
                             x-ref="bar{{ $loop->index }}"
                             style="width: 0%" 
                             x-bind:style="`width: ${bars[{{ $loop->index }}] || 0}%`"
                             data-percentage="{{ $percentage }}">
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Quick Actions -->
    <div class="glass-card p-6 animate-fade-in-up animation-delay-700">
        <h3 class="title-card mb-6 flex items-center text-client-700">
            <div class="w-10 h-10 bg-gradient-to-br from-amber-500 to-amber-600 rounded-xl flex items-center justify-center mr-3 shadow-lg">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                </svg>
            </div>
            Ações Rápidas
        </h3>
        
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <a href="{{ route('client.dashboard') }}" class="glass-card p-6 text-center hover-lift group transition-all duration-300 border-2 border-transparent hover:border-client-300/50">
                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center mx-auto mb-3 shadow-lg group-hover:shadow-xl group-hover:scale-110 transition-all duration-300">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <div class="text-sm font-semibold text-gray-700 dark:text-gray-300 group-hover:text-client-600 transition-colors duration-300">Meus Exames</div>
            </a>
            
            <a href="{{ route('client.profile.edit') }}" class="glass-card p-6 text-center hover-lift group transition-all duration-300 border-2 border-transparent hover:border-client-300/50">
                <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl flex items-center justify-center mx-auto mb-3 shadow-lg group-hover:shadow-xl group-hover:scale-110 transition-all duration-300">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                </div>
                <div class="text-sm font-semibold text-gray-700 dark:text-gray-300 group-hover:text-client-600 transition-colors duration-300">Editar Perfil</div>
            </a>
            
            <a href="{{ route('client.profile.activity') }}" class="glass-card p-6 text-center hover-lift group transition-all duration-300 border-2 border-transparent hover:border-client-300/50">
                <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center mx-auto mb-3 shadow-lg group-hover:shadow-xl group-hover:scale-110 transition-all duration-300">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
                <div class="text-sm font-semibold text-gray-700 dark:text-gray-300 group-hover:text-client-600 transition-colors duration-300">Atividades</div>
            </a>
            
            <a href="{{ route('client.profile.help') }}" class="glass-card p-6 text-center hover-lift group transition-all duration-300 border-2 border-transparent hover:border-client-300/50">
                <div class="w-12 h-12 bg-gradient-to-br from-red-500 to-red-600 rounded-2xl flex items-center justify-center mx-auto mb-3 shadow-lg group-hover:shadow-xl group-hover:scale-110 transition-all duration-300">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="text-sm font-semibold text-gray-700 dark:text-gray-300 group-hover:text-client-600 transition-colors duration-300">Ajuda</div>
            </a>
        </div>
    </div>
</div>

<!-- Toast Notification -->
<div x-data="toastSystem" 
     x-show="show" 
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0 transform translate-x-full"
     x-transition:enter-end="opacity-100 transform translate-x-0"
     x-transition:leave="transition ease-in duration-300"
     x-transition:leave-start="opacity-100 transform translate-x-0"
     x-transition:leave-end="opacity-0 transform translate-x-full"
     class="fixed top-4 right-4 z-50 max-w-sm">
    <div class="glass-card p-4 border-2" 
         :class="{
             'border-green-300/50 bg-green-50/80': type === 'success',
             'border-red-300/50 bg-red-50/80': type === 'error',
             'border-blue-300/50 bg-blue-50/80': type === 'info'
         }">
        <div class="flex items-center">
            <template x-if="type === 'success'">
                <svg class="w-5 h-5 text-green-600 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
            </template>
            <template x-if="type === 'error'">
                <svg class="w-5 h-5 text-red-600 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                </svg>
            </template>
            <span class="text-sm font-medium" :class="{
                'text-green-800': type === 'success',
                'text-red-800': type === 'error',
                'text-blue-800': type === 'info'
            }" x-text="message"></span>
        </div>
    </div>
</div>

<script>
// Alpine.js Components
document.addEventListener('alpine:init', () => {
    // Profile Handler - Main Component
    Alpine.data('profileHandler', () => ({
        // Main profile state
    }))
    
    // Notification Settings Component
    Alpine.data('notificationSettings', () => ({
        emailNotifications: {{ $client->receive_email_notifications ? 'true' : 'false' }},
        smsNotifications: {{ $client->receive_sms_notifications ? 'true' : 'false' }},
        updating: false,
        
        async updateNotification(type, value) {
            this.updating = true;
            
            try {
                const response = await fetch('{{ route("client.profile.notifications") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        receive_email_notifications: this.emailNotifications,
                        receive_sms_notifications: this.smsNotifications
                    })
                });
                
                const data = await response.json();
                
                if (data.success) {
                    Alpine.store('toast').show('Preferências atualizadas com sucesso!', 'success');
                } else {
                    throw new Error('Erro na resposta do servidor');
                }
            } catch (error) {
                console.error('Erro:', error);
                Alpine.store('toast').show('Erro ao atualizar preferências', 'error');
                // Revert the change on error
                if (type === 'email') {
                    this.emailNotifications = !value;
                } else {
                    this.smsNotifications = !value;
                }
            } finally {
                this.updating = false;
            }
        }
    }))
    
    // Chart Animation Component
    Alpine.data('chartAnimation', () => ({
        bars: [],
        
        animateCharts() {
            // Animate chart bars with staggered timing
            document.querySelectorAll('[data-percentage]').forEach((bar, index) => {
                const percentage = bar.dataset.percentage;
                setTimeout(() => {
                    this.bars[index] = percentage;
                }, index * 200);
            });
        }
    }))
    
    // Toast System Component
    Alpine.data('toastSystem', () => ({
        show: false,
        message: '',
        type: 'success',
        
        init() {
            // Listen to global toast store
            this.$watch(() => Alpine.store('toast').show, (show) => {
                if (show) {
                    this.message = Alpine.store('toast').message;
                    this.type = Alpine.store('toast').type;
                    this.show = true;
                    
                    // Auto-hide after 4 seconds
                    setTimeout(() => {
                        this.show = false;
                        Alpine.store('toast').hide();
                    }, 4000);
                }
            });
        }
    }))
    
    // Global Toast Store
    Alpine.store('toast', {
        show: false,
        message: '',
        type: 'success',
        
        show(message, type = 'success') {
            this.message = message;
            this.type = type;
            this.show = true;
        },
        
        hide() {
            this.show = false;
        }
    });
});
</script>
@endsection