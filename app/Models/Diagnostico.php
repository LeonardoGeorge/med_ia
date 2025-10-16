<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diagnostico extends Model
{
    use HasFactory;

    protected $table = 'diagnosticos';

    protected $fillable = [
        'nome_doenca',
        'sintomas_chave',
        'diagnostico_provavel',
        'condicao_gravidade',
        'posologias',
        'exames_solicitados',
        'recomendacoes',
        'observacoes'
    ];

    protected $casts = [
        'posologias' => 'array',
        'exames_solicitados' => 'array',
        'recomendacoes' => 'array',
    ];

    /**
     * Busca diagnósticos similares baseados nos sintomas
     */
    public static function buscarPorSintomas($sintomas)
    {
        $sintomasLower = strtolower($sintomas);

        return static::whereRaw('LOWER(sintomas_chave) LIKE ?', ['%' . $sintomasLower . '%'])
            ->orWhereRaw('LOWER(nome_doenca) LIKE ?', ['%' . $sintomasLower . '%'])
            ->first();
    }
}
