<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DiagnosticoController extends Controller
{
    public function processar(Request $request)
    {
        // Validação dos sintomas
        $request->validate([
            'sintomas' => 'required|string|min:10|max:1000'
        ]);

        $sintomas = $request->input('sintomas');

        try {
            // Tenta chamar a API DeepSeek
            $diagnostico = $this->chamarDeepSeekAPI($sintomas);
        } catch (\Exception $e) {
            // Fallback para simulação se a API falhar
            $diagnostico = $this->simularDiagnostico($sintomas);
        }

        // Adiciona os sintomas ao resultado
        $diagnostico['sintomas_analisados'] = $sintomas;

        // Salva na sessão e redireciona para resultado
        return redirect()->route('resultado')->with('diagnostico', $diagnostico);
    }

    private function chamarDeepSeekAPI($sintomas)
    {
        $apiKey = env('DEEPSEEK_API_KEY');

        // Se não tiver API key, usa a simulação
        if (!$apiKey || $apiKey === 'sua_chave_aqui') {
            return $this->simularDiagnostico($sintomas);
        }

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $apiKey,
            'Content-Type' => 'application/json',
        ])->post('https://api.deepseek.com/v1/chat/completions', [
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

        // Se a API falhar, usa simulação
        return $this->simularDiagnostico($sintomas);
    }

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
