<section id="cta" class="section-lg bg-gradient-to-br from-blue-600 to-blue-700 text-white animate-on-scroll">
    <div class="container">
        <div class="max-w-4xl mx-auto text-center">
            <!-- Main CTA Header -->
            <div class="mb-12">
                <h2 class="text-4xl md:text-5xl font-bold mb-6 animate-child">
                    Pronto para <span class="text-yellow-300">revolucionar</span> 
                    sua clínica?
                </h2>
                <p class="text-xl text-blue-100 mb-8 animate-child">
                    Junte-se a centenas de veterinários que já transformaram 
                    a entrega de exames com a VetExams
                </p>
                
                <!-- Social Proof -->
                <div class="flex flex-wrap justify-center items-center gap-8 mb-12 animate-child">
                    <div class="text-center">
                        <div class="text-3xl font-bold text-yellow-300">500+</div>
                        <div class="text-sm text-blue-200">Clínicas ativas</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-yellow-300">50k+</div>
                        <div class="text-sm text-blue-200">Exames enviados</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-yellow-300">98%</div>
                        <div class="text-sm text-blue-200">Satisfação</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-yellow-300">4.9/5</div>
                        <div class="text-sm text-blue-200">Avaliação</div>
                    </div>
                </div>
            </div>

            <!-- Registration Form -->
            <div class="bg-white rounded-3xl shadow-2xl p-8 md:p-12 text-gray-900 animate-child">
                <div class="mb-8">
                    <h3 class="text-3xl font-bold text-gray-900 mb-4">
                        Comece seu teste grátis agora
                    </h3>
                    <p class="text-lg text-gray-600">
                        14 dias grátis • Sem cartão de crédito • Cancelamento fácil
                    </p>
                </div>

                <form id="trial-form" action="{{ route('landing.trial') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <div class="grid md:grid-cols-2 gap-6">
                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                Nome completo *
                            </label>
                            <input 
                                type="text" 
                                id="name" 
                                name="name" 
                                required
                                value="{{ old('name') }}"
                                class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors {{ $errors->has('name') ? 'border-red-500' : 'border-gray-300' }}"
                                placeholder="Dr. João Silva"
                            >
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                Email profissional *
                            </label>
                            <input 
                                type="email" 
                                id="email" 
                                name="email" 
                                required
                                value="{{ old('email') }}"
                                class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors {{ $errors->has('email') ? 'border-red-500' : 'border-gray-300' }}"
                                placeholder="joao@clinicaveterinaria.com"
                            >
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Clinic Name -->
                        <div>
                            <label for="clinic_name" class="block text-sm font-medium text-gray-700 mb-2">
                                Nome da clínica *
                            </label>
                            <input 
                                type="text" 
                                id="clinic_name" 
                                name="clinic_name" 
                                required
                                value="{{ old('clinic_name') }}"
                                class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors {{ $errors->has('clinic_name') ? 'border-red-500' : 'border-gray-300' }}"
                                placeholder="Clínica Veterinária Exemplo"
                            >
                            @error('clinic_name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Phone -->
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                                Telefone/WhatsApp *
                            </label>
                            <input 
                                type="tel" 
                                id="phone" 
                                name="phone" 
                                required
                                value="{{ old('phone') }}"
                                class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors {{ $errors->has('phone') ? 'border-red-500' : 'border-gray-300' }}"
                                placeholder="(11) 99999-9999"
                            >
                            @error('phone')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- City -->
                        <div>
                            <label for="city" class="block text-sm font-medium text-gray-700 mb-2">
                                Cidade *
                            </label>
                            <input 
                                type="text" 
                                id="city" 
                                name="city" 
                                required
                                value="{{ old('city') }}"
                                class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors {{ $errors->has('city') ? 'border-red-500' : 'border-gray-300' }}"
                                placeholder="São Paulo - SP"
                            >
                            @error('city')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Clinic Size -->
                        <div>
                            <label for="clinic_size" class="block text-sm font-medium text-gray-700 mb-2">
                                Porte da clínica *
                            </label>
                            <select 
                                id="clinic_size" 
                                name="clinic_size" 
                                required
                                class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors {{ $errors->has('clinic_size') ? 'border-red-500' : 'border-gray-300' }}"
                            >
                                <option value="">Selecione o porte</option>
                                <option value="small" {{ old('clinic_size') == 'small' ? 'selected' : '' }}>
                                    Pequena (1-2 veterinários)
                                </option>
                                <option value="medium" {{ old('clinic_size') == 'medium' ? 'selected' : '' }}>
                                    Média (3-10 veterinários)
                                </option>
                                <option value="large" {{ old('clinic_size') == 'large' ? 'selected' : '' }}>
                                    Grande (10+ veterinários)
                                </option>
                            </select>
                            @error('clinic_size')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Email Marketing Consent -->
                    <div class="flex items-start space-x-3">
                        <input 
                            type="checkbox" 
                            id="accept_emails" 
                            name="accept_emails" 
                            value="1"
                            {{ old('accept_emails') ? 'checked' : '' }}
                            class="mt-1 h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                        >
                        <label for="accept_emails" class="text-sm text-gray-600">
                            Aceito receber emails com dicas, novidades e ofertas especiais da VetExams. 
                            Você pode cancelar a qualquer momento.
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <button 
                        type="submit" 
                        class="w-full bg-gradient-to-r from-green-500 to-green-600 text-white font-bold py-4 px-8 rounded-lg hover:from-green-600 hover:to-green-700 transform hover:scale-105 transition-all duration-200 shadow-lg text-lg"
                        data-track="trial_form_submit"
                    >
                        <svg class="w-6 h-6 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        Começar Teste Grátis de 14 Dias
                    </button>

                    <!-- Form Footer -->
                    <div class="text-center text-sm text-gray-500 space-y-2">
                        <p>
                            ✅ Sem cartão de crédito • ✅ Cancelamento fácil • ✅ Suporte incluído
                        </p>
                        <p>
                            Ao se cadastrar, você concorda com nossos 
                            <a href="#" class="text-blue-600 hover:underline">Termos de Uso</a> e 
                            <a href="#" class="text-blue-600 hover:underline">Política de Privacidade</a>
                        </p>
                    </div>
                </form>
            </div>

            <!-- Guarantees -->
            <div class="mt-12 grid md:grid-cols-3 gap-8 animate-child">
                <div class="text-center">
                    <div class="bg-green-500 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h4 class="text-lg font-semibold mb-2">Garantia de Satisfação</h4>
                    <p class="text-blue-100 text-sm">
                        Se não ficar satisfeito nos primeiros 30 dias, 
                        devolvemos 100% do seu dinheiro
                    </p>
                </div>

                <div class="text-center">
                    <div class="bg-yellow-500 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </div>
                    <h4 class="text-lg font-semibold mb-2">Dados Seguros</h4>
                    <p class="text-blue-100 text-sm">
                        Criptografia de ponta, servidores no Brasil 
                        e conformidade total com a LGPD
                    </p>
                </div>

                <div class="text-center">
                    <div class="bg-orange-500 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M12 12h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h4 class="text-lg font-semibold mb-2">Suporte Especializado</h4>
                    <p class="text-blue-100 text-sm">
                        Equipe técnica dedicada e treinamento 
                        completo para sua equipe
                    </p>
                </div>
            </div>

            <!-- Urgency -->
            <div class="mt-12 bg-yellow-400 text-gray-900 rounded-2xl p-6 animate-child">
                <div class="flex items-center justify-center space-x-4">
                    <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div class="text-center">
                        <p class="font-bold text-lg">
                            🔥 Oferta limitada: Primeiros 100 cadastros ganham 1 mês extra grátis!
                        </p>
                        <p class="text-sm">
                            Restam apenas <span class="font-bold">23 vagas</span> • Termina em 48h
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
