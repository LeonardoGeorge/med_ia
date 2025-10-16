<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Diagnostico;
use Illuminate\Support\Facades\Log;

class DiagnosticoController extends Controller
{
    public function processar(Request $request)
    {
        // Validação dos sintomas
        $request->validate([
            'sintomas' => 'required|string|min:10|max:1000'
        ]);

        $sintomas = $request->input('sintomas');

        // 1️⃣ PRIMEIRO: Busca no banco local por sintomas similares
        $diagnosticoLocal = Diagnostico::buscarPorSintomas($sintomas);

        if ($diagnosticoLocal) {
            // 2️⃣ SE ENCONTROU NO BANCO: Refina com API
            $diagnostico = $this->refinarDiagnosticoComAPI($sintomas, $diagnosticoLocal);
            $diagnostico['fonte'] = 'banco_local_refinado';
        } else {
            // 3️⃣ SE NÃO ENCONTROU: Tenta API diretamente
            try {
                $diagnostico = $this->chamarDeepSeekAPI($sintomas);
                $diagnostico['fonte'] = 'api_deepseek';

                // 💡 OPcional: Salva novo diagnóstico no banco para futuras consultas
                $this->salvarNovoDiagnostico($sintomas, $diagnostico);
            } catch (\Exception $e) {
                // Fallback para simulação
                $diagnostico = $this->simularDiagnostico($sintomas);
                $diagnostico['fonte'] = 'simulacao_fallback';
            }
        }

        // Adiciona os sintomas analisados ao resultado
        $diagnostico['sintomas_analisados'] = $sintomas;

        // Salva na sessão e redireciona para resultado
        return redirect()->route('resultado')->with('diagnostico', $diagnostico);
    }

