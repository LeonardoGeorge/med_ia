@extends('layouts.app')

@section('title', 'Resultado - Med.IA')

@section('content')
<div class="min-h-screen bg-gray-50 py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <!-- Header -->
            <div class="bg-gradient-to-r from-indigo-600 to-indigo-700 px-8 py-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold text-white">Resultado do Diagnóstico</h1>
                            <p class="text-indigo-100">Análise baseada em inteligência artificial</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="text-indigo-100 text-sm">Data</div>
                        <div class="text-white font-medium">{{ now()->format('d/m/Y H:i') }}</div>
                    </div>
                </div>
            </div>

            <div class="p-8 space-y-8">
                <!-- Sintomas Analisados -->
                <div>
                    <h2 class="text-lg font-semibold text-gray-900 mb-3 flex items-center">
                        <svg class="w-5 h-5 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Sintomas Analisados
                    </h2>
                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                        <p class="text-gray-700">{{ $diagnostico['sintomas_analisados'] ?? 'Não informado' }}</p>
                    </div>
                </div>

                <!-- Diagnóstico -->
                @if(isset($diagnostico['diagnostico_provavel']))
                <div>
                    <h2 class="text-lg font-semibold text-gray-900 mb-3 flex items-center">
                        <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                        Diagnóstico Provável
                    </h2>
                    <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                        <p class="text-green-800 font-medium">{{ $diagnostico['diagnostico_provavel'] }}</p>
                    </div>
                </div>
                @endif

                <!-- Gravidade -->
                @if(isset($diagnostico['condicao_gravidade']))
                <div>
                    <h2 class="text-lg font-semibold text-gray-900 mb-3 flex items-center">
                        <svg class="w-5 h-5 text-yellow-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Gravidade da Condição
                    </h2>
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                        <p class="text-yellow-800 font-medium">
                            @if($diagnostico['condicao_gravidade'] == 'leve')
                                Condição Leve
                            @elseif($diagnostico['condicao_gravidade'] == 'moderada')
                                Condição Moderada
                            @else
                                Condição Grave
                            @endif
                        </p>
                    </div>
                </div>
                @endif

                <!-- Posologias -->
                @if(isset($diagnostico['posologias']) && count($diagnostico['posologias']) > 0)
                <div>
                    <h2 class="text-lg font-semibold text-gray-900 mb-3 flex items-center">
                        <svg class="w-5 h-5 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                        </svg>
                        Orientações de Tratamento
                    </h2>
                    <div class="space-y-4">
                        @foreach($diagnostico['posologias'] as $posologia)
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                            <div class="grid grid-cols-2 gap-2">
                                <div><span class="font-medium">Medicamento:</span> {{ $posologia['medicamento'] }}</div>
                                <div><span class="font-medium">Dose:</span> {{ $posologia['dose'] }}</div>
                                <div><span class="font-medium">Frequência:</span> {{ $posologia['frequencia'] }}</div>
                                <div><span class="font-medium">Duração:</span> {{ $posologia['duracao'] }}</div>
                                @if(isset($posologia['observacoes']))
                                <div class="col-span-2"><span class="font-medium">Observações:</span> {{ $posologia['observacoes'] }}</div>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Exames Solicitados -->
                @if(isset($diagnostico['exames_solicitados']) && count($diagnostico['exames_solicitados']) > 0)
                <div>
                    <h2 class="text-lg font-semibold text-gray-900 mb-3 flex items-center">
                        <svg class="w-5 h-5 text-orange-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Exames Recomendados
                    </h2>
                    <div class="space-y-2">
                        @foreach($diagnostico['exames_solicitados'] as $exame)
                        <div class="flex items-center space-x-3 bg-orange-50 border border-orange-200 rounded-lg p-3">
                            <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                            <span class="text-orange-800">{{ $exame }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Recomendações -->
                @if(isset($diagnostico['recomendacoes']) && count($diagnostico['recomendacoes']) > 0)
                <div>
                    <h2 class="text-lg font-semibold text-gray-900 mb-3 flex items-center">
                        <svg class="w-5 h-5 text-purple-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                        Recomendações Gerais
                    </h2>
                    <div class="space-y-2">
                        @foreach($diagnostico['recomendacoes'] as $recomendacao)
                        <div class="flex items-center space-x-3 bg-purple-50 border border-purple-200 rounded-lg p-3">
                            <svg class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span class="text-purple-800">{{ $recomendacao }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Observações -->
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                    <div class="flex items-start space-x-3">
                        <svg class="w-5 h-5 text-yellow-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                        <div>
                            <h3 class="font-semibold text-yellow-800">Importante</h3>
                            <p class="text-yellow-700 text-sm mt-1">
                                {{ $diagnostico['observacoes'] ?? 'Este diagnóstico é preliminar e não substitui a consulta com um médico.' }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex space-x-4 pt-6">
                    <a href="{{ route('consulta') }}" class="flex-1 bg-indigo-600 text-white text-center py-3 px-6 rounded-lg font-semibold hover:bg-indigo-700 transition-colors">
                        Nova Consulta
                    </a>
                    <button onclick="window.print()" class="flex-1 bg-gray-200 text-gray-700 py-3 px-6 rounded-lg font-semibold hover:bg-gray-300 transition-colors">
                        Imprimir Resultado
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection