<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanilhaItem extends Model
{
    use HasFactory;

    protected $table = 'planilha_itens';

    protected $fillable = [
        'nome_sistema',
        'ip',
        'ambiente',
        'url',
        'tipo_os',
        'usuario_os',
        'senha_os',
        'usuario_site',
        'senha_site',
        'database',
        'usuario_db',
        'senha_db',
        'caminho',
        'git',
        'empresa_desenvolvdor',
        'responsavel_diretor',
    ];
}