    /**
     * Busca diagnóstico no banco local e refina com API
     */
    private function refinarDiagnosticoComAPI($sintomas, Diagnostico $diagnosticoBase)
    {
        $apiKey = env('DEEPSEEK_API_KEY');

        // Se não tem API key, retorna o diagnóstico local sem refinamento
        if (!$apiKey || $apiKey === 'sua_chave_aqui') {
            return $diagnosticoBase->toArray();
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,
                'Content-Type' => 'application/json',
            ])->timeout(15)->post('https://api.deepseek.com/v1/chat/completions', [
                'model' => 'deepseek-chat',
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'Você é um assistente médico. Analise os sintomas e refine o diagnóstico base. Retorne APENAS JSON com: diagnostico_provavel, condicao_gravidade, posologias, exames_solicitados, recomendacoes, observacoes.'
                    ],
                    [
                        'role' => 'user',
                        'content' => "Sintomas do paciente: {$sintomas}. Diagnóstico base para refinar: " . json_encode($diagnosticoBase->toArray()) . ". Forneça análise médica refinada em formato JSON."
                    ]
                ],
                'temperature' => 0.3,
                'max_tokens' => 1000
            ]);

            if ($response->successful()) {
                $content = $response->json()['choices'][0]['message']['content'];
                $diagnosticoRefinado = json_decode($content, true);

                // Combina dados locais com refinamento da API
                if (is_array($diagnosticoRefinado)) {
                    return array_merge($diagnosticoBase->toArray(), $diagnosticoRefinado);
                }
            }

            return $diagnosticoBase->toArray();
        } catch (\Exception $e) {
            return $diagnosticoBase->toArray();
        }
    }

    /**
     * Salva novo diagnóstico no banco para aprendizado futuro
     */
    private function salvarNovoDiagnostico($sintomas, array $diagnostico)
    {
        try {
            Diagnostico::create([
                'nome_doenca' => $diagnostico['diagnostico_provavel'] ?? 'Diagnóstico Gerado',
                'sintomas_chave' => $sintomas,
                'diagnostico_provavel' => $diagnostico['diagnostico_provavel'] ?? null,
                'condicao_gravidade' => $diagnostico['condicao_gravidade'] ?? 'moderada',
                'posologias' => $diagnostico['posologias'] ?? [],
                'exames_solicitados' => $diagnostico['exames_solicitados'] ?? [],
                'recomendacoes' => $diagnostico['recomendacoes'] ?? [],
                'observacoes' => $diagnostico['observacoes'] ?? 'Diagnóstico gerado automaticamente via API'
            ]);
        } catch (\Exception $e) {
            // Log do erro, mas não interrompe o fluxo
            Log::error("Erro ao salvar diagnóstico: " . $e->getMessage());
        }
    }

    /**
     * Chamada original para API DeepSeek (mantida para compatibilidade)
     */
    private function chamarDeepSeekAPI($sintomas)
    {
        $apiKey = env('DEEPSEEK_API_KEY');

        if (!$apiKey || $apiKey === 'sua_chave_aqui') {
            return $this->simularDiagnostico($sintomas);
        }

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $apiKey,
            'Content-Type' => 'application/json',
        ])->timeout(15)->post('https://api.deepseek.com/v1/chat/completions', [
            'model' => 'deepseek-chat',
            'messages' => [
                [
                    'role' => 'system',
                    'content' => 'Você é um assistente médico. Analise os sintomas e retorne um diagnóstico em JSON com: diagnostico_provavel, condicao_gravidade, posologias, exames_solicitados, recomendacoes, observacoes. Seja conservador e profissional.'
                ],
                [
                    'role' => 'user',
                    'content' => "Paciente relata: {$sintomas}. Forneça análise médica em formato JSON."
                ]
            ],
            'temperature' => 0.3,
            'max_tokens' => 1000
        ]);

        if ($response->successful()) {
            $content = $response->json()['choices'][0]['message']['content'];
            return json_decode($content, true);
        }

        return $this->simularDiagnostico($sintomas);
    }

    /**
     * Simulação de diagnóstico (fallback)
     */
    private function simularDiagnostico($sintomas)
    {
        $sintomasLower = strtolower($sintomas);

        // Diagnósticos simulados baseados nos sintomas
        if (str_contains($sintomasLower, 'dor de cabeça') && str_contains($sintomasLower, 'febre')) {
            return [
                'diagnostico_provavel' => 'Possível virose ou infecção viral',
                'condicao_gravidade' => 'leve',
                'posologias' => [
                    [
                        'medicamento' => 'Paracetamol',
                        'dose' => '500mg',
                        'frequencia' => '8 em 8 horas',
                        'duracao' => '3 dias',
                        'observacoes' => 'Não exceder 3g por dia'
                    ]
                ],
                'exames_solicitados' => ['Hemograma completo'],
                'recomendacoes' => ['Repouso', 'Hidratação adequada'],
                'observacoes' => 'Caso os sintomas persistam, procurar atendimento médico.'
            ];
        }

        if (str_contains($sintomasLower, 'tosse') && str_contains($sintomasLower, 'garganta')) {
            return [
                'diagnostico_provavel' => 'Possível faringite ou amigdalite',
                'condicao_gravidade' => 'leve',
                'posologias' => [
                    [
                        'medicamento' => 'Ibuprofeno',
                        'dose' => '400mg',
                        'frequencia' => '8 em 8 horas',
                        'duracao' => '3 dias',
                        'observacoes' => 'Tomar após as refeições'
                    ]
                ],
                'exames_solicitados' => ['Avaliação clínica'],
                'recomendacoes' => ['Gargarejo com água morna e sal', 'Repouso vocal'],
                'observacoes' => 'Evitar alimentos muito quentes ou gelados.'
            ];
        }

        if (str_contains($sintomasLower, 'febre') && str_contains($sintomasLower, 'manchas vermelhas')) {
            return [
                'diagnostico_provavel' => 'Suspeita de Dengue Clássica',
                'condicao_gravidade' => 'moderada',
                'posologias' => [
                    [
                        'medicamento' => 'Dipirona sódica',
                        'dose' => '500mg',
                        'frequencia' => '6/6h se febre',
                        'duracao' => '5 dias',
                        'observacoes' => 'Evitar AAS e ibuprofeno devido ao risco de sangramento'
                    ]
                ],
                'exames_solicitados' => ['Hemograma completo', 'Sorologia para dengue'],
                'recomendacoes' => ['Hidratação intensa', 'Repouso absoluto'],
                'observacoes' => 'Diagnóstico clínico compatível com dengue clássica.'
            ];
        }

        // Diagnóstico padrão
        return [
            'diagnostico_provavel' => 'Consulta médica recomendada para avaliação detalhada',
            'condicao_gravidade' => 'moderada',
            'posologias' => [],
            'exames_solicitados' => ['Consulta clínica presencial'],
            'recomendacoes' => ['Repouso', 'Hidratação', 'Monitorar sintomas'],
            'observacoes' => 'Este é um diagnóstico preliminar. Consulte um médico para avaliação adequada.'
        ];
    }
}
