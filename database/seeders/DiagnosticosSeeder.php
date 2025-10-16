<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Diagnostico;

class DiagnosticosSeeder extends Seeder
{
    public function run(): void
    {
        // Limpa a tabela primeiro
        Diagnostico::truncate();

        // Insere diagnósticos de exemplo
        Diagnostico::create([
            'nome_doenca' => 'Dengue Clássica',
            'sintomas_chave' => 'febre, dor de cabeça, dor atrás dos olhos, manchas vermelhas, dores musculares',
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
        ]);

        Diagnostico::create([
            'nome_doenca' => 'Virose Comum',
            'sintomas_chave' => 'febre, dor de cabeça, coriza, mal estar',
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
        ]);

        Diagnostico::create([
            'nome_doenca' => 'Faringite Aguda',
            'sintomas_chave' => 'dor de garganta, tosse, febre baixa, dificuldade para engolir',
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
        ]);
    }
}
