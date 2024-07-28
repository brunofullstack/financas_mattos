<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EstrategiaWmsHorarioPrioridade extends Model
{
    protected $primaryKey = 'cd_estrategia_wms_horario_prioridade';

    // Se a chave primária não for do tipo int, defina o tipo de chave primária
    protected $keyType = 'int';

    // Se a chave primária não for auto-incremental
    public $incrementing = true;

    protected $table = 'tb_estrategia_wms_horario_prioridade';

    // Se necessário, desabilite timestamps automáticos
    public $timestamps = false;

    protected $fillable = [
        'cd_estrategia_wms',
        'ds_horario_inicio',
        'ds_horario_final',
        'nr_prioridade',
        'dt_registro',
        'dt_modificado',
    ];
}
